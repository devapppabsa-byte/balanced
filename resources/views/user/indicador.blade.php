@extends('plantilla')
@section('title', 'LLenado de Indicadores')
@section('contenido')
@php
use App\Models\CampoCalculado;
use App\Models\CampoInvolucrado;
use App\Models\CampoPrecargado;
use App\Models\CampoVacio;
use App\Models\MetaIndicador;
use App\Models\InformacionInputVacio;
use App\Models\InformacionInputPrecargado;
use App\Models\InformacionInputCalculado;
use Carbon\Carbon;

@endphp

<div class="container-fluid sticky-top">
    <div class="row bg-primary d-flex align-items-center">

        <div class="col-8 col-sm-8 col-md-6 col-lg-9 py-2 ">
            <h5 class="text-white"> {{$indicador->nombre}} </h5>
            <h6 class="text-white fw-bold" id="fecha"></h6>
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

            @if ($errors->any())
                <div class="bg-white  fw-bold p-2 rounded">
                    <i class="fa fa-xmark-circle mx-2  text-danger"></i>
                        No se agrego! <br> 
                    <i class="fa fa-exclamation-circle mx-2  text-danger"></i>
                    {{$errors->first()}}
                </div>
            @endif
        </div>
  
        <div class="col-4 col-sm-4 col-md-6 col-lg-3 text-end ">
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


<div class="container-fluid">
    <div class="row border-bottom mb-2 bg-white">


    {{-- LOGICA DEL BLOQUEO DEL LLENADO DE INDICADORES- SE BLOQUEA SI YA SE LLENO ESTE MES Y SE BLOQUEA SI NO SE HA CARGADO EL EXCEL. --}}
    
        @php
            $carga_excel = $ultima_carga_excel?->created_at?->format('Y-m') ?? '0000-00';    
            $carga_indicador = $ultima_carga_indicador?->created_at?->format('Y-m') ?? '0000-00';
            $ahora = now()->format('Y-m');


            


        @endphp



        {{-- si la craga del excel es diferente a este mes y año o si la carga del indicador es menor o igual a ahora --}}
        @if ($carga_excel !== $ahora  || $carga_indicador === $ahora)

            @if ($carga_excel !== $ahora)
                <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
                    <button class="btn btn-outline-primary btn-sm w-100" onclick="toastr.error('{{'El indicador aún no se puede llenar. Falta cargar información por parte del admin'}}', 'Error!')">
                        <i class="fa fa-plus"></i>
                        Llenar este Indicador (Aún no se carga el excel)
                    </button>
                </div>
            @endif

            @if ($carga_indicador === $ahora)
                <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
                    <button class="btn btn-outline-danger btn-sm w-100" onclick="toastr.warning('{{'Ya se registro la información de este mes '}}', 'Aviso!')">
                        <i class="fa fa-plus"></i>
                        Ya se lleno el indicador este mes
                    </button>
                </div>
            @endif


            @else
                <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
                    <button class="btn btn-outline-primary btn-sm w-100 {{(Auth::user()->tipo_usuario != "principal") ? 'disabled' : ''  }}" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#llenado_indicadores">
                        <i class="fa fa-plus"></i>
                        Llenar este Indicador
                    </button>
                </div>
            @endif







{{-- LOGICA DEL BLOQUEO DEL LLENADO DE INDICADORES- SE BLOQUEA SI YA SE LLENO ESTE MES Y SE BLOQUEA SI NO SE HA CARGADO EL EXCEL. --}}



        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-outline-primary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#informacion_indicador">
                <i class="fa fa-eye"></i>
                Ver la informacion que se ocupa para este indicador.
            </button>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-outline-primary btn-sm w-100"  data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#grafico_indicador">
                <i class="fa-solid fa-chart-pie"></i>
                Grafico
            </button>
        </div>

    </div>
</div>



<div class="container-fluid">

    <div class="row justify-content-center pb-5 m border-bottom d-flex align-items-center mt-4">
        <div  class="col-12 mx-2 bg-white shadow-sm px-5 py-3 pb-5">
            
        <div class="row justify-content-center">
                
                <div class="col-12">
                    <h3><i class="fa fa-chart-simple"></i>
                        Historico de llenado del Indicador
                    </h3>
                </div>
        </div>



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
    $year = ucfirst($fecha->translatedFormat('Y'));
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

            <hr class="my-2">

            <!-- ITEMS -->
            <div class="row g-2 justify-content-center">

            @foreach($items as $item)

                <!-- RESULTADO FINAL -->
                @if($item->final === 'on')
                    @php $cumple = $item->informacion_campo >= $meta_minima; @endphp

                    @if ($indicador->tipo_indicador == "riesgo")
                    
                        <div class=" col-8 bg-  dark border border-2 rounded text-center py-3 my-4
                            {{ $cumple ? 'border-danger' : 'border-success' }}">
                            
                            <h6 class="fw-bold mb-1">
                                <i class="fa-solid {{ $cumple ? 'fa-circle-xmark text-danger' : 'fa-circle-check text-success' }}"></i>
                                {{ $item->nombre_campo }}
                            </h6>

                            <h3 class="fw-bold mb-0">
                                {{ $item->informacion_campo }} 
                            </h3>

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
                            <i class="fa fa-table"></i> Iniformación Extra
                        </button>
                    </div>

                    <div class="modal fade" id="com{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-primary text-white py-2">
                                    <h6 class="modal-title">Inidcador: {!! $indicador->nombre !!}</h6>
                                    <button class="btn-close" data-mdb-dismiss="modal"></button>
                                </div>
                                <div class="modal-body small ck-content">
                                    {!! $item->informacion_campo !!}
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
<div class="col-12 text-center text-muted py-5">
    <i class="fa-solid fa-circle-info"></i> Sin información disponible
</div>
@endforelse

</div>






            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="llenado_indicadores" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary py-4">
                <h3 class="text-white" id="exampleModalLabel">{{$indicador->nombre}}</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Cloeesdasdse"></button>
            </div>
            <div class="modal-body py-4">

                <form id="formulario_llenado_indicadores" method="POST" action="{{route('llenado.informacion.indicadores', $indicador->id)}}" class="row gap-4 p-2 justify-content-center form-loader">
                    @csrf
                    @forelse ($campos_vacios as $campo_vacio)

                    <div class="col-11 col-sm-11 col-md-4 col-lg-3 mb-4">

                        <div class="p-3 rounded-4 shadow-sm border bg-white campos_vacios h-100">

                            {{-- Nombre del campo --}}
                            <label class="fw-semibold mb-2 text-dark">
                                {{$campo_vacio->nombre}}
                            </label>

                            {{-- Input --}}
                            <input  type="number" step="0.0001"  class="form-control form-control-sm" name="informacion_indicador[]" id="{{$campo_vacio->id_input}}" placeholder="Ingrese {{$campo_vacio->nombre}}" require >

                            {{-- Campos ocultos (NO se tocan) --}}
                            <input type="hidden" name="id_input[]" value="{{$campo_vacio->id}}">
                            <input type="hidden" name="tipo_input[]" value="{{$campo_vacio->tipo}}">
                            <input type="hidden" name="id_input_vacio[]" value="{{$campo_vacio->id_input}}">
                            <input type="hidden" name="nombre_input_vacio[]" value="{{$campo_vacio->nombre}}">

                            {{-- Descripción --}}
                            <div class="mt-2 p-2 bg-light rounded-3">
                                <small class="text-muted">
                                    {{$campo_vacio->descripcion}}
                                </small>
                            </div>

                        </div>

                    </div>

                    @empty
                        <div class="col-11 border border-4 p-5 text-center">
                            <h2>
                                <i class="fa fa-exclamation-circle text-danger"></i>
                                No se encontraron datos
                            </h2>
                        </div>
                    @endforelse

                    @if (!$campos_vacios->isEmpty() )
                        <div class="col-12 bg-light p-3 rounded ql-toolbar">
                            <label> <i class="fa fa-table"></i> Información extra para el Indicador: </label>

                        <div class="form-group">
                            <div id="editor_info_extra"></div>
                            <input type="hidden" name="info_extra" id="info_extra">
                        </div>

                        </div>
                </form>

                <div class="row justify-content-center bg-light  rounded p-4">
                    <div class="col-12">
                        <i class="fa fa-exclamation-circle"></i>
                        <span class="fw-bold">Descripción:</span>
                    </div>
                    <div class="col-12">
                        <span>{{$indicador->descripcion}}</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button  class="btn btn-primary w-100 py-3" form="formulario_llenado_indicadores" data-mdb-ripple-init>
                    <h6>Guardar</h6>
                </button>
                @endif
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
            <div class="modal-body py-4 bg-light">
                <div class="col-12  mx-2 bg-white shadow-sm p-5 mt-4" >
                    <canvas class="w-100 h-100" id="grafico"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="informacion_indicador" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog  modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary py-4">
                <h3 class="text-white" id="exampleModalLabel">{{$indicador->nombre}}</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Cloeesdasdse"></button>
            </div>
            <div class="modal-body py-4 bg-light">

                <div class="row gap-4  justify-content-center ">

                    <div class="col-12 col-sm-12 border col-md-11 col-lg-10 bg-white boder  shadow shadow-sm py-2 px-5">

                        <div class="row justify-content-center">
                            <div class="col-12 text-center my-3">
                                <h4>
                                    <i class="fa fa-exclamation-circle text-primary"></i>
                                    Información para este indicador
                                </h4>
                                <hr>
                            </div>

                            {{-- aqui vamos a consultar los campos precargados --}}

                            @forelse ($campos_unidos as $campo)
                            <div class="col-11 col-sm-11 col-md-5 col-lg-3 border border-4 p-4 shadow-sm m-3">

                                <span class="fw-bold">{{$campo->nombre}}</span>
                                @php

                                    //se tiene que validar todo el desmadre por que de los campos que conformacn campos unidos hay vario que no tienen el campo informacion.
                                    if(CampoPrecargado::where('id_input', $campo->id_input)->latest()->first()){

                                        $precargado = CampoPrecargado::where('id_input', $campo->id_input)->latest()->first();

                                        $info_precargada = InformacionInputPrecargado::where('id_input_precargado', $precargado->id)->latest()->first();
                                    
                                    }
                                    else {
                                        $precargado = null;
                                        $info_precargada = null;
                                    }
                                    
                                @endphp

                                <input type="text" class="form-control"  name="{{$campo->nombre}}" value="{{($info_precargada != null  ?  $info_precargada->informacion : '' )}}" disabled>

                                <small>{{$campo->descripcion}}</small>

                            </div>                    
                            @empty
                                
                            @endforelse

                            <div class="col-12 p-3 bg-light">
                                <p><i class="fa fa-info-circle text-primary"></i> {{$indicador->descripcion}}</p>
                            </div>

                        </div>

                    </div>
                    
                </div>

            </div>
        </div>
    </div>
</div>






{{-- DATOS DEL INDICADOR PARA EL ENVIO DEL CORREO ELECTRONICO. --}}
<div id="data-indicador"
    data-user = "{{Auth::user()->name}}"
    data-correos = '@json($correos)''
     data-indicador="{{ $indicador->nombre }}"
     data-departamento="{{ Auth::user()->departamento->nombre }}">
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
            return mesesES[fecha.getMonth()-1];
        })
    )];

    // ============================
    // METAS
    // ============================

    const MINIMO = {{ $indicador->meta_minima }};
    const MAXIMO = {{ $indicador->meta_esperada }};

    const colorMinimo = TIPO_INDICADOR === "riesgo" ? "green" : "red";
    const colorMaximo = TIPO_INDICADOR === "riesgo" ? "red" : "green";

    // ============================
    // DATASET FINAL (BARRAS CON COLORES)
    // ============================

    const datasetFinal = {
        type: "bar",
        label: datosFinal.length > 0
            ? datosFinal[0].nombre_campo
            : "Cumplimiento",

        data: labels.map(mes => {
            const item = datosFinal.find(d => {
                const fecha = new Date(d.created_at);
                return mesesES[fecha.getMonth()-1] === mes;
            });
            return item ? parseFloat(item.informacion_campo) : null;
        }),

        backgroundColor: ctx => {

            const value = ctx.raw;

            if (value === null) return "rgba(200,200,200,0.3)";

            // Respeta lógica de indicador
            if (TIPO_INDICADOR === "riesgo") {
                return value < MINIMO
                    ? "rgba(75,192,75,0.7)"
                    : "rgba(255,99,132,0.7)";
            }

            return value < MINIMO
                ? "rgba(255,99,132,0.7)"
                : "rgba(75,192,75,0.7)";
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
        const mes = mesesES[fecha.getMonth()-1];

        if (!referenciasAgrupadas[item.nombre_campo]) {
            referenciasAgrupadas[item.nombre_campo] = {};
        }

        referenciasAgrupadas[item.nombre_campo][mes] =
            parseFloat(item.informacion_campo);
    });

    // Crear una línea rellena por cada referencia
    const datasetsReferencias = Object.keys(referenciasAgrupadas).map((nombre, index) => {

        return {
            type: "line",
            label: nombre,

            data: labels.map(mes =>
                referenciasAgrupadas[nombre][mes] ?? null
            ),

            borderWidth: 3,
            tension: 0.3,

            // ✅ Línea rellena
            fill: true,

            // Color automático diferente por referencia
            borderColor: `rgba(${50 + index * 60}, 120, 255, 1)`,
            backgroundColor: `rgba(${50 + index * 60}, 120, 255, 0.2)`,

            spanGaps: true,
            order: 5
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

                // Barras Final
                datasetFinal,

                // Referencias como líneas rellenas
                ...datasetsReferencias,

                // ============================
                // META MINIMA
                // ============================
                {
                    type: "line",
                    label: "Meta mínima",
                    data: labels.map(() => MINIMO),
                    borderColor: colorMinimo,
                    borderWidth: 2,
                    order: 10
                },

                // ============================
                // META MAXIMA
                // ============================
                {
                    type: "line",
                    label: "Meta máxima",
                    data: labels.map(() => MAXIMO),
                    borderColor: colorMaximo,
                    borderWidth: 2,
                    order: 10
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

});





</script>









{{-- AQUI ESTA EL SCRIPT QUE ENVIA LOS CORREOS ELECTRONICOS --}}
<script>

const data = document.getElementById('data-indicador');

let filas = `Se llenó el indicador de ${data.dataset.indicador}
del departamento ${data.dataset.departamento}`;
const correos = JSON.parse(data.dataset.correos);

document.getElementById('formulario_llenado_indicadores')
.addEventListener('submit', function (e) {

    e.preventDefault();


    const inputs = document.querySelectorAll('.input');

    // 🔹 Enviar correo con EmailJS
    emailjs.send('service_ns6885s', 'template_zfgln7k', {
        name: data.dataset.user,
        time: new Date().toLocaleString(),
        message: filas,
        mails: correos

    }).then(() => {

        // 🔹 Cuando el correo se envía, ahora sí mandamos el form a Laravel
        e.target.submit();

    }).catch(error => {
        console.error('Error al enviar correo:', error);
        alert('Error al enviar notificación por correo');
    });

});

</script>







@endsection