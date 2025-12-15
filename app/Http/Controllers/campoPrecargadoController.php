<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CampoPrecargado;
use App\Models\Indicador;
use Illuminate\Http\Request;

class campoPrecargadoController extends Controller
{
 

    //este es para el campo de prueba
    public function agregar_campo_precargado(Indicador $indicador, Request $request){

        $request->validate([
        
            'campo_precargado' => 'required'

        ]);


        list($informacion, $tipo, $nombre) = explode('|', $request->campo_precargado);
        $fecha_creado = date("YmdHis");

        $id_input = strtolower(str_replace(" ", "", $fecha_creado.$nombre));
    
        CampoPrecargado::create([
           
            'nombre' => $nombre,
            'id_input' => $id_input, 
            'informacion_precargada'  => $informacion,
            'tipo_dato' => $tipo,
            'id_indicador' => $indicador->id

        ]);


        return back()->with('success', 'El campo fue agregado!');


    }//este es para el campo de prueba




    public function crear_campo_precargado(Request $request){


        $request->validate([

            "nombre_precargado" => 'required',
            "descripcion_precargado" => 'required'

        ]);

         $id_input = date('YmdHis').rand(0,5000); 

         
        CampoPrecargado::create([

            'id_input' => $id_input,
            



        ]);


    }



}
