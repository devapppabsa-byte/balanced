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




<div class=" row justify-content-center pb-5 m border-bottom d-flex align-items-center mt-1">
        <div  class="col-12 mx-2 px-5 py-3 pb-5">
            
<div class="row">

@forelse($grupos as $movimiento => $items)

@php
    $metas = MetaIndicador::where(
        'id_movimiento_indicador_lleno',
        $items->first()->id_movimiento
    )->first();

    $meta_minima = $metas->meta_minima ?? 0;
    $meta_maxima = $metas->meta_maxima ?? 0;

    Carbon::setLocale('es');
    $fecha = $items[0]->created_at->copy()->subMonth();

    $mes  = ucfirst($fecha->translatedFormat('F'));
    $year = $fecha->translatedFormat('Y');
@endphp

<div class="col-12 col-lg-4 mt-3">
    <div class="card shadow-sm border-0 h-100">

        <!-- HEADER -->
        <div class="card-header bg-info text-white text-center py-2">
            <h6 class="fw-semibold mb-0">
                <i class="fa-solid fa-calendar-days me-1"></i>
                {{ $mes }} {{ $year }}
            </h6>
        </div>

        <div class="card-body py-3">

            <!-- METAS -->
                @if ($indicador->tipo_indicador == "riesgo")

                    @if ($indicador->variacion == "on")

                        <div class="row p-0">
                            <div class="col-6">
                                <span class="badge bg-success-subtle text-success p-2 w-100">
                                    <i class="fa-solid fa-arrow-up"></i>
                                    Variación:  {{ $meta_minima }}
                                </span>
                            </div>
                            <div class="col-6">
                                <span class="badge bg-danger-subtle text-danger p-2 w-100">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Meta:  {{ $meta_maxima }}
                                </span>
                            </div>
                        </div>   

                    @else
                        
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
                    @endif

                    
                @else


                    @if ($indicador->variacion == "on")

                        <div class="row p-0">
                            <div class="col-6">
                                <span class="badge bg-success-subtle text-success p-2 w-100">
                                    <i class="fa-solid fa-arrow-up"></i>
                                    Variación:  {{ $meta_minima }}
                                </span>
                            </div>
                            <div class="col-6">
                                <span class="badge bg-danger-subtle text-danger p-2 w-100">
                                    <i class="fa-solid fa-triangle-exclamation"></i>
                                    Meta:  {{ $meta_maxima }}
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



                @endif

            <hr class="my-2">

            <!-- ITEMS -->
            <div class="row g-2 justify-content-center">

            @foreach($items as $item)

                <!-- RESULTADO FINAL -->
                @if($item->final === 'on')

                    @php 

                        if($indicador->variacion === "on"){


                    
                            if ($meta_minima == 0 && $meta_maxima == 0) {
                                $cumple = true; //aqui se cambia el sentido de este pequeño algoritmo.
                            } else {
                                $min = $meta_maxima - $meta_minima;
                                $max = $meta_maxima + $meta_minima;

                                $cumple = $item->informacion_campo >= $min 
                                    && $item->informacion_campo <= $max;
                            }




                        }
                        else{

                            $cumple = $item->informacion_campo >= $meta_minima; 
                        
                        }
                    @endphp




                    @if ($indicador->tipo_indicador == "riesgo")

                        <div class=" col-8 bg-  dark border border-2 rounded text-center py-3 my-4
                            {{ $cumple ? 'border-danger' : 'border-success' }}">
                            
                            <h6 class="fw-bold mb-1">
                                <i class="fa-solid {{ $cumple ? 'fa-circle-xmark text-danger' : 'fa-circle-check text-success' }}"></i>
                                {{ $item->nombre_campo }}
                            </h6>

                            <h4 class="fw-bold mb-0 ">
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

                <!-- COMENTARIO -->
                @if($item->final === 'comentario')
                    <div class="col-12">
                        <button class="btn btn-outline-secondary btn-sm py-1 px-2"
                                data-mdb-modal-init
                                data-mdb-target="#com{{ $item->id }}">
                            <i class="fa fa-table"></i> Información Extra
                        </button>
                    </div>

                    <div class="modal fade" id="com{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white ">
                                    <h4 class="modal-title">{{ $indicador->nombre }}</h4>
                                    <button class="btn-close" data-mdb-dismiss="modal"></button>
                                </div>
                                <div class="modal-body small ck-content table-responsive">
                                   <h4> {!!  $item->informacion_campo !!} </h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- REGISTRO -->
                @if($item->final === 'registro')
                    <div class="col-12">
                        <div class="bg-light border rounded p-2 small">
                            <div class="fw-semibold">{{ $item->nombre_campo }}</div>
                            <div class="text-muted">
                                {{ $item->informacion_campo }} ·
                                {{ $item->created_at->translatedFormat('d M Y H:i') }}
                            </div>
                        </div>
                    </div>
                @endif

                <!-- NORMAL -->
                @if(is_null($item->final))
                    <div class="col-6">
                        <div class="border rounded p-2 small">
                            <span class="text-muted">{{ $item->nombre_campo }}</span>
                            <div class="fw-bold format-number">
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
<div class="col-12 text-center text-muted py-5 bg-white h2">
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
            <div class="modal-body  row justify-content-center" >

                <div class="col-12 py-2">
                    <div class="row justify-content-center">
                        <div class="col-auto text-white bg-success rounded-3 my-3 mx-2">
                            <h4 class="mt-2">
                                <i class="fa fa-check-circle"></i>
                                Meta: {{ $indicador->meta_esperada }}
                            </h4>
                        </div>

                        @if ($indicador->variacion === "on")
                            <div class="col-auto text-white bg-danger rounded-3 my-3 mx-2">
                                <h4 class="mt-2">
                                    <i class="fa-solid fa-arrow-trend-down"></i>
                                    Variación:{{ $indicador->meta_minima }} </h4>
                            </div>
                            
                        @else
                            <div class="col-auto text-white bg-danger rounded-3 my-3 mx-2">
                                <h4 class="mt-2">
                                    <i class="fa-solid fa-arrow-trend-down"></i>
                                    Minimo:{{ $indicador->meta_minima }} </h4>
                            </div>
                        @endif

                    </div>
                </div>



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
                                <div class="col-12  chart-container w-100" >
                                    <canvas class="" id="grafico"></canvas>
                                </div>
                            </div>
                            <div class="tab-pane  p-5" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">

                            <div class="row justify-content-center">
                                    <div class="col-12 text-center chart-container w-100" >
                                        <canvas id="graficoPie"></canvas>
                                    </div>
                            </div>

                            </div>
                            <div class="tab-pane " id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                                <div class="col-12 text-center chart-container w-100" >
                                    <canvas id="graficoLine"></canvas>

                                </div>
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

<script>
document.addEventListener("DOMContentLoaded", function () {

    const datos = @json($graficar);
    const TIPO_INDICADOR = "{{ $tipo_indicador }}";

    const mesesES = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    // ============================
    // FILTRAR DATOS
    // ============================

    const datosFinal = datos.filter(d => d.final === "on");
    const datosReferencia = datos.filter(d => d.referencia === "on");

    // ============================
    // LABELS (MESES)
    // ============================

    const labels = [...new Set(
        [...datosFinal, ...datosReferencia].map(item => {
            const fecha = new Date(item.created_at);
            return mesesES[fecha.getMonth() - 1];
        })
    )];

    // ============================
    // METAS + VARIACIÓN
    // ============================

    const VARIACION_ON = "{{ $indicador->variacion }}" === "on";

    const META_MINIMA = {{ $indicador->meta_minima }};
    const META_ESPERADA = {{ $indicador->meta_esperada }};

    // Si variación está activa, meta_minima se usa como variación
    const VARIACION = VARIACION_ON ? META_MINIMA : null;

    // Límites calculados solo si variación está activa
    const LIMITE_INFERIOR = VARIACION_ON ? META_ESPERADA - VARIACION : null;
    const LIMITE_SUPERIOR = VARIACION_ON ? META_ESPERADA + VARIACION : null;

    // Colores
    const colorMetaMinima = "red";
    const colorMetaMaxima = "green";
    const colorVariacion = "red";

    // ============================
    // DATASET FINAL (BARRAS)
    // ============================

    const datasetFinal = {
        type: "bar",
        label: datosFinal.length > 0
            ? datosFinal[0].nombre_campo
            : "Cumplimiento",

        data: labels.map(mes => {
            const item = datosFinal.find(d => {
                const fecha = new Date(d.created_at);
                return mesesES[fecha.getMonth() - 1] === mes;
            });
            return item ? parseFloat(item.informacion_campo) : null;
        }),

        backgroundColor: ctx => {
            const value = ctx.raw;
            if (value === null) return "rgba(200,200,200,0.3)";

            // ============================
            // SI VARIACIÓN ESTÁ ACTIVA
            // ============================
            if (VARIACION_ON) {
                // ❌ Fuera del rango → ROJO
                if (value < LIMITE_INFERIOR || value > LIMITE_SUPERIOR) {
                    return "rgba(255,99,132,0.8)";
                }
                // ✅ Dentro del rango → VERDE
                return "rgba(75,192,75,0.8)";
            }

            // ============================
            // SI NO HAY VARIACIÓN (NORMAL)
            // ============================
            if (TIPO_INDICADOR === "riesgo") {
                return value < META_MINIMA
                    ? "rgba(75,192,75,0.8)"
                    : "rgba(255,99,132,0.8)";
            }

            return value < META_MINIMA
                ? "rgba(255,99,132,0.8)"
                : "rgba(75,192,75,0.8)";
        },

        borderWidth: 1,
        order: 1
    };

    // ============================
    // REFERENCIAS (LINEAS RELLENAS)
    // ============================

    const referenciasAgrupadas = {};

    datosReferencia.forEach(item => {
        const fecha = new Date(item.created_at);
        const mes = mesesES[fecha.getMonth() - 1];

        if (!referenciasAgrupadas[item.nombre_campo]) {
            referenciasAgrupadas[item.nombre_campo] = {};
        }

        referenciasAgrupadas[item.nombre_campo][mes] =
            parseFloat(item.informacion_campo);
    });

    const datasetsReferencias = Object.keys(referenciasAgrupadas).map((nombre, index) => {
        return {
            type: "line",
            label: nombre,
            data: labels.map(mes =>
                referenciasAgrupadas[nombre][mes] ?? null
            ),
            borderWidth: 3,
            tension: 0.3,
            fill: true,
            borderColor: `rgba(${50 + index * 60}, 120, 255, 1)`,
            backgroundColor: `rgba(${50 + index * 60}, 120, 255, 0.2)`,
            spanGaps: true,
            order: 9
        };
    });

    // ============================
    // CANVAS
    // ============================

    const canvas = document.getElementById("grafico");
    if (!canvas) return;

    // ============================
    // CHART
    // ============================

    new Chart(canvas.getContext("2d"), {

        data: {
            labels,
            datasets: [
                datasetFinal,
                ...datasetsReferencias,

                // ============================
                // METAS DINÁMICAS
                // ============================
                ...(VARIACION_ON ? [

                    // Meta esperada
                    {
                        type: "line",
                        label: "Meta esperada",
                        data: labels.map(() => META_ESPERADA),
                        borderColor: colorMetaMaxima,
                        borderWidth: 3,
                        order: 9
                    },

                    // Variación inferior
                    {
                        type: "line",
                        label: "Variación inferior",
                        data: labels.map(() => LIMITE_INFERIOR),
                        borderColor: colorVariacion,
                        borderWidth: 2,
                        borderDash: [6, 6],
                        order: 9
                    },

                    // Variación superior
                    {
                        type: "line",
                        label: "Variación superior",
                        data: labels.map(() => LIMITE_SUPERIOR),
                        borderColor: colorVariacion,
                        borderWidth: 2,
                        borderDash: [6, 6],
                        order: 9
                    }

                ] : [

                    // Meta mínima
                    {
                        type: "line",
                        label: "Meta mínima",
                        data: labels.map(() => META_MINIMA),
                        borderColor: colorMetaMinima,
                        borderWidth: 2,
                        borderDash: [6, 6],
                        order: 9
                    },

                    // Meta máxima
                    {
                        type: "line",
                        label: "Meta máxima",
                        data: labels.map(() => META_ESPERADA),
                        borderColor: colorMetaMaxima,
                        borderWidth: 3,
                        order: 0
                    }

                ])
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

});


</script>





{{-- los otros graficos  --}}

<script>
document.addEventListener("DOMContentLoaded", function () {

    const datos = @json($graficar);
    const TIPO_INDICADOR = "{{ $tipo_indicador }}";

    const mesesES = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    if (!datos || datos.length === 0) return;

    // ============================
    // FILTRAR DATOS
    // ============================

    const datosFinal = datos.filter(d => d.final === "on");
    const datosReferencia = datos.filter(d => d.referencia === "on");

    // ============================
    // LABELS (MESES)
    // ============================

    const labels = [...new Set(
        [...datosFinal, ...datosReferencia].map(item => {
            const fecha = new Date(item.created_at);
            return mesesES[fecha.getMonth()-1]; // 🔥 
        })
    )];

    // ============================
    // METAS + VARIACIÓN
    // ============================

    const VARIACION_ON = "{{ $indicador->variacion }}" === "on";

    const META_MINIMA = {{ $indicador->meta_minima ?? 0 }};
    const META_ESPERADA = {{ $indicador->meta_esperada ?? 0 }};

    const VARIACION = VARIACION_ON ? META_MINIMA : null;

    const LIMITE_INFERIOR = VARIACION_ON ? META_ESPERADA - VARIACION : null;
    const LIMITE_SUPERIOR = VARIACION_ON ? META_ESPERADA + VARIACION : null;

    // ============================
    // DATA FINAL (BARRAS BASE)
    // ============================

    const dataValores = labels.map(mes => {
        const item = datosFinal.find(d => {
            const fecha = new Date(d.created_at);
            return mesesES[fecha.getMonth()-1] === mes;
        });
        return item ? parseFloat(item.informacion_campo) : null;
    });

    const nombreCampo = datosFinal.length > 0
        ? datosFinal[0].nombre_campo
        : "Indicador";

    // ============================
    // FUNCIÓN GLOBAL DE COLOR
    // ============================

    function obtenerColor(valor) {

        if (valor === null) return "rgba(200,200,200,0.3)";

        // 🔴🟢 CON VARIACIÓN
        if (VARIACION_ON) {
            if (valor < LIMITE_INFERIOR || valor > LIMITE_SUPERIOR) {
                return "rgba(255,99,132,0.8)";
            }
            return "rgba(75,192,75,0.8)";
        }

        // 🔄 INDICADOR DE RIESGO (invertido)
        if (TIPO_INDICADOR === "riesgo") {
            return valor < META_MINIMA
                ? "rgba(75,192,75,0.8)"
                : "rgba(255,99,132,0.8)";
        }

        // 📊 NORMAL
        return valor < META_MINIMA
            ? "rgba(255,99,132,0.8)"
            : "rgba(75,192,75,0.8)";
    }

    // ============================
    // 📈 GRÁFICA DE LÍNEA
    // ============================

    const ctxLine = document.getElementById("graficoLine");
    if (ctxLine) {
        new Chart(ctxLine.getContext("2d"), {
            type: "line",
            data: {
                labels: labels,
                datasets: [{
                    label: nombreCampo,
                    data: dataValores,
                    borderColor: "rgba(54,162,235,1)",
                    backgroundColor: "rgba(54,162,235,0.1)",
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: ctx => obtenerColor(ctx.raw),
                    pointRadius: 6
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });
    }

    // ============================
    // 🥧 GRÁFICA DOUGHNUT
    // ============================

    const ctxPie = document.getElementById("graficoPie");
    if (ctxPie) {
        new Chart(ctxPie.getContext("2d"), {
            type: "doughnut",
            data: {
                labels: labels,
                datasets: [{
                    label: nombreCampo,
                    data: dataValores,
                    backgroundColor: dataValores.map(v => obtenerColor(v)),
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: "bottom"
                    }
                }
            }
        });
    }

});
</script>












{{--  --}}




@endsection