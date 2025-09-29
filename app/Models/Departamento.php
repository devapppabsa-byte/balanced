<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departamento extends Model
{
    
    protected $table = 'departamentos';
    protected $fillable = ['nombre']; 



    

    public function user(){
        return $this->hasMany(User::class);
    }



    public function indicador(){
        return $this->hasMany(Indicador::class);
    }


    public function departamento(){
        return $this->hasMany(Encuesta::class, "id_departamento");
    }



}
