<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampoCalculado extends Model
{
    
    protected $table = "input_calculado";
    protected $fillable = ['nombre', 'informacion', 'tipo', 'operacion', 'tipo', 'id_indicador', 'id_input', 'resultado_final', 'descripcion'];



    public function indicador(){
        return $this->belongsTo(Indicador::class, "id_indicador");
    }


    public function campo_involucrado(){
        return $this->hasMany(CampoInvolucrado::class, 'id_input_calculado');
    }


}
