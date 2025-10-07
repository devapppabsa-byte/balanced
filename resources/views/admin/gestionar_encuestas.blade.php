@extends('plantilla')
@section('title', 'Encuestas a los clientes')

@section('contenido')
<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center px-4">
        <div class="col-auto py-4 text-white">
            <h1 class="mt-1">Encuestas para los clientes</h1>
            @if (session('success'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('success')}}
                </div>
            @endif
            @if (session('actualizado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('actualizado')}}
                </div>
            @endif
            @if (session('editado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('editado')}}
                </div>
            @endif
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

<div class="container-fluid mb-5">
    <div class="row  border-bottom">
        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_cuestionario">
                <i class="fa fa-plus-circle"></i>
                Agregar Cliente
            </button>
        </div>
    </div>
</div>



<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-11 col-lg-8  ">
            <div class="row">
                <div class="col-12 text-center">
                    <h2>
                        <i class="fa-regular fa-newspaper"></i>
                        Encuestas
                    </h2>
                    @if (session('eliminado'))
                        <h5 class="">
                            <i class="fa fa-exclamation-circle text-danger"></i>
                            {{session('eliminado')}}
                        </h5>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-12 ">
                    <div class="row   table-responsive">
                        @if (!$encuestas->isEmpty()) {{-- Esto es para ocultar la cabecera de la tabla cuando no haya datos --}}
                        
                            <table class="table mb-0 border table-hover">
                                <thead class="table-secondary text-white cascadia-code">
                                    <tr>
                                    <th>Nombre</th>
                                    <th>Descripción</th>
                                    <th>Departamento</th>
                                    <th>Acciones</th>
                                    <th>Cumplimiento</th>
                                    </tr>
                                </thead>
                            <tbody>
                        @endif

                        @forelse ($encuestas as $encuesta)
                            <tr>
                                <td>
                                    <a href="{{route('encuesta.index', $encuesta->id)}}" class="text-decoration-none text-dark fw-bold">
                                        {{$encuesta->nombre}}
                                    </a>
                                </td>
                                <td>{{$encuesta->descripcion}}</td>
                                <td>{{$encuesta->departamento->nombre}}</td>

                                <td class="tex-start">
                                    <a class="text-danger mx-1" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del_en{{$encuesta->id}}" style="cursor: pointer">
                                        <i class="fa fa-trash"></i> 
                                    </a>

                                    <a class="text-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#edit_en{{$encuesta->id}}"  style="cursor: pointer">
                                        <i class="fa fa-edit"></i> 
                                    </a>

                                    <a class=" mx-1" href="{{route('encuesta.index', $encuesta->id)}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                
                                </td>

                                <td class="text-start">

                                    @php  $suma=0; $contador=0;    @endphp

                                    @forelse ($encuesta->preguntas as $pregunta)

                                        @if ($pregunta->cuantificable === 1)

                                            @forelse ($pregunta->respuestas as $respuesta)
                                                @php
                                                    $suma = $suma + $respuesta->respuesta;
                                                @endphp
                                                @php $contador++;  @endphp {{--Este contador me ayuda a saber cuantas preguntas del cuestionario con cuantificables --}}
                                                
                                            @empty
                                                @if ($loop->first)
                                                    <span>No hay respuestas disponibles.</span>
                                                @endif
                                            @endforelse

                                        @else
                                        {{-- si no son cuantificables no las muestra --}}
                                        @endif

                                    @empty
                                        <span>Aún no se han registrado preguntas.</span>                                        
                                    @endforelse

                                    @if ($suma>0)
                                        {{-- Aqui esta el porcentaje de cumplimiento --}}
                                        <h6 class="{{($suma/($contador*10)*100 > 50) ? "text-success" : "text-danger" }}" >
                                            {{round(($suma/($contador*10))*100, 3) }} %
                                            <i class="fa {{($suma/($contador*10)*100 > 50) ? "fa-check-circle" : "fa-xmark-circle" }} "></i>
                                        </h6>
                                        @endif
                                
                                </td>

                            </tr>
                        @empty
                            <div class="col-12 p-5 text-center p-5 border">

                                <div class="row">
                                    
                                    <div class="col-12">
                                        <i class="fa fa-exclamation-circle text-danger"></i>
                                        No cuenta con indicadores, pero los puedes agregar aqui
                                    </div>
                                    
                                    <div class="col-12">
                                        <a class="btn btn-secondary btn-sm" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_cuestionario">
                                            Agregar Cuestionario
                                        </a>
                                    </div>

                                </div>
                                <h5>
                                </h5>
                            </div>
                        @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="agregar_cuestionario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Agregar Encuesta</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('encuesta.store.two')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-12 text-center">
                    <div class="form-group mt-2">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('nombre_encuesta') ? 'is-invalid' : '' }} " id="nombre_encuesta" name="nombre_encuesta" required>
                            <label class="form-label" for="nombre_encuesta" >Nombre para la Encuesta</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <div class="form-outline" data-mdb-input-init>
                                <textarea class="form-control w-100 {{ $errors->first('descripcion_cuestionario') ? 'is-invalid' : '' }}" id="descrpcion_encuesta" name="descripcion_encuesta" required ></textarea>
                                <label class="form-label" for="descrpcion_encuesta">Descripción del Cuestionario</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group mt-3">
                        <select name="departamento" id=""  class="form-select" >
                            <option value="" selected disabled>Selecciona un Departamento</option>
                            @forelse ($departamentos as $departamento)
                            <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
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




@forelse ($encuestas as $encuesta)
    <div class="modal fade" id="del_en{{$encuesta->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header bg-danger py-4">
                <h3 class="text-white" id="exampleModalLabel">¿Eliminar la encuesta {{$encuesta->nombre}} ?</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{route('encuesta.delete', $encuesta->id)}}" method="POST">
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


    <div class="modal fade" id="edit_en{{$encuesta->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-primary py-4">
            <h3 class="text-white" id="exampleModalLabel">Editando Encuesta</h3>
            <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-4">
            <form action="{{route('encuesta.edit', $encuesta->id)}}" method="post">
                @csrf @method("PATCH")
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="form-group mt-2">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="text" class="form-control form-control-lg {{ $errors->first('nombre_encuesta_edit') ? 'is-invalid' : '' }} " id="nombre_encuesta" value="{{$encuesta->nombre}}" name="nombre_encuesta_edit" required>
                                <label class="form-label" for="nombre_encuesta_edit" >Nombre para la Encuesta</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <div class="form-group mt-3">
                            <div class="form-outline" data-mdb-input-init>
                                <div class="form-outline" data-mdb-input-init>
                                    <textarea class="form-control w-100 {{ $errors->first('descripcion_encuesta_edit') ? 'is-invalid' : '' }}" id="descrpcion_encuesta" name="descripcion_encuesta_edit" required >{{$encuesta->descripcion}}</textarea>
                                    <label class="form-label" for="descrpcion_encuesta_edit">Descripción del la Encuesta</label>
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
@empty
    
@endforelse





@endsection
    