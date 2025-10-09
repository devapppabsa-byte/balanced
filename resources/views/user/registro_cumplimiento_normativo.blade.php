@extends('plantilla')
@section('title', 'Registro de Cumplimiento Mensual')

@section('contenido')


<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center justify-content-start ">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  py-4">
            <h2 class="text-white">
                <i class="fa-regular fa-file-lines"></i>
                {{Auth::user()->departamento->nombre}} - {{$norma->nombre}}
            </h2>
            <h4 class="text-white" id="fecha"></h4>

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
    @include('user.assets.nav')
</div>    


<div class="container-fluid">
    <div class="row justify-content-center mt-4">

        <div class="col-12 col-sm-12 col-md-10 col-lg-10  mx-5">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <h2 class="text-uppercase">
                        <i class="fa-regular fa-file-lines"></i>
                        Apartados de {{$norma->nombre}}
                    </h2>
                    @if (session('eliminado'))
                        <h5 class="">
                            <i class="fa fa-exclamation-circle text-danger"></i>
                            {{session('eliminado')}}
                        </h5>
                    @endif
                </div>
            </div>
                @if (!$apartados->isEmpty())
                    <div class="table-responsive shadow-sm">
                        <table class="table table-responsive mb-0 border shadow-sm table-hover">
                                <thead class="table-secondary text-white cascadia-code">
                                    <tr>
                                        <th>Apartado</th>
                                        <th>Entregables</th>
                                        <th class="text-center">Acciones</th>
                                    </tr>
                                </thead>
                            <tbody>
                @endif

                @forelse ($apartados as $apartado)
                    <tr>
                        <td>
                            {{$apartado->apartado}}
                        </td>

                        <td>
                           {{$apartado->descripcion}}
                        </td>

                        <td class="text-center">
                            <div class="btn-group">
                                <a class="btn btn-primary btn-sm" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#reg{{$apartado->id}}">
                                    <i class="fa-regular fa-check-square"></i>
                                </a>

                                <a href="{{route('ver.evidencia.cumplimiento.normativo', $apartado->id)}}" class="btn btn-secondary btn-sm">
                                    <i class="fa fa-eye"></i>
                                </a>
                            </div>
                        </td>

                    </tr>
                @empty
                    <div class="col-12 p-5 text-center p-5 border">

                        <div class="row justify-content-center">
                            
                            <div class="col-12 text-center">
                                <img src="{{asset('/img/iconos/emtpy.png')}}" class="img-fluid" alt="">
                            </div>
                            <div class="col-12">
                                <i class="fa fa-exclamation-circle text-danger"></i>
                                No cuenta con datos aqui.
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





@forelse ($apartados as $apartado)
    <div class="modal fade" id="reg{{$apartado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary py-4">
                    <h3 class="text-white mb-0 pb-0" id="exampleModalLabel">
                        <i class="fa-regular fa-square-check"></i>
                        Registrar Actividad
                    </h3>
                    <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form action="{{route('registro.actividad.cumplimiento.norma', $apartado->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="form-group">
                            <div class="form-outline" data-mdb-input-init>
                                <textarea  class="form-control form-control-lg {{ $errors->first('descripcion_actividad') ? 'is-invalid' : '' }} " value="{{old("descripcion_actividad")}}"  name="descripcion_actividad"></textarea>
                                <label class="form-label" for="descripcion_actividad" >Descripción Actividad </label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="bg-light my-2">
                                <i class="fa fa-exclamation-circle"></i>
                                Puedes subir PDF, imagenes, documentos de word y videos de no mas de 10 mb.
                            </label>
                            <input type="file" name="evidencias[]" multiple class="form-control" accept=".jpg,.png,.pdf,.docx,.mp4" required>
                        </div>


                        <div class="form-group mt-3">
                            <button  class="btn btn-primary w-100 " data-mdb-ripple-init>
                                <i class="fa fa-save"></i>
                                Guardar Registro
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>    
@empty
    
@endforelse



@endsection