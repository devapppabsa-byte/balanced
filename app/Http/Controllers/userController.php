<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\EvaluacionProveedor;
use App\Models\Departamento;
use App\Models\Indicador;
use App\Models\Proveedor;
use App\Models\Norma;
use App\Models\ClienteEncuesta;
use App\Models\Pregunta;
use App\Models\Cliente;
use App\Models\Respuesta;
use App\Models\Encuesta;
use App\Models\IndicadorLleno;
use App\Models\ApartadoNorma;
use App\Models\CumplimientoNorma;
use Illuminate\Support\Facades\DB;

class userController extends Controller
{

    public function index(){
        return view('inicio');
    }


    public function login_user(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');
        

        //se intenta la utenticacion con attemp
        if(Auth::attempt($credentials)){

            $request->session()->regenerate();

            return redirect()->route('perfil.usuario') ;

        }

        else{
            return back()->with("error", 'Error de usuario o contraseña');
        }

    }




    public function perfil_user(){   

        $year = Carbon::now()->year;

        $id_dep = Auth::user()->departamento->id;
        $indicadores = Indicador::where('id_departamento', $id_dep)->get();



        //TODO EL DESMADRE DE ABAJO ES PARA PODER OBTENER LA PONDERACION Y QUE NO SE LLENEN INDICADORES SI LA PONDERACION CAMBIA
    
        //Teniendo el departamento tomo los indicadores que se le estan registrando.
        $indicadores_ponderaciones = Indicador::where('id_departamento', $id_dep)->get();
        $ponderacion_indicadores = [];
        foreach($indicadores_ponderaciones as $indicador_ponderacion){
            array_push($ponderacion_indicadores, $indicador_ponderacion->ponderacion);
        }



        $normas_ponderaciones = Norma::where('id_departamento', $id_dep)->get();
        $ponderacion_normas = [];
        foreach($normas_ponderaciones as $norma_ponderacion){
            array_push($ponderacion_normas, $norma_ponderacion->ponderacion);
        }



        $encuestas_ponderaciones = Encuesta::where('id_departamento', $id_dep)->get();
        $ponderacion_encuestas = [];
        foreach($encuestas_ponderaciones as $encuesta_ponderacion){
            array_push($ponderacion_encuestas, $encuesta_ponderacion->ponderacion);
        }

        $ponderacion = array_sum(array_merge($ponderacion_indicadores, $ponderacion_normas, $ponderacion_encuestas));

        //TODO EL DESMADRE DE ARRIBA ES PARA PODER OBTENER LA PONDERACION Y QUE NO SE LLENEN INDICADORES SI LA PONDERACION CAMBIA





        
    //DE AQUI SE SACA EL CUMPLIMIENTO DE LOS INDICADORES
    $indicadores_graficas = Indicador::where('id_departamento', $id_dep)->pluck('ponderacion', 'id');
    $registros = IndicadorLleno::where('final', 'on')->get();


        $datosGrafica = collect($registros)
        ->groupBy(function ($item) {
            return Carbon::parse($item->created_at)->format('Y-m');
        })
        ->map(function ($itemsPorMes) use ($indicadores_graficas) {

            $totalMes = 0;

            foreach ($itemsPorMes as $item) {
                $ponderacion = ($indicadores_graficas[$item->id_indicador] ?? 0) / 100;
                $totalMes += floatval($item->informacion_campo) * $ponderacion;
            }

            return round($totalMes, 2);
        });



        $labels_indicadores = $datosGrafica->keys()->values();
        $data_indicadores   = $datosGrafica->values();

    //DE AQUI SE SACA EL CUMPLIMIENTO DE LOS INDICADORES
        




    //AQUI TERMINA LA GENERACION DE GRAFICAS DEL CUMPLIMIENTO NORMATIVO
    // Se consultan todas las normas del departamento
    $normas = Norma::where('id_departamento', $id_dep)->get();

    // Meses a graficar (últimos 12)
    $meses = collect(range(0, 11))
        ->map(fn ($i) => now()->subMonths($i)->format('Y-m'))
        ->reverse()
        ->values();

    $resultado_normas = [];

    foreach ($normas as $norma) {

        $apartados = ApartadoNorma::where('id_norma', $norma->id)->get();
        $data = [];

        foreach ($meses as $mes) {

            $totalApartados = $apartados->count();
            $apartadosCumplidos = 0;

            foreach ($apartados as $apartado) {

                $cumple = CumplimientoNorma::where('id_apartado_norma', $apartado->id)
                    ->whereYear('created_at', substr($mes, 0, 4))
                    ->whereMonth('created_at', substr($mes, 5, 2))
                    ->exists();

                if ($cumple) {
                    $apartadosCumplidos++;
                }
            }

            $data[] = $totalApartados > 0
                ? round(($apartadosCumplidos / $totalApartados) * 100, 2)
                : 0;
        }

        $resultado_normas[] = [
            'norma'  => $norma->nombre,
            'labels' => $meses,
            'data'   => $data
        ];
    }

    //AQUI TERMINA LA GENERACION DE GRAFICAS DEL CUMPLIMIENTO NORMATIVO

    



        $resultado_encuestas = DB::table(DB::raw('
            (
                SELECT
                    e.id AS encuesta_id,
                    e.nombre AS encuesta,
                    DATE_FORMAT(r.created_at, "%Y-%m") AS mes,
                    r.id_cliente,
                    AVG(r.respuesta) AS promedio_cliente
                FROM respuestas r
                JOIN preguntas p ON p.id = r.id_pregunta
                JOIN encuestas e ON e.id = p.id_encuesta
                WHERE e.id_departamento = '.$id_dep.'
                AND (p.cuantificable = 1 OR p.cuantificable = "on")
                GROUP BY e.id, r.id_cliente, mes
            ) AS t
        '))
        ->select(
            'encuesta_id',
            'encuesta',
            'mes',
            DB::raw('ROUND(AVG(promedio_cliente),2) AS total')
        )
        ->groupBy('encuesta_id', 'encuesta', 'mes')
        ->orderBy('mes')
        ->get()
        ->groupBy('encuesta')
        ->map(function ($items, $encuesta) {
            return [
                'encuesta' => $encuesta,
                'labels'   => $items->pluck('mes')->values(),
                'data'     => $items->pluck('total')->values()
            ];
        })
        ->values();

        return view('user.perfil_user', compact('indicadores', 'ponderacion', 'labels_indicadores', 'data_indicadores', 'resultado_normas', 'resultado_encuestas'));

    }




    public function eliminar_usuario(User $usuario){

        $usuario_eliminado = User::findOrFail($usuario->id);

        $usuario_eliminado->delete();

        return back()->with('eliminado_user', 'El usuario ' .$usuario->name. ' fue eliminado');

    }


    public function editar_usuario(User $usuario, Request $request){


        $request->validate([

            'nombre_usuario' => 'required',
            'puesto_usuario' => 'required',
            'correo_usuario' => 'required',
            'departamento' => 'required'

        ]);

        
        $usuario_editar = User::findOrFail($usuario->id);
        $usuario_editar->name = $request->nombre_usuario;
        $usuario_editar->email = $request->correo_usuario;
        $usuario_editar->puesto = $request->puesto_usuario;
        $usuario_editar->id_departamento = $request->departamento;


        if($request->password_usuario){

            $usuario_editar->password = $request->password_usuario;

        }

        $usuario_editar->save();
        
        return back()->with('editado', 'El usuario fue actualizado!');

    }


    public function usuarios_show_admin(){

        $usuarios = User::get();
        $departamentos = Departamento::get();

        return view('admin.gestionar_usuarios', compact('usuarios', 'departamentos'));

    }


    public function evaluacion_servicio_store(User $user, Request $request){


        $request->validate([
            'descripcion_servicio' => 'required',
            'proveedor' => 'required',
            'calificacion' => 'required'
        ]);

        $fecha = Carbon::now()->locale('es')->translatedFormat('l j \\d\\e F \\d\\e Y');

        EvaluacionProveedor::create([

            'fecha' => $fecha,
            'calificacion' => $request->calificacion,
            'descripcion' => $request->descripcion_servicio,
            'id_departamento' => $user->departamento->id,
            'observaciones' => $request->observaciones_servicio,
            'id_proveedor' => $request->proveedor

        ]);


        return back()->with('success', 'La evaluación fue agregada');


    }




    public function encuesta_clientes_user(){
        
         $id_user = Auth::user()->id;
         $id_depto = Auth::user()->departamento->id;
         $encuestas = Encuesta::where('id_departamento', $id_depto)->get();



         return view('user.encuestas_clientes', compact('encuestas'));


    }


    public function encuesta_index_user(Encuesta $encuesta){

        
         
        //checo si la encuesta ya fue contestada
        $existe = ClienteEncuesta::where('id_encuesta', $encuesta->id)->get();
        
        //Esto me trae todas las preguntas de la encuesta con sus respuestas 
        $preguntas = Pregunta::with('respuestas')->where('id_encuesta', $encuesta->id)->get();


        //me ayuda a agregar los clientes que ya respondieron las preguntas
        $cliente_arr = [];
        foreach($existe as $cliente ){
            array_push($cliente_arr, $cliente->id_cliente);
        }
        //los clientes que ya contestaron la encuesta.
        $clientes = Cliente::whereIn('id', $cliente_arr)->get();




        //DATOS PARA LA GRAFICA DE LA ENCUESTA
       $resultados = Respuesta::join('preguntas', 'respuestas.id_pregunta', '=', 'preguntas.id')
                ->join('clientes', 'respuestas.id_cliente', '=', 'clientes.id')
                ->where('preguntas.id_encuesta', $encuesta->id)
                ->where('preguntas.cuantificable', 1)
                ->groupBy('clientes.id', 'clientes.nombre')
                ->select(
                    'clientes.nombre as cliente',
                    DB::raw('AVG(respuestas.respuesta) as puntuacion')
                )
                ->get();

            $labels  = $resultados->pluck('cliente');
            $valores = $resultados->pluck('puntuacion')->map(fn($v) => round($v, 2));
        //DATOS PARA LA HGRAFICA DE LA ENCUESTA



        return view('user.detalle_encuesta', compact('resultados', 'existe', 'encuesta', 'preguntas', 'clientes', 'labels', 'valores'));


    }


    // public function show_respuestas_cliente(Cliente $cliente, Encuesta $encuesta){


    //     $existe = ClienteEncuesta::where('id_encuesta', $encuesta->id)->get();
        
    //     //Esto me trae todas las preguntas de la encuesta con sus respuestas 
    //     $preguntas = Pregunta::with('respuestas')->where('id_encuesta', $encuesta->id)->get();


    //     //me ayuda a agregar los clientes que ya respondieron las preguntas
    //     $cliente_arr = [];
    //     foreach($existe as $cliente ){
    //         array_push($cliente_arr, $cliente->id_cliente);
    //     }
    //     //los clientes que ya contestaron la encuesta.
    //     $clientes = Cliente::whereIn('id', $cliente_arr)->get();




    //     //DATOS PARA LA GRAFICA DE LA ENCUESTA
    //     $resultados = Respuesta::join('preguntas', 'respuestas.id_pregunta', '=', 'preguntas.id')
    //             ->join('clientes', 'respuestas.id_cliente', '=', 'clientes.id')
    //             ->where('preguntas.id_encuesta', $encuesta->id)
    //             ->where('preguntas.cuantificable', 1)
    //             ->groupBy('clientes.id', 'clientes.nombre')
    //             ->select(
    //                 'clientes.nombre as cliente',
    //                 DB::raw('AVG(respuestas.respuesta) as puntuacion')
    //             )
    //             ->get();

    //         $labels  = $resultados->pluck('cliente');
    //         $valores = $resultados->pluck('puntuacion')->map(fn($v) => round($v, 2));
    //     //DATOS PARA LA HGRAFICA DE LA ENCUESTA
                



    //     return view('user.detalle_encuesta', compact('encuesta', 'preguntas', 'existe', 'clientes', 'labels', 'valores'));


    // }


    public function show_respuestas_usuario(Cliente $cliente, Encuesta $encuesta){

        $clienteId = $cliente->id;
        $encuestaId = $encuesta->id;


        $preguntas = Pregunta::with(['respuestas' => function ($q) use ($clienteId) {
                $q->where('id_cliente', $clienteId);
            }])
            ->where('id_encuesta', $encuestaId)
            ->where('cuantificable', 1)
            ->get();


        //se necesitan las respuestas de las encuestas, es decir, consultar las preguntas con su respuesta, todo estom vendra de la tabla auxiliar.
        return view("admin.respuestas_cliente_encuestas", compact('preguntas', 'cliente'));


    }





    public function cerrar_session(Request $request){

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');


    }


    public function cerrar_session_cliente(Request $request){

    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login_cliente');


}



}
