<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CampoCalculado;
use App\Models\CampoInvolucrado;
use App\Models\CampoPrecargado;
use App\Models\CampoVacio;
use App\Models\InformacionForanea;
use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Indicador;
use App\Models\User;

class indicadorController extends Controller
{


    public function agregar_indicadores_index(Departamento $departamento){

        $indicadores = Indicador::where('id_departamento', $departamento->id)->get();

        $usuarios = User::with('departamento')->where('id_departamento', $departamento->id)->get();
        



        $departamentos = Departamento::get();
        





        return view('admin.agregar_indicadores', compact('departamento','indicadores', 'usuarios', 'departamentos' ));

    }




    public function agregar_indicadores_store(Request $request, Departamento $departamento){
    

        $request->validate([

            'nombre_indicador' => 'required'

        ]);


        $indicador = new Indicador();
        $indicador->nombre = $request->nombre_indicador;
        $indicador->id_departamento = $departamento->id;
        $indicador->descripcion = $request->descripcion;
        $indicador->meta_esperada = $request->meta_esperada;
        $indicador->meta_minima = $request->meta_minima;
        if ($indicador->planta_1) $request->planta_1;
        if ($indicador->planta_2) $request->planta_2;
        if ($indicador->planta_3) $request->planta_3; 
        $indicador->save();

        
        return back()->with('success', 'El indicador fue creado!');

    }


    public function borrar_indicador(Indicador $indicador){


        $indicador->delete();

        return back()->with('eliminado', 'El indicador fue eliminado');


    }



    public function indicador_index(Indicador $indicador){

        //esta linea me ayuda a cargar las relaciones que tiene el Inidcador, por que inyecte el indicador directo en el metodo y no lo consulte con su respectiva query
        $indicador->load('departamento');
        $campos_vacios = CampoVacio::where('id_indicador', $indicador->id)->get();
        $campos_precargados = CampoPrecargado::where('id_indicador', $indicador->id)->get();


        // $campos_unidos = $campos_vacios->union($campos_precargados)->orderBy('created_at', 'desc')->get();


        $campos_unidos = $campos_vacios->
        concat($campos_precargados)->
        sortBy('created_at')->
        values()->map(function($item, $index){
            $item->id_nuevo = $index + 1; //con esto empezara en 1
            return $item;
        });




        //Llamar a la informacion 
        $informacion_foranea = InformacionForanea::get();

        return view('admin.indicador', compact('indicador', 'campos_vacios','campos_precargados', 'informacion_foranea', 'campos_unidos'));

    }



    public function borrar_campo(Request $request, $campo){

        
        if($request->campo_vacio){

           $campo = CampoVacio::findOrFail($campo);
           $campo->delete();
           return back()->with("deleted", "El campo fue eliminado del indicador!");
 
        }

        if($request->campo_precargado){

            $campo = CampoPrecargado::findOrFail($campo);
            $campo->delete();
            return back()->with("deleted", "El campo fue eliminado del indicador");

        }


        return back()->with('Error', 'Ocurrio un error inesperado!');


    }



    //retornando los indicadores a la 
    
    
public function show_indicador_user(Indicador $indicador){

    $campos_vacios = CampoVacio::where('id_indicador', $indicador->id)->get();
    $campo_llenos = CampoPrecargado::where('id_indicador', $indicador->id)->get();


    $campos_unidos = $campos_vacios->concat($campo_llenos)
                                    ->sortBy('created_at')
                                    ->values()
                                    ->map(function($item, $index){
                                    $item->id_nuevo = $index + 1; //con esto empezara en 1
                                    return $item;
        });




    return view('user.indicador', compact('indicador', 'campos_unidos'));
}



    public function input_promedio_guardar(Request $request, Indicador $indicador){
        

        //contara los inputs que vienen y creara el ciclo para mandarlos a CamposInvolucrados.
        $contador = count($request->input_promedio);
        
        
        
        $campo_calculado = CampoCalculado::create([
            
            "nombre" => $request->nombre_nuevo,
            "tipo" => "number",
            "operacion" => "promedio",
            "id_indicador" => $indicador->id
            
        ]);
        
        
        for($i=0; $i<$contador; $i++){
            
            CampoInvolucrado::create([
                
                "id_input" => $request->input_promedio[$i],
                "tipo" => "number",
                "id_input_calculado" => $campo_calculado->id,
                
            ]);
            
        }

        //Ahora hay que consultar todo esto que se guardo y combinarlo con los inputs que se muestran en la tabla de esta seccion la ctm!!
        
        

        return back();

    

        
        

    }






}
