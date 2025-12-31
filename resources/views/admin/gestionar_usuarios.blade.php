@extends('plantilla')
@section('title', 'Gestionar los clientes de la empresa')

@section('contenido')
<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center">
        <div class="col-auto pt-2 text-white">
            <h3 class="mt-1 league-spartan">Usuarios de la empresa</h3>

            @if ($errors->any())
                <div class="text-white fw-bold bad_notifications">
                    <i class="fa fa-xmark-circle mx-2"></i>
                    {{$errors->first()}}
                </div>
            @endif


        </div>
    </div>
    @include('admin.assets.nav')
</div>

<div class="container-fluid">
    <div class="row  border-bottom mb-5 bg-white">
        <div class="col-12 col-sm-12 col-md-3 col-lg-2 my-1 ">
            <button class="btn btn-secondary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_usuario">
                <i class="fa fa-plus-circle"></i>
                Agregar Usuario
            </button>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row justify-content-center ">
        <div class="col-12 col-sm-12 col-md-10 col-lg-6  bg-white p-5 rounded border shadow-sm">
            <div class="row">

                    <div class="col-12 text-center">
                        <h2>
                            <i class="fa-solid text-dark fa-users-gear"></i>
                            Usuarios
                        </h2>
                    </div>


                    @if (!$usuarios->isEmpty())
                        <div class="col-12 table-responsive">
                            <table class="table border table-hover">
                                <thead class="table-secondary border cascadia-code ">
                                    <th scope="col">Nombre</th>
                                    <th scope="col">Departamento y Puesto</th>
                                    <th scope="col">Acciones</th>
                                </thead>
                                <tbody class="">
                    @endif

                            @forelse ($usuarios as $usuario)
                                <tr>
                                    <th>
                                        <p class="py-0 my-0">
                                            {{$usuario->name}}
                                        </p>
                                        <a href="mailto:{{$usuario->email}}" data-mdb-tooltip-init title="Enviar un correo a {{$usuario->email}}" class="text-dark fw-bold" target="_blank">
                                            {{$usuario->email}}
                                        </a>
                                    </th>
                                    <td>
                                        <p class="my-0 py-0">
                                            {{$usuario->puesto}}
                                        </p>
                                        <b class="my-0 py-0">
                                            {{$usuario->departamento->nombre}}
                                        </b>
                                    </td>

                                    <td class=""> 
                                        <a class="text-danger" data-mdb-tooltip-init title="Eliminar a {{$usuario->name}}" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del_user{{$usuario->id}}">
                                            <i class="fa fa-trash"></i>
                                        </a>

                                        <a class="text-primary" data-mdb-tooltip-init title="Editar a {{$usuario->name}}" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#edit_user{{$usuario->id}}">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                    </td>

                                </tr>
                            @empty

                                <div class="row justify-content-center mt-4 border border-3 p-5">

                                    <div class="col-12 text-center">
                                        <i class="fa fa-exclamation-circle text-danger"></i>
                                        No cuenta con usuaios, pero los puedes agregar aqui
                                    </div>
                                    
                                    <div class="col-12 text-center">
                                        <a class="btn btn-secondary btn-sm" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_usuario">
                                            Agregar Usuario
                                        </a>
                                    </div>

                                </div>
    
                            @endforelse
                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="agregar_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">
            <i class="fa fa-users"></i>
            Agregar Usuarios
        </h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('agregar.usuario')}}"  method="post" onkeydown="return event.key !='Enter';">
            @csrf

            <div class="row">

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('nombre_usuario') ? 'is-invalid' : '' }} " id="nombre_usuario" name="nombre_usuario">
                            <label class="form-label" for="nombre_usuario" >Nombre </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('correo_usuario') ? 'is-invalid' : '' }} "  name="correo_usuario">
                            <label class="form-label" for="correo_usuario" >Correo </label>
                        </div>
                    </div>
                </div>

                
                <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="password" class="form-control form-control-lg {{ $errors->first('password_usuario') ? 'is-invalid' : '' }}" name="password_usuario">
                            <label class="form-label" for="password" >Contraseña </label>
                        </div>
                    </div>
                </div>


                <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="puesto" class="form-control form-control-lg {{ $errors->first('puesto_usuario') ? 'is-invalid' : '' }}" name="puesto_usuario">
                            <label class="form-label" for="puesto" >Puesto </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <select name="planta" class="form-control form-control-lg" id="">
                            <option value="" disabled selected>Selecciona la planta a la que pertenece</option>
                            <option value="planta_1">Planta 1</option>
                            <option value="planta_2">Planta 2</option>
                            <option value="planta_3">Planta 3</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group mt-3">
                        <select class="form-control form-control-lg" name="tipo_usuario" id="">
                            <option value="" disabled selected>Tipo de usuarios</option>
                            <option value="principal">Principal</option>
                            <option value="lecura">Solo lectura</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 ">
                    <div class="form-group mt-3">
                        <select id="departamentoSelect" name="departamento" class="form-control form-control-lg {{$errors->first('departamento') ? 'is-invalid' : ''}}" data-mdb-select-init data-mdb-filter="true" 
                        data-mdb-clear-button="true">
                            <option value="" disabled selected>Selecciona el departamento al que pertenece</option>
                            @forelse ($departamentos as $departamento)
                                <option value="{{$departamento->id}}" {{old('departamento', $departamento->nombre ?? '') == $departamento->id ? 'selected' : '' }}>

                                    {{$departamento->nombre}}

                                </option>
                            @empty
                                
                            @endforelse
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button  class="btn btn-primary w-100 py-3" data-mdb-ripple-init>
                <h6>Guardar</h6>
            </button>
        </form>
      </div>
    </div>
  </div>
</div>









@forelse ($usuarios as $usuario)

<div class="modal fade" id="del_user{{$usuario->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-danger py-4">
            <h3 class="text-white" id="exampleModalLabel">¿Eliminar a {{$usuario->name}} ?</h3>
            <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-4">
            <form action="{{route('eliminar.usuario', $usuario->id)}}" method="POST">
                @csrf @method('DELETE')
                <button  class="btn btn-danger w-100 py-3" data-mdb-ripple-init>
                    <h6>Eliminar</h6>
                </button>
            </form>
        </div>
        {{-- <div class="modal-footer">
        </div> --}}
        </div>
    </div>
</div>


<!-- Modal -->
<div class="modal fade" id="edit_user{{$usuario->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Editando a {{$usuario->name}}</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('editar.usuario', $usuario->id)}}"  method="post">
            @csrf @method('PATCH')

            <div class="row">

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('nombre_usuario') ? 'is-invalid' : '' }} " id="nombre_{{$usuario->id}}" name="nombre_usuario" value="{{old('nombre_usuario', $usuario->name)}}">
                            <label class="form-label" for="nombre_usuario" >Nombre </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('correo_usuario') ? 'is-invalid' : '' }} " id="correo_{{$usuario->id}}" name="correo_usuario" value="{{old('correo_usuario', $usuario->email)}}">
                            <label class="form-label" for="correo_usuario" >Correo </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="password" class="form-control form-control-lg {{ $errors->first('password_usuario') ? 'is-invalid' : '' }}" id="password_{{$usuario->id}}" name="password_usuario" >
                            <label class="form-label" for="password" >Contraseña </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="puesto" class="form-control form-control-lg {{ $errors->first('puesto_usuario') ? 'is-invalid' : '' }} " id="puesto_{{$usuario->id}}" value="{{old('puesto_usuario', $usuario->puesto)}}" name="puesto_usuario">
                            <label class="form-label" for="puesto" >Puesto </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 ">
                    <div class="form-group mt-3">
                        <select id="departamento_{{$usuario->id}}" name="departamento" class="form-control form-control-lg {{$errors->first('departamento') ? 'is-invalid' : ''}}" data-mdb-select-init data-mdb-filter="true" 
                        data-mdb-clear-button="true">


                            <option  disabled selected>Selecciona el departamento al que pertenece</option>

                            @forelse ($departamentos as $departamento)

                                <option value="{{ $departamento->id }}"
                                    {{ $departamento->id == $usuario->id_departamento ? 'selected' : '' }}>
                                    {{ $departamento->nombre }}
                                </option>

                            @empty
                                
                            @endforelse
                        </select>
                    </div>
                </div>


            </div>
        </div>
        <div class="modal-footer">
            <button  class="btn btn-primary w-100 py-3" data-mdb-ripple-init>
                <h6>Guardar</h6>
            </button>
        </form>

      </div>
    </div>
  </div>
</div>


@empty
@endforelse



@endsection
    