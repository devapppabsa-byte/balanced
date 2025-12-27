<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Departamento;
use App\Models\LogBalanced;
use Illuminate\Http\Request;

class departamentoController extends Controller
{



    public function eliminar_departamento(Departamento $departamento){

        try{

            $autor = auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;

            $departamento->delete();


            //registro del log
            LogBalanced::create([
                'autor' => $autor,
                'accion' => "Se elimino el departamento de : ".$departamento->nombre,                
            ]);
            //registro del log

            return back()->with('eliminado', 'El departamento fue eliminado!');
        
        } catch (\Illuminate\Database\QueryException $e) {
            
            if ($e->getCode() == '23000') {
                return redirect()->back()->with('error', 'No se puede eliminar este departamento porque está siendo utilizado en otra operación.');
        
        }

        return redirect()->back()->with('error', 'Ocurrió un error inesperado al intentar eliminar el departamento.');
    }



}

    



    public function actuliza_departamento(Departamento $departamento, Request $request){



        $autor = auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;


        $departamento->nombre = $request->nombre_departamento;
        $departamento->update();

        
            //registro del log
            LogBalanced::create([
                'autor' => $autor,
                'accion' => "Se actualizo el departamento : ".$departamento->nombre,                
            ]);
            //registro del log



        return back()->with('actualizado', 'El departamento '.$departamento->nombre. ' fue actualizado ');

    }


    public function departamentos_show_admin(){
        
        $departamentos = Departamento::get();


        return view('admin.gestionar_departamentos', compact("departamentos"));
    }


}
