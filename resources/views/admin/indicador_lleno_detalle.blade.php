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


<div class="container-fluid sticky-top">

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



        <div class="card border-0 shadow-sm mb-2">
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



    <div class=" card row justify-content-center pb-5 m border-bottom d-flex align-items-center mt-4">
        <div  class="col-11 mx-2 px-5 py-3 pb-5">
            
            <div class="row justify-content-center">
                                
                @forelse($grupos as $movimiento => $items)
                    @php
                        //para obtener las metas minimas y maximas desde la otra tabla
                        $metas = MetaIndicador::where('id_movimiento_indicador_lleno',  $items[0]->id_movimiento)->first();

                        $meta_minima = $metas->meta_minima;
                        $meta_maxima = $metas->meta_maxima;

                    @endphp

                <div class="col-10 col-sm-8 col-md-5 col-lg-3 shadow-sm mx-4 border rounded mt-4">

                    @php
                        //para sacar fecha y año
                        $fecha = Carbon::parse(explode('-', $movimiento)[0]);
                        Carbon::setLocale('es');
                        $mes = $fecha->subMonth()->translatedformat('F');
                        $year = $fecha->format('Y');
                   
                   @endphp

                    <div class="row justify-content-center">
                        
                        <div class="col-12 bg-info text-white pt-3 pb-2 mb-1 rounded">
                            <h3 class="text-center fw-bold">
                                <i class="fa-solid fa-calendar-days"></i> {{ $mes.' - '.$year }}
                            </h3>
                        </div>

                        <div class="col-12 text-center   p-2 my-2 rounded">
                            <div class="row justify-contente-center">
                                <div class="col-6 text-center ">
                                    <div class="badge badge-danger p-2">
                                        <i class="fa-solid fa-circle-arrow-down text-danger"></i>                                    
                                        <span>Minima:   {{$meta_minima}} </span>
                                    </div>
                                
                                </div>
                                <div class="col-6 text-center">
                                    <div class="badge badge-success p-2">
                                        <i class="fa-solid fa-circle-arrow-up text-success"></i>                                    
                                        <span>Maxima:   {{$meta_maxima}} </span>
                                    </div>
                                </div>
                            </div>
                            
                        </div>

                        <hr>
                        
                        
                        @foreach($items as $item)
                        {{-- Se hace la consulta de la informaion del indiacor lleno, y se hace la condicional  para saber si esta el campo final --}}
                        @if ($item->final === "on")
                            <div class="col-8  fw-bold  rounded-5 border zoom_link {{($meta_minima > $item['informacion_campo']) ? 'border-danger' : 'border-success' }} bg-light mb-3 py-2 mt-3 border-2">
                                
                                
                                <h5 class="text-center ">
                                    <i class="fa {{($meta_minima > $item['informacion_campo']) ? 'fa-xmark-circle text-danger' : 'fa-check-circle text-success' }}"></i>
                                    {{ $item['nombre_campo'] }}: 
                                </h5> 
                                <h4 class="text-center fw-bold">{{ $item['informacion_campo'] }} </h4>
                            
                            </div>

                        @else

                        @if ($item->final === 'comentario')

                            <button class="btn btn-light btn-sm" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#com{{$item->id}}">
                                <i class="fa fa-comment"></i>
                                Comentario
                            </button>
                            {{-- jajajaja vete alv, voy a tener que poner el modal aqui jajaja --}}

                            <div class="modal fade" id="com{{$item['id']}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
                                <div class="modal-dialog  modal-xl">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary py-4">
                                            <h3 class="text-white" id="exampleModalLabel">{{$indicador->nombre}}</h3>
                                            <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Cloeesdasdse"></button>
                                        </div>
                                        <div class="modal-body py-4 bg-light">
                                            <div class="col-12  mx-2 bg-white shadow-sm p-3 mt-4" >
                                                <b class="h3">Comentario: </b>
                                                <p class="h5 mt-2">
                                                    {{$item['informacion_campo']}} 
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        @else

                            @if ($item->final === 'registro')
                            
                                <div class="col-11 p-3 mb-3 bg-light border  rounded ">
                                    <small class="fw-bold">{{ $item['nombre_campo'] }}: </small> <br>
                                    <small class="text-center"> <b>{{ $item['informacion_campo'] }} </b>- {{ $item['created_at'] }} </small> 
                                
                                    <br>                
                                </div>

                            @else

                                <div class="col-11">
                                    <span class="fw-bold">{{ $item['nombre_campo'] }}: </span> <br>
                                    <span class="fw-bold ">{{ $item['informacion_campo'] }}</span> <br>                
                                </div>
                                
                            @endif
                            

                        @endif
                        @endif


                        @endforeach
                        
                    </div>
                </div>
                

                @empty


                <div class="">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fa-regular fa-newspaper text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                        <h5 class="text-muted mb-2">No se encontraron indicadores.</h5>
                    </div>
                </div>



                @endforelse

            </div>
        </div>

    </div>
</div>



<div class="modal fade" id="grafico_indicador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog  modal-xl">
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
<script>

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
    fecha.setMonth(fecha.getMonth() -1)
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
</script>







<script>

const ctxLine = document.getElementById('graficoLine').getContext('2d');

new Chart(ctxLine, {
  type: "line",
  data: {
    labels: labels,
    datasets: [

      {
        label: "Cumplimiento del Indicador",
        data: valores,
        borderColor: "#3b82f6",
        borderWidth: 3,
        tension: 0.3,
        fill: false,
        pointRadius: 6,
        pointBackgroundColor: valores.map(v =>
          v < MINIMO ? "red" : "green"
        ),
        pointBorderColor: "#000"
      },

      // ➖ Línea nivel mínimo
      {
        label: "Nivel mínimo",
        data: valores.map(() => MINIMO),
        borderColor: "red",
        borderWidth: 2,
        borderDash: [5, 5],
        pointRadius: 0,
        fill: false
      },

      // ➕ Línea nivel máximo
      {
        label: "Nivel máximo",
        data: valores.map(() => MAXIMO),
        borderColor: "green",
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

// Colores dinámicos por segmento
const colores = valores.map(v =>
  v < MINIMO
    ? "rgba(255, 99, 132, 0.7)" // rojo
    : "rgba(75, 192, 75, 0.7)" // verde
);

const bordes = valores.map(v =>
  v < MINIMO ? "red" : "green"
);

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
            const estado = valor < MINIMO ? " No cumple" : " Cumple";
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