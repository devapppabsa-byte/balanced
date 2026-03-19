@extends('plantilla')
@section('title', 'Detalle del Indicador')
@section('contenido')
@php
    use Carbon\Carbon;
    use App\Models\InformacionInputPrecargado;
    use App\Models\MetaIndicador;
@endphp
<div class="container-fluid sticky-top ">

    <div class="row bg-primary d-flex align-items-center justify-content-start">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10 pt-2">
            <h2 class="text-white league-spartan">{{$indicador->nombre}}</h2>

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




<div class="row">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body py-3 px-4">

            <form action="{{route('indicador.lleno.show.admin', $indicador->id)}}" method="GET">
                <div class="d-flex flex-wrap align-items-end gap-3">

                    <!-- Fecha inicio -->
                    <div>
                        <label class="form-label small text-muted fw-semibold mb-1">Desde</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-calendar-days text-primary"></i>
                            </span>
                            <input type="date"
                                name="fecha_inicio"
                                value="{{ request('fecha_inicio') ?? now()->format('Y-m-d') }}"
                                class="form-control border-0 bg-light datepicker"
                                onchange="this.form.submit()">
                        </div>
                    </div>

                    <!-- Fecha fin -->
                    <div>
                        <label class="form-label small text-muted fw-semibold mb-1">Hasta</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-calendar-days text-danger"></i>
                            </span>
                            <input type="date"
                                name="fecha_fin"
                                value="{{ request('fecha_fin') ?? now()->format('Y-m-d') }}"
                                class="form-control border-0 bg-light datepicker"
                                onchange="this.form.submit()">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


</div>




<div class="container-fluid">
    <div class="row">
        <div class="col-3">
            
        </div>
    </div>
</div>


@endsection