<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{

    protected $table = "clientes";
    protected $fillable = ["nombre", 'password', 'email', 'linea', 'telefono', 'id_interno'];



}
