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

          <div class="alert alert-danger border border-2 border-danger">
            <i class="fa fa-info-circle"></i>
            La sumatoria de la ponderación no da 100%. Actualmente da <b>  {{$ponderacion}}%</b>
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
                      Grafica de los indicadores
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark" id="ex3-tab-2" href="#ex3-tabs-2" role="tab" aria-controls="ex3-tabs-2" aria-selected="false">
                      <i class="fa fa-chart-line"></i> 
                      Grafica del cumplimiento normativo
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark" id="ex3-tab-3" href="#ex3-tabs-3" role="tab" aria-controls="ex3-tabs-3" aria-selected="false">
                      <i class="fa fa-circle"></i>  
                     Grafica de satisfacción del cliente
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
                    <canvas  class="w-100" id="grafico_normas"></canvas>
                </div>
                <div class="tab-pane " id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                    <canvas id="grafico_encuestas" class="w-100"></canvas>
                </div>
            </div>
            <!-- Tabs content -->

        </div>
    </div>
</div>






@endsection

@section('scripts')

<script>

    const labelsRaw = @json($labels_indicadores);
    const data = @json($data_indicadores);
    const meses = [
    "Enero","Febrero","Marzo","Abril","Mayo","Junio",
    "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"
  ];

  const labels = labelsRaw.map(fecha => {
    const [year, month] = fecha.split("-");
    return `${meses[month - 1]} ${year}`;
  });

//Se pueden poner los limites e las lineas de las graficas
  const minimo = 50;
  const maximo = 100;

  const lineaMin = Array(data.length).fill(minimo);
  const lineaMax = Array(data.length).fill(maximo);

  const ctx = document.getElementById('grafico').getContext('2d');

  new Chart(ctx, {
    data: {
      labels: labels,
      datasets: [
        {
          type: "bar",
          label: "Cumplimiento",
          data: data,

          backgroundColor: function(context) {
            const value = context.raw;
            return value < minimo
              ? "rgba(255, 99, 132, 0.7)"
              : "rgba(75, 192, 75, 0.7)";
          },
          borderColor: function(context) {
            const value = context.raw;
            return value < minimo ? "red" : "green";
          },
          borderWidth: 1
        },
        {
          type: "line",
          label: "Mínimo",
          data: lineaMin,
          borderColor: "red",
          borderWidth: 2,
          fill: false
        },
        {
          type: "line",
          label: "Máximo",
          data: lineaMax,
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
        y: {
          beginAtZero: true,
          max: 100
        }
      }
    }
  });


</script>

<script>
  const graficas = @json($resultado_normas);

  if (!graficas || graficas.length === 0) {
    console.warn('No hay datos para graficar');
  } else {

    const meses = [
      "Enero","Febrero","Marzo","Abril","Mayo","Junio",
      "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"
    ];

    // Labels (meses)
    const labels = graficas[0].labels.map(fecha => {
      const [year, month] = fecha.split("-");
      return `${meses[month - 1]} ${year}`;
    });

    // Colores automáticos
    const colores = [
      "rgba(54, 162, 235, 0.7)",
      "rgba(255, 99, 132, 0.7)",
      "rgba(75, 192, 192, 0.7)",
      "rgba(255, 159, 64, 0.7)",
      "rgba(153, 102, 255, 0.7)",
      "rgba(201, 203, 207, 0.7)"
    ];

    // Datasets por norma
    const datasets = graficas.map((g, index) => ({
      label: g.norma,
      data: g.data,
      backgroundColor: colores[index % colores.length],
      borderColor: colores[index % colores.length].replace('0.7', '1'),
      borderWidth: 1
    }));

    const ctx = document
      .getElementById('grafico_normas')
      .getContext('2d');

    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: labels,
        datasets: datasets
      },
      options: {
        responsive: true,
        plugins: {
          legend: {
            position: 'top'
          },
          tooltip: {
            callbacks: {
              label: function(context) {
                return `${context.dataset.label}: ${context.raw}%`;
              }
            }
          }
        },
        scales: {
          y: {
            beginAtZero: true,
            max: 100,
            ticks: {
              callback: value => value + '%'
            }
          }
        }
      }
    });
  }
</script>

<script>
const graficas_encuestas = @json($resultado_encuestas);

if (!graficas_encuestas || graficas_encuestas.length === 0) {
  console.warn('No hay datos para graficar');
} else {

  const meses = [
    "Enero","Febrero","Marzo","Abril","Mayo","Junio",
    "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"
  ];

  // 🔹 Labels globales (todos los meses usados)
  const labelsRaw = [...new Set(
    graficas_encuestas.flatMap(g => g.labels)
  )].sort();

  const labels = labelsRaw.map(fecha => {
    const [year, month] = fecha.split("-");
    return `${meses[month - 1]} ${year}`;
  });

  // 🔹 Colores automáticos
  const colores = [
    "rgba(54, 162, 235, 0.7)",
    "rgba(255, 99, 132, 0.7)",
    "rgba(75, 192, 192, 0.7)",
    "rgba(255, 159, 64, 0.7)",
    "rgba(153, 102, 255, 0.7)",
    "rgba(201, 203, 207, 0.7)"
  ];

  // 🔹 Datasets por encuesta (alineados por mes)
  const datasets = graficas_encuestas.map((g, index) => {
    const dataAlineada = labelsRaw.map(mes => {
      const pos = g.labels.indexOf(mes);
      return pos !== -1 ? g.data[pos] : 0;
    });

    return {
      label: g.encuesta,
      data: dataAlineada,
      backgroundColor: colores[index % colores.length],
      borderColor: colores[index % colores.length].replace('0.7', '1'),
      borderWidth: 1
    };
  });

  const ctx = document
    .getElementById('grafico_encuestas')
    .getContext('2d');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: datasets
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return `${context.dataset.label}: ${context.raw}`;
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
}
</script>







{{-- Grafico de Pie --}}


{{-- 
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
</script> --}}






{{-- grafico de burbuja --}}


{{-- 
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
</script> --}}


@endsection