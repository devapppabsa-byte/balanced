@extends('plantilla')
@section('title', 'Perfil Cliente')
@section('contenido')
@php
    use App\Models\ClienteEncuesta;
@endphp
<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center ">
        <div class="col-9 col-sm-9 col-md-8 col-lg-10 pt-2 text-white">
            <h3 class="mt-1 mb-0">
                Hola {{strtok(Auth::guard("cliente")->user()->nombre, " ")}}, 
            </h3>
            <span>Bienvenido a tus encuestas</span>
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
            @if (session('contestado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('contestado')}}
                </div>
            @endif

            @if(session('contestada'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('contestada')}}
                </div>
            @endif

            @if ($errors->any())
                <div class="text-white fw-bold bad_notifications">
                    <i class="fa fa-xmark-circle mx-2"></i>
                    {{$errors->first()}}
                </div>
            @endif
        </div>

        <div class="col-3 col-sm-3 col-md-4 col-lg-2 text-center ">
            <form action="{{route('cerrar.session')}}" method="POST">
                @csrf 
                <button  class="btn  btn-sm text-danger text-white fw-bold">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Cerrar Sesión
                </button>
            </form>
        </div>

    </div>

    @include('client.assets.nav')

    <div class="row bg-white shadow-sm border-bottom">
        <div class="col-12 col-sm-12 col-md-4 col-lg-auto m-1 p-2">
            <a class="btn btn-danger btn-sm w-100 px-3 py-1" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#sugerencia">
                <i class="fa-solid fa-comments"></i>
                Queja o sugerencia
            </a>
        </div>
    </div>

</div>






<div class="container-fluid mt-3">
    <div class="row justify-content-around">

        <div class="col-12 col-sm-12 col-md-8 col-lg-6 mt-2">
            <div class="table-responsive shadow-sm">
                <table class="table  table-responsive mb-0 border shadow-sm table-hover">
                        <thead class="bree-serif-regular table-primary">
                            <tr>
                                <th class="text-gray">Titulo Encuesta</th>
                                <th>Estado</th>
                                <th>Ver</th>
                            </tr>
                        </thead>
                    <tbody>
                    @forelse ($encuestas as $encuesta)
                            @php //Esta logica es engorrosa pero la necesito de momento para diferenciar las encuestas //contestadas de las no contestadas
                                $existe = ClienteEncuesta::where('id_cliente', Auth::guard('cliente')->user()->id)
                                ->where('id_encuesta', $encuesta->id)
                                ->exists();
                            @endphp 
                        @if ($existe)
                                <tr class="table-light">
                                    <td class="fw-bold">
                                        <a href="{{route('index.encuesta.contestada', $encuesta->id)}}" class="text-dark">
                                            <i class="fa fa-check-circle text-success me-3" ></i>
                                            {{$encuesta->nombre}}
                                        </a>
                                    </td>
                                    <td class="fw-bold">
                                        <i class="fa fa-check-circle text-success mx-2"></i>
                                        Contestada
                                    </td>
                                    <td>
                                    <a class="btn btn-success btn-sm " href="{{route('index.encuesta.contestada', $encuesta->id)}}">
                                            <i class="fa fa-eye "></i>            
                                        </a>
                                    </td>
                                </tr>

                            @else
                                <tr>
                                    <td class="fw-bold">
                                        <a href="{{route('index.encuesta', $encuesta->id)}}" class="text-dark">
                                            <i class="fa fa-exclamation-circle text-dark me-3" ></i>
                                            {{$encuesta->nombre}}
                                        </a>
                                    </td>
                                    <td>
                                        <i class="fa fa-exclamation-circle text-danger"></i>
                                        Aún no es contestada
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm " href="{{route('index.encuesta', $encuesta->id)}}">
                                            <i class="fa fa-eye "></i>            
                                        </a>
                                    </td>
                                </tr>
                            @endif
   
                    @empty
                        <div class="col-12 p-5 text-center p-5 border">
                            <div class="row">
        
                                <div class="col-12">
                                    <i class="fa fa-exclamation-circle text-danger"></i>
                                    No cuenta hay encuestas aún.
                                </div>
                            
                            </div>
                        </div>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="col-11 col-sm-11 col-md-8 col-lg-5 bg-white rounded-5 shadow border p-2 mt-2">

            <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark active" id="ex3-tab-1" href="#ex3-tabs-1" role="tab" aria-controls="ex3-tabs-1" aria-selected="true">
                    <i class="fa fa-chart-simple"></i>  
                    Barras
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark" id="ex3-tab-2" href="#ex3-tabs-2" role="tab" aria-controls="ex3-tabs-2" aria-selected="false">
                    <i class="fa fa-chart-line"></i> 
                    Lineas
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark" id="ex3-tab-3" href="#ex3-tabs-3" role="tab" aria-controls="ex3-tabs-3" aria-selected="false">
                    <i class="fa fa-circle"></i>  
                    Burbuja
                    </a>
                </li>
            </ul>
            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tab-content" id="ex2-content">
                <div class="tab-pane  show active" id="ex3-tabs-1" role="tabpanel" aria-labelledby="ex3-tab-1" >
                    <canvas class="" id="grafico"></canvas>
                </div>
                <div class="tab-pane" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                    <canvas  class="" id="chartLinea"></canvas>
                </div>
                <div class="tab-pane " id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                    <canvas  class="" id="chartBurbuja"></canvas>
                </div>
            </div>
            <!-- Tabs content -->

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

            backgroundColor: function(context) {
            const value = context.raw;
            return value < 50
                ? "rgba(255, 99, 132, 0.7)"  // rojo
                : "rgba(75, 192, 75, 0.7)";  // verde
            },
            borderColor: function(context) {
            const value = context.raw;
            return value < 50 ? "red" : "green";
            },

            borderWidth: 1
        },
        {
            type: "line", // Línea sobrepuesta
            label: "Mínimo",
            data: [50, 50, 50, 50],
            borderColor: "red",
            borderWidth: 2,
            fill: false
        },
        {
            type: "line", // Línea sobrepuesta
            label: "Máximo",
            data: [100, 100, 100, 100],
            borderColor: "green",
            borderWidth: 2,
            fill: false
        }
        ]
    },
    options: {
        responsive: true,

        plugins: {
        legend: { position: "top" }
        },
        scales: {
        y: { beginAtZero: true }
        }
    }
    });
</script>








{{-- Grafico de Pie --}}



<script>
const ctx2 = document.getElementById('chartLinea');

new Chart(ctx2, {
  type: 'line',
  data: {
    labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
    datasets: [
      {
        label: 'Ventas',
        data: [30, 50, 40, 60],
        borderColor: '#36a2eb',
        backgroundColor: 'rgba(54,162,235,0.2)',
        fill: true,
        tension: 0.3
      },
      {
        label: 'Mínimo',
        data: [50, 50, 50, 50],
        borderColor: 'red',
        borderDash: [5, 5],
        fill: false
      },
      {
        label: 'Máximo',
        data: [100, 100, 100, 100],
        borderColor: 'green',
        borderDash: [5, 5],
        fill: false
      }
    ]
  },
  options: { responsive: true }
});
</script>






{{-- grafico de burbuja --}}



<script>
const ctx3 = document.getElementById('chartBurbuja');

new Chart(ctx3, {
  type: 'bubble',
  data: {
    datasets: [
      {
        label: 'Ventas por mes',
        data: [
          {x: 1, y: 30, r: 10},
          {x: 2, y: 50, r: 15},
          {x: 3, y: 40, r: 12},
          {x: 4, y: 60, r: 18}
        ],
        backgroundColor: ['#ff6384','#4bc0c0','#ffce56','#36a2eb']
      }
    ]
  },
  options: {
    scales: {
      x: {
        ticks: { callback: (val) => ['Ene','Feb','Mar','Abr'][val-1] },
        title: { display: true, text: 'Mes' }
      },
      y: {
        beginAtZero: true,
        title: { display: true, text: 'Valor' }
      }
    }
  }
});
</script>


@endsection