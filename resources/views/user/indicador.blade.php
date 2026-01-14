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

        <div class="col-8 col-sm-8 col-md-6 col-lg-9  py-4  py-4 ">
            <h1 class="text-white"> {{$indicador->nombre}} </h1>
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

        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-outline-primary btn-sm w-100 {{(Auth::user()->tipo_usuario != "principal") ? 'disabled' : ''  }}  " data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#llenado_indicadores">
                <i class="fa fa-plus"></i>
                Llenar este Indicador
            </button>
        </div>

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




 <div class="row ">
                                
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
        $mes   = ucfirst($fecha->translatedFormat('F'));
        $year  = $fecha->format('Y');
    @endphp





    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 mt-4 ">
        <div class="card shadow-sm border-0 h-100">

            {{-- HEADER --}}
            <div class="card-header bg-info text-white text-center py-3">
                <h5 class="fw-bold mb-0">
                    <i class="fa-solid fa-calendar-days me-1"></i>
                    {{ $mes }} - {{ $year }}
                </h5>
            </div>

            {{-- METAS --}}
            <div class="card-body text-center ">
                <div class="row mb-3">
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

                <hr>

                {{-- ITEMS --}}
                <div class="row justify-content-center indicador-container">

             
                @foreach($items as $item)

                    {{-- RESULTADO FINAL --}}
                    @if($item->final === 'on')
                        @php
                            $cumple = $item->informacion_campo >= $meta_minima;
                        @endphp

                        <div class=" col-8  border border-2 rounded text-center py-3 my-4
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

                    {{-- COMENTARIO --}}
                    @if($item->final === 'comentario')
                        <button class="btn btn-outline-secondary btn-sm mb-2"
                                data-mdb-modal-init
                                data-mdb-target="#com{{ $item->id }}">
                            <i class="fa fa-comment"></i> Comentario
                        </button>

                        <div class="modal fade" id="com{{ $item->id }}" tabindex="-1">
                            <div class="modal-dialog modal-lg modal-dialog-centered">
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

                        <div class="col-6 border text-start  p-2 my-2">
                            
                            <div class=" ">
                                <span class="">{{ $item->nombre_campo }}</span>
                                <br>
                                <div class="badge badge-secondary  fw-bold border shadow-sm fs-6">                                  
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
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header bg-primary py-4">
                <h3 class="text-white" id="exampleModalLabel">{{$indicador->nombre}}</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Cloeesdasdse"></button>
            </div>
            <div class="modal-body py-4">

                <form id="formulario_llenado_indicadores" method="POST" action="{{route('llenado.informacion.indicadores', $indicador->id)}}" class="row gap-4 p-2 justify-content-center">
                    @csrf
                    @forelse ($campos_vacios as $campo_vacio)
                        <div class="col-11  col-sm-11 col-md-4 col-lg-3  text-start border border-4 mb-4 p-3 shadow-sm campos_vacios ">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <label for="" class="fw-bold">{{$campo_vacio->nombre}}</label>
                                </div>
                                <div class="col-12">
                                    <input type="number" step="0.0001"  min="0" class="form-control input" name="informacion_indicador[]" id="{{$campo_vacio->id_input}}" placeholder="{{$campo_vacio->nombre}}" required>

                                    {{-- campos ocultos para llevar informacion al controlador --}}
                                        <input type="hidden" name="id_input[]" value="{{$campo_vacio->id}}">
                                        <input type="hidden" name="tipo_input[]" value="{{$campo_vacio->tipo}}">
                                        <input type="hidden" name="id_input_vacio[]" value="{{$campo_vacio->id_input}}">
                                        <input type="hidden" name="nombre_input_vacio[]" value="{{$campo_vacio->nombre}}"">

                                    {{-- campos ocultos para llevar informacion al controlador --}}

                                </div>
                                <div class="col-11 bg-light m-4">
                                    <small>{{$campo_vacio->descripcion}}</small>
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
                        <div class="col-12 bg-light p-3 rounded">
                            <label>Comentario del Indicador: </label>
                            <textarea type="text" name="comentario" placeholder="Comentario" class="form-control"></textarea>
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
    <div class="modal-dialog  modal-xl modal-dialog-centered">
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

{{-- <script>
    // VEINTIUNICA GRAFICA.
    // ESTO VIENE DINÁMICO DESDE LARAVEL
    const datos = @json($graficar);

    // Meses en español
    const mesesES = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    // Separar FINAL y REFERENCIA
    const datosFinal = datos.filter(item => item.final === 'on');
    const datosReferencia = datos.filter(item => item.referencia === 'on');

    // Labels (usamos los finales)
    const labels = datosFinal.map(item => {
        const fecha = new Date(item.created_at);
        fecha.setMonth(fecha.getMonth() - 1);
        return mesesES[fecha.getMonth()];
    });

    // Valores
    const valores = datosFinal.map(item => parseFloat(item.informacion_campo));
    const valoresReferencia = datosReferencia.map(item => parseFloat(item.informacion_campo));

    // Niveles dinámicos
    const MINIMO = {{$meta_minima_general}};
    const MAXIMO = {{$meta_maxima_general}};

    const ctx = document.getElementById('grafico').getContext('2d');

    new Chart(ctx, {
        data: {
            labels: labels,
            datasets: [

                // BARRAS (FINAL)
                {
                    type: "bar",
                    label: "Cumplimiento del Indicador",
                    data: valores,
                    backgroundColor: function (context) {
                        const value = context.raw;
                        return value < MINIMO
                            ? "rgba(255, 99, 132, 0.7)"
                            : "rgba(75, 192, 75, 0.7)";
                    },
                    borderColor: function (context) {
                        const value = context.raw;
                        return value < MINIMO ? "red" : "green";
                    },
                    borderWidth: 1
                },

                // LINEA DE REFERENCIA
                {
                    type: "line",
                    label: "Referencia",
                    data: valoresReferencia,
                    borderColor: "rgba(54, 162, 235, 1)",
                    borderWidth: 3,
                    fill: false,
                    tension: 0.3,
                    pointRadius: 5
                },

                // Línea de nivel mínimo
                {
                    type: "line",
                    label: "Nivel mínimo",
                    data: valores.map(() => MINIMO),
                    borderColor: "red",
                    borderWidth: 2,
                    fill: false,
                    pointRadius: 0
                },

                // Línea de nivel máximo
                {
                    type: "line",
                    label: "Nivel máximo",
                    data: valores.map(() => MAXIMO),
                    borderColor: "green",
                    borderWidth: 2,
                    fill: false,
                    pointRadius: 0
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
</script> --}}


<script>
    const datos = @json($graficar);

    const mesesES = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    // FINAL
    const datosFinal = datos.filter(d => d.final === 'on');

    // REFERENCIA
    const datosReferencia = datos.filter(d => d.referencia === 'on');

    // Labels desde FINAL
    const labels = datosFinal.map(item => {
        const fecha = new Date(item.created_at);
        fecha.setMonth(fecha.getMonth() - 1);
        return mesesES[fecha.getMonth()];
    });

    // Valores FINAL
    const valores = datosFinal.map(item =>
        parseFloat(item.informacion_campo)
    );

    // REFERENCIA alineada por id_movimiento
    const valoresReferencia = datosFinal.map(finalItem => {
        const ref = datosReferencia.find(r =>
            r.id_movimiento === finalItem.id_movimiento
        );

        return ref ? parseFloat(ref.informacion_campo) : null;
    });

    const MINIMO = {{$meta_minima_general}};
    const MAXIMO = {{$meta_maxima_general}};

    const ctx = document.getElementById('grafico').getContext('2d');

    new Chart(ctx, {
        data: {
            labels: labels,
            datasets: [

                {
                    type: "bar",
                    label: "Cumplimiento del Indicador",
                    data: valores,
                    backgroundColor: function (context) {
                        const value = context.raw;
                        return value < MINIMO
                            ? "rgba(255, 99, 132, 0.7)"
                            : "rgba(75, 192, 75, 0.7)";
                    },
                    borderColor: function (context) {
                        const value = context.raw;
                        return value < MINIMO ? "red" : "green";
                    },
                    borderWidth: 1
                },

                // 🔥 REFERENCIA (AHORA SÍ FUNCIONA)
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

                {
                    type: "line",
                    label: "Nivel mínimo",
                    data: valores.map(() => MINIMO),
                    borderColor: "red",
                    borderWidth: 2,
                    fill: false,
                    pointRadius: 0
                },

                {
                    type: "line",
                    label: "Nivel máximo",
                    data: valores.map(() => MAXIMO),
                    borderColor: "green",
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