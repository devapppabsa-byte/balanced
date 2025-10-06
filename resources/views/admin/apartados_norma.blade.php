@extends('plantilla')
@section('title', 'Apartados de la Norma')

@section('contenido')
    
<div class="container-fluid">

    <div class="row bg-primary d-flex align-items-center justify-content-start">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  py-4">
            <h1 class="text-white">Apartados de la norma {{$norma->nombre}}</h1>

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

            @if (session('eliminado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('eliminado')}}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-white  fw-bold p-2 rounded">
                    <i class="fa fa-xmark-circle mx-2  text-danger"></i>
                        No se agrego! <br> 
                    <i class="fa fa-exclamation-circle mx-2  text-danger"></i>
                    {{$errors->first()}}
                </div>
            @endif
        </div>

        
        <div class="col-12 cl-sm-12 col-md-6 col-lg-2 text-center ">
            <form action="{{route('cerrar.session')}}" method="POST">
                @csrf 
                <button  class="btn btn-primary text-danger text-white fw-bold">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>

    @include('admin.assets.nav')
</div>


<div class="container-fluid">
    <div class="row  border-bottom">
        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_apartado_norma">
                <i class="fa fa-plus-circle"></i>
                Agregar Apartado Norma
            </button>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-11 col-lg-8  ">
            <div class="row">
                <div class="col-12 text-center">
                    <h2> Apartados de la norma {{$norma->nombre}}</h2>
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
                        @if (!$apartados->isEmpty()) {{-- Esto es para ocultar la cabecera de la tabla cuando no haya datos --}}
                        
                            <table class="table mb-0 border table-hover">
                                <thead class="table-secondary text-white cascadia-code">
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                            <tbody>
                        @endif

                        @forelse ($apartados as $apartado)
                            <tr>
                                <td>
                                    <span  class="text-decoration-none text-dark fw-bold">
                                        {{$apartado->apartado}}
                                    </span>
                                </td>
                                <td>{{$apartado->descripcion}}</td>

                                <td class="tex-start">
                                    <a class="text-danger mx-1" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del_ap{{$apartado->id}}" style="cursor: pointer">
                                        <i class="fa fa-trash"></i> 
                                    </a>

                                    <a class="text-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#edit_ap{{$apartado->id}}"  style="cursor: pointer">
                                        <i class="fa fa-edit"></i> 
                                    </a>
                                
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
                                        <a class="btn btn-secondary btn-sm" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_apartado_norma">
                                            Agregar apartado a la norma
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




<div class="modal fade" id="agregar_apartado_norma" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Agregar Norma</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('apartado.norma.store', $norma->id)}}" method="post">
            @csrf
            <div class="row">

                <div class="col-12 text-center">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" min="0" max="100" value="{{old('titulo_apartado_norma')}}" class="form-control w-100 {{ $errors->first('titulo_apartado_norma') ? 'is-invalid' : '' }} " name="titulo_apartado_norma" required>
                            <label class="form-label" for="titulo_apartado_norma" >Titulo Apartado Norma</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <div class="form-outline" data-mdb-input-init>
                                <textarea class="form-control w-100 {{ $errors->first('descripcion_norma') ? 'is-invalid' : '' }}" id="descripcion_apartado_norma" name="descripcion_apartado_norma" required >{{old('descripcion_norma')}}</textarea>
                                <label class="form-label" for="descripcion_apartado_norma">Descripción del apartado</label>
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







@forelse ($apartados as $apartado)

    <div class="modal fade" id="del_ap{{$apartado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger py-4">
                    <h3 class="text-white" id="exampleModalLabel">¿Eliminar {{$apartado->nombre}} ?</h3>
                    <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form action="{{route('delete.apartado.norma', $apartado->id)}}" method="POST">
                        @csrf @method('DELETE')
                        <button  class="btn btn-danger w-100 py-3" data-mdb-ripple-init>
                            <h6>Eliminar</h6>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="edit_ap{{$apartado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header bg-primary py-4">
                <h5 class="text-white" id="exampleModalLabel">Editando  {{$apartado->apartado}}</h5>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{route('edit.apartado.norma', $apartado->id)}}" method="POST">
                    @csrf @method('PATCH')
                    
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg w-100{{ $errors->first('nombre_apartado_edit') ? 'is-invalid' : '' }} " id="nombre_apartado{{$apartado->id}}" name="nombre_apartado_edit" value="{{old('nombre_apartado_edit', $apartado->apartado)}}" style="font-size: 30px">
                            <label class="form-label" for="nombre_apartado_edit{{$apartado->id}}" >Editando apartado </label>
                        </div>
                    </div>

                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <textarea type="text" class="form-control form-control-lg w-100{{ $errors->first('descripcion_apartado_edit') ? 'is-invalid' : '' }} " id="descripcion_apartado{{$apartado->id}}" name="descripcion_apartado_edit" value="{{old('descripcion_apartado_edit', $apartado->apartado)}}" style="font-size: 30px">{{$apartado->descripcion}}</textarea>
                            <label class="form-label" for="descripcion_apartado_edit{{$apartado->id}}" >Editando apartado </label>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button  class="btn btn-primary w-100 btn-lg" data-mdb-ripple-init>
                            <i class="fa fa-pencil mx-2"></i>
                            Editar
                        </button>
                    </div>


                </form>
            </div>
            {{-- <div class="modal-footer">
            </div> --}}
            </div>
        </div>
    </div>
@empty
    
@endforelse





@endsection