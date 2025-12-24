@extends('plantilla')
@section('title', 'Encuestas a clientes')


@section('contenido')
<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center justify-content-start ">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  py-4">
            <h2 class="text-white">
                <i class="fa-regular fa-file-lines"></i>
                {{Auth::user()->departamento->nombre}} - Cumplimiento Normativo
            </h2>
            <h5 class="text-white fw-bold" id="fecha"></h5>

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





<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-11 col-lg-8 shadow-sm rounded border  bg-white p-5">
            <div class="row ">
                <div class="col-12 text-center">
                    <h2>
                        <i class="fa-regular fa-newspaper"></i>
                        Encuestas
                    </h2>
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
                                    <th>Cumplimiento</th>
                                    </tr>
                                </thead>
                            <tbody>
                        @endif

                        @forelse ($encuestas as $encuesta)
                            <tr>
                                <td>
                                    <a href="{{route('encuesta.index.user', ['cliente' => $cliente->id, 'encuesta' => $encuesta->id]}}" data-mdb-tooltip-init title="Detalles de {{$encuesta->nombre}}" class="text-decoration-none text-dark fw-bold">
                                        {{$encuesta->nombre}}
                                    </a>
                                    <p>
                                        {{$encuesta->descripcion}}
                                    </p>
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
                                        <h6 class="badge fs-6  p-2 {{($suma/($contador*10)*100 > $encuesta->meta_minima) ? "badge-success border border border-success" : "badge-danger border border-danger" }}" data-mdb-tooltip-init title="{{round($suma/($contador*10)*100, 3)}}%">
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
















@endsection