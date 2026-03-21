@extends('plantilla')
@section('title', 'Detalle del Indicador')
@section('contenido')
@php
    use Carbon\Carbon;
    use App\Models\InformacionInputPrecargado;
    use App\Models\MetaIndicador;
@endphp
<div class="container-fluid sticky-top ">

    <div class="row bg-primary d-flex align-items-center justify-content-start">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10 pt-2">
            <h2 class="text-white league-spartan">{{$indicador->nombre}}</h2>

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




<div class="row">
    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-body py-3 px-4">

            <form action="#" method="GET">
                <div class="d-flex flex-wrap align-items-end gap-3">

                    <!-- Fecha inicio -->
                    <div>
                        <label class="form-label small text-muted fw-semibold mb-1">Desde</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-calendar-days text-primary"></i>
                            </span>
                            <input type="date"
                                name="fecha_inicio"
                                value="{{ request('fecha_inicio') ?? now()->format('Y-m-d') }}"
                                class="form-control border-0 bg-light datepicker"
                                onchange="this.form.submit()">
                        </div>
                    </div>

                    <!-- Fecha fin -->
                    <div>
                        <label class="form-label small text-muted fw-semibold mb-1">Hasta</label>
                        <div class="input-group input-group-sm">
                            <span class="input-group-text bg-light border-0">
                                <i class="fa-solid fa-calendar-days text-danger"></i>
                            </span>
                            <input type="date"
                                name="fecha_fin"
                                value="{{ request('fecha_fin') ?? now()->format('Y-m-d') }}"
                                class="form-control border-0 bg-light datepicker"
                                onchange="this.form.submit()">
                        </div>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>


</div>



<div class="container-fluid">

    <div class="row justify-content-center px-2">
        <div class="col-5 ">
            <div class="row">

                <div class="col-12 p-1 bg-white mt-3 p-3">
        <!-- BOTÓN + GRAFICA 1 -->
                    <h5>Barras + Linea</h5>
                    <canvas id="grafico"></canvas>

                </div>

                <div class="col-12 p-1 bg-white mt-3 p-3">
                    <h5>Pie</h5>
                    <canvas id="graficoPie"></canvas>
                </div>

                <div class="col-12 p-1 bg-white mt-3 p-3">
                    <h5>Tendencia</h5>
                    <canvas id="graficoLine"></canvas>
                </div>

            </div>
        </div>



        <div class="col-7 ">

            <div class="row mt-3 ">
                <div class="col-2">
                    <a href="{{ route('estacionalidad.show', $indicador->id) }}" class="btn btn-success w-100">
                        Estacionalidad
                    </a>
                </div>
            </div>




            <div class="row  mt-5">
                <div class="col-12 ">
                    <h5 class="fw-bold">
                        <i class="fa fa-calendar"></i>
                        Historial:
                    </h5>
                </div>
                @forelse ($info_meses as $info_mes)
                    <div class="col-2 shadow-sm mx-1  border-bottom mb-1 p-2 bg-white ">
                        <span class="fw-bold">
                            <i class="fa {{ ($loop->first ? 'fa-location-dot text-primary' : 'fa-calendar') }} "></i>
                            {{ Carbon::parse($info_mes->fecha_periodo)->translatedFormat('F Y') }} 
                        </span>
                        
                        <br>

                        <span class="">
                            @if($indicador->unidad_medida === 'pesos')
                                ${{ number_format($info_mes->informacion_campo, 2) }}

                            @elseif($indicador->unidad_medida === 'porcentaje')
                                {{ round($info_mes->informacion_campo, 2) }}%

                            @elseif($indicador->unidad_medida === 'dias')
                                {{ round($info_mes->informacion_campo, 2) }} Días

                            @elseif($indicador->unidad_medida === 'toneladas')
                                {{ round($info_mes->informacion_campo, 2) }} Ton.

                            @else
                                {{ round($info_mes->informacion_campo, 2) }}
                            @endif 
                            
                        </span>

                    </div>

                @empty
                    
                @endforelse
            </div>




        </div>






    </div>
</div>


@endsection




@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>

<script>
document.addEventListener("DOMContentLoaded", function () {

    const indicador = @json($indicador);
    const datos = @json($graficar);
    const TIPO_INDICADOR = "{{ $indicador->tipo_indicador }}";

    const mesesES = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    if (!datos || datos.length === 0) return;

    const datosFinal = datos.filter(d => d.final === "on");
    const datosReferencia = datos.filter(d => d.referencia === "on");

    const labels = [...new Set(
        [...datosFinal, ...datosReferencia].map(item => {
            const fecha = new Date(item.fecha_periodo);
            return `${mesesES[fecha.getMonth()]} ${fecha.getFullYear()}`;
        })
    )];

    const VARIACION_ON = "{{ $indicador->variacion }}" === "on";

    const META_MINIMA = {{ $indicador->meta_minima }};
    const META_ESPERADA = {{ $indicador->meta_esperada }};

    const VARIACION = VARIACION_ON ? META_MINIMA : null;

    const LIMITE_INFERIOR = VARIACION_ON ? META_ESPERADA - VARIACION : null;
    const LIMITE_SUPERIOR = VARIACION_ON ? META_ESPERADA + VARIACION : null;

    const UNIDAD_MEDIDA = "{{ $indicador->unidad_medida }}";

    // ============================
    // DATASET PRINCIPAL (BARRAS)
    // ============================

    const datasetFinal = {
        type: "bar",
        label: datosFinal.length > 0 ? datosFinal[0].nombre_campo : "Cumplimiento",

        data: labels.map(label => {
            const item = datosFinal.find(d => {
                const fecha = new Date(d.fecha_periodo);
                return `${mesesES[fecha.getMonth()]} ${fecha.getFullYear()}` === label;
            });
            return item ? parseFloat(item.informacion_campo) : null;
        }),

        backgroundColor: ctx => {
            const value = ctx.raw;
            if (value === null) return "rgba(200,200,200,0.3)";

            if (VARIACION_ON) {
                if (value < LIMITE_INFERIOR || value > LIMITE_SUPERIOR) {
                    return "rgba(255,99,132,0.8)";
                }
                return "rgba(75,192,75,0.8)";
            }

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
        order: 1,

        datalabels: {
            anchor: 'end',
            align: 'top',
            color: '#000',
            font: function(context) {
                const total = context.chart.data.labels.length;
                let size = 14;
                if (total > 6) size = 12;
                if (total > 10) size = 10;
                if (total > 15) size = 8;

                return {
                    weight: 'bold',
                    size: size
                };
            },
            formatter: function(value) {
                if (value === null) return '';

                switch (UNIDAD_MEDIDA) {
                    case 'pesos': return '$' + value.toFixed(2);
                    case 'porcentaje': return value.toFixed(2) + '%';
                    case 'dias': return value.toFixed(2) + ' Días';
                    case 'toneladas': return value.toFixed(2) + ' Ton.';
                    default: return value.toFixed(2);
                }
            }
        }
    };

    // ============================
    // REFERENCIAS (LÍNEAS)
    // ============================

    const referenciasAgrupadas = {};

    datosReferencia.forEach(item => {
        const fecha = new Date(item.fecha_periodo);
        const label = `${mesesES[fecha.getMonth()]} ${fecha.getFullYear()}`;

        if (!referenciasAgrupadas[item.nombre_campo]) {
            referenciasAgrupadas[item.nombre_campo] = {};
        }

        referenciasAgrupadas[item.nombre_campo][label] =
            parseFloat(item.informacion_campo);
    });

    const datasetsReferencias = Object.keys(referenciasAgrupadas).map((nombre, index) => ({
        type: "line",
        label: nombre,
        data: labels.map(label => referenciasAgrupadas[nombre][label] ?? null),
        borderWidth: 3,
        tension: 0.1,
        fill: false,
        borderColor: `rgba(${50 + index * 60}, 120, 255, 1)`,
        spanGaps: true,
        order: 10
    }));

    // ============================
    // CANVAS
    // ============================

    const canvas = document.getElementById("grafico");
    if (!canvas) return;

    // 🔥 EVITAR DUPLICACIÓN
    if (window.miGrafica) {
        window.miGrafica.destroy();
    }

    // ============================
    // CREAR GRÁFICA
    // ============================

    window.miGrafica = new Chart(canvas.getContext("2d"), {

        data: {
            labels,
            datasets: [
                datasetFinal,
                ...datasetsReferencias,

                ...(VARIACION_ON ? [
                    {
                        type: "line",
                        label: "Meta esperada",
                        data: labels.map(() => META_ESPERADA),
                        borderColor: "green",
                        borderWidth: 3,
                        order: 10
                    },
                    {
                        type: "line",
                        label: "Variación inferior",
                        data: labels.map(() => LIMITE_INFERIOR),
                        borderColor: "red",
                        borderWidth: 2,
                        borderDash: [6, 6],
                        order: 10
                    },
                    {
                        type: "line",
                        label: "Variación superior",
                        data: labels.map(() => LIMITE_SUPERIOR),
                        borderColor: "red",
                        borderWidth: 2,
                        borderDash: [6, 6],
                        order: 10
                    }
                ] : [
                    {
                        type: "line",
                        label: "Meta mínima",
                        data: labels.map(() => META_MINIMA),
                        borderColor: "red",
                        borderWidth: 2,
                        borderDash: [6, 6],
                        order: 10
                    },
                    {
                        type: "line",
                        label: "Meta máxima",
                        data: labels.map(() => META_ESPERADA),
                        borderColor: "green",
                        borderWidth: 3,
                        order: 10
                    }
                ])
            ]
        },

        options: {
            responsive: true,

            plugins: {
                legend: {
                    display: true,
                    labels: {
                        filter: function(item, chart) {

                            const dataset = chart.datasets[item.datasetIndex];

                            return dataset.type !== 'bar'; // 👈 oculta solo barras
                        }
                    }
                },
                datalabels: {
                    display: context => context.dataset.type === 'bar'
                }
            },

            scales: {
                y: {
                    beginAtZero: true
                }
            }
        },

        plugins: [ChartDataLabels]

    });

});
</script>





{{-- los otros graficos  --}}

<script>
document.addEventListener("DOMContentLoaded", function () {

    const datos = @json($graficar);
    const TIPO_INDICADOR = "{{ $indicador->tipo_indicador }}";
    const UNIDAD_MEDIDA = "{{ $indicador->unidad_medida }}";

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

    const todosDatos = [...datosFinal, ...datosReferencia];

    // ============================
    // LABELS (MES + AÑO ORDENADO)
    // ============================

    const fechasUnicas = [...new Set(
        todosDatos.map(item => item.fecha_periodo)
    )].sort((a, b) => new Date(a) - new Date(b));

    const labels = fechasUnicas.map(fechaStr => {
        const fecha = new Date(fechaStr);
        const mes = mesesES[fecha.getMonth()];
        const year = fecha.getFullYear();
        return `${mes} ${year}`;
    });

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
    // DATA FINAL
    // ============================

    const dataValores = fechasUnicas.map(fecha => {
        const item = datosFinal.find(d => d.fecha_periodo === fecha);
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

        if (VARIACION_ON) {
            if (valor < LIMITE_INFERIOR || valor > LIMITE_SUPERIOR) {
                return "rgba(255,99,132,0.8)";
            }
            return "rgba(75,192,75,0.8)";
        }

        if (TIPO_INDICADOR === "riesgo") {
            return valor < META_MINIMA
                ? "rgba(75,192,75,0.8)"
                : "rgba(255,99,132,0.8)";
        }

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
                    tension: 0,
                    fill: true,
                    pointBackgroundColor: ctx => obtenerColor(ctx.raw),
                    pointRadius: 6
                }]
            },

            options: {
                responsive: true,
                scales: {
                    y: { beginAtZero: true }
                },
                plugins: {
                    datalabels: {
                        anchor: 'end',
                        align: 'center',
                        color: '#000',
                        font: function(context) {

                            const total = context.chart.data.labels.length;

                            let size = 17;

                            if (total > 6) size = 15;
                            if (total > 10) size = 12;
                            if (total > 15) size = 10;
                            if (total > 20) size = 8;

                            return {
                                weight: 'bold',
                                size: size
                            };
                        },
                        formatter: function(value) {

                            if (value === null) return '';

                            switch (UNIDAD_MEDIDA) {

                                case 'pesos':
                                    return '$' + value.toFixed(2);

                                case 'porcentaje':
                                    return value.toFixed(2) + '%';

                                case 'dias':
                                    return value.toFixed(2) + ' Días';

                                case 'toneladas':
                                    return value.toFixed(2) + ' Ton.';

                                default:
                                    return value.toFixed(2);
                            }
                        }
                    }
                }
            },

            plugins: [ChartDataLabels]

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
                        display:false
                    },
                    datalabels: {
                        color: '#fff',
                        font: function(context) {

                            const total = context.chart.data.labels.length;

                            let size = 15;

                            if (total > 6) size = 15;
                            if (total > 10) size = 10;
                            if (total > 15) size = 8;
                            if (total > 20) size = 8;

                            return {
                                weight: 'bold',
                                size: size
                            };
                        },
                        formatter: function(value, context) {

                            if (value === null) return '';

                            const label = context.chart.data.labels[context.dataIndex];

                            let valorFormateado = '';

                            switch (UNIDAD_MEDIDA) {

                                case 'pesos':
                                    valorFormateado = '$' + value.toFixed(2);
                                    break;

                                case 'porcentaje':
                                    valorFormateado = value.toFixed(2) + '%';
                                    break;

                                case 'dias':
                                    valorFormateado = value.toFixed(2) + ' Días';
                                    break;

                                case 'toneladas':
                                    valorFormateado = value.toFixed(2) + ' Ton.';
                                    break;

                                default:
                                    valorFormateado = value.toFixed(2);
                            }

                            return label + '\n' + valorFormateado;
                        },

                    }
                }
            },

            plugins: [ChartDataLabels]

        });

    }

});
</script>








{{-- Aqui yacen os scripts de la estacionalidad --}}





@endsection