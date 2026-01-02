@extends('plantilla')
@section('title', 'LLenado de Indicadores')
@section('contenido')
@php
use App\Models\CampoCalculado;
use App\Models\CampoInvolucrado;
use App\Models\CampoPrecargado;
use App\Models\CampoVacio;
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

    <div class="row justify-content-around pb-5 m border-bottom d-flex align-items-center mt-4">
        <div  class="col-12 mx-2 bg-white shadow-sm p-5">
            
            <div class="row justify-content-center">
                
                <div class="col-12">
                    <h3><i class="fa fa-chart-simple"></i>
                        Historico de llenado del Indicador
                    </h3>
                </div>


                
                @forelse($grupos as $movimiento => $items)

                <div class="col-10 col-sm-5 col-md-5 col-lg-3  shadow-sm mx-4 border rounded mt-4">
                    @php
                        $fecha = Carbon::parse(explode('-', $movimiento)[0]);
                        Carbon::setLocale('es');
                        $mes = $fecha->subMonth()->translatedformat('F');
                        $year = $fecha->format('Y');
                    @endphp

                    <div class="row justify-content-center">
                        
                        <div class="col-12 bg-info text-white pt-3 pb-2 mb-4 rounded">
                            <h3 class="text-center fw-bold">
                                <i class="fa-solid fa-calendar-days"></i> {{ $mes.' - '.$year }}
                            </h3>
                        </div>
                        
                        @foreach($items as $item)

                        
                        {{-- Se hace la consulta de la informaion del indiacor lleno, y se hace la condicional  para saber si esta el campo final --}}
                        @if ($item->final === "on")
                            <div class="col-8  fw-bold  rounded-5 border zoom_link {{($indicador->meta_minima > $item['informacion_campo']) ? 'border-danger' : 'border-success' }} bg-light mb-3 py-2 mt-3">
                                
                                
                                <h5 class="text-center ">
                                    <i class="fa {{($indicador->meta_minima > $item['informacion_campo']) ? 'fa-xmark-circle text-danger' : 'fa-check-circle text-success' }}"></i>
                                    {{ $item['nombre_campo'] }}: 
                                </h5> 
                                <h2 class="text-center">{{ $item['informacion_campo'] }} </h2>
                            
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
                                <span class="h3">{{ $item['informacion_campo'] }}</span> <br>                
                            </div>
                            
                        @endif
                            

                        @endif
                        @endif
                        @endforeach
                        
                    </div>
                </div>
                
                    
                @empty

                @endforelse

            </div>
        </div>

    </div>
</div>



<div class="modal fade" id="llenado_indicadores" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header bg-primary py-4">
                <h3 class="text-white" id="exampleModalLabel">{{$indicador->nombre}}</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Cloeesdasdse"></button>
            </div>
            <div class="modal-body py-4">

                <form id="formulario_llenado_indicadores" method="POST" action="{{route('llenado.informacion.indicadores', $indicador->id)}}" class="row gap-4 p-2 justify-content-center">
                    @csrf
                    @forelse ($campos_vacios as $campo_vacio)
                        <div class="col-11  col-sm-11 col-md-4 col-lg-5 text-start border border-4 mb-4 p-3 shadow-sm campos_vacios">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <label for="" class="fw-bold">{{$campo_vacio->nombre}}</label>
                                </div>
                                <div class="col-12">
                                    <input type="{{$campo_vacio->tipo}}" min="0" class="form-control input" name="informacion_indicador[]" id="{{$campo_vacio->id_input}}" placeholder="{{$campo_vacio->nombre}}">

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
                                <input type="text" class="form-control"  name="{{$campo->nombre}}" value="" disabled>
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









@endsection











@section('scripts')
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



@endsection