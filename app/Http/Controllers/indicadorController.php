<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\CampoCalculado;
use App\Models\CampoInvolucrado;
use App\Models\CampoPrecargado;
use App\Models\CampoVacio;
use App\Models\InformacionInputVacio;
use App\Models\InformacionForanea;
use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Norma;
use App\Models\Indicador;
use App\Models\Encuesta;
use App\Models\User;

class indicadorController extends Controller
{


    public function agregar_indicadores_index(Departamento $departamento){

        $indicadores = Indicador::where('id_departamento', $departamento->id)->get();
        $usuarios = User::with('departamento')->where('id_departamento', $departamento->id)->get();
        $encuestas = Encuesta::where("id_departamento", $departamento->id)->get();
        $normas = Norma::where("id_departamento", $departamento->id)->get();
        



        $departamentos = Departamento::get();
        

        return view('admin.agregar_indicadores', compact('departamento','indicadores', 'usuarios', 'departamentos', 'encuestas', 'normas' ));

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
        $indicador->ponderacion = $request->ponderacion_indicador;
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
        })->orderBy('created_at', 'ASC')->get();


    //Se consulta el campo de resultado final.
    $campo_resultado_final = CampoCalculado::where('id_indicador', $indicador->id)->whereNotNull('resultado_final')->where('resultado_final', '!=', '')->first();


    //aqui hay un desmadre, combino todos los campos y les asigno un ID
    $campos_unidos = $campos_vacios->concat($campos_llenos)
                                    ->concat($campos_calculados)
                                    ->sortBy('created_at')
                                    ->values()
                                    ->map(function($item, $index){
                                    $item->id_nuevo = $index + 1; //con esto empezara en 1
                                    return $item;
    });
    //para poder hacer las opreaciones tengo que consultar todo.
    
    


    //el desmadre que combina los campos y les asigno un ID
    $campos_involucrados = [];
    $campos_involucrados2 = [];
    $campos_calculados2 = [];
    $contador = 0;
    $ids_inputs = [];
    $operaciones = [];




    //Ok, vamos de nueo con la logica de esta cosa.
    //este ciclo me va a dar la oportunidad de recorrer todos los campos calculados



    foreach($campos_calculados as $calculado){


        //este ciclo me permitira saber los campos involucrados dentro de cada campo calculado.
        foreach($calculado->campo_involucrado as $campo_involucrado){

            //consulta sql para ver los campos vacios que estan involucrados en este input.
            array_push($campos_involucrados, CampoVacio::where("id_input", $campo_involucrado->id_input)->get());

            //defino la variable que me traera los campos calculados que son involucrados en otro campo calculado.
            $campos_involucrados_calculados = CampoCalculado::where('id_input', $campo_involucrado->id_input)->get();

            array_push($campos_involucrados2, $campos_involucrados_calculados);

        }




        
        //se retorna la variable dentro del primer ciclo, ya que si lo retorno afuera de los
        //dos ciclos me hace una consulta de mas.
        array_push($ids_inputs, $campos_involucrados[$contador][0]->id_input);

        //aqui se obtiene la operacion que se va a realizar
        //return $calculado->operacion;

        // return $campos_calculados[1];
        array_push($operaciones, $campos_calculados[$contador]->operacion);

    }


 
    
    return view('user.indicador', compact('indicador', 'campos_calculados', 'campos_llenos', 'campos_unidos', 'campo_resultado_final', 'campos_vacios'));



    
}//cierra el metodo de show_indicador_user














public function input_porcentaje_guardar(Request $request, Indicador $indicador){

    if($request->resultado_final){

        $comprobacion = CampoCalculado::where('id_indicador', $indicador->id)
            ->whereNotNull('resultado_final')
            ->where('resultado_final', '!=', '')
            ->get();
            
        
        if(!$comprobacion->isEmpty()){
            return back()->with('error_input', 'Ya extiste un campo de resultado final en este indicador, por lo que no se puede crear otro. Thanks!');
        }

    }


    if(count($request->input_porcentaje) < 2 ) return back()->with("error", "Debe agregregar un par de campos");

    $contador = count($request->input_porcentaje);
    $id_input = Date('ydmHis').rand(0,100);



    $campo_calculado = CampoCalculado::create([

        "nombre" => $request->nombre,
        "id_input" => $id_input,
        "tipo" => "number",
        "operacion" => "porcentaje",
        "resultado_final" => $request->resultado_final,
        "id_indicador" => $indicador->id,
        "descripcion" => $request->descripcion,

    ]);

    for($i=0; $i < $contador; $i++){
        
        CampoInvolucrado::create([
            "id_input" => $request->input_porcentaje[$i],
            "tipo" => "number",
            "id_input_calculado" => $campo_calculado->id
        ]);

    }

    return back()->with("success", "El campo de porcentaje ha sido creado");


}



public function input_resta_guardar(Request $request, Indicador $indicador){


    if($request->resultado_final){

        $comprobacion = CampoCalculado::where('id_indicador', $indicador->id)
                        ->whereNotNull('resultado_final')
                        ->where('resultado_final', '!=', '')
                        ->get();

        if(!$comprobacion->isEmpty()){

            return back()->with("error_input", "Ya existe un campo final en este indicador!");
        
        }

    }

    if(count($request->input_resta) < 2 ) return back()->with("error", "Se deben agregar dos campos!");


    $id_input = Date('ydmHis').rand(0,100);

    $campo_calculado = CampoCalculado::create([

            "nombre" => $request->nombre_campo_resta,
            "id_input" => $id_input,
            "tipo" => "number",
            "operacion" => "resta",
            "resultado_final" => $request->resultado_final,
            "id_indicador" => $indicador->id,
            "descripcion" => $request->descripcion

    ]);


    CampoInvolucrado::create([

        "id_input" => $request->input_resta[0],
        "tipo" => "number",
        "id_input_calculado" => $campo_calculado->id,
        "posicion" => "0"

    ]);


    CampoInvolucrado::create([

        "id_input" => $request->input_resta[1],
        "tipo" => "number",
        "id_input_calculado" => $campo_calculado->id,
        "posicion" => "1"

    ]);


    return back()->with("success", "Se agrego el campo de resta!");






}




public function input_division_guardar(Request $request, Indicador $indicador){





     //$request->input_division[0] -> el mero divisor, el que va a dividir
    //$request->input_division[1] -> el dividendo,es al que se van a dividor
    if($request->resultado_final){

        $comprobacion = CampoCalculado::where('id_indidcador', $indicador->id)
                        ->whereNotNull('resultado_final')
                        ->where('resultado_final', '!=', '')
                        ->get();

        if(!$comprobacion->isEmpty()){

            return back()->with('error_input', 'Ya existe un campo final en este indicador!');

        }

    }



    if(count($request->input_division) < 2 ) return back()->with('error', 'Se deben agregar un par de campos');


    $id_input  = Date('ydmHis').rand(0,100);

    
    $campo_calculado = CampoCalculado::create([

        "nombre" => $request->nombre_campo_division,
        "id_input" => $id_input,
        "tipo" => "number",
        "operacion" => "division",
        "resultado_final" => $request->resultado_final,
        "id_indicador" => $indicador->id,
        "descripcion" => $request->descripcion

    ]);


    //En lugar del for voy a hacerlo a mano ya que sol son dos campos y necesito diferenciar entre el primero y el segundo

    
    CampoInvolucrado::create([

        "id_input" => $request->input_division[0],
        "tipo" => "number",
        "id_input_calculado" => $campo_calculado->id,
        "posicion" => "0"

    ]);


    CampoInvolucrado::create([

        "id_input" => $request->input_division[1],
        "tipo" => "number",
        "id_input_calculado" => $campo_calculado->id,
        "posicion" => "1"

    ]);



    return back()->with("success", "Se a creado el nuevo campo de división");

}


public function input_suma_guardar(Request $request, Indicador $indicador){




if($request->resultado_final){

    $comprobacion = CampoCalculado::where('id_indicador', $indicador->id)
                    ->whereNotNull('resultado_final')
                    ->where('resultado_final', '!=', '')
                    ->get();

    if(!$comprobacion->isEmpty()){
        
        return back()->with('error_input', 'Ya existe un campo final en este indicador.');
        
    } 
}



if( count($request->input_suma) < 2) return back()->with('error', 'Se debe agregar por lo menos dos campos!');

    $contador = count($request->input_suma);
    $id_input = Date('ydmHis').rand(0,100);



    $campo_calculado = CampoCalculado::create([

        "nombre" => $request->nombre_campo_suma,
        "id_input" => $id_input,
        "tipo" => "number",
        "operacion" => "suma",
        "resultado_final" => $request->resultado_final,
        "id_indicador" => $indicador->id,
        "descripcion" => $request->descripcion


    ]);


    for($i=0; $i < $contador; $i++){

        CampoInvolucrado::create([

            "id_input" => $request->input_suma[$i],
            "tipo" => "number",
            "id_input_calculado" => $campo_calculado->id

        ]);

    }


    return back()->with("success", "Se a creado el nuevo campo de suma");


}




public function input_multiplicacion_guardar(Request $request, Indicador $indicador){

    

    

    if($request->resultado_final){

        $comprobacion = CampoCalculado::where('id_indicador', $indicador->id)
                        ->whereNotNull('resultado_final')
                        ->where('resultado_final', '!=','')
                        ->get();


        if(!$comprobacion->isEmpty()){
    
            return back()->with('error_input', 'Ya existe un campo resultado en este indicador.');
    
        }

    }


    //validando que no venga vacio
    if(count($request->input_multiplicado) < 2) return back()->with("error", 'Se debe poner por lo menos un par de campos');

    $contador = count($request->input_multiplicado);

    $id_input = Date('ydmHis').rand(0,100);


    //se crea el nuevo campo calculado, este campo contendra la informacion de todos los campos que los componen, es decir, despues de crear este campo vamos a  crear los registros de los campos involucrados con este campo calculado.

    
    
    $campo_calculado = CampoCalculado::create([

        "nombre" => $request->nombre_campo_multiplicacion,
        "id_input" => $id_input,
        "tipo" => "number",
        "operacion" => "multiplicacion",
        "resultado_final" => $request->resultado_final,
        "id_indicador" => $indicador->id,
        "descripcion" => $request->descripcion

    ]);

    


    for($i=0; $i<$contador; $i++){

        CampoInvolucrado::create([

            "id_input" => $request->input_multiplicado[$i],
            "tipo" => "number",
            "id_input_calculado" => $campo_calculado->id

        ]);

    }

    return back()->with("success", "Se a creado el nuevo campo de multiplicación");


}



public function input_promedio_guardar(Request $request, Indicador $indicador){

       
    //aqui se hace la verificación si el campo combinado de promedio qued marcado como campo final
    if($request->resultado_final){

       $comprobacion = CampoCalculado::where('id_indicador', $indicador->id)
            ->whereNotNull('resultado_final')
            ->where('resultado_final', '!=', '')
            ->get();
   

        //Se necesita comprobar que en el indicador no haya mas Campos que sean Resultado Final
        //creo que aqui ya hice esa validación, soy un crack ya habia avanzado algo
        if(!$comprobacion->isEmpty() ){

            return back()->with('error_input', 'Ya existe un campo de resultado final en este indicador, por lo que no se puede crear otro.' );
        
        }

    }


    if(count($request->input_promedio) < 2) return back()->with("error", 'Debe agregar almenos un par de campos');
    //termina el bloque de comprobacion del campo final


    // Tremendo, parece que ya tengo un poco de logic implementada
       //contara los inputs que vienen y creara el ciclo para mandarlos a CamposInvolucrados.
       $contador = count($request->input_promedio);
        

       //Sacando el ID para el campo y se pueda gestionar el el combinados de campos al crear nuevos
       $id_input = Date('ydmHis').rand(0,100);
       //Sacando el ID para el campo y se pueda gestionar el el combinados de campos al crear nuevos
        
        
        $campo_calculado = CampoCalculado::create([
            
            "nombre" => $request->nombre,
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



public function lista_indicadores_admin(Departamento $departamento){

    $indicadores = Indicador::where('id_departamento', $departamento->id)->get();
    $encuestas = Encuesta::where('id_departamento', $departamento->id)->get();
    $normas = Norma::where('id_departamento', $departamento->id)->get();

    return view('admin.lista_indicadores', compact('indicadores', 'departamento', 'encuestas', 'normas'));

}


public function indicador_lleno_show_admin(Indicador $indicador){


    $campos_llenos = CampoPrecargado::where('id_indicador', $indicador->id)->get();
    
    return view('admin.indicador_lleno_detalle', compact('indicador', 'campos_llenos'));

}






//aui empieza el codigo para el llenado de indicadores
public function llenado_informacion_indicadores(Indicador $indicador, Request $request){

    $request->validate([

        "informacion_indicador" => "required",
        "id_input" => "required",
        "id_input_vacio" => "required",
        "tipo_input" => "required"
    
    ]);


    $contador = count($request->informacion_indicador);


        for($i=0 ; $i < $contador ; $i++ ){
        
            InformacionInputVacio::create([

                "id_input_vacio" => $request->id_input_vacio[$i],
                "informacion" => $request->informacion_indicador[$i],
                "id_input" => $request->id_input[$i],
                "tipo" => $request->tipo_input[$i]

            ]);

        }

    return back()->with('success', 'El indicador fue rellenado');

}



}
