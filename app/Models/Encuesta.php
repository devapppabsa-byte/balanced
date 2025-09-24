<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = "encuestas";
    protected $fillable = ["nombre", "descripcion", "id_departamento"];




    public function preguntas(){

        return $this->hasMany(Pregunta::class);
    
    }


}
