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



}
