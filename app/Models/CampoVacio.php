<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CampoVacio extends Model
{
    

    protected $table = 'input_vacio';
    protected $fillable = ['nombre', 'id_input', 'tipo', 'informacion_llenada', 'id_indicador', 'descripcion'];




    public function indicador(){
        $this->belongsTo(Indicador::class, 'id_indicador');
    }






}
