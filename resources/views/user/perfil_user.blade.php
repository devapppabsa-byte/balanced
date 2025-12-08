@extends('plantilla')
@section('title', 'Perfil del usuario')



@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center justify-content-start ">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  py-3">
            <h2 class="text-white">Balance General de {{Auth::user()->departamento->nombre}}</h2>
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






<div class="container-fluid border-bottom pt-2 bg-white shadow shadow-sm ">
     <div class="row">
        <div class="col-12 ">
            <h5>Indicadores de {{Auth::user()->departamento->nombre}}</h5>
        </div>
     </div>

    <div class="row">
      
      @if ($ponderacion == 100)
          
        @forelse ($indicadores as $indicador)
          <div class="col-auto m-2">
            <a href="{{route('show.indicador.user', $indicador->id)}}" class="btn btn-outline-primary">
              {{$indicador->nombre}}
            </a>
          </div>
        @empty
          <li>No hay datos </li>
        @endforelse

      @else

          <div class="alert alert-info">
            <i class="fa fa-info-circle"></i>
            La sumatoria de la ponderación no da 100%. Actualmente da <b> %{{$ponderacion}} </b>
          </div>

      @endif
    </div>
</div>


<div class="container-fluid py-2"><div class="row">
    </div>
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-11 col-lg-7  shadow px-5 pb-5 pt-4 bg-white" >
            <!-- Tabs navs -->
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
                    <canvas class="w-100" id="grafico"></canvas>
                </div>
                <div class="tab-pane" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                    <canvas  class="w-100" id="chartLinea"></canvas>
                </div>
                <div class="tab-pane " id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                    <canvas  class="w-100" id="chartBurbuja"></canvas>
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