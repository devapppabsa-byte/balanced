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



<div class="container-fluid mt-5">
    <div class="row justify-content-center mt-5">
        <div class="col-12 col-sm-12 col-md-10 col-lg-9  mx-5 bg-white rounded border p-5 shadow-sm">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <h2>
                        <i class="fa fa-clipboard-list"></i>
                        Listado de actividades evaluadas
                    </h2>
                </div>
            </div>
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
                                No cuenta con eevaluaciones.
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
                        <canvas id="bubbleChart"></canvas>
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
        const ctx1 = document.getElementById('barLineChart');

        new Chart(ctx1, {
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril'],
            datasets: [
            {
                type: 'bar',
                label: 'Puntuación obtenida',
                data: [75, 85, 65, 90],
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderRadius: 5
            },
            {
                type: 'line',
                label: 'Meta esperada (100%)',
                data: [100, 100, 100, 100],
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
                text: 'Cumplimiento del Proveedor',
                font: { size: 18 }
            }
            },
            scales: {
            y: { beginAtZero: true, max: 100 }
            }
        }
        });





        const ctx2 = document.getElementById('bubbleChart');

        new Chart(ctx2, {
        type: 'bubble',
        data: {
            datasets: [{
            label: 'Cumplimiento del Proveedor',
            data: [
                {x: 10, y: 85, r: 10}, // Trato amable
                {x: 8, y: 90, r: 8},  // Tiempo de atención
                {x: 12, y: 70, r: 12}, // Resolución del problema
                {x: 6, y: 95, r: 6}   // Claridad del vendedor
            ],
            backgroundColor: 'rgba(255, 99, 132, 0.6)',
            borderColor: 'rgba(255, 99, 132, 1)'
            }]
        },
        options: {
            plugins: {
            title: {
                display: true,
                text: 'Cumplimiento del Proveedor',
                font: { size: 18 }
            }
            },
            scales: {
            x: { title: { display: true, text: 'Cantidad de servicios' }, beginAtZero: true },
            y: { title: { display: true, text: 'Satisfacción (%)' }, beginAtZero: true, max: 100 }
            }
        }
        });





        const ctx3 = document.getElementById('lineChart');

        new Chart(ctx3, {
        type: 'line',
        data: {
            labels: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo'],
            datasets: [{
            label: 'Cumplimiento general (%)',
            data: [70, 78, 82, 90, 88],
            borderColor: 'rgba(75, 192, 192, 1)',
            backgroundColor: 'rgba(75, 192, 192, 0.2)',
            tension: 0.4,
            fill: true,
            pointRadius: 5
            }]
        },
        options: {
            plugins: {
            title: {
                display: true,
                text: 'Evolución del Cumplimiento Mensual',
                font: { size: 18 }
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