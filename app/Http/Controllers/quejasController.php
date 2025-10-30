<?php

namespace App\Http\Controllers;

use App\Models\Queja;
use App\Models\Cliente;
use Illuminate\Http\Request;

class quejasController extends Controller
{
    
    public function index_quejas(){

        $clientes = Cliente::with('quejas')->get();

        return view('admin.quejas', compact('clientes'));

    }




}
