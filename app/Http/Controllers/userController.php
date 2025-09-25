<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Indicador;

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

        return view('user.perfil_user', compact('indicadores'));

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



    public function cerrar_session(Request $request){

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');


    }



}
