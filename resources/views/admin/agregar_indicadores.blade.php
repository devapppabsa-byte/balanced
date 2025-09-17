@extends('plantilla')
@section('title', 'Indicadores ')



@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center px-4">
        <div class="col-auto text-center">
            <a href="{{route('perfil.admin')}}">
                <i class="fa fa-home fa-2x text-white"></i>
            </a>
        </div>
        <div class="col-auto py-4 text-white">
            <h1 class="mt-1">{{$departamento->nombre}}</h1>
            @if (session('success'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('success')}}
                </div>
            @endif
            @if (session('editado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('editado')}}
                </div>
            @endif
        </div>
    </div>
</div>




<div class="container-fluid">
    <div class="row border py-2">
        <div class="col-12 col-sm-12 col-md-4 col-lg-2">
            <a class="btn btn-outline-secondary w-100 h-100 btn-block" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_indicador">
                <i class="fa fa-plus"></i>
                Indicador a {{$departamento->nombre}}
            </a>
        </div>
    </div>
</div>


<div class="container-fluid m-3 mt-5">
    <div class="row justify-content-center px-4">
        <div class="col-12 col-sm-12 col-md-10 col-lg-4 mx-1 mt-5 mt-lg-0 ">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>Indicadores de {{$departamento->nombre}}</h2>
                    @if (session('eliminado'))
                        <h4>
                            <i class="fa-solid fa-triangle-exclamation text-danger"></i>
                            {{session('eliminado')}}
                        </h4>
                    @endif
                </div>
                <div class="col-12">
                    <div class="row  border">
                        @forelse ($indicadores as $indicador)
                            <div class="col-12 m-2 p-3">
                                <div class="row d-flex align-items-center">
                                    
                                    <div class="col-12 col-sm-12 col-md-7 col-lg-9">
                                        <a href="{{route('indicador.index', $indicador->id)}}" class="btn btn-outline-dark w-100 h-100 d-block py-4">
                                            {{$indicador->nombre}}
                                        </a>
                                    </div>


                                    <div class="col-12 col-sm-12 col-md-4 col-lg-2">
                                        <div class="form-group mt-1">
                                            <button class="btn btn-sm w-100 btn-outline-danger" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#bo{{$indicador->id}}">
                                                <i class="fa fa-trash"></i> 
                                            </button>
                                        </div>
                                    </div>

                                </div>

                            </div>
                        @empty

                        <div class="col-12 p-5 text-center p-5 border">
                            <h5>
                                <i class="fa fa-exclamation-circle text-danger"></i>
                                No se encontraron indicadores
                            </h5>
                        </div>
                            
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <div class="col-12 col-sm-12 col-md-10 col-lg-6 mx-1 mt-5 mt-lg-0">
            <div class="row">

                <div class="col-12 text-center ">
                    <h2>Usuarios de {{$departamento->nombre}}</h2>
                    @if (session('eliminado_user'))
                        <h5 class="text-danger">
                            <i class="fa fa-exclamation-circle"></i>
                            {{session('eliminado_user')}}
                        </h5>
                    @endif
                </div>

                
                <div class="col-12 table-responsive">
                    <table class="table border">
                        <thead class="table-secondary border">
                            <th scope="col">Nombre</th>
                            <th scope="col">Correo</th>
                            <th scope="col">Puesto</th>
                            <th scope="col">Departamento</th>
                            <th scope="col">Acciones</th>
                        </thead>
                        <tbody class="">
                            @forelse ($usuarios as $usuario)
                                <tr>
                                    <th>{{$usuario->name}}</th>
                                    <td>{{$usuario->email}}</td>
                                    <td>{{$usuario->puesto}}</td>
                                    <td>{{$usuario->departamento->nombre}}</td>

                                    <td class="btn-group shadow-0 border-0"> 
                                        <button class="btn btn-outline-danger" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del_user{{$usuario->id}}">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                        <button class="btn btn-outline-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#edit_user{{$usuario->id}}">
                                            <i class="fa fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td>
                                        <h5>
                                            <i class="fa fa-exclamation-circle text-danger"></i>
                                             No hay datos disponibles
                                        </h5>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>


{{-- Modales de los indicadores --}}
<div class="modal fade" id="agregar_indicador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Agregar Indicador a {{$departamento->nombre}}</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('agregar.indicadores.store', $departamento->id)}}" method="post">
            @csrf
            <div class="row">
                <div class="col-12">
                    <h6>Datos Generales</h6>
                </div>
                <div class="col-12 text-center">
                    <div class="form-group mt-2">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('nombre_usuario') ? 'is-invalid' : '' }} " id="nombre_indicador" name="nombre_indicador" required>
                            <label class="form-label" for="nombre_usuario" >Nombre del Indicador </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <div class="form-outline" data-mdb-input-init>
                                <textarea class="form-control w-100 {{ $errors->first('descripcion') ? 'is-invalid' : '' }}" id="descrpcion" name="descripcion" required ></textarea>
                                <label class="form-label" for="descrpcion">Descripción del indicador</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-5 mt-4 border-left">
                    <div class="row d-flex align-items-center justify-content-center">
                        <div class="col-12">
                            <h6>% Porcentaje de cumplimiento</h6>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <input type="number" min="1" class="form-control" name="meta_minima" placeholder="% Minimo" required>
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="form-group">
                                <input type="number" min="1" class="form-control" name="meta_esperada" placeholder="% Máximo"  required>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-7  d-flex align-items-center justify-content-center mt-4 ">
                    <div class="row">
                        <div class="col-12">
                            <h6>Aplica para: </h6>
                        </div>
                        <div class="col-auto">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="planta_1" id="planta1" class="form-check-input" value="active">
                                <label for="planta1" class="form-check-label">Planta 1</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="planta_2" id="planta2" class="form-check-input" value="active">
                                <label for="planta2" class="form-check-label">Planta 2</label>
                            </div>
                        </div>
                        <div class="col-auto">
                            <div class="form-check form-check-inline">
                                <input type="checkbox" name="planta_3" id="planta3" class="form-check-input" value="active">
                                <label for="planta3" class="form-check-label">Planta 3</label>
                            </div>
                        </div>
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



{{-- bucle que me da s modales para la gestios de usuarios --}}
{{-- bucle de los modales del usuario --}}
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


@forelse ($indicadores as $indicador)
    <div class="modal fade" id="bo{{$indicador->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h2>¿Eliminar Indicador?</h2>
                </div>
                <div class="modal-body">
                    <form action="{{route('borrar.indicador', $indicador->id)}}" method="POST">
                        @csrf @method('DELETE')
                        <h2>
                            <button class="btn btn-danger w-100">
                                Eliminar
                            </button>
                        </h2>
                    </form>
                </div>
            </div>
        </div>

    </div>
@empty
    
@endforelse





@endsection







