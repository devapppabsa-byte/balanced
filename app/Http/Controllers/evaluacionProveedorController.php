<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EvaluacionProveedor;
use App\Models\Proveedor;

use Illuminate\Support\Facades\Auth;

class evaluacionProveedorController extends Controller
{
    
    public function  evaluaciones_show_user(){

        
        $evaluaciones = EvaluacionProveedor::with('proveedor')->where('id_departamento', Auth::user()->departamento->id )->Simplepaginate();
        $proveedores = Proveedor::get();
        

        return view('user.evaluaciones_proveedores', compact('evaluaciones', 'proveedores'));

    }

    public function detalle_evaluacion_proveedor(Proveedor $proveedor){
        
        $evaluaciones = EvaluacionProveedor::where('id_proveedor', $proveedor->id)->get();
   
   
   
        return view('admin.detalle_evaluacion_proveedores', compact('proveedor', 'evaluaciones'));
   
    }




}
