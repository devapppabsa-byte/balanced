<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\InformacionForanea;
use Illuminate\Http\Request;

class informacionForaneaController extends Controller
{



    public function informacion_foranea_show_admin(){



        return view('admin.gestionar_informacion_foranea');

    }
    




    public function agregar_informacion_foranea(Request $request){


        $request->validate([
            'nombre_info' => 'required',
            'informacion' => 'required',
            'tipo_info' => 'required'
        ]);


        InformacionForanea::create([

            'nombre_info' => $request->nombre_info,
            'contenido' => $request->informacion,
            'tipo_dato'  => $request->tipo_info

        ]);



        return back()->with('success', 'La información fue agregada!');


    }



}
