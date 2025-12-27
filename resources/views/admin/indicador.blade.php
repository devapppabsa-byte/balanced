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
                            <th scope="col">Descripción</th>
                            <th scope="col">Autor</th>
                            <th scope="col">Acciones</th>
                        </thead>
                        <tbody class="" id="contenedor">
                            @forelse ($campos_unidos as $campo)

                                <tr>
                                    <td>{{$campo->id}}</td>
                                    <td>{{$campo->nombre}}</td>
                                    <td>{!!($campo->descripcion) ? $campo->descripcion : ' <i class="fa fa-info-circle text-primary"></i> No hay descripción disponible'!!}</td>

                                    <td class="fw-bold">
                                        <i class="fa fa-pencil"></i>
                                        {{$campo->autor}}
                                    </td>

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
                <div class="row pb-5 px-2 bg-light border m-3 no-drop"  id="calculados_container_promedio" ondrop="dropPromedio(event)" ondragover="allowDropPromedio(event)">
                    <div class="col-12 no-drop m-2">
                        <h6 class"no-drop">Campos Disponibles</h6>
                    </div>

                    @forelse ($campos_unidos as $campo_unido)

                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3 border no-drop bg-white" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStartPromedio(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_promedio[]" value="{{$campo_unido->id_input}}">
                        </div>

                    @empty
                        
                    @endforelse
                </div>

                <hr>

                <div class="form-group mt-5 mx-4 no-drop">
                    <h4>Datos Nuevo Campo</h4>

        
                    <div class="form-outline no-drop" data-mdb-input-init>
                        <input type="text" id="nombre_campo_promedio" class="form-control form-control-lg no-drop w-100 {{ $errors->first('nombre') ? 'is-invalid' : '' }}" form="promedio_container" name="nombre" required>
                        <label class="form-label" for="nombre_campo_promedio" >Nombre nuevo campo </label>
                    </div>


                    <div class="form-outline no-drop mt-3" data-mdb-input-init>
                        <textarea class="w-100 form-control" id="descripcion_promedio" name="descripcion" form="promedio_container" required></textarea>
                        <label class="form-label" for="descripcion_promedio">Descripción del campo</label>
                    </div>
                    
                </div>


                <form action="{{route("input.promedio.guardar", $indicador->id)}}"  autocomplete="off" method="POST" class="row  m-3  destino  bg-light  pb-5 p-3" ondrop="dropPromedio(event)" ondragover="allowDropPromedio(event)" id="promedio_container">
                    @csrf
                    <h6 class="no-drop" id="letrero_promedio" style="z-index: 1"> Arrastra los campos a promediar </h6>
                </form>



                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg"  type="checkbox" name="resultado_final" id="resultado_final" />
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

                <div class="row pb-5 px-2 bg-light border m-3 no-drop"  ondrop="dropMultiplicacion(event)" ondragover="allowDropMultiplicacion(event)">
                    <div class="col-12 no-drop my-2">
                        <h4 class="no-drop">Campos Disponibles</h4>
                    </div>

                    @forelse ($campos_unidos as $campo_unido)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3 border no-drop bg-white m-1" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStartMultiplicacion(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_multiplicado[]" value="{{$campo_unido->id_input}}">
                        </div>
                    @empty
                        
                    @endforelse
                </div>

                <hr>

                <div class="form-group mt-5 mx-4 no-drop">

                    <h4>Datos Nuevo Campo</h4>
                    <div class="form-outline no-drop" data-mdb-input-init>
                        <input type="text" id="nombre_campo_multiplicacion" class="form-control form-control-lg no-drop {{ $errors->first('nombre_campo_multiplicacion') ? 'is-invalid' : '' }}" form="multiplicacion_container" name="nombre_campo_multiplicacion">
                        <label class="form-label" for="nombre_campo_multiplicacion" >Nombre nuevo campo </label>
                    </div>
                    <div class="form-outline no-drop mt-3" data-mdb-input-init>
                        <textarea class="w-100 form-control" id="descripcion_multiplicacion" name="descripcion" form="multiplicacion_container" id=""></textarea>
                        <label class="form-label" for="descripcion_multiplicacion">Descripción del campo</label>
                    </div>


                </div>


                <form action="{{route('input.multiplicacion.guardar', $indicador->id)}}" id="multiplicacion_container" autocomplete="off" method="POST" class="row justify-content-center m-3  destino  bg-light  pb-5" ondrop="dropMultiplicacion(event)" ondragover="allowDropMultiplicacion(event)">
                    @csrf
                    <h6 class="no-drop" id="letrero_multiplicacion" style="z-index: 1"> Arrastra los campos a multiplicar </h6>
                    <br class="no-drop">
                </form>

                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" type="checkbox" name="resultado_final" id="resultado_final" form="multiplicacion_container" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Campo Final</label>
                        </div>

                        <button  class="btn btn-primary"  form="multiplicacion_container"> {{-- id="crear_campo_promedio" --}}
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

                <div class="row pb-5 px-2 bg-light border m-3"  id="calculados_container_suma" ondrop="dropSuma(event)" ondragover="allowDropSuma(event)">
                    <div class="col-12 no-drop m-2">
                        <h6 class="no-drop">Campos Disponibles</h6>
                    </div>

                    @forelse ($campos_unidos as $campo_unido)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3 border no-drop bg-white" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStartSuma(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_suma[]" value="{{$campo_unido->id_input}}">
                        </div>
                    @empty
                        
                    @endforelse
                </div>


                <div class="form-group mt-5 mx-4 no-drop">
                    <h4>Datos Nuevo Campo</h4>

        
                    <div class="form-outline no-drop" data-mdb-input-init>
                        <input type="text" id="nombre_campo_suma" class="form-control form-control-lg no-drop w-100 {{ $errors->first('nombre_campo_suma') ? 'is-invalid' : '' }}" form="suma_container" name="nombre_campo_suma">
                        <label class="form-label" for="nombre_campo_suma" >Nombre nuevo campo </label>
                    </div>


                    <div class="form-outline no-drop mt-3" data-mdb-input-init>
                        <textarea class="w-100 form-control" id="descripcion_suma" name="descripcion" form="suma_container"></textarea>
                        <label class="form-label" for="descripcion_suma">Descripción del campo</label>
                    </div>
                    
                </div>

                <form action="{{route('input.suma.guardar', $indicador->id)}}" autocomplete="off" id="suma_container" method="POST" class="row  m-3  destino  bg-light  pb-5 border-dashed" ondrop="dropSuma(event)" ondragover="allowDropSuma(event)" id="suma_container">
                    @csrf
                    <h6 class="no-drop" id="letrero_suma" style="z-index: 1"> Arrastra los campos a sumar. </h6>
                </form>


                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" form="suma_container" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Campo Final</label>
                        </div>

                        <button  class="btn btn-primary" form="suma_container" > {{-- id="crear_campo_promedio" --}}
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

                <div class="row pb-5 px-2 bg-light border m-3 justify-content-center"  id="calculados_container">
                    
                <div class="col-12 no-drop m-2">
                    <h6 class="no-drop">Campos Disponibles</h6>
                </div>



                @forelse ($campos_unidos as $campo_unido)
                    <div class="col-12 col-sm-12 col-md-4 col-lg-3 py-4 px-3 m-1 border no-drop bg-white" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStartDivision(event)">
                        <label class="no-drop">{{ $campo_unido->nombre }}</label>
                        <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_division[]" value="{{$campo_unido->id_input}}">
                    </div>
                @empty
                    
                @endforelse


                </div>

                <div class="form-group mt-5 mx-4 no-drop">
                    <h4>Datos Nuevo Campo</h4>

        
                    <div class="form-outline no-drop" data-mdb-input-init>
                        <input type="text" id="nombre_campo_division" class="form-control form-control-lg no-drop w-100 {{ $errors->first('nombre_campo_division') ? 'is-invalid' : '' }}" form="division_container" name="nombre_campo_division">
                        <label class="form-label" for="nombre_campo_division" >Nombre nuevo campo </label>
                    </div>


                    <div class="form-outline no-drop mt-3" data-mdb-input-init>
                        <textarea class="w-100 form-control" id="descripcion_division" name="descripcion" form="division_container"></textarea>
                        <label class="form-label" for="descripcion_division">Descripción del campo</label>
                    </div>
                    
                </div>

                <form action="{{route('input.division.guardar', $indicador->id)}}" method="POST" class="row m-3 justify-content-center " id="division_container">
                    @csrf

                    <h6 class="my-0 no-drop">Divisor</h6>
                    
                    <div class="col-12 bg-light border pb-5 mb-3 text-center" ondrop="dropDivision(event)" ondragover="allowDropDivision(event)" id="divisor_container">
                    </div>
                    
                    <h6 class="my-0 no-drop">Dividendo</h6>
                    <div class="col-12 bg-light border pb-5 mb-3 text-center" ondrop="dropDivision(event)" ondragover="allowDropDivision(event)" id="dividendo_container">
                    </div>
                    
                </form>


                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg" form="division_container" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Campo Final</label>
                        </div>

                        <button  class="btn btn-primary" form="division_container">
                            Crear Campo Promedio
                        </button>
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

                <div class="row pb-5 px-2 bg-light border m-3" >
                    <div class="col-12 no-drop m-2">
                        <h6 class="no-drop">Campos Disponibles</h6>
                    </div>

                    @forelse ($campos_unidos as $campo_unido)
                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3 border no-drop bg-white my-1" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStartResta(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_resta[]" value="{{$campo_unido->id_input}}">
                        </div>
                    @empty
                        
                    @endforelse
                   
                </div>

                <div class="form-group mt-5 mx-4 no-drop">
                    <h4>Datos Nuevo Campo</h4>

        
                    <div class="form-outline no-drop" data-mdb-input-init>
                        <input type="text" id="nombre_campo_resta" class="form-control form-control-lg no-drop w-100 {{ $errors->first('nombre_campo_resta') ? 'is-invalid' : '' }}" form="resta_container" name="nombre_campo_resta">
                        <label class="form-label" for="nombre_campo_resta" >Nombre nuevo campo </label>
                    </div>


                    <div class="form-outline no-drop mt-3" data-mdb-input-init>
                        <textarea class="w-100 form-control" id="descripcion_resta" name="descripcion" form="resta_container"></textarea>
                        <label class="form-label" for="resta_division">Descripción del campo</label>
                    </div>
                    
                </div>

                <form action="{{route('input.resta.guardar', $indicador->id)}}" method="POST" id="resta_container" class="row m-3 justify-content-around">
                    @csrf
                    
                    <h6 class="my-0">Minuendo</h6>
                    <div class="row mx-2 bg-light pb-5 border" id="minuendo_container" ondrop="dropResta(event)" ondragover="allowDropResta(event)" id="minuendo_container">
                    </div>
                    
                    <h6 class="my-0">Sustraendo</h6>
                    <div class="row mx-2 bg-light pb-5 mt-1 border" id="sustraendo_container" ondrop="dropResta(event)" ondragover="allowDropResta(event)" id="sustraendo_container">
                    </div>
                    
                </form>


                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input form="resta_container" class="form-check-input form-check-input-lg" type="checkbox" name="resultado_final" id="resultado_final" />
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Campo Final</label>
                        </div>

                        <button form="resta_container"  class="btn btn-primary" >
                            Crear Campo Promedio
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>




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

                <div class="row pb-5 px-2 bg-light border m-3 no-drop"  id="calculados_container_porcentaje" ondrop="dropPorcentaje(event)" ondragover="allowDropPorcentaje(event)">
                    <div class="col-12 no-drop m-2">
                        <h6 class"no-drop">Campos Disponibles</h6>
                    </div>

                    @forelse ($campos_unidos as $campo_unido)

                        <div class="col-12 col-sm-12 col-md-4 col-lg-3 p-3 border no-drop bg-white" draggable="true" id="{{$campo_unido->id_input}}" ondragstart="dragStartPorcentaje(event)">
                            <label class="no-drop">{{ $campo_unido->nombre }}</label>
                            <input class="form-control form-control-sm no-drop" placeholder="{{ $campo_unido->nombre }}" id="{{$campo_unido->id_input}}" disabled type="{{ $campo_unido->tipo_dato }}"><input type="hidden" name="input_porcentaje[]" value="{{$campo_unido->id_input}}">
                        </div>

                    @empty
                        
                    @endforelse
                </div>
            

                <div class="form-group mt-5 mx-4 no-drop">
                    <h4>Datos Nuevo Campo</h4>

        
                    <div class="form-outline no-drop" data-mdb-input-init>
                        <input type="text" id="nombre_campo_porcentaje" class="form-control form-control-lg no-drop w-100 {{ $errors->first('nombre_campo_porcentaje') ? 'is-invalid' : '' }}" form="porcentaje_container" name="nombre">
                        <label class="form-label" for="nombre_campo_porcentaje" >Nombre nuevo campo </label>
                    </div>


                    <div class="form-outline no-drop mt-3" data-mdb-input-init>
                        <textarea class="w-100 form-control" id="descripcion_porcentaje" name="descripcion" form="porcentaje_container"></textarea>
                        <label class="form-label" for="descripcion_porcentaje">Descripción del campo</label>
                    </div>
                    
                </div>
                


                <form action="{{route('input.porcentaje.guardar', $indicador->id)}}" method="POST" id="porcentaje_container" class="row m-3 justify-content-around">
                    @csrf
                    
                    <h6 class="my-0">Parte (Cantidad a comparar)</h6>
                    <div class="row mx-2 bg-light p-3 pb-5 border" ondrop="dropPorcentaje(event)" ondragover="allowDropPorcentaje(event)" id="parte_container">
                    </div>
                    
                    <h6 class="my-0">Total (Cantidad sobre la que se va a comparar)</h6>
                    <div class="row mx-2 bg-light p-3 pb-5 mt-1 border" ondrop="dropPorcentaje(event)" ondragover="allowDropPorcentaje(event)" id="total_container">
                    </div>
                    
                </form>


                <div class="modal-footer">
                    <div class="btn-group shadow-0 gap-3 d-flex align-item-center">

                        <div class="form-check mt-2">
                            <input class="form-check-input form-check-input-lg"  type="checkbox" name="resultado_final" id="resultado_final" form="porcentaje_container"/>
                            <label class="form-check-label text-danger fw-bold" for="resultado_final">Resultado Final</label>
                        </div>

                        <button  class="btn btn-primary" form="porcentaje_container" > {{-- id="crear_campo_promedio" --}}
                            Crear Campo Porcentaje
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
                        @foreach ($informacion_foranea as $informacion)
                        
                            <option value="{{$informacion->id_input}}|{{$informacion->id}}|{{$informacion->nombre}}|{{$informacion->descripcion}}">                   
                                {{$informacion->nombre}}
                            </option>

                        @endforeach
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

                    <div class="col-12 ">
                        <div class="form-group mt-3">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="text" class="form-control form-control-lg w-100" id="nombre_campo_vacio" name="nombre_campo_vacio" required>
                                <label class="form-label" for="nombre_campo_vacio" >Nombre </label>
                            </div>
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
                    <input type="hidden" name="id_input" value="{{$campo->id_input}}" >
                    <input type="hidden" name="campo_vacio" value="{{$campo->tipo}}">
                    <input type="hidden" name="campo_precargado" value="{{$campo->id_input_foraneo}}">
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

{{-- Me mamecon esto, iba a importar todo el JS en u archivo, pero resulta que estoy mandando una variable de backend a este archivo de blade,
asi que puse el aterrizado de la variable arriba del codigo del promedio. --}}
<script>
    const campos_para_operaciones = @json($campos_unidos);
    //const calculados_container = document.getElementById("calculados_container_promedio");
</script>

{{-- <script src="{{asset('js/drop.js')}}"></script> --}}
<script src="{{asset('js/drop_promedio.js')}}" ></script>
<script src="{{asset('js/drop_division.js')}}"></script>
<script src="{{asset('js/drop_resta.js')}}"></script>
<script src="{{asset('js/drop_suma.js')}}"></script>
<script src="{{asset('js/drop_porcentaje.js')}}"></script>
<script src="{{asset('js/drop_multiplicacion.js')}}" ></script>

@endsection
