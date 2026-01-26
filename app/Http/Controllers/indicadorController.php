<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Support\Str;
use App\Models\CampoCalculado;
use App\Models\CampoForaneo;
use App\Models\CumplimientoNorma;
use App\Models\CampoInvolucrado;
use App\Models\CampoPrecargado;
use App\Models\CampoVacio;
use App\Models\InformacionInputVacio;
use App\Models\InformacionForanea;
use App\Models\InformacionInputPrecargado;
use App\Models\InformacionInputCalculado;
use Illuminate\Http\Request;
use App\Models\Departamento;
use App\Models\Norma;
use App\Models\Indicador;
use App\Models\IndicadorLleno;
use App\Models\Encuesta;
use App\Models\User;
use App\Models\LogBalanced;
use App\Models\MetaIndicador;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
class indicadorController extends Controller
{


    public function agregar_indicadores_index(Departamento $departamento){

        
        $indicadores = Indicador::where('id_departamento', $departamento->id)->get();
        $usuarios = User::with('departamento')->where('id_departamento', $departamento->id)->get();
        $encuestas = Encuesta::where("id_departamento", $departamento->id)->get();
        $normas = Norma::where("id_departamento", $departamento->id)->get();
        $departamentos = Departamento::get();



    
        //Teniendo el departamento tomo los indicadores que se le estan registrando.
        $indicadores_ponderaciones = Indicador::where('id_departamento', $departamento->id)->get();
        $ponderacion_indicadores = [];
        foreach($indicadores_ponderaciones as $indicador_ponderacion){
            array_push($ponderacion_indicadores, $indicador_ponderacion->ponderacion);
        }



        $normas_ponderaciones = Norma::where('id_departamento', $departamento->id)->get();
        $ponderacion_normas = [];
        foreach($normas_ponderaciones as $norma_ponderacion){
            array_push($ponderacion_normas, $norma_ponderacion->ponderacion);
        }



        $encuestas_ponderaciones = Encuesta::where('id_departamento', $departamento->id)->get();
        $ponderacion_encuestas = [];
        foreach($encuestas_ponderaciones as $encuesta_ponderacion){
            array_push($ponderacion_encuestas, $encuesta_ponderacion->ponderacion);
        }


        $ponderacion = array_sum(array_merge($ponderacion_indicadores, $ponderacion_normas, $ponderacion_encuestas));





        

        return view('admin.agregar_indicadores', compact('departamento','indicadores', 'usuarios', 'departamentos', 'encuestas', 'normas', 'ponderacion' ));

    }




    public function agregar_indicadores_store(Request $request, Departamento $departamento){


        $autor = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;

         
        $nombre_admin = Auth::guard('admin')->user()->nombre;
        $puesto = Auth::guard('admin')->user()->puesto;


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
        $indicador->tipo_indicador = $request->tipo_indicador;

        // if ($request->planta_1 == "active") $indicador->planta_1 = $request->planta_1;
        // if ($request->planta_2 == "active") $indicador->planta_2 =  $request->planta_2;
        // if ($request->planta_3 == "active") $indicador->planta_3 = $request->planta_3;

        $indicador->creador = $nombre_admin . ' - ' . $puesto;
        $indicador->save();


        //registro del log
        LogBalanced::create([
            'autor' => $autor,
            'accion' => "add",
            'descripcion' => "Se agrego el indicador : ".$indicador->nombre . " con el id: ". $indicador->id,
            'ip' => $request->ip() 
        ]);
        //registro del log



        
        return back()->with('success', 'El indicador fue creado!');

    }


    public function borrar_indicador(Indicador $indicador){

        $autor = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;



        $indicador->delete();


        //registro del log
        LogBalanced::create([
            'autor' => $autor,
            'accion' => "deleted",
            'descripcion' => "Se elimino el indicador : ".$indicador->nombre . " con el id: ". $indicador->id,
            'ip' => request()->ip() 
        ]);
        //registro del log



        return back()->with('eliminado', 'El indicador fue eliminado');


    }


    public function indicador_edit(Request $request, Indicador $indicador){

        $autor = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;


        $request->validate([

            "meta_minima" => "required",
            "meta_esperada" => "required",
            "ponderacion_indicador_edit" => "required"

        ]);

        // Capturar estado anterior para el log
        $cambios = [];
        if($indicador->meta_esperada != $request->meta_esperada) {
            $cambios[] = "Meta Esperada: '{$indicador->meta_esperada}' -> '{$request->meta_esperada}'";
        }
        if($indicador->meta_minima != $request->meta_minima) {
            $cambios[] = "Meta Mínima: '{$indicador->meta_minima}' -> '{$request->meta_minima}'";
        }
        if($indicador->ponderacion != $request->ponderacion_indicador_edit) {
            $cambios[] = "Ponderación: '{$indicador->ponderacion}' -> '{$request->ponderacion_indicador_edit}'";
        }

        $indicador->meta_esperada = $request->meta_esperada;
        $indicador->meta_minima = $request->meta_minima;
        $indicador->ponderacion = $request->ponderacion_indicador_edit;

        $indicador->update();


        //registro del log
        $descripcion = "Se actualizo el indicador: ".$indicador->nombre." (ID: ".$indicador->id.")";
        if(!empty($cambios)) {
            $descripcion .= ". Cambios: ".implode(", ", $cambios);
        }
        
        LogBalanced::create([
            'autor' => $autor,
            'accion' => "update",
            'descripcion' => $descripcion,
            'ip' => request()->ip() 
        ]);
        //registro del log



        return back()->with('success', 'El indicador fue actualizado!');

    }



    public function indicador_index(Indicador $indicador){

        //esta linea me ayuda a cargar las relaciones que tiene el Inidcador, por que inyecte el indicador directo en el metodo y no lo consulte con su respectiva query
        $indicador->load('departamento');


        //verificar si ya hay un campo_final en este indicador.
         $campo_final = CampoCalculado::where('id_indicador', $indicador->id)->where('resultado_final', 'on')->get();

        //consultar el campo de referencia.
        $campo_referencia = CampoCalculado::where('id_indicador', $indicador->id)->where('referencia', 'on')->get();




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
        $informacion_foranea = CampoForaneo::get();

        return view('admin.indicador', compact('indicador', 'campos_vacios','campos_precargados', 'informacion_foranea', 'campos_unidos', 'campo_final', 'campo_referencia'));

    }






public function borrar_campo(Request $request, $campo){

        $autor = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;

        //vamos a buscar el id_input en la base de datos de los campos involucrados.
        $id_indicador = CampoInvolucrado::where('id_input',$request->id_input)->first();

        //  return $id_indicador;

        if($id_indicador){

            return back()->with('error_input', 'Este campo esta siendo utilizado como parte de otro campo, por lo que no puede ser eliminado');

        }



    
        if($request->campo_calculado && $request->campo_vacio){
            
            $campo_delete = CampoCalculado::findOrFail($campo);
            $nombre_campo = $campo_delete->nombre;
            $campo_delete->delete();
            
            LogBalanced::create([
                'autor' => $autor,
                'accion' => "deleted",
                'descripcion' => "Se elimino el campo calculado: ".$nombre_campo." (ID: ".$campo.") del indicador",
                'ip' => request()->ip() 
            ]);
            
            return back()->with("deleted", "El campo fue eliminado del indicador!.");
        }
        


   
        if($request->campo_vacio){

           $campo_delete = CampoVacio::findOrFail($campo);
           $nombre_campo = $campo_delete->nombre;
           $campo_delete->delete();
           
           LogBalanced::create([
               'autor' => $autor,
               'accion' => "deleted",
               'descripcion' => "Se elimino el campo vacio: ".$nombre_campo." (ID: ".$campo.") del indicador",
               'ip' => request()->ip() 
           ]);
           
           return back()->with("deleted", "El campo fue eliminado del indicador!.");
 
        }



        if($request->campo_precargado){

            $campo_delete = CampoPrecargado::findOrFail($campo);
            $nombre_campo = $campo_delete->nombre;
            $campo_delete->delete();
            
            LogBalanced::create([
                'autor' => $autor,
                'accion' => "deleted",
                'descripcion' => "Se elimino el campo precargado: ".$nombre_campo." (ID: ".$campo.") del indicador",
                'ip' => request()->ip() 
            ]);
            
            return back()->with("deleted", "El campo fue eliminado del indicador");

        }




        return back()->with('Error', 'Ocurrio un error inesperado!');


}



    //retornando los indicadores a la 
    
    
public function show_indicador_user(Indicador $indicador){



    //le mandamos los admins para que les envie el correo de que ya se lleno el indicador
  $correos = Admin::pluck('email')->toArray();

    //CONSULTA DE LOS CAMPOS
    //se consultan en la vista para que el usuario los rellene
    $campos_vacios = CampoVacio::where('id_indicador', $indicador->id)->get();

    //se consultan en la vista para que el usuario los vea
    $campos_llenos = CampoPrecargado::where('id_indicador', $indicador->id)->get();

    //esta es la consulta que me va a dar el arreglo para hacer los iclos y realizar las operaciones.
    $campos_calculados = CampoCalculado::with('campo_involucrado')->where('id_indicador', $indicador->id)->where(function ($q) {
            $q->whereNull('resultado_final')
            ->orWhere('resultado_final', '');
        })->orderBy('created_at', 'ASC')->get();

    


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





   $datos = IndicadorLleno::where('id_indicador', $indicador->id)->get();

    $grupos = $datos->groupBy('id_movimiento')->sortKeysDesc();

    
    //se consultan las metas directo de la tabla del indicador para tenerlas actualizadas
    $meta_minima_general = $indicador->meta_minima;
    $meta_maxima_general = $indicador->meta_esperada;
    
    
    
    
    //Se consulta el campo de resultado final.
    $campo_resultado_final = CampoCalculado::where('id_indicador', $indicador->id)->whereNotNull('resultado_final')->where('resultado_final', '!=', '')->first();

    //datos para graficar...
    $graficar = IndicadorLleno::where('id_indicador', $indicador->id)
        ->where(function ($q) {
            $q->where('final', 'on')
            ->orWhere('referencia', 'on');
        })
        ->orderBy('created_at')
        ->get();

    $tipo_indicador = $indicador->tipo_indicador;

    


    return view('user.indicador', compact('indicador', 'campos_calculados', 'campos_llenos', 'campos_unidos', 'campo_resultado_final', 'campos_vacios', 'grupos', 'graficar', 'correos', 'meta_minima_general', 'meta_maxima_general', 'tipo_indicador'));



    
}//cierra el metodo de show_indicador_user








public function input_porcentaje_guardar(Request $request, Indicador $indicador){

   $autor_log = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;
   $autor = auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;
    


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
        "autor" => $autor,
        "tipo" => "number",
        "operacion" => "porcentaje",
        "resultado_final" => $request->resultado_final,
        "referencia" => $request->referencia,
        "id_indicador" => $indicador->id,
        "descripcion" => $request->descripcion,

    ]);







    for($i=0; $i < $contador; $i++){
        
        CampoInvolucrado::create([
            "id_input" => $request->input_porcentaje[$i],
            "tipo" => "number",
            "posicion" => $i,
            "id_input_calculado" => $campo_calculado->id
        ]);

    }






    return back()->with("success", "El campo de porcentaje ha sido creado");


}



public function input_resta_guardar(Request $request, Indicador $indicador){



    $autor_log = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;
    $autor = auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;


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
            "autor" => $autor,
            "tipo" => "number",
            "operacion" => "resta",
            "resultado_final" => $request->resultado_final,
            "referencia" => $request->referencia,
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

    LogBalanced::create([
        'autor' => $autor_log,
        'accion' => "add",
        'descripcion' => "Se creo el campo calculado (resta): '{$request->nombre_campo_resta}' (ID: {$campo_calculado->id}) en el indicador: {$indicador->nombre}",
        'ip' => request()->ip() 
    ]);

    return back()->with("success", "Se agrego el campo de resta!");






}









public function input_division_guardar(Request $request, Indicador $indicador){



       $autor_log = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;
       $autor = auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;


    //COMPROBACION DEL CAMPO FINAL, SI YA HAY UN CAMPO FINAL NO SE PODRA AGREGAR OTRO
    if($request->resultado_final){

        $comprobacion = CampoCalculado::where('id_indicador', $indicador->id)
                        ->whereNotNull('resultado_final')
                        ->where('resultado_final', '!=', '')
                        ->get();

        if(!$comprobacion->isEmpty()){

            return back()->with('error_input', 'Ya existe un campo final en este indicador!');

        }

    }


    //COMPROBACION PARA QUE VENGAN DOS CAMPOS POR LO MENOS
    if(count($request->input_division) < 2 ) return back()->with('error', 'Se deben agregar un par de campos');

    $id_input  = Date('ydmHis').rand(0,100);

    
    $campo_calculado = CampoCalculado::create([

        "nombre" => $request->nombre_campo_division,
        "id_input" => $id_input,
        "autor" => $autor,
        "tipo" => "number",
        "operacion" => "division",
        "referencia" => $request->referencia,
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

    LogBalanced::create([
        'autor' => $autor_log,
        'accion' => "add",
        'descripcion' => "Se creo el campo calculado (división): '{$request->nombre_campo_division}' (ID: {$campo_calculado->id}) en el indicador: {$indicador->nombre}",
        'ip' => request()->ip() 
    ]);

    return back()->with("success", "Se a creado el nuevo campo de división");

}




public function input_suma_guardar(Request $request, Indicador $indicador){



    $autor_log = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;
    $autor = auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;



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
        "autor" => $autor,
        "operacion" => "suma",
        "referencia" => $request->referencia,
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

    LogBalanced::create([
        'autor' => $autor_log,
        'accion' => "add",
        'descripcion' => "Se creo el campo calculado (suma): '{$request->nombre_campo_suma}' (ID: {$campo_calculado->id}) en el indicador: {$indicador->nombre}",
        'ip' => request()->ip() 
    ]);


    return back()->with("success", "Se a creado el nuevo campo de suma");



}


public function input_multiplicacion_guardar(Request $request, Indicador $indicador){


       $autor_log = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;
       $autor = auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;



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
        "autor" => $autor,
        "operacion" => "multiplicacion",
        "referencia" => $request->referencia,
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

    LogBalanced::create([
        'autor' => $autor_log,
        'accion' => "add",
        'descripcion' => "Se creo el campo calculado (multiplicación): '{$request->nombre_campo_multiplicacion}' (ID: {$campo_calculado->id}) en el indicador: {$indicador->nombre}",
        'ip' => request()->ip() 
    ]);

    return back()->with("success", "Se a creado el nuevo campo de multiplicación");


}





public function input_promedio_guardar(Request $request, Indicador $indicador){


    

    $autor_log = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;
    $autor = auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;

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
            "autor" => $autor,
            "operacion" => "promedio",
            "resultado_final" => $request->resultado_final, 
            "referencia" => $request->referencia,
            "id_indicador" => $indicador->id,
            "descripcion" => $request->descripcion,
        ]);

        
        //Este ciclo manda todos los datos de los campos involucrados.
        for($i=0; $i < $contador; $i++){
            
            CampoInvolucrado::create([
                
                "id_input" => $request->input_promedio[$i],
                "tipo" => "number",
                "id_input_calculado" => $campo_calculado->id,
                "posicion" => $i
            ]);
            
        }

        LogBalanced::create([
            'autor' => $autor_log,
            'accion' => "add",
            'descripcion' => "Se creo el campo calculado (promedio): '{$request->nombre}' (ID: {$campo_calculado->id}) en el indicador: {$indicador->nombre}",
            'ip' => request()->ip() 
        ]);

        return back()->with('success', 'El nuevo campo de promedio a sido creado!');
        
}






public function lista_indicadores_admin(Departamento $departamento){


//Filtro de fechas para los indicadores
$inicio = request()->filled('fecha_inicio')
    ? Carbon::parse(request('fecha_inicio'), config('app.timezone'))
        ->startOfDay()
        ->utc()
    : Carbon::now(config('app.timezone'))
        ->startOfYear()
        ->utc();

$fin = request()->filled('fecha_fin')
    ? Carbon::parse(request('fecha_fin'), config('app.timezone'))
        ->endOfDay()
        ->utc()
    : Carbon::now(config('app.timezone'))
        ->endOfYear()
        ->utc();



//Consulta SQL que me tra el cumplimiento  de los indicadores multiplicados por su ponderacion.
 $subQuery = DB::table('indicadores_llenos as il')
    ->join('indicadores as i', 'i.id', '=', 'il.id_indicador')
    ->where('il.final', 'on')
    ->where('i.id_departamento', $departamento->id)
    ->whereBetween('il.created_at', [$inicio, $fin])
    ->selectRaw("
        il.id_indicador,
        i.ponderacion,
        DATE_FORMAT(il.created_at, '%Y-%m') as mes,
        AVG(CAST(il.informacion_campo AS DECIMAL(10,2))) as promedio_indicador
    ")
    ->groupBy('il.id_indicador', 'mes', 'i.ponderacion');



$cumplimientoIndicadoresMensual = DB::query()
    ->fromSub($subQuery, 't')
    ->selectRaw("
        mes,
        SUM(ROUND((promedio_indicador * ponderacion)/100, 2)) as cumplimiento_total
    ")
    ->groupBy('mes')
    ->orderBy('mes')
    ->get();




//CONSULTA SQL DE LAS ENCUESTAS..
 $resultado_encuestas = DB::table(DB::raw('
    (
        SELECT 
            DATE_FORMAT(r.created_at, "%Y-%m") AS mes,
            e.id AS encuesta_id,
            e.ponderacion,
            AVG(r.respuesta) AS promedio
        FROM encuestas e
        JOIN preguntas p ON p.id_encuesta = e.id
        JOIN respuestas r ON r.id_pregunta = p.id
        WHERE 
            e.id_departamento = ?
            AND p.cuantificable = 1
            AND r.created_at BETWEEN ? AND ?
        GROUP BY 
            e.id,
            e.ponderacion,
            mes
    ) as sub
'))
->setBindings([
    $departamento->id,
    $inicio,
    $fin
])
->select(
    'mes',
    DB::raw('SUM((promedio * (ponderacion / 10))) AS cumplimiento_total')
)
->groupBy('mes')
->orderBy('mes')
->get();






/*
 |------------------------------------------------------------
 | Subconsulta: meses donde hay cumplimiento
 |------------------------------------------------------------
 */
$meses = DB::table('cumplimiento_norma')
    ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as mes")
    ->whereBetween('created_at', [$inicio, $fin])
    ->distinct();

/*
 |------------------------------------------------------------
 | Consulta principal
 |------------------------------------------------------------
 */
 $resultado_norma = DB::table('norma as n')
    ->joinSub($meses, 'm', function ($join) {
        // cross join lógico para evaluar cada norma por mes
        $join->on(DB::raw('1'), '=', DB::raw('1'));
    })
    ->where('n.id_departamento', $departamento->id)
    ->select(
        'm.mes',
        DB::raw('
            ROUND(
                SUM(
                    (
                        (
                            SELECT COUNT(*)
                            FROM apartado_norma an2
                            WHERE an2.id_norma = n.id
                              AND EXISTS (
                                  SELECT 1
                                  FROM cumplimiento_norma cn2
                                  WHERE cn2.id_apartado_norma = an2.id
                                    AND DATE_FORMAT(cn2.created_at, "%Y-%m") = m.mes
                              )
                        )
                        /
                        (
                            SELECT COUNT(*)
                            FROM apartado_norma an3
                            WHERE an3.id_norma = n.id
                        )
                    ) * 100 * (n.ponderacion / 100)
                ),
            2) AS cumplimiento_total
        ')
    )
    ->groupBy('m.mes')
    ->orderBy('m.mes')
    ->get();





//CONSULTA SQL DEL CUMPLIMIENTO NORMATIVO..


//Uniendo los campos para generar la grafica del cumplimiento general
 $indicadores = $cumplimientoIndicadoresMensual
    ->pluck('cumplimiento_total', 'mes');

 $encuestas = $resultado_encuestas
    ->pluck('cumplimiento_total', 'mes');

 $normas = $resultado_norma
    ->pluck('cumplimiento_total', 'mes');


$meses = collect()
    ->merge($indicadores->keys())
    ->merge($encuestas->keys())
    ->merge($normas->keys())
    ->unique()
    ->sort()
    ->values();

    
$cumplimiento_general = $meses->map(function ($mes) use ($indicadores, $encuestas, $normas) {
    return [
        'mes' => $mes,
        'total' =>
            ($indicadores[$mes] ?? 0) +
            ($encuestas[$mes] ?? 0) +
            ($normas[$mes] ?? 0),
    ];
});




//FINALIZA PRUEBAS  PARA LO DE LAS GRAFICAS





$indicadores = Indicador::with('indicadorLleno')->where('id_departamento', $departamento->id)->get();

    //Este codigo es para sacar el cumplimiento normativo

$inicio = Carbon::now()->startOfMonth();
$fin = Carbon::now()->endOfMonth();
$diasMes = $inicio->daysInMonth;



$mesActual = now()->format('Y-m');

$normas = DB::table('norma')
    ->where('id_departamento', $departamento->id)
    ->select('id', 'nombre', 'meta_minima', 'meta_esperada')
    ->get();




$resultado_normas = [];

foreach ($normas as $norma) {

    // Total de apartados de la norma
    $totalApartados = DB::table('apartado_norma')
        ->where('id_norma', $norma->id)
        ->count();

    // Apartados cumplidos con evidencia en el mes
    $apartadosCumplidos = DB::table('apartado_norma')
        ->join('cumplimiento_norma', 'cumplimiento_norma.id_apartado_norma', '=', 'apartado_norma.id')
        ->join(
            'evidencia_cumplimiento_norma',
            'evidencia_cumplimiento_norma.id_cumplimiento_norma',
            '=',
            'cumplimiento_norma.id'
        )
        ->where('apartado_norma.id_norma', $norma->id)
        ->whereRaw("DATE_FORMAT(cumplimiento_norma.created_at, '%Y-%m') = ?", [$mesActual])
        ->distinct('apartado_norma.id')
        ->count('apartado_norma.id');

    // Porcentaje de cumplimiento
    $porcentaje = $totalApartados > 0
        ? round(($apartadosCumplidos / $totalApartados) * 100, 2)
        : 0;

    // Evaluación contra metas
    if ($porcentaje < $norma->meta_minima) {
        $estatus = 'bajo';
    } elseif ($porcentaje < $norma->meta_esperada) {
        $estatus = 'riesgo';
    } else {
        $estatus = 'cumple';
    }

    $resultado_normas[] = [
        'id_norma'        => $norma->id,
        'norma'           => $norma->nombre,
        'total_apartados' => $totalApartados,
        'cumplimiento'       => $apartadosCumplidos,
        'porcentaje'      => $porcentaje,
        'meta_minima'     => $norma->meta_minima,
        'meta_esperada'   => $norma->meta_esperada,
        'estatus'         => $estatus,
    ];
}




//CODIGO QUE ME AYUDA A MOSTRAR EL CUMPLIMIENTO DE LAS ENCUESTAS

$encuestas = DB::table('encuestas as e')
    ->leftJoin('preguntas as p', function ($join) {
        $join->on('p.id_encuesta', '=', 'e.id')
             ->where('p.cuantificable', 1);
    })
    ->leftJoin('respuestas as r', 'r.id_pregunta', '=', 'p.id')
    ->where('e.id_departamento', $departamento->id)
    ->select(
        'e.id',
        'e.nombre',
        DB::raw('MAX(e.meta_minima) as meta_minima'),
        DB::raw('MAX(e.meta_esperada) as meta_esperada'),
        DB::raw('COALESCE(ROUND((AVG(r.respuesta) / 10) * 100, 2), 0) as porcentaje_cumplimiento')
    )
    ->groupBy('e.id', 'e.nombre')
    ->get();

//CODIGO QUE ME AYUDA A MOSTRAR EL CUMPLIMIENTO DE LAS ENCUESTAS


 return view('admin.lista_indicadores', compact('indicadores', 'departamento', 'encuestas', 'resultado_normas', 'cumplimiento_general'));



}









public function indicador_lleno_show_admin(Indicador $indicador){

    
    $tipo_indicador = $indicador->tipo_indicador;

    //fehcas de filtrado, si request->fecha_inicio trae algo lo pone en la variable inicio si no deja aa inicio como el inicio del año.
    //se convirtieron las fechas a UTC para que coincidieran con el registro de busqueda.
    $inicio = request()->filled('fecha_inicio')
        ? Carbon::parse(request('fecha_inicio'), config('app.timezone'))
            ->startOfDay()
            ->utc()
        : Carbon::now(config('app.timezone'))
            ->startOfYear()
            ->utc();

    $fin = request()->filled('fecha_fin')
        ? Carbon::parse(request('fecha_fin'), config('app.timezone'))
            ->endOfDay()
            ->utc()
        : Carbon::now(config('app.timezone'))
            ->endOfYear()
            ->utc();


    //Para lgraficar los datos del indicador
    IndicadorLleno::where('id_indicador', $indicador->id)->where('final', 'on')->get();




    $graficar = IndicadorLleno::where('id_indicador', $indicador->id)
        ->where(function ($q) {
            $q->where('final', 'on')
            ->orWhere('referencia', 'on');
        })
        ->orderBy('created_at')
        ->get();



    //para graficar os datos del indicaor


    //Para mostrar los datos del indicador
    $datos = IndicadorLleno::where('id_indicador', $indicador->id)->whereBetween('created_at', [$inicio, $fin])->get();
    
    $grupos = $datos->groupBy('id_movimiento')->sortKeysDesc();

 
    //Se consulta el campo de resultado final.

    $campo_resultado_final = CampoCalculado::where('id_indicador', $indicador->id)->whereNotNull('resultado_final')->where('resultado_final', '!=', '')->first();
    //Para mostrar los datos el indicador

    $campos_llenos = CampoPrecargado::where('id_indicador', $indicador->id)->get();

    

    return view('admin.indicador_lleno_detalle', compact('indicador', 'campos_llenos', 'graficar', 'datos', 'grupos', 'indicador', 'tipo_indicador'));

}












//aui empieza el codigo para el llenado de indicadores
public function llenado_informacion_indicadores(Indicador $indicador, Request $request){


    $nombre_usuario = auth()->user()->name;
    $year = Carbon::now()->year;
    $mes = Carbon::now()->subMonth()->translatedFormat('F');
    //$id_movimiento = (string) Str::ulid();

     $id_movimiento = str_replace(':', '',str_replace(' ','',Carbon::now().'-'.random_int(0, 5000000))); //exagere un poquis, pero poatra que no de error


    //validando la insercion de datos

        $request->validate([

            "informacion_indicador" => "required",
            "id_input" => "required",
            "id_input_vacio" => "required",
            "tipo_input" => "required"
        
        ]);


//EN ESTA PARTE SE CARGAN LOS CAMPOS VACIOS AL INDICADORE LLENO....
        for($i=0 ; $i < count($request->informacion_indicador) ; $i++ ){
        
            InformacionInputVacio::create([

                "id_input_vacio" => $request->id_input_vacio[$i],
                "informacion" => $request->informacion_indicador[$i],
                "id_input" => $request->id_input[$i],
                "tipo" => 'number',
                "mes" => $mes,
                "year" => $year

            ]);

            //creo que es aqui, es u for que de acuerdo al numero de campos vacios 
            // 
            IndicadorLleno::create([

                "nombre_campo" => $request->nombre_input_vacio[$i],
                "informacion_campo" => $request->informacion_indicador[$i], 
                "id_indicador" =>$indicador->id,
                "id_movimiento" => $id_movimiento

            ]);
        }

//EN ESTA PARTE SE CARGAN LOS CAMPOS VACIOS AL INDICADORE LLENO....


//SE AGREGAN LOS INPUTS PRECARGADOS AL INDICADOR LLENO

$inputs_precargados = CampoPrecargado::where('id_indicador', $indicador->id)->get();



foreach($inputs_precargados as $index_precargados => $precargado){


       

     $informacion = InformacionInputPrecargado::where('id_input_precargado', $precargado->id)->latest()->first();


        IndicadorLleno::create([
            "nombre_campo" => $precargado->nombre,
            "informacion_campo" => $informacion->informacion,
            "id_indicador" =>$indicador->id,
            "id_movimiento" => $id_movimiento
        ]);  

}

//SE AGREGAN LOS INPUTS PRECARGADOS AL INDICADOR LLENO



        //Aqui esta la logica nueva 03 de diciembre del 2025
        //Se toman los inputs calculados segun el ID del indicador:

         // $campos_calculados_indicador = CampoCalculado::with('campo_involucrado')->where('id_indicador', $indicador->id)->get();

       $campos_calculados_indicador = CampoCalculado::with(['campo_involucrado' => function ($q) {
                                                            $q->orderBy('posicion', 'asc');
                                                           }])
                                                             ->where('id_indicador', $indicador->id)
                                                            ->get();



        //Aqui es donde se desarrollara la logica, vamos a ver como.
        //se recorren los campos_calculados encontrados en el indicador
        foreach($campos_calculados_indicador as $index_calculado => $campo_calculado) {
            
            $informacion_campos_vacios_encontrados = [];
            $informacion_campos_precargados_encontrados = [];
            $informacion_campos_calculados_encontrados = [];

            $campos_vacios_encontrados = [];
            $campos_precargados_encontrados = [];
            $campos_calculados_encontrados = [];
                    
            


            //arrays que me ayudan a guardar la info de los campos encontrados
                $datos = [];

                foreach ($campo_calculado->campo_involucrado as $index_involucrado => $campo_involucrado) {

                    $existe_en_vacios = CampoVacio::where('id_input', $campo_involucrado->id_input)->latest()->first();
                    $existe_en_precargados = CampoPrecargado::where('id_input', $campo_involucrado->id_input)->latest()->first();
                    $existe_en_calculados = CampoCalculado::where("id_input", $campo_involucrado->id_input)->latest()->first();

                    // Vacíos
                    if ($existe_en_vacios) {
                        $info = InformacionInputVacio::where('id_input', $existe_en_vacios->id)->latest()->first();
                        if ($info) {
                            $datos[$index_involucrado] = $info->informacion;
                        }
                    }

                    // Precargados
                    if ($existe_en_precargados) {
                        $info = InformacionInputPrecargado::where('id_input_precargado', $existe_en_precargados->id)->latest()->first();
                        if ($info) {
                            $datos[$index_involucrado] = $info->informacion;
                        }
                    }

                    // Calculados
                    if ($existe_en_calculados) {
                        $info = InformacionInputCalculado::where('id_input_calculado', $existe_en_calculados->id)->latest()->first();
                        if ($info) {
                            $datos[$index_involucrado] = $info->informacion;
                        }
                    }
                }


               





                    //aqui va la insercion de la info en el campo calculado
                    if($campo_calculado->operacion === "suma"){

                        
                        InformacionInputCalculado::create([
                            
                            'id_input_calculado' => $campo_calculado->id,
                            'tipo' => $campo_involucrado->tipo,
                            'informacion' => round(array_sum($datos), 4),
                            'mes' => $mes,
                            'year' => $year

                        ]);



                        //paso la informacion a la tabla de indicadores llenos
                      
                        IndicadorLleno::create([

                            'nombre_campo' => $campo_calculado->nombre,
                            'informacion_campo' => round(array_sum($datos), 4),
                            'id_indicador' => $indicador->id,
                            'id_movimiento' => $id_movimiento,
                            'final' => $campo_calculado->resultado_final,
                            'referencia' => $campo_calculado->referencia

                        ]);
                        

                    }



                    if($campo_calculado->operacion === "promedio"){
                                           
    
                        InformacionInputCalculado::create([

                            'id_input_calculado' => $campo_calculado->id,
                            'tipo' => $campo_involucrado->tipo,
                            'informacion' => round(array_sum($datos) / count($datos), 4),
                            'mes' => $mes,
                            'year' => $year

                        ]);



                        IndicadorLleno::create([

                            'nombre_campo' => $campo_calculado->nombre,
                            'informacion_campo' => round(array_sum($datos) / count($datos), 4),
                            'id_indicador' => $indicador->id,
                            'id_movimiento' => $id_movimiento,
                            'final' => $campo_calculado->resultado_final,
                            'referencia' => $campo_calculado->referencia
                        ]);



                    }





                if($campo_calculado->operacion === "division"){

             


                    InformacionInputCalculado::create([

                        'id_input_calculado' => $campo_calculado->id,
                        'tipo' => $campo_involucrado->tipo,
                        'informacion' => round($datos[1] / $datos[0], 4),
                        'mes' => $mes,
                        'year' => $year

                    ]);



                    IndicadorLleno::create([

                        'nombre_campo' => $campo_calculado->nombre,
                        'informacion_campo' => round($datos[1] / $datos[0], 4),
                        'id_indicador' => $indicador->id,
                        'id_movimiento' => $id_movimiento,
                        'final' => $campo_calculado->resultado_final,
                        'referencia' => $campo_calculado->referencia

                    ]);



                }



                    if($campo_calculado->operacion === "porcentaje"){
                        
                       // return $datos;
                        $porcentaje = ($datos[1] == 0)
                            ? (($datos[0] == 0) ? 100 : 0)
                            : round(($datos[0] / $datos[1]) * 100, 4);


                        InformacionInputCalculado::create([

                            'id_input_calculado' => $campo_calculado->id,
                            'tipo' => $campo_involucrado->tipo,
                            'informacion' => $porcentaje,  
                            'mes' => $mes,
                            'year' => $year

                        ]);



                        IndicadorLleno::create([

                            'nombre_campo' => $campo_calculado->nombre,
                            'informacion_campo' => $porcentaje,
                            'id_indicador' => $indicador->id,
                            'id_movimiento' => $id_movimiento,
                            'final' => $campo_calculado->resultado_final,
                            'referencia' => $campo_calculado->referencia                            
                        ]);



                    }







                    if($campo_calculado->operacion === "resta"){

                        InformacionInputCalculado::create([
                            'id_input_calculado' => $campo_calculado->id,
                            'tipo' => $campo_involucrado->tipo,
                            'informacion' => round(($datos[0] - $datos[1]), 4),
                            'mes' => $mes,
                            'year' => $year
                        ]);


                        IndicadorLleno::create([

                            'nombre_campo' => $campo_calculado->nombre,
                            'informacion_campo' => round(($datos[0] - $datos[1]), 4),
                            'id_indicador' => $indicador->id,
                            'id_movimiento' => $id_movimiento,
                            'final' => $campo_calculado->resultado_final,
                            'referencia' => $campo_calculado->referencia

                        ]);



                    }





                    if($campo_calculado->operacion === "multiplicacion"){



                        InformacionInputCalculado::create([

                            'id_input_calculado' => $campo_calculado->id,
                            'tipo' => $campo_involucrado->tipo,
                            'informacion' => round(array_product($datos), 4),
                            'mes' => $mes,
                            'year' => $year

                        ]);

            

                        IndicadorLleno::create([

                            'nombre_campo' => $campo_calculado->nombre,
                            'informacion_campo' => round(array_product($datos), 4),
                            'id_indicador' => $indicador->id,
                            'id_movimiento' => $id_movimiento,
                            'final' => $campo_calculado->resultado_final,
                            'referencia' => $campo_calculado->referencia
                        ]);



                    }


   
        }


        //AQUI ESTA EL CODIGO De la persona que gusrada el indicador

        IndicadorLleno::create([

                "nombre_campo" => 'Registro',
                "informacion_campo" => $nombre_usuario,
                "id_indicador" =>$indicador->id,
                "id_movimiento" => $id_movimiento,
                "final" => 'registro'


        ]);
        //AQUI ESTA EL CODIGO De la persona que gusrada el indicador        

        //DEsde aqui se guarda el campo del comenatario
        if($request->comentario != null){

            IndicadorLleno::create([

                'nombre_campo' => "comentario",
                'informacion_campo' => $request->comentario,
                'id_indicador' => $indicador->id,
                'id_movimiento' => $id_movimiento,
                'final' => 'comentario'

            ]);
        }
        //Desde aqui se guarda el campo del comentario



        //Se agregan las metas del indicador que se tienen al momento de rellenar este mismo


        MetaIndicador::create([

            'meta_minima' => $indicador->meta_minima,
            'meta_maxima' => $indicador->meta_esperada,
            'id_movimiento_indicador_lleno' => $id_movimiento

        ]);


        
        return back()->with('success', 'El indicador fue rellenado ');


}




}
