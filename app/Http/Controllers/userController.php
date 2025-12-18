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

    





//PARA LA GRAFICA DE LAS ENCUESTAS
    $resultado_encuestas = DB::table('encuestas as e')
    ->join('preguntas as p', 'p.id_encuesta', '=', 'e.id')
    ->leftJoin('respuestas as r', 'r.id_pregunta', '=', 'p.id')
    ->where('e.id_departamento', $id_dep)
    ->where(function ($q) {
        $q->where('p.cuantificable', 'on')
          ->orWhere('p.cuantificable', 1);
    })
    ->select(
        'e.id',
        'e.nombre as encuesta',
        DB::raw("DATE_FORMAT(r.created_at, '%Y-%m') as mes"),
        DB::raw('COALESCE(AVG(r.respuesta),0) as total')
    )
    ->groupBy('e.id', 'e.nombre', 'mes')
    ->orderBy('mes')
    ->get()
    ->groupBy('encuesta')
    ->map(function ($items, $encuesta) {
        return [
            'encuesta' => $encuesta,
            'labels'   => $items->pluck('mes')->filter()->values(),
            'data'     => $items->pluck('total')->values()
        ];
    })
    ->values();

    //PARA LAS GRAFICAS DE LAS ENCUESTAS


    //de aqui se van a sacar las graficas de las encuestas a los clientes




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

    public function cerrar_session(Request $request){

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');


    }



}
