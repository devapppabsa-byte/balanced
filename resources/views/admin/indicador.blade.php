@extends('plantilla')
@section('title', 'Inidcador')


@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center">
        <div class="col-auto py-4 text-white">

            <h1 class="mt-1">
                {{$indicador->nombre}}
            </h1>
            <span>
                Departamento de {{$indicador->departamento->nombre}}
            </span>
            @if (session('success'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('success')}}
                </div>
            @endif
            @if (session('error_input'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('error_input')}}
                </div>
            @endif
            @if (session('editado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('editado')}}
                </div>
            @endif
            @if (session('deleted'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('deleted')}}
                </div>
            @endif

        </div>
    </div>
    @include('admin.assets.nav')
</div>


<div class="container-fluid">
    <div class="row border py-2 justify-content-center bg-white shadow-sm">

        <div class="col-5 col-sm-5 col-md-6 col-lg-auto m-1">
            <button class="btn btn-secondary w-100"
            data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalCampos">
                <i class="fa fa-plus-circle mx-2"></i>
                 Campos Vacios
            </button>
        </div>


        <div class="col-5 col-sm-4 col-md-5 col-lg-auto m-1">
            <button class="btn btn-secondary w-100"
            data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalCamposPrecargados">
                <i class="fa fa-plus-circle mx-2"></i>
                 Campos Precargados
            </button>
        </div>

        <div class="col-5 col-sm-4 col-md-5 col-lg-auto m-1">
            <button class="btn btn-outline-primary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalPromediarCampos">
              <i class="fa-solid fa-scale-balanced"></i>
                Crear Campo Promedio
            </button>
        </div>

        <div class="col-5 col-sm-4 col-md-5 col-lg-auto m-1">
             <button class="btn btn-outline-primary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalDividirCampos">
               <i class="fa-solid fa-divide fw-bold"></i>
                 Crear Campo División
             </button>
         </div>

        <div class="col-5 col-sm-4 col-md-5 col-lg-auto m-1">
            <button class="btn btn-outline-primary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalSumarCampos">
              <i class="fa-solid fa-plus fw-bold"></i>
                Crear Campo Suma
            </button>
        </div>

        <div class="col-5 col-sm-4 col-md-5 col-lg-auto m-1">
            <button class="btn btn-outline-primary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalRestarCampos">
              <i class="fa-solid fa-minus fw-bold"></i>
                Crear Campo Resta
            </button>
        </div>


        <div class="col-5 col-sm-4 col-md-5 col-lg-auto m-1">
            <button class="btn btn-outline-primary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalMultiplicarCampos">
                <i class="fa-solid fa-square-xmark"></i>
                Crear Campo Multiplicación
            </button>
        </div>


    </div>
</div>



<div class="container-fluid shadow">
    <div class="row justify-content-around mt-4 mx-2 bg-white pb-5 pt-2 rounded px-4">
        <div class="col-12 text-center my-3">
            <h3>
                <i class="fa-solid fa-clipboard-check"></i>
                Campos del Indicador
            </h3>    
        </div>       
        <div class="col-12 col-sm-12 col-md-11 col-lg-12">

            @if (!$campos_unidos->isEmpty())
                <div class="table-responsive">
                    <table class="table border">
                        <thead class="table-primary border">
                            <th scope="col">Id</th>
                            <th scope="col">Nombre del campo</th>
                            <th scope="col">Tipo</th>
                            <th scope="col">Descripcion</th>
                            <th scope="col">Vista previa</th>
                            <th scope="col">Acciones</th>
                        </thead>
                        <tbody class="" id="contenedor">
    
                        </tbody>
                    </table>
                </div>
            @else
                
            <div class="row justify-content-center mt-5 ">
                <div class="col-12 text-center ">
                    <img src="{{asset('/img/iconos/empty.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-12 text-center">
                    <h3>
                        <i class="fa fa-exclamation-circle text-danger"></i>
                        No hay campos disponibles en este indicador.
                    </h3>
                </div>
            </div>
            
            @endif

        </div>
    </div>
</div>


<div class="modal fade" id="modalPromediarCampos" tabindex="-1"  aria-labelledby="sdsad" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary py-3">
                <h3 class="text-white" id="exampleModalLabel">
                <i class="fa-solid fa-gauge-simple"></i>
                   Selecciona los datos que se van a promediar.
                </h3>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-2">

                <div class="row pb-5 px-2 bg-light border m-3"  id="calculados_container" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div class="col-12 no-drop m-2">
                        <h6 class"no-drop">Campos Disponibles</h6>
                    </div>

                    @forelse ($campos_unidos as $campo_unido)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3 border no-drop bg-white" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStart(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_promedio[]" value="{{$campo_unido->id_input}}">
                        </div>
                    @empty
                        
                    @endforelse


                </div>

                <form action="{{route("input.promedio.guardar", $indicador->id)}}" autocomplete="off" method="POST" class="row  m-3  destino  bg-light  pb-5 border" ondrop="drop(event)" ondragover="allowDrop(event)" id="promedio_container">
                    @csrf
                    <h6 class="no-drop" style="z-index: 1"> Arrastra los campos a promediar </h6>
                    
                </form>

                <div  class="row m-3 justify-content-center destino  bg-light  pb-5 border no-drop" id="vista_previa_campo">

                    <h6 class="no-drop">Campo Generado</h6>

                </div>
                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" form="promedio_container" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Resultado Final</label>
                        </div>

                        <button  class="btn btn-primary" form="promedio_container" > {{-- id="crear_campo_promedio" --}}
                            Crear Campo Promedio
                        </button>
                        {{-- <a  href="#" class="btn btn-secondary" id="vista_previa_button">
                            Vista Previa
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalRestarCampos" tabindex="-1"  aria-labelledby="sdsad" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary py-3">
                <h3 class="text-white" id="exampleModalLabel">
                    <i class="fa fa-minus-circle"></i>
                   Selecciona los datos que se van a restar.
                </h3>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-2">

                <div class="row pb-5 px-2 bg-light border m-3"  id="calculados_container" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div class="col-12 no-drop m-2">
                        <h6 class="no-drop">Campos Disponibles</h6>
                    </div>

                    @forelse ($campos_unidos as $campo_unido)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3 border no-drop bg-white" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStart(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_promedio[]" value="{{$campo_unido->id_input}}">
                        </div>
                    @empty
                        
                    @endforelse
                   

                </div>

                <form action="{{route("input.promedio.guardar", $indicador->id)}}" autocomplete="off" method="POST" class="row  m-3  destino  bg-light  pb-5 border" ondrop="drop(event)" ondragover="allowDrop(event)" id="promedio_container">
                    @csrf
                    <h6 class="no-drop" style="z-index: 1"> Arrastra los campos a promediar </h6>
                </form>

                <div  class="row m-3 justify-content-center destino  bg-light  pb-5 border no-drop" id="vista_previa_campo">

                    <h6 class="no-drop">Campo Generado</h6>

                </div>
                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" form="promedio_container" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Resultado Final</label>
                        </div>

                        <button  class="btn btn-primary" form="promedio_container" >
                            Crear Campo Promedio
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalMultiplicarCampos" tabindex="-1"  aria-labelledby="sdsad" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary py-3">
                <h3 class="text-white" id="exampleModalLabel">
                    <i class="fa fa-xmark-circle"></i>
                   Selecciona los datos que se van a multiplicar.
                </h3>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-2">

                <div class="row pb-5 px-2 bg-light border m-3"  id="calculados_container" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div class="col-12 no-drop m-2">
                        <h6 class="no-drop">Campos Disponibles</h6>
                    </div>

                    @forelse ($campos_unidos as $campo_unido)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3 border no-drop bg-white" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStart(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_promedio[]" value="{{$campo_unido->id_input}}">
                        </div>
                    @empty
                        
                    @endforelse


                </div>

                <form action="{{route("input.promedio.guardar", $indicador->id)}}" autocomplete="off" method="POST" class="row  m-3  destino  bg-light  pb-5 border" ondrop="drop(event)" ondragover="allowDrop(event)" id="promedio_container">
                    @csrf
                    <h6 class="no-drop" style="z-index: 1"> Arrastra los campos a promediar </h6>
                </form>

                <div  class="row m-3 justify-content-center destino  bg-light  pb-5 border no-drop" id="vista_previa_campo">

                    <h6 class="no-drop">Campo Generado</h6>

                </div>
                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" form="promedio_container" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Resultado Final</label>
                        </div>

                        <button  class="btn btn-primary" form="promedio_container" > {{-- id="crear_campo_promedio" --}}
                            Crear Campo Promedio
                        </button>
                        {{-- <a  href="#" class="btn btn-secondary" id="vista_previa_button">
                            Vista Previa
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalDividirCampos" tabindex="-1"  aria-labelledby="sdsad" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary py-3">
                <h3 class="text-white" id="exampleModalLabel">
                   Selecciona los datos que se van a Dividir.
                </h3>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-2">

                <div class="row pb-5 px-2 bg-light border m-3"  id="calculados_container" ondrop="drop(event)" ondragover="allowDrop(event)">
                    
                    <div class="col-12 no-drop m-2">
                        <h6 class="no-drop">Campos Disponibles</h6>
                    </div>



                    @forelse ($campos_unidos as $campo_unido)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3 border no-drop bg-white" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStart(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_promedio[]" value="{{$campo_unido->id_input}}">
                        </div>
                    @empty
                        
                    @endforelse


                </div>

                <form action="{{route("input.promedio.guardar", $indicador->id)}}" autocomplete="off" method="POST" class="row  m-3  destino  bg-light  pb-5 border" ondrop="drop(event)" ondragover="allowDrop(event)" id="promedio_container">
                    @csrf
                    <h6 class="no-drop" style="z-index: 1"> Arrastra los campos a promediar </h6>
                </form>

                <div  class="row m-3 justify-content-center destino  bg-light  pb-5 border no-drop" id="vista_previa_campo">

                    <h6 class="no-drop">Campo Generado</h6>

                </div>
                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" form="promedio_container" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Resultado Final</label>
                        </div>

                        <button  class="btn btn-primary" form="promedio_container" > {{-- id="crear_campo_promedio" --}}
                            Crear Campo Promedio
                        </button>
                        {{-- <a  href="#" class="btn btn-secondary" id="vista_previa_button">
                            Vista Previa
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<div class="modal fade" id="modalSumarCampos" tabindex="-1"  aria-labelledby="sdsad" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary py-3">
                <h3 class="text-white" id="exampleModalLabel">
                    <i class="fa fa-plus-circle"></i>
                   Selecciona los datos que se van a sumar.
                </h3>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-2">

                <div class="row pb-5 px-2 bg-light border m-3"  id="calculados_container_suma" ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div class="col-12 no-drop m-2">
                        <h6 class="no-drop">Campos Disponibles</h6>
                    </div>

                    @forelse ($campos_unidos as $campo_unido)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3 border no-drop bg-white" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStart(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_promedio[]" value="{{$campo_unido->id_input}}">
                        </div>
                    @empty
                        
                    @endforelse


                </div>

                <form action="#" autocomplete="off" method="POST" class="row  m-3  destino  bg-light  pb-5 border" ondrop="drop(event)" ondragover="allowDrop(event)" id="suma_container">
                    @csrf
                    <h6 class="no-drop" style="z-index: 1"> Arrastra los campos a sumar. </h6>
                </form>

                <div  class="row m-3 justify-content-center destino  bg-light  pb-5 border no-drop" id="vista_previa_campo">

                    <h6 class="no-drop">Campo Generado</h6>

                </div>
                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" form="promedio_container" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Resultado Final</label>
                        </div>

                        <button  class="btn btn-primary" form="promedio_container" > {{-- id="crear_campo_promedio" --}}
                            Crear Campo de Suma
                        </button>
                        {{-- <a  href="#" class="btn btn-secondary" id="vista_previa_button">
                            Vista Previa
                        </a> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="modalCamposPrecargados" tabindex="-1"  aria-labelledby="exampleModalLaaabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-primary  py-4">
            <h3 class="text-white" id="exampleModalLabel">Selecciona un campo para agregar </h3>
            <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-2">

            <form action="{{route('agregar.campo.precargado', $indicador->id)}}" method="POST">
                @csrf
                <div class="form-group">

                    <select name="campo_precargado" class="form-control" id="">
                        <option value="" disabled selected>
                            Selecciona un campo precargado
                        </option>
                        @forelse ($informacion_foranea as $informacion)
                            <option value="{{$informacion->informacion}}|{{$informacion->tipo_dato}}|{{$informacion->nombre_info}}">{{$informacion->nombre_info}}</option>
                        @empty

                        @endforelse
                    </select>

                </div>

                <div class="form-group mt-3">
                    <button class="btn btn-primary">
                        Agregar campo
                    </button>
                </div>
            </form>


        </div>
        {{-- <div class="modal-footer">
        </div> --}}
        </div>
    </div>
</div>


<div class="modal fade" id="modalCampos" tabindex="-1"  aria-labelledby="exampleModdalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-primary  py-4">
            <h3 class="text-white" id="exampleModalLabel">Agregar campos vacios </h3>
            <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body p-2">

            <form action="{{route('agregar.campo.vacio', $indicador->id)}}" method="POST">
                @csrf
                <div class="row">

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group mt-3">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="text" class="form-control form-control-lg w-100" id="nombre_campo_vacio" name="nombre_campo_vacio" required>
                                <label class="form-label" for="nombre_campo_vacio" >Nombre </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-sm-12 col-md-6 col-lg-6">
                        <div class="form-group mt-3">
                        <select id="departamentoSelect" name="tipo_dato" class="form-control form-control-lg" data-mdb-select-init data-mdb-filter="true"
                        data-mdb-clear-button="true" required>
                            <option value="" disabled selected>Tipo de dato</option>
                                <option value="number">Número</option>
                                <option value="string">Texto</option>

                        </select>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mt-3">
                            <div class="form-outline" data-mdb-input-init>
                                {{-- <input type="text" class="form-control form-control-lg w-100" id="nombre_campo_vacio" name="nombre_campo_vacio" required> --}}
                                <textarea name="descripcion" class="form-control w-100 " id="descripcion"></textarea>
                                <label class="form-label" for="descripcion" >Descripción </label>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 mt-4">
                        <div class="form-group">
                            <button class="btn btn-primary w-100">
                                Insertar Campo
                            </button>
                        </div>
                    </div>

                </div>
            </form>

        </div>
        {{-- <div class="modal-footer">
        </div> --}}
        </div>
    </div>
</div>





@php
    $contador = 0;
@endphp
@forelse ($campos_unidos as $campo)

@php
    $contador ++;
@endphp


    <div class="modal fade" id="del{{$contador}}" tabindex="-1"  aria-labelledby="exampleMddodalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header bg-danger py-4">
                <h3 class="text-white" id="exampleModalLabel">¿Eliminar a {{$campo->nombre}} {{$campo->tipo}} {{$campo->tipo_dato}}?</h3>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">

                <form action="{{route('eliminar.campo', $campo->id)}}" method="POST">
                    @csrf @method('DELETE')

                    <div class="form-group">
                        <input type="hidden" name="id_input" value="{{$campo->id_input}}" >
                        <input type="hidden" name="campo_vacio" value="{{$campo->tipo}}">
                        <input type="hidden" name="campo_precargado" value="{{$campo->informacion_precargada}}">
                        <input type="hidden" name="campo_calculado" value="{{$campo->operacion}}">
                    </div>

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


@endsection





@section('scripts')
    
{{-- Codigo que genera la tabla que muestra los campos combinados  --}}
    <script>
        const campos_ = @json($campos_unidos);
        const campos = Object.values(campos_);

        const contenedor = document.getElementById("contenedor");

        let contador = 0;

        campos.forEach(campo => {

            contador ++;
            //este va a ser el codio de la vista previa del input
            const input1 = document.createElement("input");
            input1.classList.add("form-control", "w-100");
            input1.placeholder = campo.nombre;
            input1.id = campo.id_input;
            input1.disabled = true;
            input1.name = "input_promedio[]";
            if(campo.tipo) input1.type = campo.tipo;
            if(campo.tipo_dato) input1.type = campo.tipo_dato;

            const tr = document.createElement('tr');

            const tdNombre = document.createElement("td");
            tdNombre.textContent = campo.nombre;

            const tdTipo = document.createElement("td");
            
            if(campo.tipo_dato) {
                tdTipo.textContent = campo.tipo_dato;
                input1.value = campo.contenido;
                // input1.disabled = true;
            }
            

            if(campo.tipo){

                tdTipo.textContent = campo.tipo;

            }

            const tdDescripcion = document.createElement("td");
            tdDescripcion.textContent = campo.descripcion;

            const tdInput = document.createElement("td");
            tdInput.appendChild(input1)


            //botones de eliminar y editar
            const tdActions = document.createElement("td");

            const btnGroup = document.createElement("div");
            btnGroup.classList.add("btn-group", "shadow-0");


            const btnEliminar = document.createElement("button");
            btnEliminar.classList.add("btn", "btn-outline-danger");
            btnEliminar.innerHTML = "<i class='fa fa-trash'></i>";
            btnEliminar.setAttribute("data-mdb-ripple-init", "");
            btnEliminar.setAttribute("data-mdb-modal-init", "");
            btnEliminar.setAttribute("data-mdb-target", "#del"+contador);

            const tdId = document.createElement('td');
            tdId.textContent = contador;
            console.log(tdId);

            btnGroup.appendChild(btnEliminar);
            tdActions.appendChild(btnGroup);
            tr.appendChild(tdId);
            tr.appendChild(tdNombre);
            tr.appendChild(tdTipo);
            tr.appendChild(tdDescripcion);
            tr.appendChild(tdInput);
            tr.appendChild(tdActions);
            contenedor.appendChild(tr);



        });

    </script>  
{{-- Codigo que genera la tabla que muestra los campos combinados  --}}



    <script>

            const calculados_container = document.getElementById("calculados_container");
            const campos_para_operaciones = @json($campos_unidos);


            let nodo_arrastrado = null;

            // variables que me dan la vista previa de el input generado
            const contenedor_vista_previa = document.getElementById('vista_previa_campo');
            const div_columna = document.createElement("div");
            div_columna.classList.add("col-12", "col-sm-12", "col-md-4", "col-lg-3", "px-3", "py-4", "border", "bg-white", "no-drop");
            const label_vista_previa = document.createElement("label");
            // variables que me dan la vista previa de el input generado




            function dragStart(e){

            nodo_arrastrado = e.target;
            e.dataTransfer.setData('text', e.target.id);
            console.log("contador")
            //    console.log(e.dataTransfer.setData('text', e.target.id));

            }

            function allowDrop(e){
                e.preventDefault();
            }


            function drop(e){
                e.preventDefault();

                if(nodo_arrastrado){


                    let destino = e.target;
                    const id = e.dataTransfer.getData('text');

                    if(!destino.classList.contains('no-drop')){


                        destino.appendChild(nodo_arrastrado);

                        //Aqui ocurre la magia
                        const inputs = document.querySelectorAll("#promedio_container input");
                        const inputs_valores = Array.from(inputs);
                        const input_vista_previa = document.createElement("input"); //es para generar el input que vera el usuario, innecesario en la pratica pero le ayuda al user
                        const nombre_nuevo_campo = document.createElement("input"); //Es para insertar el nombre del nuevo input, que repetitivo es esto :p
                        const descripcion_nuevo_campo = document.createElement("textarea");
                        descripcion_nuevo_campo.classList.add("form-control", "form-control-sm", "mb-1", "no-drop", "w-100"); 
                        descripcion_nuevo_campo.placeholder = "Insertar Descripción";
                        descripcion_nuevo_campo.name = "descripcion";   
                        descripcion_nuevo_campo.setAttribute("form", "promedio_container");
                        descripcion_nuevo_campo.required = true;

                        nombre_nuevo_campo.classList.add("form-control", "form-control-sm", "mb-1");
                        nombre_nuevo_campo.placeholder = "Insertar Nombre";
                        nombre_nuevo_campo.name = "nombre_nuevo";
                        nombre_nuevo_campo.required = true;
                        nombre_nuevo_campo.setAttribute("form", "promedio_container");
                        nombre_nuevo_campo.id = "{{$indicador->id}}";
                        nombre_nuevo_campo.type = "text";



                        input_vista_previa.classList.add("form-control", "no-drop");
                        input_vista_previa.name = "promedio";

                        let suma = 0; //se usa mas adelanta para sumar los valores de os inputs

                        //va recogiendo los datos de cada input y los va sumando
                        inputs_valores.shift(); //quita el input que trae el toker csrf de laravel


                        inputs_valores.forEach(input_valor => {
                            
                            if(input_valor.type != "hidden"){
                            
                                suma = Number(suma) + Number(input_valor.value);
                                
                            }

                        });


                        div_columna.innerHTML = "";
                        input_vista_previa.value = Number(suma) / (Number(inputs_valores.length)/2);
                        // input_vista_previa.disabled = true;
                        div_columna.appendChild(nombre_nuevo_campo);
                        div_columna.appendChild(input_vista_previa);
                        div_columna.appendChild(descripcion_nuevo_campo);
                        contenedor_vista_previa.appendChild(div_columna);

                    }
                }
            }

    </script>




@endsection
