<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = "preguntas";
    protected $fillable = ['pregunta', 'cuantificable', 'id_encuesta'];




    public function encuesta(){
    
        $this->belongsTo(Encuesta::class, 'id_encuesta');

    }

    public function respuestas(){

        $this->hasMany(Respuesta::class, 'id_encuesta');
    
    }



}
