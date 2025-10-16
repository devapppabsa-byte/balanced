<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;

class proveedorController extends Controller
{
    
    public function proveedores_show_admin(){

        $proveedores = Proveedor::with('evaluacion_proveedores')->get();

        return view('admin.gestionar_proveedores', compact('proveedores'));

    }


    public function proveedor_store(Request $request){

        $request->validate([

            'nombre_proveedor' => 'required|unique:proveedores,nombre',
            'descripcion_proveedor' => 'required' 

        ]);


        Proveedor::create([
            'nombre' => $request->nombre_proveedor,
            'descripcion' => $request->descripcion_proveedor
        ]);


        return back()->with('success', 'El proveedor fue agregado!');


    }



    public function proveedor_delete(Proveedor $proveedor){


        try{

            $proveedor->delete();
             return back()->with('eliminado', 'El proveedor '.$proveedor->nombre.' fue eliminado');
        
        } catch (\Illuminate\Database\QueryException $e) {
            
            if ($e->getCode() == '23000') {
                return redirect()->back()->with('error', 'No se puede eliminar este departamento porque está siendo utilizado en una evaluación de proveedores.');
        
        }

        return redirect()->back()->with('error', 'Ocurrió un error inesperado al intentar eliminar el departamento.');
    }


        


       


    }



}
