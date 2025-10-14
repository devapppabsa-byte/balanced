@extends('plantilla')
@section('title', 'Perfil del usuario')



@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center justify-content-start ">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  py-4">
            <h2 class="text-white">{{Auth::user()->departamento->nombre}}</h2>
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
        @forelse ($indicadores as $indicador)
        <div class="col-auto m-2">
            <a href="{{route('show.indicador.user', $indicador->id)}}" class="btn btn-outline-primary">
                {{$indicador->nombre}}
            </a>
        </div>
        @empty
        <li>No hay datos </li>
        @endforelse
    </div>
</div>


<div class="container-fluid py-2"><div class="row">
        <div class="col-12 text-center">
            <h2 class="cascadia_code">Balance General de {{Auth::user()->departamento->nombre}}</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-11 col-sm-10 col-md-11 col-lg-8  shadow px-5 pb-5 pt-4 bg-white" >
            <!-- Tabs navs -->
            <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
                <li class="nav-item" role="presentation">
                    <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark active" id="ex3-tab-1" href="#ex3-tabs-1" role="tab" aria-controls="ex3-tabs-1" aria-selected="true">
                        Grafico de Barras
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark" id="ex3-tab-2" href="#ex3-tabs-2" role="tab" aria-controls="ex3-tabs-2" aria-selected="false">
                        Grafico de Pie
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark" id="ex3-tab-3" href="#ex3-tabs-3" role="tab" aria-controls="ex3-tabs-3" aria-selected="false">
                        Grafico de Burbuja
                    </a>
                </li>
            </ul>
            <!-- Tabs navs -->

            <!-- Tabs content -->
            <div class="tab-content" id="ex2-content">
                <div class="tab-pane  show active" id="ex3-tabs-1" role="tabpanel" aria-labelledby="ex3-tab-1" >
                    <canvas class="w-100 h-100" id="grafico"></canvas>
                </div>
                <div class="tab-pane  p-5" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                <div class="row justify-content-center">
                        <div class="col-8 text-center">
                            <canvas id="pieChart"></canvas>
                        </div>
                </div>
                </div>
                <div class="tab-pane " id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                    <canvas id="bubbleChart"></canvas>
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

const ctxPie = document.getElementById('pieChart').getContext('2d');

new Chart(ctxPie, {
  type: 'pie',
  data: {
    labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
    datasets: [{
      label: 'Ventas',
      data: [30, 50, 35, 60],
      backgroundColor: [
        'rgba(255, 99, 132, 0.6)',
        'rgba(54, 162, 235, 0.6)',
        'rgba(255, 206, 86, 0.6)',
        'rgba(75, 192, 192, 0.6)'
      ],
      borderColor: '#fff',
      borderWidth: 2
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: 'bottom' },
      title: {
        display: true,
        text: 'Gráfico de Pie - Ventas'
      }
    }
  }
});
</script>





{{-- grafico de burbuja --}}


<script>
const ctxBubble = document.getElementById('bubbleChart').getContext('2d');

new Chart(ctxBubble, {
  type: 'bubble',
  data: {
    datasets: [{
      label: 'Ventas',
      data: [
        { x: 1, y: 30, r: 10 },   // Enero
        { x: 2, y: 50, r: 15 },   // Febrero
        { x: 3, y: 35, r: 12 },   // Marzo
        { x: 4, y: 60, r: 18 }    // Abril
      ],
      backgroundColor: 'rgba(75, 192, 192, 0.6)',
      borderColor: 'rgba(75, 192, 192, 1)',
      borderWidth: 2
    }]
  },
  options: {
    scales: {
      x: { title: { display: true, text: 'Mes' } },
      y: { title: { display: true, text: 'Ventas' }, beginAtZero: true }
    },
    plugins: {
      title: {
        display: true,
        text: 'Gráfico de Burbuja - Ventas'
      },
      legend: { position: 'bottom' }
    }
  }
});
</script>

@endsection