@extends('plantilla')
@section('title', 'Detalle del Indicador')
@section('contenido')
@php
    use Carbon\Carbon;
    use App\Models\InformacionInputPrecargado;
@endphp  
<style>
    .accordion{
        padding-top: 0.25rem;   /* menos alto */
        padding-bottom: 0.25rem;
        padding-left: 0.75rem;  /* opcional, ajusta horizontal */
        padding-right: 0.75rem;
        margin: 0rem;
        font-size: 0.9rem;  
    }
</style>



<div class="container-fluid sticky-top">

    <div class="row bg-primary d-flex align-items-center justify-content-start">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10 pt-2">
            <h3 class="text-white league-spartan">Detalle del {{$indicador->nombre}}</h3>

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

<div class="row bg-white">
    <div class="accordion p-0 m-0 bg-white" id="accordionExample">
        <div class="">
            <div class="accordion-header text-start " id="headingTwo">
                <a data-mdb-collapse-init class="fw-bold  collapsed m-2" type="button" data-mdb-target="#info_precargada" aria-expanded="false" aria-controls="collapseTwo">
                    <i class="fa-solid fa-circle-arrow-down"></i>
                    Información precargada por el administrador
                </a>
            </div>
            <div id="info_precargada" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-mdb-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="row gap-4  justify-content-start d-flex align-items-center">
                        @forelse ($campos_llenos as $campo_lleno)
                        <div class="col-2 p-2 text-center  bg-white mb-4 border border-dark border-4 rounded-5">
                            <h5 class="fw-bold">{{$campo_lleno->nombre}}</h5>

                            <h5  class="lh-1">
                                @php
                                    $last_info = InformacionInputPrecargado::latest()->first();
                                    $meses = ["0","Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
                                @endphp
                                {{$last_info->informacion}}
                            </h5>
                            <p>{{$meses[$last_info->mes]}} {{$last_info->year}}</p>
                            <small>{{$campo_lleno->descripcion}}</small>
                        </div>
                        @empty
                            <div class="col-12 border border-4 p-5 text-center">
                                <h2>
                                    <i class="fa fa-exclamation-circle text-danger"></i>
                                    No se encontraron datos
                                </h2>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>


    <div class="row justify-content-center">
                @forelse($grupos as $movimiento => $items)

                <div class="col-10 col-sm-5 col-md-5 col-lg-3  shadow-sm mx-4 border rounded mt-4 bg-white">
                    @php
                        $fecha = Carbon::parse(explode('-', $movimiento)[0]);
                        Carbon::setLocale('es');
                        $mes = $fecha->translatedformat('F');
                        $year = $fecha->format('Y');
                    @endphp

                    <div class="row justify-content-center">
                        
                        <div class="col-12 bg-info text-white pt-3 pb-2 mb-4 rounded">
                            <h3 class="text-center fw-bold">
                                <i class="fa-solid fa-calendar-days"></i> {{ $mes.' - '.$year }}
                            </h3>
                        </div>
                        
                        @foreach($items as $item)

                        
                        {{-- Se hace la consulta de la informaion del indiacor lleno, y se hace la condicional  para saber si esta el campo final --}}
                        @if ($item->final === "on")
                        <div class="col-8  fw-bold  rounded-5 border zoom_link {{($indicador->meta_minima > $item['informacion_campo']) ? 'border-danger' : 'border-success' }} bg-light mb-3 py-2 mt-3">
                            
                             
                            <h5 class="text-center ">
                                <i class="fa {{($indicador->meta_minima > $item['informacion_campo']) ? 'fa-xmark-circle text-danger' : 'fa-check-circle text-success' }}"></i>
                                {{ $item['nombre_campo'] }}: 
                            </h5> 
                            <h2 class="text-center">{{ $item['informacion_campo'] }} </h2>
                        
                        </div>
                        @else
                        <div class="col-12">
                            <span class="fw-bold">{{ $item['nombre_campo'] }}: </span> <br>
                            <span class="h3">{{ $item['informacion_campo'] }}</span> <br>                
                        </div>
                        @endif



                        @endforeach
                        
                    </div>
                </div>
                
                    
                @empty

                @endforelse
    </div>


    <div class="row  pb-5  mt-2 d-flex align-items-center justify-content-around">
        

        {{-- <div class="col-11 col-sm-10 col-md-9 col-lg-6 mt-5 shadow p-5 bg-white" >
            <div class="col-auto ">
                <h5 class="my-2">
                    <i class="fa-solid fa-chart-simple"></i>
                    Seguimiento del Indicador de Ventas
                </h5>
                <div class="table-responsive p-0 border shadow-sm ">
                <table class="table">
                    <thead class="table-primary">
                    <tr>
                        <th scope="col">Mes</th>
                        <th scope="col">Toneladas Presupuestadas</th>
                        <th scope="col">Toneladas Producidas</th>
                        <th scope="col">Cumplimiento</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <th scope="row">Enero</th>
                        <td>4000</td>
                        <td>3950</td>
                        <td class="text-success fw-bold">98.75%</td>
                    </tr>                    

                    <tr>
                        <th scope="row">Febrero</th>
                        <td>4000</td>
                        <td>2000</td>
                        <td class="text-danger fw-bold">50%</td>
                    </tr>
                    <tr>
                        <th scope="row">Marzo</th>
                        <td>4000</td>
                        <td>3950</td>
                        <td class="text-success fw-bold">98.75%</td>
                    </tr>
                    <tr>
                        <th scope="row">Abril</th>
                        <td>4000</td>
                        <td>3950</td>
                        <td class="text-success fw-bold">98.75%</td>
                    </tr>
                    </tbody>
                </table>
                </div>
            </div>
        </div> --}}








        <div class="col-11 col-sm-10 col-md-9 col-lg-5 mt-5 shadow px-5 pb-5 pt-4 bg-white" >
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
                        <i class="fa fa-chart-pie"></i>
                        Pie
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
                    <canvas class="w-100 h-100" id="grafico"></canvas>
                </div>
                <div class="tab-pane  p-5" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                   <div class="row justify-content-center">
                        <div class="col-8 text-center">
                            <canvas id="graficoPie"></canvas>
                        </div>
                   </div>
                </div>
                <div class="tab-pane " id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                    <canvas id="graficoLine"></canvas>
                </div>
            </div>
            <!-- Tabs content -->

        </div>

    </div>
</div>


@endsection





@section('scripts')

{{-- Grafico de Pie --}}

<script>
const datos = @json($graficar);

// Meses en español
const mesesES = [
  "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
  "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];

// Labels por mes
const labels = datos.map(item => {
    const fecha = new Date(item.created_at);
    return mesesES[fecha.getMonth()];
});

// Valores
const valores = datos.map(item => parseFloat(item.informacion_campo));

// Niveles
const MINIMO = {{$indicador->meta_minima}};
const MAXIMO = {{$indicador->meta_esperada}}; // (solo referencia)

// Colores condicionales por valor
const colores = valores.map(value =>
    value < MINIMO
      ? "rgba(255, 99, 132, 0.7)"   // rojo
      : "rgba(75, 192, 75, 0.7)"    // verde
);

const ctxPie = document.getElementById('graficoPie').getContext('2d');

new Chart(ctxPie, {
  type: "pie",
  data: {
    labels: labels,
    datasets: [{
      label: "Costo por tonelada",
      data: valores,
      backgroundColor: colores,
      borderColor: "#ffffff",
      borderWidth: 2
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: "top"
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            const valor = context.parsed;
            const total = context.dataset.data.reduce((a, b) => a + b, 0);
            const porcentaje = ((valor / total) * 100).toFixed(1);

            const estado = valor < MINIMO ? "❌ Bajo mínimo" : "✅ Cumple";

            return `${context.label}: ${valor} (${porcentaje}%) ${estado}`;
          }
        }
      }
    }
  }
});
</script>

<script>
    const ctxBar = document.getElementById('grafico').getContext('2d');

    new Chart(ctxBar, {
    data: {
        labels: labels,
        datasets: [
        {
            type: "bar",
            label: "Costo por tonelada",
            data: valores,

            backgroundColor: function(context) {
            const value = context.raw;
            return value < MINIMO
                ? "rgba(255, 99, 132, 0.7)" // rojo
                : "rgba(75, 192, 75, 0.7)"; // verde
            },
            borderColor: function(context) {
            const value = context.raw;
            return value < MINIMO ? "red" : "green";
            },
            borderWidth: 1
        },

        // Línea de nivel mínimo
        {
            type: "line",
            label: "Nivel mínimo",
            data: valores.map(() => MINIMO),
            borderColor: "red",
            borderWidth: 2,
            fill: false
        },

        // Línea de nivel máximo
        {
            type: "line",
            label: "Nivel máximo",
            data: valores.map(() => MAXIMO),
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


<script>
// Labels: mes


// Valores

// 🎨 Paleta fija (1 color por mes)
const coloresMeses = [
  "#3498db", // Enero
  "#1abc9c", // Febrero
  "#9b59b6", // Marzo
  "#e67e22", // Abril
  "#f1c40f", // Mayo
  "#2ecc71", // Junio
  "#e74c3c", // Julio
  "#34495e", // Agosto
  "#16a085", // Septiembre
  "#d35400", // Octubre
  "#8e44ad", // Noviembre
  "#c0392b"  // Diciembre
];

// Colores de los puntos según mes
const coloresPuntos = labels.map(mes => {
    const index = mesesES.indexOf(mes);
    return coloresMeses[index] ?? "#95a5a6";
});

const ctx = document.getElementById('graficoLine').getContext('2d');

new Chart(ctx, {
  type: "line",
  data: {
    labels: labels,
    datasets: [{
      label: "Costo por tonelada",
      data: valores,
      borderColor: "#2c3e50",
      backgroundColor: "rgba(44, 62, 80, 0.1)",
      fill: true,
      tension: 0.35,

      // 🔹 puntos
      pointBackgroundColor: coloresPuntos,
      pointBorderColor: "#2c3e50",
      pointRadius: 6,
      pointHoverRadius: 8
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: "top"
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            return `${context.label}: ${context.parsed}`;
          }
        }
      }
    },
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});


</script>

@endsection