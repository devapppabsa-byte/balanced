@extends('plantilla')
@section('title', 'Inidcador')


@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center">
        <div class="col-auto pt-2 text-white">

            <h3 class="mt-1 league-spartan mb-0">
                {{$indicador->nombre}}
            </h3>
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

        <div class="col-3 col-sm-4 col-md-3 col-lg-auto m-1">
            <button class="btn btn-secondary btn-sm w-100"
            data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalCampos">
                <i class="fa fa-plus-circle mx-2"></i>
                 Campos Vacios
            </button>
        </div>


        <div class="col-3 col-sm-3 col-md-3 col-lg-auto m-1">
            <button class="btn btn-secondary btn-sm w-100"
            data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalCamposPrecargados">
                <i class="fa fa-plus-circle mx-2"></i>
                 Precargados
            </button>
        </div>

        <div class="col-3 col-sm-3 col-md-3 col-lg-auto m-1">
            <button class="btn btn-primary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalPromediarCampos">
              <i class="fa-solid fa-scale-balanced"></i>
                Promedio
            </button>
        </div>

        <div class="col-3 col-sm-3 col-md-3 col-lg-auto m-1">
             <button class="btn btn-primary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalDividirCampos">
               <i class="fa-solid fa-divide fw-bold"></i>
                 División
             </button>
         </div>

        <div class="col-3 col-sm-3 col-md-3 col-lg-auto m-1">
            <button class="btn btn-primary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalSumarCampos">
              <i class="fa-solid fa-plus fw-bold"></i>
                Suma
            </button>
        </div>

        <div class="col-3 col-sm-3 col-md-3 col-lg-auto m-1">
            <button class="btn btn-primary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalRestarCampos">
              <i class="fa-solid fa-minus fw-bold"></i>
                Resta
            </button>
        </div>


        <div class="col-3 col-sm-4 col-md-3 col-lg-auto m-1">
            <button class="btn btn-primary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalMultiplicarCampos">
                <i class="fa-solid fa-square-xmark"></i>
                Multiplicación
            </button>
        </div>

        <div class="col-3 col-sm-4 col-md-3 col-lg-auto m-1">
            <button class="btn btn-primary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#modalPorcentajeCampos">
                <i class="fa-solid fa-square-xmark"></i>
                Porcentaje
            </button>
        </div>


    </div>
</div>



<div class="container-fluid shadow">
    <div class="row justify-content-around mt-4 mx-2 bg-white pb-5 pt-2 rounded px-4">
        <div class="col-9 text-center my-3">
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
                            <th scope="col">Descripción</th>
                            <th scope="col">Acciones</th>
                        </thead>
                        <tbody class="" id="contenedor">
                            @forelse ($campos_unidos as $campo)

                                <tr>
                                    <td>{{$campo->id}}</td>
                                    <td>{{$campo->nombre}}</td>
                                    <td>{{($campo->tipo) ? $campo->tipo : $campo->tipo_dato}}</td>
                                    <td>{!!($campo->descripcion) ? $campo->descripcion : ' <i class="fa fa-info-circle text-primary"></i> No hay descripción disponible'!!}</td>
                                    <td>
                                        <buttton class="btn btn-danger btn-control-sm py-2 px-3" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del{{$campo->id_input}}">
                                            <i class="fa fa-trash"></i>
                                        </buttton>
                                    </td>
                                </tr>
                                
                            @empty
                                
                            @endforelse
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




{{-- modales de los campos calculados --}}
<div class="modal fade" id="modalPorcentajeCampos" tabindex="-1"  aria-labelledby="sdsad" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary py-3">
                <h3 class="text-white" id="exampleModalLabel">
                <i class="fa-solid fa-gauge-simple"></i>
                   Selecciona los datos que se van a comparar para sacar el porcentaje.
                </h3>
                <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body p-2">

                <div class="row pb-5 px-2 bg-light border m-3"  id="calculados_container_promedio" ondrop="drop(event)" ondragover="allowDrop(event)">
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

                <div class="form-group mt-3 mx-4 no-drop">
                    <div class="form-outline no-drop" data-mdb-input-init>
                        <input type="text" class="form-control form-control-lg no-drop {{ $errors->first('nombre') ? 'is-invalid' : '' }}" form="promedio_container" name="nombre">
                        <label class="form-label" for="nombre" >Nombre nuevo campo </label>
                    </div>
                </div>

                <form action="{{route("input.promedio.guardar", $indicador->id)}}"  autocomplete="off" method="POST" class="row  m-3  destino  bg-light  pb-5 p-3" ondrop="drop(event)" ondragover="allowDrop(event)" id="promedio_container">
                    @csrf
                    <h6 class="no-drop" id="letrero_promedio" style="z-index: 1"> Arrastra los campos a promediar </h6>


                    
                </form>
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

                <div class="row pb-5 px-2 bg-light border m-3"  id="calculados_container_promedio" ondrop="drop(event)" ondragover="allowDrop(event)">
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

                <div class="form-group mt-3 mx-4 no-drop">
                    <div class="form-outline no-drop" data-mdb-input-init>
                        <input type="text" class="form-control form-control-lg no-drop {{ $errors->first('nombre') ? 'is-invalid' : '' }}" form="promedio_container" name="nombre">
                        <label class="form-label" for="nombre" >Nombre nuevo campo </label>
                    </div>
                </div>

                <form action="{{route("input.promedio.guardar", $indicador->id)}}"  autocomplete="off" method="POST" class="row  m-3  destino  bg-light  pb-5 p-3" ondrop="drop(event)" ondragover="allowDrop(event)" id="promedio_container">
                    @csrf
                    <h6 class="no-drop" id="letrero_promedio" style="z-index: 1"> Arrastra los campos a promediar </h6>


                    
                </form>
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

                <div class="row pb-5 px-2 bg-light border m-3"  ondrop="drop(event)" ondragover="allowDrop(event)">
                    <div class="col-12 no-drop m-2">
                        <h6 class="no-drop">Campos Disponibles</h6>
                    </div>

                    @forelse ($campos_unidos as $campo_unido)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3 border no-drop bg-white" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStart(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_resta[]" value="{{$campo_unido->id_input}}">
                        </div>
                    @empty
                        
                    @endforelse
                   

                </div>

                <div class="row m-3 justify-content-around">
                    
                    <div class="row mx-2 bg-light pb-5 border" id="minuendo_container" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <h6 class="">Minuendo</h6>
                    </div>

                    <div class="row mx-2 bg-light pb-5 mt-1 border" id="sustraendo_container" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <h6 class="">Sustraendo</h6>
                    </div>
                    
                </div>


                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" form="promedio_container" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Campo Final</label>
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

                <form action="# autocomplete="off" method="POST" class="row  m-3  destino  bg-light  pb-5 border-dashed" ondrop="drop(event)" ondragover="allowDrop(event)" id="promedio_container">
                    @csrf
                    <h6 class="no-drop" style="z-index: 1"> Arrastra los campos a multiplicar </h6>
                </form>

                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" form="promedio_container" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Campo Final</label>
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
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 py-4 border no-drop bg-white" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStart(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_promedio[]" value="{{$campo_unido->id_input}}">
                        </div>
                    @empty
                        
                    @endforelse


                </div>

                <div class="row m-3 justify-content-around border-dashed">
                    
                    <div class="col-12 bg-light border pb-5" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <h6 class="">Divisor</h6>
                    </div>
                    <div class="col-12 bg-light border pb-5" ondrop="drop(event)" ondragover="allowDrop(event)">
                        <h6 class="">Dividendo</h6>
                    </div>
                    
                </div>


                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" form="promedio_container" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Campo Final</label>
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

                <form action="#" autocomplete="off" method="POST" class="row  m-3  destino  bg-light  pb-5 border-dashed" ondrop="drop(event)" ondragover="allowDrop(event)" id="suma_container">
                    @csrf
                    <h6 class="no-drop" style="z-index: 1"> Arrastra los campos a sumar. </h6>
                </form>


                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" form="promedio_container" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Campo Final</label>
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


{{-- modales de los campos calculados --}}















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






@forelse ($campos_unidos as $campo)

<div class="modal fade" id="del{{$campo->id_input}}" tabindex="-1"  aria-labelledby="exampleMddodalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-danger py-4">
            <h3 class="text-white" id="exampleModalLabel">¿Eliminar a {{$campo->nombre}} ?</h3>
            <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-4">

            <form action="{{route('eliminar.campo', $campo->id)}}" method="POST">
                @csrf @method('DELETE')

                <div class="form-group">
                    <input type="text" name="id_input" value="{{$campo->id_input}}" >
                    <input type="text" name="campo_vacio" value="{{$campo->tipo}}">
                    <input type="text" name="campo_precargado" value="{{$campo->informacion_precargada}}">
                    <input type="text" name="campo_calculado" value="{{$campo->operacion}}">
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

{{-- Me mamecon esto, iba a importar todo el JS en u archivo, pero resulta que estoy mandando una variable de backend a este archivo de blade,
asi que puse el aterrizado de la variable arriba del codigo del promedio. --}}
<script>
    const campos_para_operaciones = @json($campos_unidos);
    //const calculados_container = document.getElementById("calculados_container_promedio");
</script>
<script src="{{asset('js/drop_promedio.js')}}"></script>
<script src="{{asset('js/drop_resta.js')}}"></script>















@endsection
