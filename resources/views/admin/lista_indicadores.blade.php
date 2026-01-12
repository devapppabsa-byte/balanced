@extends('plantilla')
@section('title', 'Lista de Indicadores del departamento')
@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center">
        <div class="col-auto  text-white">
            <h3 class="mt-1 mb-0">
                {{$departamento->nombre}}
            </h3>

            <small>
                Lista de indicadores de {{$departamento->nombre}}
            </small>

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
    @include('admin.assets.nav')
</div>


<div class="container-fluid">
    <div class="row jusfify-content-center">
        @forelse ($indicadores as $indicador)
                @php
                    $contador = 0;
                    $suma = 0;
                @endphp
            @foreach($indicador->indicadorLleno as $indicador_lleno)

                @if ($indicador_lleno->final == 'on')

                    @php
                        $contador++;
                        $suma = $suma + $indicador_lleno->informacion_campo;
                    @endphp

                @endif


            @endforeach


            @if ($contador > 0)
            @php
                $cumplimiento = $suma/$contador;
            @endphp

                <div class="col-10 col-sm-10 col-md-6 col-lg-4 my-3">
                    <div class="card text-white {{($cumplimiento < $indicador->meta_minima) ? 'bg-danger' : 'bg-success'}} shadow-2-strong">
                        <a href="{{route('indicador.lleno.show.admin', $indicador->id)}}" class="text-white w-100">
                        <div class="card-body">
                            <div class="row justify-content-around d-flex align-items-center">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                                    <h3 class="card-title fw-bold display-6 x">
                                        {{round($cumplimiento, 3)}}   
                                    </h3>
                                    <p class="card-text fw-bold">{{$indicador->nombre}}</p>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-4 p-0 m-0">
                                    <i class="fas fa-chart-line fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-2">
                                <div class="row  d-flex justify-content-between align-items-center">
                                    <div class="col-auto">
                                            Ver Detalles
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </div>
                                </div>
                        </div>
                        </a>
                    </div>
                </div>
            @else

                <div class="col-10 col-sm-10 col-md-6 col-lg-4 my-3">
                    <div class="card text-white bg-dark shadow-2-strong">
                        <a href="{{route('indicador.lleno.show.admin', $indicador->id)}}" class="text-white w-100">
                        <div class="card-body">
                            <div class="row justify-content-around d-flex align-items-center">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                                    <h5 class="card-title fw-bold  x">
                                        Sin registros aún.
                                    </h5>
                                    <p class="card-text fw-bold">{{$indicador->nombre}}</p>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-4 p-0 m-0">
                                    <i class="fas fa-chart-line fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-2">
                                <div class="row  d-flex justify-content-between align-items-center">
                                    <div class="col-auto">
                                            Ver Detalles
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </div>
                                </div>
                        </div>
                        </a>
                    </div>
                </div>


            @endif


        @empty

        @endforelse








{{-- Foreach de las encuestas --}}


    @forelse ($resultado_normas as $norma)

        <div class="col-10 col-sm-10 col-md-6 col-lg-4 my-3">
            <div class="card text-white {{($norma['meta_minima'] > $norma['porcentaje']) ? 'bg-danger' : 'bg-success'}} shadow-2-strong">
                <a href="{{route('apartado.norma', $norma['id_norma'])}}" class="text-white w-100">
                <div class="card-body">
                    <div class="row justify-content-around d-flex align-items-center">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                            <h2 class="card-title fw-bold display-6 x">{{$norma['porcentaje']}}%</h2>
                            <p class="card-text fw-bold">{{$norma['norma']}}</p>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 p-0 m-0">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2">
                        <div class="row  d-flex justify-content-between align-items-center">
                            <div class="col-auto">
                                    Ver Detalles
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </div>
                </div>
                </a>
            </div>
        </div>

    @empty

    @endforelse 


{{-- Foreach de las encuestas --}}



{{-- Foreach del cumplimiento a normas --}}
    @forelse ($encuestas as $encuesta)

        <div class="col-10 col-sm-10 col-md-6 col-lg-4 my-3">
            <div class="card text-white {{($encuesta->porcentaje_cumplimiento < $encuesta->meta_minima) ? 'bg-danger' : 'bg-success'}} shadow-2-strong">
                <a href="{{route('encuesta.index', $encuesta->id)}}" class="text-white w-100">
                <div class="card-body">
                    <div class="row justify-content-around d-flex align-items-center">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                            <h2 class="card-title fw-bold display-6 x">{{$encuesta->porcentaje_cumplimiento}}%</h2>
                            <p class="card-text fw-bold">{{$encuesta->nombre}}</p>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 p-0 m-0">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2">
                        <div class="row  d-flex justify-content-between align-items-center">
                            <div class="col-auto">
                                    Ver Detalles
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </div>
                </div>
                </a>
            </div>
        </div>

    @empty

    @endforelse

{{-- Foreach del cumplimiento a normas --}}
    </div>


    @if ($encuestas->isEmpty() && $resultado_normas->isEmpty()  &&  $indicadores->isEmpty() )
        <div class="row mt-5 justify-content-center">
            <div class="col-9 p-5 text-center bg-white shadow shadow-sm border">
                <h4>
                    <i class="fa fa-exclamation-circle text-danger"></i>
                    No se encontro Información.
                </h4>
            </div>
        </div>
    @endif




</div>





@endsection