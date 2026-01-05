@extends('plantilla')

@section('title', 'Detalle Evaluacion de Proveedores')

@section('contenido')
<button class="btn btn-danger flotante" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#grafico">
    <i class="fa fa-chart-pie fa-4x"></i>
</button>

<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center px-4">
        <div class="col-auto py-4 text-white">
            <h1 class="mt-1">Evaluaciones de {{ $proveedor->nombre }}.</h1>
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
            @if (session('editado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('editado')}}
                </div>
            @endif
            @if (session('eliminado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('eliminado')}}
                </div>
            @endif
            @if ($errors->any())
                <div class="text-white fw-bold bad_notifications">
                    <i class="fa fa-xmark-circle mx-2"></i>
                    {{$errors->first()}}
                </div>
            @endif
        </div>
    </div>
    @include('admin.assets.nav')
</div>



<div class="container-fluid ">

    <form class="row   justify-content-center " action="#" method="GET">
        <div class="col-9  mx-5  ">
            <div class="row justify-content-center p-3">
                @csrf @method("GET")
                        <div class="col-12 col-sm-12 col-md-8 col-lg-5  shadow shadow-sm p-3 border bg-white px-4">
                            <div class="row justify-content-center"> 
                                <div class="col-6 ">
                                    <div class="form-group">
                                        <label for="" class="fw-bold">Fecha Inicio: </label>
                                        <input type="date" name="fecha_inicio" value="{{request('fecha_inicio')}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-6 ">
                                    <div class="form-group">
                                        <label for="" class="fw-bold">Fecha Final: </label>
                                        <input type="date" name="fecha_fin" value="{{request('fecha_fin')}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-12 m-2">
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-sm ">
                                            <i class="fa fa-filter"></i>
                                            Filtrar
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
            </div>
        </div>

    </form>




    <div class="row justify-content-center ">
        <div class="col-12 col-sm-12 col-md-10 col-lg-9  mx-5 bg-white rounded border p-5 shadow-sm">
            <h4>
                <i class="fa fa-list"></i>
                Lista de evaluaciones al proveedor
            </h4>
                @if (!$evaluaciones->isEmpty())
                <div class="table-responsive shadow-sm">
                    <table class="table table-responsive mb-0 border shadow-sm table-hover">
                            <thead class="table-secondary text-white cascadia-code">
                                <tr>
                                <th>
                                    <i class="fa fa-calendar"></i>
                                    Fecha
                                </th>
                                <th>Descripción</th>
                                <th>Calificación</th>
                                <th>Observaciones</th>
                                </tr>
                            </thead>
                        <tbody>
                @endif

                @forelse ($evaluaciones as $evaluacion)
                    <tr>
                        <td>
                            {{$evaluacion->fecha}}
                        </td>

                        <td>
                           {{$evaluacion->descripcion}}
                        </td>

                        <td class=" fw-bold {{ ($evaluacion->calificacion) >= 80 ? 'text-success' : 'text-danger'}}">
                           {{$evaluacion->calificacion}} Puntos
                        </td>
                                               
                        <td>
                            {{$evaluacion->observaciones}}
                        </td>

                    </tr>
                @empty
                    <div class="col-12 p-5 text-center p-5 border">

                        <div class="row">
                            
                            <div class="col-12">
                                <i class="fa fa-exclamation-circle text-danger"></i>
                                No cuenta con evaluaciones.
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










<div class="modal fade" id="grafico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-xl  modal-fullscreen-md-down">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Gráfica</h5>
        <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <div class="col-12 pb-5 px-5 pt-2" >
                <!-- Tabs navs -->
                <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark active" id="ex3-tab-1" href="#ex3-tabs-1" role="tab" aria-controls="ex3-tabs-1" aria-selected="true">
                            <i class="fa-solid fa-chart-simple"></i>
                            Grafico de Barras
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark" id="ex3-tab-2" href="#ex3-tabs-2" role="tab" aria-controls="ex3-tabs-2" aria-selected="false">
                            <i class="fa fa-chart-line"></i>
                            Grafico de Linea
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark" id="ex3-tab-3" href="#ex3-tabs-3" role="tab" aria-controls="ex3-tabs-3" aria-selected="false">
                            <i class="fa fa-circle"></i>
                            Grafico de Burbuja
                        </a>
                    </li>
                </ul>
                <!-- Tabs navs -->

                <!-- Tabs content -->
                <div class="tab-content" id="ex2-content">
                    <div class="tab-pane  show active" id="ex3-tabs-1" role="tabpanel" aria-labelledby="ex3-tab-1" >
                        <canvas id="barLineChart"></canvas>
                    </div>
                    <div class="tab-pane" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                        <canvas id="lineChart"></canvas>
                    </div>
                    <div class="tab-pane " id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
                <!-- Tabs content -->

            </div>
        </div>
    </div>
  </div>
</div>

@endsection




@section('scripts')

<script>
/* =============================
   DATOS DESDE LARAVEL
============================= */
const evaluaciones = @json($evaluaciones);

/* =============================
   CONSTANTES
============================= */
const mesesES = [
  'Enero','Febrero','Marzo','Abril','Mayo','Junio',
  'Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'
];

const META = 80;

/* =============================
   AGRUPAR POR MES
============================= */
const porMes = {};

evaluaciones.forEach(e => {
    const fecha = new Date(e.created_at);
    const mes = fecha.getMonth();

    if (!porMes[mes]) porMes[mes] = [];
    porMes[mes].push(Number(e.calificacion));
});

/* =============================
   LABELS Y PROMEDIOS
============================= */
const labels = Object.keys(porMes).map(m => mesesES[m]);

const promedios = Object.values(porMes).map(arr =>
    Number((arr.reduce((a, b) => a + b, 0) / arr.length).toFixed(1))
);

/* =============================
   COLORES SEGÚN META
============================= */
const coloresPorValor = promedios.map(valor =>
    valor >= META
        ? 'rgba(75, 192, 75, 0.7)'   // verde
        : 'rgba(255, 99, 132, 0.7)'  // rojo
);

const metas = labels.map(() => META);

/* =============================
   GRÁFICA BAR + LINE
============================= */
const ctx1 = document.getElementById('barLineChart');

new Chart(ctx1, {
    data: {
        labels: labels,
        datasets: [
            {
                type: 'bar',
                label: 'Puntuación obtenida',
                data: promedios,
                backgroundColor: coloresPorValor,
                borderRadius: 5
            },
            {
                type: 'line',
                label: 'Meta esperada (80%)',
                data: metas,
                borderColor: 'red',
                borderWidth: 2,
                tension: 0.3,
                pointRadius: 5
            }
        ]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Cumplimiento del Proveedor'
            }
        },
        scales: {
            y: { beginAtZero: true, max: 100 }
        }
    }
});

/* =============================
   GRÁFICA PIE
============================= */
const ctx2 = document.getElementById('pieChart');

new Chart(ctx2, {
    type: 'pie',
    data: {
        labels: labels,
        datasets: [{
            label: 'Distribución del Cumplimiento (%)',
            data: promedios,
            backgroundColor: coloresPorValor,
            borderColor: '#ffffff',
            borderWidth: 2
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Distribución del Cumplimiento por Mes'
            },
            tooltip: {
                callbacks: {
                    label: function (context) {
                        const valor = context.parsed;
                        const estado = valor >= META ? 'Cumple' : 'No cumple';
                        return `${context.label}: ${valor}% ${estado}`;
                    }
                }
            }
        }
    }
});

/* =============================
   GRÁFICA LINE
============================= */
const ctx3 = document.getElementById('lineChart');

new Chart(ctx3, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Cumplimiento general (%)',
            data: promedios,
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4,
            fill: true,
            pointRadius: 6,
            pointBackgroundColor: coloresPorValor,
            pointBorderColor: coloresPorValor
        }]
    },
    options: {
        plugins: {
            title: {
                display: true,
                text: 'Evolución del Cumplimiento Mensual'
            }
        },
        scales: {
            y: { beginAtZero: true, max: 100 },
            x: { title: { display: true, text: 'Meses' } }
        }
    }
});





    </script>
@endsection