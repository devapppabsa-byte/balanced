<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Perspectiva;
use App\Models\Indicador;
use App\Models\Objetivo;
class perspectivaController extends Controller
{

    public function perspectivas_show(){

        $perspectivas = Perspectiva::get();


        return view('admin.agregar_perspectivas', compact('perspectivas'));
    
    }


    public function perspectiva_store(Request $request){


        $request->validate([
            'nombre_perspectiva' => 'required|unique:perspectivas,nombre',
            'ponderacion' => 'required|numeric|max:100|min:1'
        ]);

        Perspectiva::create([
            'nombre' => $request->nombre_perspectiva,
            'ponderacion' => $request->ponderacion
        ]);


        return back()->with('success', 'La perspectiva fue agregada!');

    }




    public function perspectiva_delete(Perspectiva $perspectiva){

        $perspectiva->delete();
        return back()->with('deleted', 'La perspectiva fue eliminada');

    }


    public function edit_perspectiva(Perspectiva $perspectiva, Request $request){


        $perspectiva_edit = Perspectiva::findOrFail($perspectiva->id);

    

        $perspectiva_edit->nombre = $request->nombre_perspectiva;
        $perspectiva_edit->ponderacion = $request->ponderacion_perspectiva;

        $perspectiva_edit->save();
        
        return back()->with('edit', 'La perspectiva fue editada');


    }






    public function detalle_perspectiva(Perspectiva $perspectiva){

        $objetivos = Objetivo::where('id_perspectiva', $perspectiva->id)->get();
        $indicadores = Indicador::get();


        return view('admin.agregar_objetivos_perspectiva', compact('perspectiva', 'objetivos', 'indicadores'));

    }


    public function objetivo_delete(Objetivo $objetivo){

        $objetivo->delete();

        return back()->with('deleted', 'El objetivo fue borrado!');


    }


    public function objetivo_update(Request $request, Objetivo $objetivo){

        $request->validate([

            "nombre_objetivo_edit" => "required",
            "ponderacion_objetivo_edit" => "required"

        ]);


        $objetivo->nombre = $request->nombre_objetivo_edit;
        $objetivo->ponderacion = $request->ponderacion_objetivo_edit;
        $objetivo->save();



        return back()->with('actualizado', 'El objetivo fue actualizado');
    
    }




    public function objetivo_store(Request $request, Perspectiva $perspectiva){
    
        $request->validate([

            "nombre_objetivo"  => "required",
            "ponderacion_objetivo" => "required",
            
        ]);


        Objetivo::create([
            "nombre" => $request->nombre_objetivo,
            "ponderacion" => $request->ponderacion_objetivo,
            "id_perspectiva" => $perspectiva->id
        ]);



        return back()->with('success', 'Se agrego el objetivo!');

    }




    public function add_indicador_objetivo(Request $request, Objetivo $objetivo){


        $request->validate([
            'indicadores' => 'required|array|min:1',
            'indicadores.*' => 'integer|exists:indicadores,id',
        ]);



        // IDs seleccionados
    $idsIndicadores = $request->indicadores;

        Indicador::whereIn('id', $idsIndicadores)
            ->update([
                'id_objetivo_perspectiva' => $objetivo->id
            ]);

        return back()->with('success', 'Indicadores asignados correctamente.');
    }



    public function agregar_ponderacion_indicador_objetivo(Indicador $indicador, Request $request ){

        
        $request->validate([

            "ponderacion_indicador" => "required"

        ]);



        $indicador->ponderacion_indicador = $request->ponderacion_indicador;
        $indicador->save();




        return back()->with('success', 'La ponderación fue guardada');

    }



}
