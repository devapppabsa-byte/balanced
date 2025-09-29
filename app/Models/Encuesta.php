<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = "encuestas";
    protected $fillable = ["nombre", "descripcion", "id_departamento", 'contestado'];




    public function preguntas(){

        return $this->hasMany(Pregunta::class, 'id_encuesta');
    
    }

    public function departamento(){

        return $this->belongsTo(Departamento::class, "id_departamento");
    
    }


}
