<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IndicadorLleno extends Model
{

    protected $table = "indicadores_llenos";
    protected $fillable = ["nombre_campo", "informacion_campo", "id_indicador"];


    //creando la relacion 
    public function indicador(){

        $this->belongsTo(Indicador::class, "id_indicador");
    
    }


    
}
