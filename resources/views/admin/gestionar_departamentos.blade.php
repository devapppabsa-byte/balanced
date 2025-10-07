@extends('plantilla')
@section('title', 'Gestión de los Deaprtamentos de la Empresa')

@section("contenido")

<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center px-4">
        <div class="col-auto py-4 text-white">
            <h1 class="mt-1">Departamentos de la empresa</h1>
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
            <button class="btn btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_departamento">
                <i class="fa fa-plus-circle"></i>
                Agregar Departamento
            </button>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="row justify-content-around">
        @forelse ($departamentos as $departamento)

        <div class="col-12 col-sm-12 col-md-5 col-lg-4">
                <div class="row justify-content-center mx-2 text-center border border-3 shadow shadow-3 py-3">
                    <div class="col-12">
                        <a href="{{route('agregar.indicadores.index', $departamento->id)}}" class="btn btn-outline-secondary fw-bold w-100 h-100 d-block h5 py-4" style="font-size:3vh;">
                            {{$departamento->nombre}}    
                        </a>   
                    </div>

                    <div class="col-12  text-end px-3">
                        <a href="#coll{{$departamento->id}}" data-mdb-collapse-init data-mdb-ripple-init role="button" aria-expanded="false" aria-controls="collapseExample">
                           <i class="fa-solid fa-circle-arrow-right"></i>
                        </a>

                        <div class="collapse" id="coll{{$departamento->id}}">
                            <div class="row">
                                <div class="col-auto">
                                    <a href="#" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del_dep{{$departamento->id}}" class="text-danger">
                                        <i class="fa fa-trash"></i>
                                        Eliminar
                                    </a>
                                </div>
                                <div class="col-auto">
                                    <a href="edit_dep{{$departamento->id}}" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#edit_dep{{$departamento->id}}"  class="text-primary">
                                        <i class="fa fa-edit"></i>
                                        Editar
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 py-5">
               <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <img src="{{asset('/img/iconos/empty.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-12 text-center">
                    <h2>
                        <i class="fa fa-exclamation-circle text-danger"></i>
                        No hay datos disponibles 
                    </h2>
                </div>
               </div>
            </div>
        @endforelse
    </div>
</div>







{{-- bucle que nos va a darlos modales para la edicion y eliminado de los departamentos--}}

@forelse ($departamentos as $departamento)

    <div class="modal fade" id="del_dep{{$departamento->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header bg-danger py-4">
                <h3 class="text-white" id="exampleModalLabel">¿Eliminar {{$departamento->nombre}} ?</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{route('eliminar.departamento', $departamento->id)}}" method="POST">
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


    <div class="modal fade" id="edit_dep{{$departamento->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header bg-primary py-4">
                <h5 class="text-white" id="exampleModalLabel">Editando Departamento {{$departamento->nombre}}</h5>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{route('actualizar.departamento', $departamento->id)}}" method="POST">
                    @csrf @method('PATCH')
                    
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg w-100{{ $errors->first('nombre_departamento') ? 'is-invalid' : '' }} " id="nombre_dep{{$departamento->id}}" name="nombre_departamento" value="{{old('nombre_departamento', $departamento->nombre)}}" style="font-size: 30px">
                            <label class="form-label" for="nombre_dep{{$departamento->id}}" >Nombre nuevo </label>
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




<div class="modal fade" id="agregar_departamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="text-white" id="exampleModalLabel">Agregar Departamento</h5>
        <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('agregar.departamento')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg w-100" id="nombre_departamento" name="nombre_departamento">
                            <label class="form-label" for="nombre_departamento" >Nombre </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button  class="btn btn-primary w-100" data-mdb-ripple-init>Guardar</button>
        </form>

      </div>
    </div>
  </div>
</div>

@endsection