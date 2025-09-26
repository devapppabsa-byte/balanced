<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Encuesta;
use App\Models\Cliente;
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


    public function index_encuesta(Encuesta $encuesta){

        
        $preguntas = Pregunta::where('id_encuesta', $encuesta->id)->get();

        return view('client.encuesta_contestar', compact("preguntas", "encuesta"));


    }


    public function contestar_encuesta(Request $request, Encuesta $encuesta){

        $respuestas = $request->input('respuestas');



        foreach($respuestas as $respuesta){

            Respuesta::create([

                "respuesta" => $respuesta,
                "id_pregunta" => $request->id,
                "id_cliente" => Auth::guard('cliente')->user()->id

            ]);

        }

        //Agregando el registro a la tabla auxiliar
        ClienteEncuesta::create([

            "id_cliente" => Auth::guard('cliente')->user()->id,
            "id_encuesta" => $encuesta->id

        ]);

        
        return redirect()->route('perfil.cliente')->with("contestado", 'El cuestionario fue contestado');


    }



    public function clientes_show_admin(){

        $clientes = Cliente::get();

        return view('admin.gestionar_clientes', compact('clientes'));

    }

    



}
