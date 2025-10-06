<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Norma extends Model
{
    protected $table= "norma";
    protected $fillable = ['nombre', 'descripcion'];


    public function apartados(){

        return $this->hasMany(ApartadoNorma::class, 'id_norma');

    }
}
