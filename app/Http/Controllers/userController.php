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

        $id_dep = Auth::user()->departamento->id;
        $indicadores = Indicador::where('id_departamento', $id_dep)->get();

    
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
        



 

        return view('user.perfil_user', compact('indicadores', 'ponderacion'));

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
