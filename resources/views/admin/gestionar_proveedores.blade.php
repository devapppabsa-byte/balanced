@extends('plantilla')
@section('title', 'Gestionar Proveedores')


@section('contenido')
<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center px-4">
        <div class="col-auto py-4 text-white">
            <h1 class="mt-1">Proveedores de la Empresa</h1>
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
            @if (session('eliminado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('eliminado')}}
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

<div class="container-fluid">
    <div class="row  border-bottom mb-5">
        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_proveedor">
                <i class="fa fa-plus-circle"></i>
                Agregar Proveedor
            </button>
        </div>
    </div>
</div>



<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-11 col-lg-8 bg-white p-5 shadow border rounded">
            <div class="row  table-responsive">

                <div class="col-12 text-center">
                    <h2>
                        <i class="fa-solid fa-users-line"></i>
                        Proveedores
                    </h2>
                </div>

                @if (!$proveedores->isEmpty()) {{-- Esto es para ocultar la cabecera de la tabla cuando no haya datos --}}
                    <table class="table mb-0 border table-hover ">
                        <thead class="table-secondary text-white cascadia-code">
                            <tr>
                                <th>Nombre</th>
                                <th>Descripción</th>
                                <th>Cumplimiento</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    <tbody>
                @endif

                @forelse ($proveedores as $proveedor)
                    <tr>
                        <td>{{$proveedor->nombre}}</td>
                        <td>{{$proveedor->descripcion}}</td>

                        <td class="">
                            @if (!$proveedor->evaluacion_proveedores->isEmpty())
                                @php
                                    $contador = 0;
                                    $suma = 0; 
                                @endphp
                                @forelse ($proveedor->evaluacion_proveedores as $evaluacion)
                                    @php
                                        $suma = $suma + $evaluacion->calificacion;
                                        $contador++;
                                    @endphp
                                @empty
                                @endforelse
                                <span class="{{(($suma/$contador) < 80 ? 'text-danger fw-bold' : 'text-success fw-bold')}}">
                                    {{round($suma/$contador, 3)}} %
                                </span>
                            @else
                                <span>No hay evaluaciones dsponibles.</span>
                            @endif

                        </td>

                        <td class="tex-start">
                            <a class="text-danger mx-1" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del_pro{{$proveedor->id}}" style="cursor: pointer">
                                <i class="fa fa-trash"></i> 
                            </a>

                            <a class="text-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#edit_pro{{$proveedor->id}}"  style="cursor: pointer">
                                <i class="fa fa-edit"></i> 
                            </a>
                        </td>
                    </tr>
                @empty
                    <div class="col-12 p-5 text-center p-5 border">

                        <div class="row">
                            
                            <div class="col-12">
                                <i class="fa fa-exclamation-circle text-danger"></i>
                                No cuenta con proveedores para la empresa, pero los puedes agregar aqui
                            </div>
                            
                            <div class="col-12">
                                <a class="btn btn-secondary btn-sm" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_proveedor">
                                    Agregar Proveedor
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






<div class="modal fade" id="agregar_proveedor" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Agregar Proveedor</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('proveedor.store')}}" method="post">
            @csrf
            <div class="row">

                <div class="col-12 text-center">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" min="0" max="100" class="form-control w-100 {{ $errors->first('nombre_proveedor') ? 'is-invalid' : '' }} " id="calificacion" name="nombre_proveedor" required>
                            <label class="form-label" for="nombre_proveedor" >Nombre Proveedor</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <div class="form-outline" data-mdb-input-init>
                                <textarea class="form-control w-100 {{ $errors->first('descripcion_proveedor') ? 'is-invalid' : '' }}" id="descripcion_proveedor" name="descripcion_proveedor" required ></textarea>
                                <label class="form-label" for="descripcion_proveedor">Descripción</label>
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




{{-- Aqui van los ciclos que me traen los modales --}}
@forelse ($proveedores as $proveedor)
    <div class="modal fade" id="del_pro{{$proveedor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header bg-danger py-4">
                <h3 class="text-white" id="exampleModalLabel">¿Eliminar la encuesta {{$proveedor->nombre}} ?</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="#" method="POST">
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


    <div class="modal fade" id="edit_pro{{$proveedor->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-primary py-4">
            <h3 class="text-white" id="exampleModalLabel">Editando Encuesta</h3>
            <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-4">
            <form action="#" method="post">
                @csrf @method("PATCH")
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="form-group mt-2">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="text" class="form-control form-control-lg {{ $errors->first('nombre_encuesta_edit') ? 'is-invalid' : '' }} " id="nombre_encuesta" value="{{$proveedor->nombre}}" name="nombre_encuesta_edit" required>
                                <label class="form-label" for="nombre_encuesta_edit" >Nombre para la Encuesta</label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <div class="form-group mt-3">
                            <div class="form-outline" data-mdb-input-init>
                                <div class="form-outline" data-mdb-input-init>
                                    <textarea class="form-control w-100 {{ $errors->first('descripcion_encuesta_edit') ? 'is-invalid' : '' }}" id="descrpcion_encuesta" name="descripcion_encuesta_edit" required >{{$proveedor->descripcion}}</textarea>
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