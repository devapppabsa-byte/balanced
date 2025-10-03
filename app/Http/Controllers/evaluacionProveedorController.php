<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\EvaluacionProveedor;
use App\Models\Proveedor;

use Illuminate\Support\Facades\Auth;

class evaluacionProveedorController extends Controller
{
    
    public function  evaluaciones_show_user(){

        
        $evaluaciones = EvaluacionProveedor::with('proveedor')->where('id_departamento', Auth::user()->departamento->id )->get();
        $proveedores = Proveedor::get();
        

        return view('user.evaluaciones_proveedores', compact('evaluaciones', 'proveedores'));

    }




}
