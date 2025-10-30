<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Pregunta;
use App\Models\Respuesta;
use App\Models\Queja;
use App\Models\ClienteEncuesta;
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

        //protegiendo la URL de las encuestas, la consulta esta es para verificar si el cliente aun no contesta 
        //la encuesta o si ya la contesto. Todo eso sobre la tabla Aux. 

        $existe = ClienteEncuesta::where('id_cliente', Auth::guard('cliente')->user()->id)
        ->where('id_encuesta', $encuesta->id)
        ->exists();

        if($existe){

            return back()->with('contestada','Esta encuesta ya fue contestada por el usuario!');

        }

        
        $preguntas = Pregunta::where('id_encuesta', $encuesta->id)->get();

        return view('client.encuesta_contestar', compact("preguntas", "encuesta"));


    }


    public function index_encuesta_contestada(Encuesta $encuesta){

                //checo si la encuesta ya fue contestada
        $existe = ClienteEncuesta::where('id_encuesta', $encuesta->id)->get();
        
        //Esto me trae todas las preguntas de la encuesta con sus respuestas 
        $preguntas = Pregunta::with('respuestas')->where('id_encuesta', $encuesta->id)->get();





        return view('client.encuesta_contestada', compact('encuesta', 'preguntas'));
    
    }


    public function clientes_show_admin(){

        $clientes = Cliente::get();

        return view('admin.gestionar_clientes', compact('clientes'));

    }







public function contestar_encuesta(Request $request, Encuesta $encuesta){

   
        $respuestas = $request->input('respuestas');


        //Guardando los ID en las tabla auxiliar
        ClienteEncuesta::create([
            "id_cliente" => Auth::guard('cliente')->user()->id,
            "id_encuesta" => $encuesta->id
        ]);

        $contador=0;
        foreach($respuestas as $respuesta){

            Respuesta::create([

                "respuesta" => $respuesta,
                "id_pregunta" => $request->input('id')[$contador],
                "id_cliente" => Auth::guard('cliente')->user()->id

            ]);

            $contador++;

        }
        
        return redirect()->route('perfil.cliente')->with("contestado", 'El cuestionario fue contestado');


    }







public function show_respuestas(Cliente $cliente, Encuesta $encuesta){

        $clienteId = $cliente->id;
        $encuestaId = $encuesta->id;


        $preguntas = Pregunta::with(['respuestas' => function ($q) use ($clienteId) {
                $q->where('id_cliente', $clienteId);
            }])
            ->where('id_encuesta', $encuestaId)
            ->get();


        //se necesitan las respuestas de las encuestas, es decir, consultar las preguntas con su respuesta, todo estom vendra de la tabla auxiliar.
        return view("admin.respuestas_cliente_encuestas", compact('preguntas', 'cliente'));
    
}

public function queja_cliente(Request $request){
    
    $request->validate([
        
        'queja' => 'required'
    
    ]);


    Queja::create([
        "queja" => $request->queja,
        'id_cliente' => Auth::guard('cliente')->user()->id
    ]);

    return back()->with('success', 'La información fue enviada con exito!');
    
}


public function seguimiento_quejas_cliente(){

    


    return view('client.seguimiento_quejas');

}



    



}
