@extends('plantilla')
@section('title', 'Detalle del Indicador')
@section('contenido')
@php
    use Carbon\Carbon;
    use App\Models\InformacionInputPrecargado;
    use App\Models\MetaIndicador;
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


<div class="container-fluid sticky-top ">

    <div class="row bg-primary d-flex align-items-center justify-content-start">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10 pt-2">
            <h3 class="text-white league-spartan">Detalle del  indicador:  {{$indicador->nombre}}</h3>

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
                    <i class="fa-solid fa-file-excel"></i>
                    Información cargada desde Excel.
                </a>
            </div>
            <div id="info_precargada" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-mdb-parent="#accordionExample">
                <div class="accordion-body">
                    <div class="row gap-4  justify-content-start d-flex align-items-center">


                        @forelse ($campos_llenos as $campo_lleno)
                            <div class="col-5 col-sm-5 col-md-5 col-lg-auto  text-center  bg-white   pt-2 rounded shadow-sm">
                                <h5 class="fw-bold">{{$campo_lleno->nombre}}</h5>


                                <h5  class="">
                                    @php
                                        $last_info = InformacionInputPrecargado::where('id_input_precargado', $campo_lleno->id)->latest()->first();
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


<div class="container-fluid">

            <div class="card border-0 shadow-sm mb-2 mt-3">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h2 class="mb-1 fw-bold">
                                <i class="fa-regular fa-simple-chart text-primary me-2"></i>
                                Historico del llenado del indicador 
                            </h2>
                        </div>
                        <div class="d-flex gap-2 mt-2 mt-md-0">
                            <button class="btn btn-info text-white" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#grafico_indicador">
                                <i class="fa-solid fa-chart-line me-2"></i>
                                Ver Gráficas
                            </button>
                        </div>
                    </div>
                </div>
            </div>



        <div class="card border-0 shadow-sm mb-2 ">
            <div class="card-body">
                <form action="{{route('indicador.lleno.show.admin', $indicador->id)}}"  method="GET">
                    <div class="row g-3 align-items-end">
                        <div class="col-12 col-md-4">
                            <label for="fecha_inicio" class="form-label fw-semibold small text-muted text-uppercase">Fecha Inicio</label>
                            <input type="date"
                                    name="fecha_inicio"
                                    value="{{request('fecha_inicio')}}"
                                    class="form-control datepicker"
                                    id="fecha_inicio">
                        </div>
                        <div class="col-12 col-md-4">
                            <label for="fecha_fin" class="form-label fw-semibold small text-muted text-uppercase">Fecha Final</label>
                            <input type="date"
                                    name="fecha_fin"
                                    value="{{request('fecha_fin')}}"
                                    class="form-control datepicker"
                                    id="fecha_fin">
                        </div>
                        <div class="col-12 col-md-4">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="fa-solid fa-filter me-2"></i>
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

</form>


<div class=" row justify-content-center pb-5 m border-bottom d-flex align-items-center mt-4">
        <div  class="col-11 mx-2 px-5 py-3 pb-5">
            
<div class="row justify-content-center">
                                
@forelse($grupos as $movimiento => $items)

    @php
        // Metas
        $metas = MetaIndicador::where(
            'id_movimiento_indicador_lleno',
            $items->first()->id_movimiento
        )->first();

        $meta_minima = $metas->meta_minima ?? 0;
        $meta_maxima = $metas->meta_maxima ?? 0;

        // Fecha
        Carbon::setLocale('es');
        $fecha = Carbon::parse(explode('-', $movimiento)[0])->subMonth();
        //$mes   = ucfirst($fecha->translatedFormat('F'));
    
        $mes = ucfirst($items[0]->created_at->translatedFormat('F'));
        $year  = ucfirst($items[0]->created_at->translatedFormat('Y'));

    @endphp



    <div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6 mt-4 ">
        <div class="card shadow-sm border-0 h-100">

            {{-- HEADER --}}
            <div class="card-header bg-info text-white text-center py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fa-solid fa-calendar-days me-1"></i>
                    {{ $mes }} - {{ $year }}
                </h5>
            </div>

            {{-- METAS --}}
            <div class="card-body text-center py-0">
            
                @if ($indicador->tipo_indicador == "riesgo")
                    <div class="row p-0">
                        <div class="col-6">
                            <span class="badge bg-success-subtle text-success p-2 w-100">
                                <i class="fa-solid fa-arrow-up"></i>
                                Maximo:  {{ $meta_minima }}
                            </span>
                        </div>
                        <div class="col-6">
                            <span class="badge bg-danger-subtle text-danger p-2 w-100">
                                <i class="fa-solid fa-triangle-exclamation"></i>
                                Exceso:  {{ $meta_maxima }}
                            </span>
                        </div>
                    </div>
                    
                @else
                    
                    <div class="row p-0">
                        <div class="col-6">
                            <span class="badge bg-danger-subtle text-danger p-2 w-100">
                                <i class="fa-solid fa-arrow-down"></i>
                                Mínima: {{ $meta_minima }}
                            </span>
                        </div>
                        <div class="col-6">
                            <span class="badge bg-success-subtle text-success p-2 w-100">
                                <i class="fa-solid fa-arrow-up"></i>
                                Máxima: {{ $meta_maxima }}
                            </span>
                        </div>
                    </div>

                @endif


                <hr>

                {{-- ITEMS --}}
                <div class="row justify-content-center indicador-container">

             
                @foreach($items as $item)

                    {{-- RESULTADO FINAL --}}
                    @if($item->final === 'on')
                        @php
                            $cumple = $item->informacion_campo >= $meta_minima;
                        @endphp

                        @if ($indicador->tipo_indicador == "riesgo")
                        
                            <div class=" col-8 bg-  dark border border-2 rounded text-center py-3 my-4
                                {{ $cumple ? 'border-danger' : 'border-success' }}">
                                
                                <h6 class="fw-bold mb-1">
                                    <i class="fa-solid {{ $cumple ? 'fa-circle-xmark text-danger' : 'fa-circle-check text-success' }}"></i>
                                    {{ $item->nombre_campo }}
                                </h6>

                                <h4 class="fw-bold mb-0">
                                    {{ $item->informacion_campo }}
                                </h4>

                            </div>    

                        @else
                        
                            <div class=" col-8 bg-  dark border border-2 rounded text-center py-3 my-4
                                {{ $cumple ? 'border-success' : 'border-danger' }}">
                                
                                <h6 class="fw-bold mb-1">
                                    <i class="fa-solid {{ $cumple ? 'fa-circle-check text-success' : 'fa-circle-xmark text-danger' }}"></i>
                                    {{ $item->nombre_campo }}
                                </h6>

                                <h4 class="fw-bold mb-0">
                                    {{ $item->informacion_campo }}
                                </h4>

                            </div>
                        @endif






                    @endif

                    {{-- COMENTARIO --}}
                    @if($item->final === 'comentario')
                        <button class="btn btn-outline-secondary btn-sm mb-2"
                                data-mdb-modal-init
                                data-mdb-target="#com{{ $item->id }}">
                            <i class="fa fa-comment"></i> Comentario
                        </button>

                        <div class="modal fade" id="com{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header bg-primary text-white">
                                        <h5 class="modal-title">{{ $indicador->nombre }}</h5>
                                        <button class="btn-close" data-mdb-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p class="fs-5">{{ $item->informacion_campo }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    {{-- REGISTRO --}}
                    @if($item->final === 'registro')
                        <div class="bg-light border rounded p-2 mb-2 text-start">
                            <small class="fw-bold">{{ $item->nombre_campo }}</small><br>
                            <small>
                                <b>{{ $item->informacion_campo }}</b> —
                                {{ $item->created_at->translatedFormat('d F Y') }}
                                {{ $item->created_at->format('H:i') }}
                            </small>
                        </div>
                    @endif


                    {{-- NORMAL --}}
                    @if(is_null($item->final))
                        <div class="col-6  text-start  p-2 my-2 border">
                            <div class=" ">
                                <small class="">{{ $item->nombre_campo }}</small>
                                <br>
                                <div class="badge badge-secondary format-number fw-bold border shadow-sm fs-6">                                  
                                    {{ $item->informacion_campo }}
                                </div>
                            </div>
                        </div>
                    @endif

                @endforeach


                </div>
            </div>
        </div>
    </div>

@empty
    <div class="col-12 text-center text-muted py-5">
        <i class="fa-solid fa-circle-info"></i> Sin información disponible
    </div>
@endforelse


            </div>
        </div>

    </div>
</div>



<div class="modal fade" id="grafico_indicador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog  modal-xl modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary py-4">
                <h3 class="text-white" id="exampleModalLabel">{{$indicador->nombre}}</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Cloeesdasdse"></button>
            </div>
            <div class="modal-body  row juatify-content-center" >



                    <div class="col-12" >
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
                                    Lineas
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
    </div>
</div>







</div>




@endsection





@section('scripts')

{{-- Grafico de Pie --}}
{{-- <script>

// ESTO VIENE DINÁMICO DESDE LARAVEL
const datos = @json($graficar);


// Meses en español
const mesesES = [
  "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
  "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
];

// Labels: sacamos el mes del created_at
const labels = datos.map(item => {
    const fecha = new Date(item.created_at);
    fecha.setMonth(fecha.getMonth())
    return mesesES[fecha.getMonth()];
});

// Valores: costo por tonelada
const valores = datos.map(item => parseFloat(item.informacion_campo));

// Niveles dinámicos (puedes modificar)
const MINIMO = {{$indicador->meta_minima}};
const MAXIMO = {{$indicador->meta_esperada}};

const ctx = document.getElementById('grafico').getContext('2d');

new Chart(ctx, {
  data: {
    labels: labels,
    datasets: [
      {
        type: "bar",
        label: "Cumplimiento del Indicador",
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
</script> --}}
<script>
    const datos = @json($graficar);

    const TIPO_INDICADOR = "{{ $tipo_indicador }}"; // "riesgo" o normal

    const mesesES = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    // FINAL
    const datosFinal = datos.filter(d => d.final === 'on');

    // REFERENCIA
    const datosReferencia = datos.filter(d => d.referencia === 'on');

    // Labels
    const labels = datosFinal.map(item => {
        const fecha = new Date(item.created_at);
        return mesesES[fecha.getMonth()];
    });

    // Valores FINAL
    const valores = datosFinal.map(item =>
        parseFloat(item.informacion_campo)
    );

    // Valores REFERENCIA alineados
    const valoresReferencia = datosFinal.map(finalItem => {
        const ref = datosReferencia.find(r =>
            r.id_movimiento === finalItem.id_movimiento
        );
        return ref ? parseFloat(ref.informacion_campo) : null;
    });

    const MINIMO = {{ $indicador->meta_minima }};
    const MAXIMO = {{ $indicador->meta_esperada }};

    // Colores dinámicos para líneas
    const colorMinimo = TIPO_INDICADOR === 'riesgo' ? "green" : "red";
    const colorMaximo = TIPO_INDICADOR === 'riesgo' ? "red"   : "green";

    const ctx = document.getElementById('grafico').getContext('2d');

    new Chart(ctx, {
        data: {
            labels: labels,
            datasets: [

                // BARRAS
                {
                    type: "bar",
                    label: "Cumplimiento del Indicador",
                    data: valores,
                    backgroundColor: function (context) {
                        const value = context.raw;

                        if (TIPO_INDICADOR === 'riesgo') {
                            return value < MINIMO
                                ? "rgba(75, 192, 75, 0.7)"   // verde = bajo riesgo
                                : "rgba(255, 99, 132, 0.7)"; // rojo = alto riesgo
                        }

                        return value < MINIMO
                            ? "rgba(255, 99, 132, 0.7)"
                            : "rgba(75, 192, 75, 0.7)";
                    },
                    borderColor: function (context) {
                        const value = context.raw;

                        if (TIPO_INDICADOR === 'riesgo') {
                            return value < MINIMO ? "green" : "red";
                        }

                        return value < MINIMO ? "red" : "green";
                    },
                    borderWidth: 1
                },

                //  REFERENCIA
                {
                    type: "line",
                    label: "Referencia",
                    data: valoresReferencia,
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 3,
                    fill: false,
                    tension: 0.3,
                    spanGaps: true,
                    pointRadius: 5
                },

                // verde / rojo NIVEL MÍNIMO
                {
                    type: "line",
                    label: "Nivel mínimo",
                    data: valores.map(() => MINIMO),
                    borderColor: colorMinimo,
                    borderWidth: 2,
                    fill: false,
                    pointRadius: 0
                },

                // rojo / verde NIVEL MÁXIMO
                {
                    type: "line",
                    label: "Nivel máximo",
                    data: valores.map(() => MAXIMO),
                    borderColor: colorMaximo,
                    borderWidth: 2,
                    fill: false,
                    pointRadius: 0
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
const ctxLine = document.getElementById('graficoLine').getContext('2d');


new Chart(ctxLine, {
  type: "line",
  data: {
    labels: labels,
    datasets: [

      //  LÍNEA PRINCIPAL
      {
        label: "Cumplimiento del Indicador",
        data: valores,
        borderColor: "#3b82f6",
        borderWidth: 3,
        tension: 0.3,
        fill: false,
        pointRadius: 6,
        pointBackgroundColor: valores.map(v => {

          //  INDICADOR DE RIESGO (invertido)
          if (TIPO_INDICADOR === 'riesgo') {
            return v < MINIMO ? "green" : "red";
          }

          //  INDICADOR NORMAL
          return v < MINIMO ? "red" : "green";
        }),
        pointBorderColor: "#000"
      },

      //  LÍNEA NIVEL MÍNIMO
      {
        label: "Nivel mínimo",
        data: valores.map(() => MINIMO),
        borderColor: colorMinimo,
        borderWidth: 2,
        borderDash: [5, 5],
        pointRadius: 0,
        fill: false
      },

      //  LÍNEA NIVEL MÁXIMO
      {
        label: "Nivel máximo",
        data: valores.map(() => MAXIMO),
        borderColor: colorMaximo,
        borderWidth: 2,
        borderDash: [5, 5],
        pointRadius: 0,
        fill: false
      }
    ]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: "top"
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







<script>
//const TIPO_INDICADOR = "{{ $tipo_indicador }}"; // "riesgo" o normal

//  Colores dinámicos por segmento
const colores = valores.map(v => {

  //  INDICADOR DE RIESGO (invertido)
  if (TIPO_INDICADOR === 'riesgo') {
    return v < MINIMO
      ? "rgba(75, 192, 75, 0.7)"   // verde = bajo riesgo
      : "rgba(255, 99, 132, 0.7)"; // rojo = alto riesgo
  }

  //  INDICADOR NORMAL
  return v < MINIMO
    ? "rgba(255, 99, 132, 0.7)"   // rojo = no cumple
    : "rgba(75, 192, 75, 0.7)";   // verde = cumple
});

const bordes = valores.map(v => {

  if (TIPO_INDICADOR === 'riesgo') {
    return v < MINIMO ? "green" : "red";
  }

  return v < MINIMO ? "red" : "green";
});

const ctx3 = document.getElementById('graficoPie').getContext('2d');

new Chart(ctx3, {
  type: "pie",
  data: {
    labels: labels,
    datasets: [{
      label: "Cumplimiento del Indicador",
      data: valores,
      backgroundColor: colores,
      borderColor: bordes,
      borderWidth: 1
    }]
  },
  options: {
    responsive: true,
    plugins: {
      legend: {
        position: "right"
      },
      tooltip: {
        callbacks: {
          label: function(context) {
            const valor = context.raw;

            let estado;

            if (TIPO_INDICADOR === 'riesgo') {
              estado = valor < MINIMO ? "Bajo riesgo" : "Alto riesgo";
            } else {
              estado = valor < MINIMO ? "No cumple" : "Cumple";
            }

            return `${context.label}: ${valor} (${estado})`;
          }
        }
      }
    }
  }
});
</script>














{{--  --}}




@endsection