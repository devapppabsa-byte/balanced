<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pregunta;
use App\Models\Encuesta;
class clienteController extends Controller
{


    public function login(){

        return view('client.login_cliente');

    }



    public function perfil_cliente(){

        $encuestas = Encuesta::get();  //

        return view("client.perfil_cliente", compact('encuestas'));
    }



    public function index_cliente(Request $request){

    

        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        
        
        $credentials = $request->only('email', 'password');

        if(Auth::guard('cliente')->attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('perfil.cliente');
        }

        else{
            return back()->with('error', 'Las credenciales no coinciden con los registros');
        }


    }


    public function contestar_encuesta(Encuesta $encuesta){

        
        $preguntas = Pregunta::where('id_encuesta', $encuesta->id)->get();

        return view('client.encuesta_contestar', compact("preguntas", "encuesta"));


    }


    



}
