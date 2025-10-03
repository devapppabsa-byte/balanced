@extends('plantilla')
@section('title', 'Detalle del Indicador')


@section('contenido')  
<div class="container-fluid">

    <div class="row bg-primary d-flex align-items-center justify-content-start">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  py-4">
            <h1 class="text-white">Detalle del {{$indicador->nombre}}</h1>

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

    <div class="row gap-4 p-2 justify-content-start border-bottom pb-5 mt-3">
        <div class="col-12">
            <h5>Información para este indicador</h5>
        </div>
        @forelse ($campos_llenos as $campo_lleno)
        <div class="col-auto border border-4 p-2 text-center shadow-sm">
            <span>{{$campo_lleno->nombre}}</span>
            <h6>{{$campo_lleno->informacion_precargada}}</h6>
            <small>{{$campo_lleno->descripcion}}</small>
        </div>
        @empty
            <div class="col-11 border border-4 p-5 text-center">
                <h2>
                    <i class="fa fa-exclamation-circle text-danger"></i>
                    No se encontraron datos
                </h2>
            </div>
        @endforelse
    </div>



    <div class="row justify-content-around pb-5 mt-4 border-bottom d-flex align-items-center">
        <div class="col-12 mb-3">
            <h5>Seguimiento del Indicador</h5>
        </div>

        <div class="col-auto mx-2">
            <div class="table-responsive p-0 border shadow-sm ">
            <table class="table">
                <thead class="table-primary">
                <tr>
                    <th scope="col">Mes</th>
                    <th scope="col">Toneladas Presupuestadas</th>
                    <th scope="col">Toneladas Producidas</th>
                    <th scope="col">% Cumplimiento</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <th scope="row">Julio</th>
                    <td>4000</td>
                    <td>3950</td>
                    <td class="text-success fw-bold">98.75%</td>
                </tr>                    

                <tr>
                    <th scope="row">Agosto</th>
                    <td>4000</td>
                    <td>2000</td>
                    <td class="text-danger fw-bold">50%</td>
                </tr>
                <tr>
                    <th scope="row">Septiembre</th>
                    <td>4000</td>
                    <td>3950</td>
                    <td class="text-success fw-bold">98.75%</td>
                </tr>
                <tr>
                    <th scope="row">Octubre</th>
                    <td>4000</td>
                    <td>3950</td>
                    <td class="text-success fw-bold">98.75%</td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>

        <div class="col-11 col-sm-10 col-md-8 col-lg-5 mt-4 shadow p-5" >
            <canvas class="w-100 h-100" id="grafico"></canvas>
        </div>

    </div>
</div>


@endsection





@section('scripts')

<script>
    const ctx = document.getElementById('grafico').getContext('2d');

    new Chart(ctx, {
    data: {
        labels: ["Enero", "Febrero", "Marzo", "Abril"],
        datasets: [
        {
            type: "bar",  // Barras
            label: "Ventas",
            data: [30, 50, 40, 60],
            backgroundColor: "rgba(75, 192, 192, 0.5)"
        },
        {
            type: "line", // Línea sobrepuesta
            label: "Promedio",
            data: [50, 50, 50, 50],
            borderColor: "red",
            borderWidth: 2,
            fill: false
        },
        {
            type: "line", // Línea sobrepuesta
            label: "Promedio",
            data: [100, 100, 100, 100],
            borderColor: "blue",
            borderWidth: 2,
            fill: false
        }
        ]
    },
    options: {
        responsive: true,
        plugins: {
        legend: { position: "top" }
        }
    }
    });
</script>

    
@endsection