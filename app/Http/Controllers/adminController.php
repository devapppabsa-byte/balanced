<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use App\Models\Departamento;
use App\Models\LogBalanced;
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

            $autor = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;

            LogBalanced::create([

                'autor' => $autor,
                'accion' => "start_session",
                'descripcion' => "El usuario : ".$request->email . " inicio sesión como administrador",
                'ip' => request()->ip() 
            
            ]);



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
    
        $autor = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;

        
        $request->validate([
            'nombre_usuario' => 'required',
            'correo_usuario' => 'required|email|unique:users,email',
            'puesto_usuario' => 'required',
            'planta' => 'required',
            'departamento' =>'required',
            'password_usuario' => 'required'
        ]);
        
        
        $usuario = User::create([
            
            'name' => $request->nombre_usuario,
            'email' => $request->correo_usuario,
            'puesto' => $request->puesto_usuario,
            'planta' => $request->planta,
            'password' => $request->password_usuario,
            'id_departamento' => $request->departamento,
            'tipo_usuario' => $request->tipo_usuario
        ]);
        
        
        $departamento = Departamento::where('id', $request->departamento)->first();
        
        
        
        //registro del log
        LogBalanced::create([
            'autor' => $autor,
            'accion' => "add",
            'descripcion' => "Se agrego el usuario : ".$usuario->name . " con el id: ". $usuario->id,
            'ip' => $request->ip() 
        ]);
        //registro del log


        return back()->with('success', 'El usuario fue agregado con exito!');



    }





    public function agregar_departamento(Request $request){

        $autor = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;



        
        $request->validate([

            'nombre_departamento' => 'required |unique:departamentos,nombre'

        ]);


        $departamento = new Departamento();
        $departamento->nombre = $request->nombre_departamento;
        $departamento->save();

        //registro del log
        LogBalanced::create([
            'autor' => $autor,
            'accion' => "add",
            'descripcion' => "Se agrego el departamento : ".$departamento->nombre . "  con el id: ". $departamento->id,
            'ip' => $request->ip()                
        ]);
        //registro del log




        return back()->with('success', 'Nuevo departamento creado!');

    }



    public function agregar_cliente(Request $request){

        $autor = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;



         $request->validate([
             "id_cliente" => "required|unique:clientes,id_interno",
             "nombre_cliente" => "required",
             "correo_cliente" => "required",
             "telefono_cliente" => "required",
             "password_cliente" => "required",
             "linea" => "required"

         ]);

         $password = bcrypt($request->password_cliente);


         $cliente = Cliente::create([

            "id_interno" => $request->id_cliente,
            "nombre" => $request->nombre_cliente,
            "linea" => $request->linea,
            "password" => $password,
            "email" => $request->correo_cliente,
            "telefono" => $request->telefono_cliente

         ]);



        //registro del log
        LogBalanced::create([
            'autor' => $autor,
            'accion' => "add",
            'descripcion' => "Se agrego al cliente : ".$cliente->nombre . "  con el id: ". $cliente->id,
            'ip' => $request->ip()                
        ]);
        //registro del log



         return back()->with("success", "El cliente fue agregado");




    }


    public function eliminar_cliente(Cliente $cliente){


        $autor = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;

        $cliente->delete();
        

        LogBalanced::create([

            'autor' => $autor,
            'accion' => "deleted",
            'descripcion' => "Se elimino al cliente : ".$cliente->nombre . "  con el id: ". $cliente->id,
            'ip' => request()->ip()

        ]);

        return back()->with("eliminado", "El cliente fue eliminado");


    }

    public function editar_cliente(Cliente $cliente, Request $request){


        $autor = 'Id: '.auth()->guard('admin')->user()->id.' - '.auth()->guard('admin')->user()->nombre .' - '. $puesto_autor = auth()->guard('admin')->user()->puesto;


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


        LogBalanced::create([

            'autor' => $autor,
            'accion' => "update",
            'descripcion' => "Se edito al cliente : ".$cliente->nombre . "  con el id: ". $cliente->id,
            'ip' => request()->ip()

        ]);



        return  back()->with("actualizado", "El cliente fue editado");

    }






    public function logs(){


        $logs = LogBalanced::orderBy('created_at', 'desc' )->simplePaginate(10);

        return view('admin.logs', compact('logs'));

    }






}
