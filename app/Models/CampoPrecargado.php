<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampoPrecargado extends Model
{
    

    protected $table = "input_precargado";
    protected $fillable = ['nombre', 'informacion_precargada', 'id_indicador', 'tipo_dato', 'id_input'];



    public function indicador(){

        return $this->belongsTo(Indicador::class, 'id_indicador');

    }

    public function InformacionInputPrecargado(){
        
        return $this->hasMany(InformacionInputPrecargado::class, 'id_input_precargado');

    }


}
