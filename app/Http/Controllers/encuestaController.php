<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encuesta;
use App\Models\Departamento;
use App\Models\Pregunta;


class encuestaController extends Controller
{



    public function encuesta_index(Encuesta $encuesta){

        $preguntas = Pregunta::where('id_encuesta', $encuesta->id)->get();

        return view('client.encuesta', compact('encuesta', 'preguntas'));

    }


    public function encuesta_store(Request $request, Departamento $departamento){


        
        $request->validate([
            "nombre_encuesta" => "required|unique:encuestas,nombre",
            "descripcion_encuesta" => "required"

        ]);


        Encuesta::create([
            "nombre" => $request->nombre_encuesta,
            "descripcion" => $request->descripcion_encuesta,
            "id_departamento" => $departamento->id
        ]);


        return back()->with("success", "El cuestionario fue agregado!");

    
    
    }



    public function encuesta_delete(Encuesta $encuesta){

        $encuesta->delete();

        return back()->with('encuesta_eliminada', 'La encuesta fue eliminada!');


    }


    public function encuesta_edit(Encuesta $encuesta, Request $request){

        $request->validate([

            "nombre_encuesta_edit" => "required|unique:encuestas,nombre,".$encuesta->id,
            "descripcion_encuesta_edit" => "required"

        ]);




        $encuesta->update([

            "nombre" => $request->nombre_encuesta_edit,
            "descripcion" => $request->descripcion_encuesta_edit

        ]);



        return back()->with("editado", "La encuesta fue editada");

    }



    public function pregunta_store(Encuesta $encuesta, Request $request){

        $request->validate([
            'pregunta' => 'required'
        ]);

        if($request->cuantificable) $cuantificable = true;
        if(!$request->cuantificable) $cuantificable = false;


        Pregunta::create([

            "pregunta" => $request->pregunta,
            "id_encuesta" => $encuesta->id,
            "cuantificable" => $cuantificable
 
        ]);

        
        return back()->with('success', 'La pregunta fue agregada al cuestionario!');

    }


    public function pregunta_delete(Pregunta $pregunta){


        $pregunta->delete();

        return back()->with("deleted", "La pregunta fue eliminada");

    }



}
