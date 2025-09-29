@extends('plantilla')
@section('title', 'Respuestas del cliente')

@section('contenido')
<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center px-4">
        <div class="col-auto py-4 text-white">
            <h1 class="mt-1">Respuestas de la encuesta</h1>
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


<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-6 col-lg-7 mt-5">
            <h3 class="text-center">Respuestas de los Clientes</h3>
                <table class="table border shadow-sm">
                    <thead class="table-secondary border">
                        <th scope="col">Cliente</th>
                        <th scope="col">Linea</th>
                        <th scope="col">Respuestas</th>
                        
                    </thead>
                    <tbody class="">
                        @forelse ($preguntas as $pregunta)
                            <tr>
                                    <th>{{$pregunta->pregunta}}</th>
                                    <td>{{$pregunta->pregunta}}</td>

                                    <td class="form-group shadow-0">
                                        <a class="btn btn-light btn-sm" href="#">
                                            <i class="fa fa-eye mx-1"></i>
                                            Ver Respuestas
                                        </a>
                                    </td>
                                

                            </tr>
                        @empty

                            <tr>
                                <td>
                                    <div class="row justify-content-center">

                                        <div class="col-auto">
                                            <i class="fa fa-exclamation-circle text-danger"></i>
                                            No cuenta con preguntas, pero las puedes agregar aqui.
                                        </div>
                                        
                                        <div class="col-auto">
                                            <a class="btn btn-secondary btn-sm" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_pregunta">
                                                Agregar Pregunta
                                            </a>
                                        </div>

                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
        </div>
    </div>
</div>





@endsection
    