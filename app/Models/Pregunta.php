<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pregunta extends Model
{
    protected $table = "preguntas";
    protected $fillable = ['pregunta', 'cuantificable', 'id_encuesta'];




    public function encuesta(){

        $this->hasMany(Encuesta::class);

    }



}
