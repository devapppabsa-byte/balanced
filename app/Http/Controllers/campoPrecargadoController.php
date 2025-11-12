<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CampoPrecargado;
use App\Models\Indicador;
use Illuminate\Http\Request;

class campoPrecargadoController extends Controller
{
 

    public function agregar_campo_precargado(Indicador $indicador, Request $request){

    
        return $request;
        
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



    }


}
