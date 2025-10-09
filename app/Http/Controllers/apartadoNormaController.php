<?php

namespace App\Http\Controllers;

//use App\Models\Apartado;
use App\Models\EvidenciaCumplimientoNorma;
use Carbon\Carbon;
use App\Models\Norma;
use App\Models\CumplimientoNorma;
use App\Models\ApartadoNorma;
use Illuminate\Validation\Rule;

use Illuminate\Http\Request;

class apartadoNormaController extends Controller
{


 public function apartado_norma_store(Request $request, Norma $norma){


        $request->validate([

            "titulo_apartado_norma" => "required|unique:apartado_norma,apartado",
            "descripcion_apartado_norma" => "required"
            
        ]);


        ApartadoNorma::create([
            "apartado" => $request->titulo_apartado_norma,
            "descripcion" => $request->descripcion_apartado_norma,
            "id_norma" => $norma->id
        ]);




        return back()->with('success', 'El apartado fue agregado!');

    }

    public function registro_cumplimiento_normativa_index(Norma $norma){


        $apartados = ApartadoNorma::where('id_norma', $norma->id)->get();


        return view('user.registro_cumplimiento_normativo', compact('norma', 'apartados'));


    }

    

    public function delete_apartado_norma(ApartadoNorma $apartado){

        $apartado->delete();

        return back()->with('eliminado', 'El apartado fue eliminado de la norma!');


    }


    public function edit_apartado_norma(ApartadoNorma $apartado, Request $request){


        $request->validate([
            'nombre_apartado_edit' => Rule::unique('apartado_norma', 'apartado')->ignore($apartado->id),
            'descripcion_apartado_edit' => 'required'
        ]);



        $apartado->update([

            "apartado" => $request->nombre_apartado_edit,
            "descripcion" => $request->descripcion_apartado_edit

        ]);


        return back()->with('actualizado', 'El apartado fue editado');


    }


    public function registro_actividad_cumplimiento_norma(Request $request, ApartadoNorma $apartado){

        Carbon::setLocale('es'); // Establece el idioma a español
        setlocale(LC_TIME, 'es_ES.UTF-8'); // Asegura que PHP use el locale correcto (depende del servidor)

        $mes = Carbon::now()->translatedFormat('F Y');


        $request->validate([

            'descripcion_actividad' => 'required',
            'evidencias.*' => 'required|file'
            
        ]);


        //Guardo la actividad que realizo y guardo todo en una variable para poder  usar el ID  de lo que se registro
        $cumplimiento_norma =  CumplimientoNorma::create([
                'mes' => $mes,
                'descripcion' => $request->descripcion_actividad,
                'id_apartado_norma' => $apartado->id

            ]);



        //registra las evidencias de la actividad que se registro 
        if ($request->hasFile('evidencias')) {
            foreach ($request->file('evidencias') as $archivo) {
                // Guarda el archivo en storage/app/public/archivos
                $ruta = $archivo->store('evidencias_normas', 'public');
                
                EvidenciaCumplimientoNorma::create([

                    'evidencia' => $ruta,
                    'nombre_archivo' => $archivo->getClientOriginalName(),
                    'id_cumplimiento_norma' => $cumplimiento_norma->id

                ]);

            }
        }

        return back()->with('success', 'La actividad fue registrada');
    }


    public function ver_evidencia_cumplimiento_normativo(ApartadoNorma $apartado){

        $cumplimientos  = CumplimientoNorma::with('evidencia_cumplimiento_norma')->where('id_apartado_norma', $apartado->id)->orderBy('created_at', 'desc')->get();

        return view('user.evidencia_cumplimiento_normativo', compact('apartado', 'cumplimientos'));



    }

    public function ver_evidencia_cumplimiento_normativo_admin(ApartadoNorma $apartado){

        $cumplimientos  = CumplimientoNorma::with('evidencia_cumplimiento_norma')->where('id_apartado_norma', $apartado->id)->orderBy('created_at', 'desc')->get();

        return view('admin.evidencia_cumplimiento_normativo', compact('apartado', 'cumplimientos'));


    }


}
