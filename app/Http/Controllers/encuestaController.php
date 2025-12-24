<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Encuesta;
use App\Models\Departamento;
use App\Models\Pregunta;
use App\Models\Cliente;
use App\Models\Respuesta;
use App\Models\ClienteEncuesta;
use Illuminate\Support\Facades\DB;


class encuestaController extends Controller
{

    public function encuesta_index(Encuesta $encuesta){
        

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
                









        return view('admin.gestionar_preguntas', compact('encuesta', 'preguntas', 'existe', 'clientes', 'labels', 'valores'));

    }








    public function encuesta_store(Request $request, Departamento $departamento){


        
        $request->validate([
            "nombre_encuesta" => "required|unique:encuestas,nombre",
            "descripcion_encuesta" => "required",
            "ponderacion_encuesta" => "required",
            "meta_esperada_encuesta" => "required",
            "meta_minima_encuesta" => "required"

        ]);


        Encuesta::create([
            "nombre" => $request->nombre_encuesta,
            "descripcion" => $request->descripcion_encuesta,
            "id_departamento" => $departamento->id,
            "ponderacion" => $request->ponderacion_encuesta,
            "meta_minima" => $request->meta_minima_encuesta,
            "meta_esperada" => $request->meta_esperada_encuesta
        ]);


        return back()->with("success", "La encuesta fue agregada!");


    
    }


    public function encuesta_store_two(Request $request){


     
        $request->validate([

            "nombre_encuesta" => "required|unique:encuestas,nombre",
            "descripcion_encuesta" => "required",
            "ponderacion_encuesta" => "required",
            "meta_esperada_encuesta" => "required",
            "meta_minima_encuesta" => "required"

        ]);


        Encuesta::create([

            "nombre" => $request->nombre_encuesta,
            "descripcion" => $request->descripcion_encuesta,
            "id_departamento" => $request->departamento,
            "ponderacion" => $request->ponderacion_encuesta,
            "meta_minima" => $request->meta_minima_encuesta,
            "meta_esperada" => $request->meta_esperada_encuesta

        ]);




        return back()->with('success', 'La encuesta fue agregada!');


    }




    public function encuesta_delete(Encuesta $encuesta){

        $encuesta->delete();

        return back()->with('eliminado', 'La encuesta fue eliminada!');


    }


    public function encuesta_edit(Encuesta $encuesta, Request $request){

        $request->validate([

            "nombre_encuesta_edit" => "required|unique:encuestas,nombre,".$encuesta->id,
            "descripcion_encuesta_edit" => "required",
            "ponderacion_encuesta_edit" => "required",
            'meta_minima_encuesta_edit' => "required",
            'meta_esperada_encuesta_edit' => "required"

        ]);




        $encuesta->update([

            "nombre" => $request->nombre_encuesta_edit,
            "descripcion" => $request->descripcion_encuesta_edit,
            "ponderacion" => $request->ponderacion_encuesta_edit,
            "meta_minima" => $request->meta_minima_encuesta_edit,
            "meta_esperada" => $request->meta_esperada_encuesta_edit

        ]);



        return back()->with("actualizado", "La encuesta fue editada");

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





    public function encuestas_show_admin(){
        
        $encuestas = Encuesta::with(['departamento', 'preguntas', 'respuestas'])->get();
        $departamentos = Departamento::get();


        //ESTO ME DA LAS GRAFICAS POR MES DE LAS ENCUESTAS
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
                WHERE (p.cuantificable = 1 OR p.cuantificable = "on")
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
        //ESTO ME DA LAS GRAFICAS POR MES DE LAS ENCUESTAS






        return view ('admin.gestionar_encuestas', compact('encuestas', 'departamentos', 'resultado_encuestas'));

    }


//muestra las 
    public function encuesta_llena_show_admin(Encuesta $encuesta){

        return view('admin.seguimiento_encuesta_detalle', compact('encuesta'));

    }



}
