<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indicador extends Model
{
    
    protected $table = 'indicadores';
    
    protected $fillable = [
        'nombre', 
        'meta_esperada',
        'meta_minina', 
        'id_departamento', 
        'planta_1', 
        'planta_2', 
        'planta_3',
        'ponderacion'
    ];






    public function departamento(){

        return $this->belongsTo(Departamento::class, 'id_departamento');
    
    }







}
