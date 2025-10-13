@extends('plantilla')
@section('title', 'Lista de Indicadores del departamento')
@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center">
        <div class="col-auto py-4 text-white">
            <h1 class="mt-1">
                {{$departamento->nombre}}
            </h1>
            <span class="">
               Lista de indicadores de {{$departamento->nombre}}
            </span>
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
    <div class="row jusfify-content-start">
        @forelse ($indicadores as $indicador) 
            
            <div class="col-10 col-sm-10 col-md-4 col-lg-4 my-3">
                <div class="card text-white bg-danger shadow-2-strong">
                    <a href="{{route('indicador.lleno.show.admin', $indicador->id)}}" class="text-white w-100">
                    <div class="card-body">
                        <div class="row justify-content-around d-flex align-items-center">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                                <h2 class="card-title fw-bold display-6 x">50%</h2>
                                <p class="card-text fw-bold">{{$indicador->nombre}}</p>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-4 p-0 m-0">
                                <i class="fas fa-chart-line fa-3x"></i>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
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
    @forelse ($normas as $norma)
        
        <div class="col-10 col-sm-10 col-md-4 col-lg-4 my-3">
            <div class="card text-white bg-danger shadow-2-strong">
                <a href="{{route('apartado.norma', $norma->id)}}" class="text-white w-100">
                <div class="card-body">
                    <div class="row justify-content-around d-flex align-items-center">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                            <h2 class="card-title fw-bold display-6 x">40%</h2>
                            <p class="card-text fw-bold">{{$norma->nombre}}</p>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 p-0 m-0">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
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
        
        <div class="col-10 col-sm-10 col-md-4 col-lg-4 my-3">
            <div class="card text-white bg-danger shadow-2-strong">
                <a href="{{route('encuesta.index', $encuesta->id)}}" class="text-white w-100">
                <div class="card-body">
                    <div class="row justify-content-around d-flex align-items-center">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                            <h2 class="card-title fw-bold display-6 x">40%</h2>
                            <p class="card-text fw-bold">{{$encuesta->nombre}}</p>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 p-0 m-0">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
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
</div>




    
@endsection