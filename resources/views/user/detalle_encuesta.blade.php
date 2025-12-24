@extends('plantilla')
@section('title', 'Detalle encuesta')
@section('contenido')


<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center justify-content-start ">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  py-4">
            <h2 class="text-white">
                <i class="fa-regular fa-file-lines"></i>
                {{Auth::user()->departamento->nombre}} - Cumplimiento Normativo
            </h2>
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






<div class="container-fluid mt-3">

    <div class="row justify-content-around">
            <div class="col-12 col-sm-12 col-md-10 col-lg-5 m table-responsive bg-white p-5 rounded shadow-sm">
                <h3 class="text-center">
                    <i class="fa-solid fa-clipboard-question"></i>
                    {{$encuesta->nombre}}
                </h3>
                    @if (!$preguntas->isEmpty())
                        <table class="table border shadow-sm">
                            <thead class="table-primary border">
                                <th scope="col">Pregunta</th>
                                <th scope="col">Cuantificable</th>
                            </thead>
                            <tbody class="">
                    @endif
                                @php
                                    $numero_preguntas_cuantificables = 0;
                                    $total_obtenido = 0;
                                @endphp

                            @forelse ($preguntas as $pregunta)
                                <tr>

                                    <th>{{$pregunta->pregunta}}</th>
                                    @if ($pregunta->cuantificable === 0)
                                        <td>No</td>
                                    @else
                                        <td>Si</td>
                                        @forelse ($pregunta->respuestas as $respuesta)
                                            @php
                                                $numero_preguntas_cuantificables = $numero_preguntas_cuantificables + 1;
                                                $total_obtenido = $total_obtenido + $respuesta->respuesta ;
                                            @endphp
                                        @empty
                                            
                                        @endforelse
                                    @endif
                                </tr>
                            @empty
                                <div class="row justify-content-center border py-5">
                                
                                    <div class="col-12 text-center">
                                        <img src="{{asset('/img/iconos/empty.png')}}" class="img-fluid" alt="">
                                    </div>

                                    <div class="col-12 text-center">
                                        <i class="fa fa-exclamation-circle text-danger"></i>
                                        No cuenta con preguntas, pero las puedes agregar aqui.
                                    </div>
                                    
                                    <div class="col-12 text-center">
                                        <a class="btn btn-secondary btn-sm" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_pregunta">
                                            <i class="fa fa-plus"></i>
                                            Agregar Pregunta
                                        </a>
                                    </div>
                                </div>
                            @endforelse
                        </tbody>
                    </table>
            </div>
            
            <div class="col-12 col-sm-12 col-md-10 col-lg-5 mt-2 table-responsive bg-white p-5 rounded shadow-sm">
                <h3 class="text-center">
                    <i class="fa-solid fa-clipboard-list"></i>
                    Respuestas de los Clientes
                </h3>
                    @if (!$clientes->isEmpty())
                        <table class="table border shadow-sm">
                            <thead class="table-secondary border">
                                <th scope="col">Cliente</th>
                                <th scope="col">Linea</th>
                                <th scope="col">Respuestas</th>
                                
                            </thead>
                            <tbody class="">
                        
                    @endif
                            @forelse ($clientes as $cliente)
                                <tr>
                                        <th>{{$cliente->nombre}}</th>
                                        <td>{{$cliente->linea}}</td>

                                        <td class="form-group shadow-0">
                                            <a class="btn btn-light btn-sm" href="{{route('show.respuestas.usuario', ['cliente' => $cliente->id, 'encuesta' => $encuesta->id])}}">
                                                <i class="fa fa-eye mx-1"></i>
                                                Ver Respuestas
                                            </a>
                                        </td>
                                    

                                </tr>
                            @empty

                            <div class="row justify-content-center py-5 border">
                                <div class="col-12 text-center">
                                    <img src="{{asset('/img/iconos/empty.png')}}" class="img-fluid" alt="">
                                </div>
                                <div class="col-12 text-center">
                                    <i class="fa fa-exclamation-circle text-danger"></i>
                                    Aún no se cuenta con respuestas.
                                </div>
                            </div>

                            @endforelse
                        </tbody>
                    </table>
            </div>
            
    </div>

    <div class="row justify-content-center mt-2 d-flex align-items-center">

        <div class="col-12 col-sm-12 col-md-10 p-3 col-lg-10 mt-2 text-center bg-white border shadow shadow-sm rounded">
            <div class="row justify-content-around">
                <div class="col-12 text-center">
                    <h3>
                        <i class="fa-solid fa-medal"></i>
                        Resultados
                    </h3>
                </div>
                
                <div class="col-auto    border-bottom border-2 p-3">

                    <h5 class="fw-bold">Puntuación Maxima</h5>
                    @if ($numero_preguntas_cuantificables != 0)
                        <h4 class="fw-bold" id="puntuacion_maxima">
                            {{$numero_preguntas_cuantificables * 10}}
                        </h4>
                    @else
                        <h6>
                            <i class="fa fa-exclamation-circle text-danger"></i>
                            No hay respuestas resgistradas.
                        </h6>         
                    @endif
                        
                </div>
                
                <div class="col-auto   border-bottom border-2 p-3">
                    <h5 class="fw-bold">Puntuación Obtenida </h5>

                    @if ($total_obtenido !== null )
                        <h4 class="fw-bold" id="puntuacion_maxima">
                            {{$total_obtenido}}
                        </h4>
                    @else
                        <h6>
                            <i class="fa fa-exclamation-circle text-danger"></i>
                            No hay respuestas resgistradas.
                        </h6>         
                    @endif
                
                </div>

                <div class="col-auto   border-bottom border-2 p-3">
                    <h5 class="fw-bold">% Cumplimiento</h5>

                    @if ($total_obtenido !== null)
                        <h4 class="fw-bold" id="puntuacion_maxima">
                            @if ($total_obtenido>0)
                                {{round((( $total_obtenido) /($numero_preguntas_cuantificables * 10)) * 100, 3)}}
                            @else
                                0
                            @endif
                        </h4>
                    @else
                        <h6>
                            <i class="fa fa-exclamation-circle text-danger"></i>
                            No hay respuestas resgistradas.
                        </h6>         
                    @endif
                   
                </div>

            </div>
        </div>
    </div>

</div>



<div class="modal fade" id="encuesta_contestada" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header bg-danger py-4">
        <h3 class="text-white" id="exampleModalLabel">La encuesta ya tiene respuestas.</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">

            <div class="row justify-content-center">

                <div class="col-12 col-sm-12 col-md-12 col-lg-10 text-center mt-3">
                    <i class="fa fa-exclamation-circle fa-4x text-danger"></i>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-10 text-justify  text-justify mt-3">
                    <p class="">La encuesta ya fue respondida por lo que para mantener la integridad de los datos no se puede modificar la encuesta.</p>
                </div>

            </div>
        </div>
    </div>
  </div>
</div>



<div class="modal fade" id="grafico" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-xl modal-fullscreen-sm-down">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Gráfica</h5>
        <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <div class="col-12" >
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
                            Grafico de Pie
                        </a>
                    </li>
                </ul>
                <!-- Tabs navs -->

                <!-- Tabs content -->
                <div class="tab-content" id="ex2-content">
                    <div class="tab-pane  show active" id="ex3-tabs-1" role="tabpanel" aria-labelledby="ex3-tab-1" >
                        <canvas id="chartBarras"></canvas>
                    </div>
                    <div class="tab-pane  p-5" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                        <canvas id="chartLinea"></canvas>
                    </div>
                    <div class="tab-pane " id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                        <canvas id="chartPie"></canvas>
                    </div>
                </div>
                <!-- Tabs content -->

            </div>
        </div>
    </div>
  </div>
</div>






{{--Aqui van a estar los ciclos que me generalk los modales--}}

@forelse ($preguntas as $pregunta)

    <div class="modal fade" id="elim{{$pregunta->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header bg-danger py-4">
                <h3 class="text-white" id="exampleModalLabel">¿Eliminar la pregunta {{$pregunta->pregunta}} ?</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{route('pregunta.delete', $pregunta->id)}}" method="POST">
                    @csrf @method('DELETE')
                    <button  class="btn btn-danger w-100 py-3" data-mdb-ripple-init>
                        <h6>Eliminar</h6>
                    </button>
                </form>
            </div>
            {{-- <div class="modal-footer">
            </div> --}}
            </div>
        </div>
    </div>   

@empty
    
@endforelse







<div class="modal fade" id="agregar_pregunta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Agregar Pregunta</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('pregunta.store', $encuesta->id)}}" method="post">
            @csrf
            <div class="row justify-content-center">
                <div class="col-12 text-center">

                    <div class="form-group mt-2">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('pregunta') ? 'is-invalid' : '' }} " id="pregunta" name="pregunta" required>
                            <label class="form-label" for="pregunta" >Escribe tu pregunta</label>
                        </div>
                    </div>

                    <div class="form-check mt-3 text-start">
                        <label for="cuantificable">Es cuantificable</label>
                        <input type="checkbox" name="cuantificable"  class="form-check-input" id="cuantificable">
                    </div>

                </div>

                <div class="col-12 text-justify  bg-light mt-3">
                    <small class="m-2">
                        <i class="fa fa-exclamation-circle mx-1"></i>
                        Recuerda que las preguntas de las encuestas para los clientes se evaluaran con: <b>un calificación del 1 al 10.</b>
                        Por lo que se deben poner preguntas que se puedan contestar.
                    </small>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button  class="btn btn-primary w-100 py-3" data-mdb-ripple-init>
                <h6>Guardar</h6>
            </button>
        </form>

      </div>
    </div>
  </div>
</div>



@endsection

















@section('scripts')

<script>
const etiquetas = @json($labels);
const valores   = @json($valores);

const minimo = 5;

const colores = valores.map(v =>
    v < minimo ? '#e74c3c' : '#2ecc71'
);

const ctx = document.getElementById('chartBarras').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: etiquetas,
        datasets: [{
            label: 'Puntuación promedio por cliente',
            data: valores,
            backgroundColor: colores,
            borderColor: '#2c3e50',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Resultados de la encuesta por cliente'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 10,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>













<script>




const coloresPuntos = valores.map(v =>
    v < minimo ? '#e74c3c' : '#2ecc71'
);

const ctxlinea = document.getElementById('chartLinea').getContext('2d');

new Chart(ctxlinea, {
    type: 'line',
    data: {
        labels: etiquetas,
        datasets: [{
            label: 'Puntuación promedio por cliente',
            data: valores,
            borderColor: '#2980b9',
            backgroundColor: 'rgba(52, 152, 219, 0.15)',
            fill: true,
            tension: 0.3,
            pointBackgroundColor: coloresPuntos,
            pointBorderColor: '#2c3e50',
            pointRadius: 6,
            pointHoverRadius: 8
        }]
    },
    options: {
        responsive: true,
        plugins: {
            title: {
                display: true,
                text: 'Resultados de la encuesta por cliente'
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                max: 10,
                ticks: {
                    stepSize: 1
                }
            }
        }
    }
});
</script>

<script>
    // Colores automáticos (uno por cliente)
    const coloresPie = etiquetas.map((_, i) => {
        const paleta = [
            '#3498db', '#2ecc71', '#e74c3c', '#f1c40f',
            '#9b59b6', '#1abc9c', '#e67e22', '#34495e'
        ];
        return paleta[i % paleta.length];
    });

    const ctxPie = document.getElementById('chartPie').getContext('2d');

    new Chart(ctxPie, {
        type: 'doughnut',
        data: {
            labels: etiquetas,
            datasets: [{
                label: 'Puntuación por cliente',
                data: valores,
                backgroundColor: coloresPie,
                borderColor: '#ffffff',
                borderWidth: 2
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: {
                    display: true,
                    text: 'Distribución de puntuación por cliente'
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const valor = context.parsed;
                            const porcentaje = ((valor / total) * 100).toFixed(1);
                            return `${context.label}: ${valor} (${porcentaje}%)`;
                        }
                    }
                }
            }
        }
    });
</script>


 





@endsection