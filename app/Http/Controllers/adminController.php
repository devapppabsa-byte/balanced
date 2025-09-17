<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Departamento;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class adminController extends Controller
{
    public function login(){

        return view('admin.login_admin');

    }


    public function ingreso_admin(Request $request){

        
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        
        
        $credentials = $request->only('email', 'password');

        if(Auth::guard('admin')->attempt($credentials)){
            $request->session()->regenerate();
            return redirect()->route('perfil.admin');
        }
        else{
            return back()->with('error', 'Las credenciales no coinciden con los registros');
        }

    }




    public function perfil_admin(){

        $departamentos = Departamento::get();


        return view('admin.perfil_admin', compact('departamentos'));


    }


    public function agregar_usuario(Request $request){
    
        
        $request->validate([
            'nombre_usuario' => 'required',
            'correo_usuario' => 'required',
            'puesto_usuario' => 'required',
            'planta' => 'required',
            'departamento' =>'required',
            'password_usuario' => 'required'
        ]);


        User::create([

            'name' => $request->nombre_usuario,
            'email' => $request->correo_usuario,
            'puesto' => $request->puesto_usuario,
            'planta' => $request->planta,
            'password' => $request->password_usuario,
            'id_departamento' => $request->departamento
        ]);


        return back()->with('success', 'El usuario fue agregado con exito!');



    }





    public function agregar_departamento(Request $request){

        $request->validate([

            'nombre_departamento' => 'required |unique:departamentos,nombre'

        ]);


        $departamento = new Departamento();
        $departamento->nombre = $request->nombre_departamento;
        $departamento->save();



        return back()->with('success', 'Nuevo departamento creado!');

    }










}
