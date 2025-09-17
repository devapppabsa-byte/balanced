<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CampoVacio;
use App\Models\Indicador;
use Illuminate\Http\Request;

class campoVacioController extends Controller
{

    public function agregar_campo_vacio(Request $request,Indicador $indicador){



        $request->validate([
            'nombre_campo_vacio' => 'required',
            'tipo_dato' => 'required'
        ]);



    //Sacando el ID para el campo y se pueda gestionar el el combinados de campos al crear nuevos
       $fecha_creado = date("YmdHis");
       $id_input = strtolower(str_replace(" ", "", $fecha_creado.$request->nombre_campo_vacio));
    //Sacando el ID para el campo y se pueda gestionar el el combinados de campos al crear nuevos




        CampoVacio::create([

            'nombre' => $request->nombre_campo_vacio,
            'id_input' => $id_input,
            'tipo' => $request->tipo_dato,
            'id_indicador' => $indicador->id,
            'descripcion' => $request->descripcion
            
        ]);

        
        return back()->with('success', 'El campo vacio fue agregado al indicador');        

    }
 

}
