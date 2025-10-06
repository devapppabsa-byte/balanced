<?php

namespace App\Http\Controllers;

use App\Models\Norma;
use App\Models\ApartadoNorma;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class apartadoNormaController extends Controller
{


 public function apartado_norma_store(Request $request, Norma $norma){


        $request->validate([

            "titulo_apartado_norma" => "required|unique:apartado_norma,apartado",
            "descripcion_apartado_norma" => "required"
            
        ]);


        ApartadoNorma::create([
            "apartado" => $request->titulo_apartado_norma,
            "descripcion" => $request->descripcion_apartado_norma,
            "id_norma" => $norma->id
        ]);




        return back()->with('success', 'El apartado fue agregado!');

    }






    public function delete_apartado_norma(ApartadoNorma $apartado){

        $apartado->delete();

        return back()->with('eliminado', 'El apartado fue eliminado de la norma!');


    }



    public function edit_apartado_norma(ApartadoNorma $apartado, Request $request){


        $request->validate([
            'nombre_apartado_edit' => Rule::unique('apartado_norma', 'apartado')->ignore($apartado->id),
            'descripcion_apartado_edit' => 'required'
        ]);



        $apartado->update([

            "apartado" => $request->nombre_apartado_edit,
            "descripcion" => $request->descripcion_apartado_edit

        ]);


        return back()->with('actualizado', 'El apartado fue editado');


    }


}
