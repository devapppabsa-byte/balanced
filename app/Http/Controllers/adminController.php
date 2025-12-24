<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
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
        $clientes = Cliente::get();


        return view('admin.perfil_admin', compact('departamentos', 'clientes'));


    }


    public function agregar_usuario(Request $request){
    

        
        $request->validate([
            'nombre_usuario' => 'required',
            'correo_usuario' => 'required|email|unique:users,email',
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
            'id_departamento' => $request->departamento,
            'tipo_usuario' => $request->tipo_usuario
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



    public function agregar_cliente(Request $request){

        
         $request->validate([
             "id_cliente" => "required|unique:clientes,id_interno",
             "nombre_cliente" => "required",
             "correo_cliente" => "required",
             "telefono_cliente" => "required",
             "password_cliente" => "required",
             "linea" => "required"

         ]);

         $password = bcrypt($request->password_cliente);


         Cliente::create([

            "id_interno" => $request->id_cliente,
            "nombre" => $request->nombre_cliente,
            "linea" => $request->linea,
            "password" => $password,
            "email" => $request->correo_cliente,
            "telefono" => $request->telefono_cliente

         ]);



         return back()->with("success", "El cliente fue agregado");




    }


    public function eliminar_cliente(Cliente $cliente){


        $cliente->delete();
        
        return back()->with("eliminado", "El cliente fue eliminado");


    }

    public function editar_cliente(Cliente $cliente, Request $request){


        $password = bcrypt($request->password_cliente_edit);

        
        $request->validate([
            "id_cliente_edit" => "required",
            "nombre_cliente_edit" => "required",
            "linea_edit" => "required",
            "correo_cliente_edit" => "required",
            "telefono_cliente_edit" => "required" 
        ]);


        $cliente->id_interno = $request->id_cliente_edit;
        $cliente->nombre = $request->nombre_cliente_edit;
        if($request->password_cliente_edit) $cliente->password = $password;
        $cliente->email = $request->correo_cliente_edit;
        $cliente->linea = $request->linea_edit;
        $cliente->telefono = $request->telefono_cliente_edit;

        $cliente->update();

        return  back()->with("actualizado", "El cliente fue editado");

    }










}
