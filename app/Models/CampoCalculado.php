<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampoCalculado extends Model
{
    
    protected $table = "input_calculado";
    protected $fillable = ['nombre', 'informacion', 'tipo', 'operacion', 'tipo', 'id_indicador'];



    public function indicador(){
        $this->belongsTo(Indicador::class, "id_indicador");
    }


}
