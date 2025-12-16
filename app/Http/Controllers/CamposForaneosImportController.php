<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Imports\CamposForaneosImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InputPrecargadoImport;

class CamposForaneosImportController extends Controller
{
    
    public function importar(Request $request){

        $request->validate([
 
            'archivo' => 'required'

        ]);



        Excel::import(new InputPrecargadoImport, $request->file('archivo'));


        return back()->with('success', 'El archivo fue cargado!');


    }



}
