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

    //relaciones con las tablas hijas
    public function camposCalculados(){

        return $this->hasMany(CampoCalculado::class, "id_indicador");
    
    }

    public function campoVacio(){

        return $this->hasMany(CampoVacio::class, "id_indicador");
    
    }

    public function indicadorLleno(){

        return $this->hasMany(IndicadorLleno::class, "id_indicador");

    }

    public function campoPrecargado(){

        return $this->hasMany(CampoPrecargado::class, "id_indicador");

    }

    







}
