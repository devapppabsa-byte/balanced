<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Norma;
use App\Models\Departamento;
use App\Models\ApartadoNorma;
use Illuminate\Http\Request;

class normaController extends Controller
{
    public function cumplimiento_norma_show_admin(){

        $normas = Norma::get();

        return view('admin.gestionar_normas', compact('normas'));


    }




    public function norma_store(Request $request, Departamento $departamento){
        
        $request->validate([

            "titulo_norma" => 'required|unique:norma,nombre',
            "descripcion_norma" => 'required',
            "ponderacion_norma" => 'required'
        ]);


        Norma::create([

            "nombre" => $request->titulo_norma,
            "descripcion" => $request->descripcion_norma,
            "id_departamento" => $departamento->id,
            "ponderacion" => $request->ponderacion_norma

        ]);


        return back()->with('success', 'La norma fue agregada!');
            
    }



    public function norma_delete(Request $request, Norma $norma){

        $norma->delete();

        return back()->with('eliminado', 'La norma fue eliminada!');

    }

    public function norma_update(Norma $norma, Request $request){

        $norma->nombre = $request->nombre_norma;
        $norma->descripcion = $request->descripcion_norma_edit;

        $norma->update();

        return back()->with('editado', 'La norma fue actualizada');
        

    }


    public function apartado_norma(Norma $norma){

        $apartados = ApartadoNorma::where('id_norma',$norma->id)->get();
        return view('admin.apartados_norma', compact('norma', 'apartados'));
   
    }


    public function cumplimiento_normativo_user(){


        $normas = Norma::where('id_departamento', Auth::user()->id_departamento)->get();


        return view('user.cumplimiento_normativo', compact('normas'));
    }


   



}
