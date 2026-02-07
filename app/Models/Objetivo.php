<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objetivo extends Model
{
    protected $table = "objetivos_perspectiva";
    protected $fillable = ['nombre', 'ponderacion', 'id_perspectiva'];



    public function perspectiva(){
        
        return $this->belongsTo(Perspectiva::class, 'id_perspectiva');

    }
}
