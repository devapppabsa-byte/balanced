<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Queja extends Model
{

    protected $table = 'quejas';
    protected $fillable = ['queja', 'id_cliente'];



    public function cliente(){
        return $this->belongsTo(Cliente::class);
    }


}
