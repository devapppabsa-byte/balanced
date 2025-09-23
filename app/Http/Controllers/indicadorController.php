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
        $campos_calculados = CampoCalculado::where('id_indicador', $indicador->id)->get();
        //DEspues de obtener los capos calculados correspondientes a este Indicador
        //Se procedera a obtener los id de los campos involucrados con el campo calculado.
        //se optienen para saber como van a ser las opereaciones, aunque en esta seccion podria
        //no obtenerlos ya que esas operaciones se van a hacer en el lado del usuario 





        // $campos_unidos = $campos_vacios->union($campos_precargados)->orderBy('created_at', 'desc')->get();


        $campos_unidos = $campos_vacios
        ->concat($campos_precargados)
        ->concat($campos_calculados)
        ->sortBy('created_at')
        ->values()
        ->map(function($item, $index){
            $item->id_nuevo = $index + 1; //con esto empezara en 1
            return $item;
        });




        //Llamar a la informacion 
        $informacion_foranea = InformacionForanea::get();

        return view('admin.indicador', compact('indicador', 'campos_vacios','campos_precargados', 'informacion_foranea', 'campos_unidos'));

    }






public function borrar_campo(Request $request, $campo){

        //vamos a buscar el id_input en la base de datos de los campos involucrados

         $id_indicador = CampoInvolucrado::where('id_input',$request->id_input)->first();

        //  return $id_indicador;

        if($id_indicador){

            return back()->with('error_input', 'Este campo esta siendo utilizado como parte de otro campo, por lo que no puede ser eliminado');

        }



    
        if($request->campo_calculado && $request->campo_vacio){
            $campo_delete = CampoCalculado::findOrFail($campo);
            $campo_delete->delete();
            return back()->with("deleted", "El campo fue eliminado del indicador!.");
        }


        if($request->campo_vacio){

           $campo_delete = CampoVacio::findOrFail($campo);
           $campo_delete->delete();
           return back()->with("deleted", "El campo fue eliminado del indicador!.");
 
        }



        if($request->campo_precargado){

            $campo_delete = CampoPrecargado::findOrFail($campo);
            $campo_delete->delete();
            return back()->with("deleted", "El campo fue eliminado del indicador");

        }




        return back()->with('Error', 'Ocurrio un error inesperado!');


}



    //retornando los indicadores a la 
    
    
public function show_indicador_user(Indicador $indicador){


    $campos_vacios = CampoVacio::where('id_indicador', $indicador->id)->get();
    $campos_llenos = CampoPrecargado::where('id_indicador', $indicador->id)->get();

    $campos_calculados = CampoCalculado::with('campo_involucrado')->where('id_indicador', $indicador->id)->where(function ($q) {
            $q->whereNull('resultado_final')
            ->orWhere('resultado_final', '');
        })->get();


    $campo_resultado_final = CampoCalculado::where('id_indicador', $indicador->id)->whereNotNull('resultado_final')->where('resultado_final', '!=', '')->first();


    $campos_unidos = $campos_vacios->concat($campos_llenos)
                                    ->concat($campos_calculados)
                                    ->sortBy('created_at')
                                    ->values()
                                    ->map(function($item, $index){
                                    $item->id_nuevo = $index + 1; //con esto empezara en 1
                                    return $item;
    });




    return view('user.indicador', compact('indicador', 'campos_calculados', 'campos_llenos', 'campos_unidos', 'campo_resultado_final', 'campos_vacios'));
}






public function input_promedio_guardar(Request $request, Indicador $indicador){
        
    //Hay que verificar que solo haya un campo_reultado_final



    if($request->resultado_final){

       $comprobacion = CampoCalculado::where('id_indicador', $indicador->id)
            ->whereNotNull('resultado_final')
            ->where('resultado_final', '!=', '')
            ->get();
   

        //Se necesita comprobar que en el indicador no haya mas Campos que sean Resultado Final
        if(!$comprobacion->isEmpty() ){

            return back()->with('error_input', 'Ya existe un campo de resultado final en este indicador, por lo que no se puede crear otro.' );
        
        }

    }

       //contara los inputs que vienen y creara el ciclo para mandarlos a CamposInvolucrados.
       $contador = count($request->input_promedio);
        

       //Sacando el ID para el campo y se pueda gestionar el el combinados de campos al crear nuevos
       $fecha_creado = date("YmdHis");
       $id_input = strtolower(str_replace(" ", "", $fecha_creado.$request->nombre_nuevo));
       //Sacando el ID para el campo y se pueda gestionar el el combinados de campos al crear nuevos
        
        
        $campo_calculado = CampoCalculado::create([
            
            "nombre" => $request->nombre_nuevo,
            "id_input" => $id_input,
            "tipo" => "number",
            "operacion" => "promedio",
            "resultado_final" => $request->resultado_final, 
            "id_indicador" => $indicador->id,
            "descripcion" => $request->descripcion,
        ]);

        
        //Este ciclo manda todos los datos de los campos involucrados.
        for($i=0; $i < $contador; $i++){
            
            CampoInvolucrado::create([
                
                "id_input" => $request->input_promedio[$i],
                "tipo" => "number",
                "id_input_calculado" => $campo_calculado->id,
                
            ]);
            
        }


        return back()->with('success', 'El nuevo campo de promedio a sido creado!');
        
        

}



}
