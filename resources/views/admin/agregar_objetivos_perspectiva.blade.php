@extends('plantilla')
@section('title', 'Perspectivas')
@section('contenido')
<style>
    .department-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    
    .department-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
    }
    
    .department-name {
        transition: color 0.2s ease;
    }
    
    .department-name:hover {
        color: var(--bs-primary) !important;
    }
    
    .badge {
        font-size: 0.75rem;
        padding: 0.4rem 0.75rem;
    }
    
    @media (max-width: 768px) {
        .department-card {
            margin-bottom: 1rem;
        }
    }
</style>


<div class="container-fluid sticky-top">
    <div class="row bg-primary  d-flex align-items-center">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  pt-2 text-white">
            <h3 class="mt-1 mb-0 league-spartan">Objetivos</h3>
            @if (session('success'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('success')}}
                </div>
            @endif
            @if (session('editado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('editado')}}
                </div>
            @endif

            @if (session('eliminado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('eliminado')}}
                </div>
            @endif
        
            @if (session('encuesta_eliminada'))
                <div class="text-danger fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('encuesta_eliminada')}}
                </div>
            @endif
            @if ($errors->any())
                <div class="text-white fw-bold bad_notifications">
                    <i class="fa fa-xmark-circle mx-2"></i>
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
            <!-- Header Card -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="d-flex align-items-center justify-content-between flex-wrap">
                        <div>
                            <h2 class="mb-1 fw-bold">
                                <i class="fa-solid fa-eye text-primary me-2"></i>
                                Objetivos
                            </h2>
                            <p class="text-muted mb-0">
                                <small>Se calcula el cumplimiento total de la empresa dividido en perspectivas.</small>
                            </p>
                        </div>
                        <div class="mt-2 mt-md-0">
                            <button class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_objetivo">
                                <i class="fa-solid fa-plus-circle me-2"></i>
                                Agregar Objetivos
                            </button>
                        </div>
                    </div>
                </div>
            </div>

    </div>


</div>




<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
                <!-- Departamentos Grid -->
            <div class="row g-4">
                @forelse ($objetivos as $objetivo)

                    @php
                        $indicadoresObjetivo = \App\Models\Indicador::where(
                            'id_objetivo_perspectiva',
                            $objetivo->id
                        )->get();

                        $suma=0;
                        $suma_ponderacion=0;
                    @endphp

                    {{-- Todo esto para poder sacar la suma de las ponderaciones --}}
                    @forelse($indicadoresObjetivo as $indicador_ponderacion)
                        @php
                            $suma_ponderacion = $suma_ponderacion + $indicador_ponderacion->ponderacion_indicador;
                        @endphp
                    @empty
                    @endforelse

                <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12  ">
                    <div class="card border-0 shadow-sm h-100 bg-light ">
                        <div class="card-body p-4 d-flex flex-column">

                            <!-- Nombre del Departamento -->
                            <div class="flex-grow-1 mb-1 row">
                                <div class="col-12">
                                    <h4 class="fw-bold mb-0 department-name text-truncate" data-mdb-tooltip-init title="{{ $objetivo->nombre }}" >
                                        {{ $objetivo->nombre }}
                                    </h4>
                                    <h5 class="text-primary">
                                        Ponderación en la Perspectiva:  <span class="fw-bold">{{ $objetivo->ponderacion }} %</span> 
                                    </h5>
                                    <h6 class=" badge badge-lg {{ ($suma_ponderacion === 100) ? 'badge-success' : 'badge-danger' }}">
                                      <i class="fa fa-exclamation-circle"></i>  Suma de las ponderaciones:  <span class="fw-bold">{{ $suma_ponderacion }} %</span> 
                                    </h6>
                                </div>
                                <hr>
                                <div class="col-12 ">
                                    <span class=" bungee-regular text-muted">Indicadores:</span>
                                </div>
                                <div class="col-12">
                                    <div class="row">


                                    
                                        @forelse($indicadoresObjetivo as $indicador)

                                                <div class="col-11 col-sm-11 col-md-4 col-lg-5 col-xl-5 my-2 p-2 m-1 rounded shadow-sm border border-2  indicador-card">

                                                    
                                                        <!-- Nombre -->
                                                        <div class="fw-bold text-truncate" style="font-size: 14px;">
                                                                {{ $indicador->nombre }} 
                                                            @if(!is_null($indicador->ponderacion_indicador))
                                                                <span class="text-success">
                                                                    -  Ponderacion: 
                                                                    {{ $indicador->ponderacion_indicador }}%
                                                                </span>
                                                            @endif
                                                            <a class="text-primary mx-1" data-mdb-tooltip-init title="Agregar ponderacion al indicador" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#pon{{ $indicador->id }}">
                                                                <i class="fa fa-plus-circle"></i>
                                                            </a>
                                                            <a href="#" class="text-danger"></a>
                                                        </div>
                                                        <hr>
                                                        <!-- Info secundaria -->
                                                        <div class="d-flex gap-3 mt-1 flex-wrap text-muted" style="font-size: 13px;">

                                                            <span>
                                                                <i class="fa-solid fa-bullseye me-1"></i>
                                                        Meta: {{ $indicador->meta_esperada }}
                                                    </span>
                                                    
                                                    @php
                                                        $informacion_indicadores = \App\Models\IndicadorLleno::where('id_indicador', $indicador->id)->where('final', 'on')->get();
                                                        $array_datos = [];
                                                        foreach($informacion_indicadores as $informacion_indicador){

                                                            array_push($array_datos, $informacion_indicador->informacion_campo);
                                                        
                                                        }
                                                        
                                                    @endphp
                                                    <span>
                                                        <i class="fa-solid fa-gauge"></i>
                                                        Promedio Cumplimiento: 
                                                        @if (!empty($array_datos))
                                                            <span class="fw-bold">

                                                                @php
                                                                    $promedio_cumplimiento;    
                                                                @endphp
                                                                
                                                                @if ($indicador->tipo_indicador == "normal")
                                                                    {{-- esta mamada la puse por que se les ocurrio que de repente la meta esperrada ya no era 100, era menos, epro a veces is alcanzaban el 100 y el cumplimiento se iba al mas del 100% de cumplimiento por que meta_esperada era 90 o algo asi --}}
                                                                    @if ($indicador->unidad_medida == "porcentaje")
                                                                        {{ $promedio_cumplimiento = round ((array_sum($array_datos) / count($array_datos)), 2)  }} %
                                                                    @else
                                                                        {{ $promedio_cumplimiento = round((array_sum($array_datos) / (count($array_datos) / $indicador->meta_esperada)) * 100)   }} %
                                                                    @endif

                                                                @else

                                                                    @if($indicador->unidad_medida == "porcentaje")
                                                                        {{  $promedio_cumplimiento = (100 - round(array_sum($array_datos) / count($array_datos) , 2))   }} %
                                                                    @else
                                                                        {{ $promedio_cumplimiento =  round($indicador->meta_esperada / (array_sum($array_datos) / count($array_datos)) * 100, 2)   }} %
                                                                    @endif

                                                                @endif
                                                            </span>
                                                        
                                                        @else

                                                            <span class="fw-bold">0</span>
                                                        
                                                        @endif
                                                    </span>
                                                    <span>
                                                        <i class="fa-solid fa-right-left"></i>
                                                        Indicador vs Ponderación: 
                                                    </span>
                                                    @if (!empty($array_datos))
                                                    <span class="fw-bold">

                                                        {{($promedio_cumplimiento * $indicador->ponderacion_indicador) / 100}} %
                                                    
                                                        {{-- esto es para completar la suma del cumplimiento general --}}
                                                        @php
                                                            $suma = $suma + ($indicador->ponderacion_indicador * $promedio_cumplimiento) / 100;
                                                        @endphp

                                                        

                                                        </span>
                                                    @else
                                                        <span class="fw-bold">0</span>
                                                    @endif
                                                    
                                                </div>

                                                    

                                                </div>
{{-- 
                                                         
          
                                                        
            





                                    {{-- modales para la ponderacion --}}
                                            <div class="modal fade" id="pon{{ $indicador->id }}" tabindex="-1" aria-labelledby="agregarDepartamentoLabel" aria-hidden="true" data-mdb-backdrop="static">
                                                <div class="modal-dialog modal-sm modal-dialog-centered">
                                                    <div class="modal-content border-0 shadow-lg">
                                                        <div class="modal-header bg-primary text-white border-0 py-3">
                                                            <span class="modal-title fw-bold" id="agregarDepartamentoLabel">
                                                                <i class="fa-solid fa-plus-circle me-2"></i>
                                                                Agregar Ponderación
                                                            </span>
                                                            <button type="button" class="btn-close btn-close-white" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body py-4">
                                                            <form action="{{ route('agregar.ponderacion.indicador.objetivo', $indicador->id) }}" method="POST">
                                                                @csrf
                                                                <div class="form-outline" data-mdb-input-init>
                                                                    <input type="text" class="form-control" id="ponderacion_indicador" name="ponderacion_indicador" |value="{{old('ponderacion_indicador')}}"required>
                                                                    <label class="form-label" for="ponderacion_indicador">
                                                                        Ponderación:
                                                                        <span class="text-danger">*</span>
                                                                    </label>
                                                                    @if ($errors->first('ponderacion_indicador'))
                                                                        <div class="invalid-feedback">
                                                                            {{ $errors->first('ponderacion_indicador') }}
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                <div class="form-group mt-2">
                                                                    <button class="btn btn-primary btn-sm">
                                                                        Guardar
                                                                    </button>    
                                                                </div> 
                                                            </form>

                                                            
                                                            

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    {{-- modales para la ponderacion --}}

                                        @empty

                                            <div class="col-12 text-muted my-2">
                                                No tiene indicadores asignados.
                                            </div>

                                        @endforelse

                                    </div>
                                </div>

                            </div>



                            {{-- Aqui va el porcentaje de cumplimietno total --}}
                            <h6 class="text-center">Cumplimiento del objetivo: </h6>
                            <h2 class="text-center fw-bold">{{ $suma }}%</h2>


                            <!-- Acciones -->
                            <div class="d-flex justify-content-end align-items-center pt-2 border-top">
                                <div class="btn-group" role="group">

                                    <button class="btn btn-sm btn-outline-success text-capitalize" data-mdb-tooltip-init title="Agregr Indicador" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#add_in{{$objetivo->id}}">
                                        <i class="fa-solid fa-plus-circle"></i>
                                        Agregar Indicadores
                                    </button>
                                    <button class="btn btn-sm btn-outline-primary" data-mdb-tooltip-init title="Editar " data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#edit_ob{{$objetivo->id}}">
                                        <i class="fa-solid fa-edit"></i>
                                    </button>

                                    <button class="btn btn-sm btn-outline-danger" data-mdb-tooltip-init title="Eliminar" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del_ob{{$objetivo->id}}">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                @empty
            <!-- Empty State -->
                <div class="card border-0 shadow-sm">
                    <div class="card-body text-center py-5">
                        <div class="mb-4">
                            <i class="fa-solid fa-eye text-muted" style="font-size: 4rem; opacity: 0.3;"></i>
                        </div>
                        <h5 class="text-muted mb-2">No se han registrado objetivos.</h5>
                        <p class="text-muted mb-4">
                            <small>Comienza agregando tu primer objetivo a la perspectiva {{ $perspectiva->nombre }}.</small>
                        </p>
                        <button class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_objetivo">
                            <i class="fa-solid fa-plus-circle me-2"></i>
                            Agregar Objetivo
                        </button>
                    </div>
                </div>  
                @endforelse

            </div>

        </div>
    </div>
</div>







<div class="modal fade" id="agregar_objetivo" tabindex="-1" aria-labelledby="agregarDepartamentoLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="agregarDepartamentoLabel">
                    <i class="fa-solid fa-plus-circle me-2"></i>
                    Agregar Objetivo
                </h5>
                <button type="button" class="btn-close btn-close-white" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{ route('objetivo.store', $perspectiva->id) }}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="text" class="form-control {{ $errors->first('nombre_objetivo') ? 'is-invalid' : '' }}" id="nombre_objetivo" name="nombre_objetivo" |value="{{old('nombre_objetivo')}}"required>
                                <label class="form-label" for="nombre_objetivo">
                                    Objetivos
                                    <span class="text-danger">*</span>
                                </label>
                                @if ($errors->first('nombre_objetivo'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nombre_objetivo') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="number" min="1" max="100" class="form-control {{ $errors->first('ponderacion_objetivo') ? 'is-invalid' : '' }}" id="ponderacion_objetivo" name="ponderacion_objetivo" |value="{{old('ponderacion_objetivo')}}"required>
                                <label class="form-label" for="ponderacion_objetivo">
                                    Ponderación
                                    <span class="text-danger">*</span>
                                </label>
                                @if ($errors->first('ponderacion_objetivo'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('ponderacion_objetivo') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer border-0 pt-4">
                        <button type="button" class="btn btn-outline-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary" data-mdb-ripple-init>
                            <i class="fa-solid fa-save me-2"></i>
                            Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>








@foreach ($objetivos as $objetivo)


<div class="modal fade" id="add_in{{$objetivo->id}}" tabindex="-1" aria-labelledby="agregarDepartamentoLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-fullscreen modal-dialog-centered">
        <div class="modal-content">

            <!-- HEADER -->
            <div class="modal-header bg-primary py-4">
                <h3 class="text-white">
                    <i class="fa-solid fa-plus-circle me-2"></i>
                    Indicadores Disponibles
                </h3>
                <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
            </div>

            <!-- BODY -->
            <div class="modal-body py-4">

                <!-- (opcional) buscador -->
                <div class="row mb-4">
                    <div class="col-12">
                        <input type="search" id="buscadorIndicadores" class="form-control form-control-lg" placeholder="Buscar indicador...">
                    </div>
                </div>

                <form action="{{ route('add.indicador.objetivo', $objetivo->id) }}" method="POST" id="formIndicadores">
                    @csrf

                    <div class="row justify-content-around" id="contenedor_indicadores">

                        @forelse ($indicadores as $indicador)

                            <div class="col-3 m-1 p-3 item-indicador"
                                 data-nombre="{{ strtolower($indicador->nombre) }}">

                                <input type="checkbox"
                                    name="indicadores[]"
                                    value="{{ $indicador->id }}"
                                    class="btn-check"
                                    id="indicador{{ $indicador->id }}"
                                    autocomplete="off"
                                    {{ $indicador->id_objetivo_perspectiva != null ? 'disabled' : '' }}>

                                <label class="btn btn-outline-primary custom-check text-start w-100 h-100"
                                       for="indicador{{ $indicador->id }}">

                                    <!-- NOMBRE -->
                                    <div class="text-center  fw-bold">
                                         {{ $indicador->nombre }}  
                                    </div>
                                    <div class="text-  fw-bold">
                                         {{ $indicador->departamento->nombre }}
                                    </div>

                                    <!-- ID -->
                                    <div class="mb-2">
                                        @php
                                        $tipos = [
                                            "g" => "<i class='fa-solid fa-city'></i> Indicador General",
                                            "p" => "<i class='fa-solid fa-cow'></i> Pecuarios",
                                            "m" => "<i class='fa-solid fa-dog'></i> Mascotas",
                                        ];
                                        @endphp

                                        {!!  
                                            empty($indicador->planta)
                                                ? "<i class='fa-solid fa-circle-exclamation'></i> Sin asignación"
                                                : ($tipos[strtolower($indicador->planta)] 
                                                    ?? "<i class='fa-solid fa-industry'></i> Planta {$indicador->planta}")
                                        !!}
                                    </div>

                                    <!-- ESTADO -->
                                    <div>
                                        @if($indicador->id_objetivo_perspectiva != null)
                                            <span class="badge bg-danger w-100">
                                                <i class="fa-solid fa-circle-check"></i>
                                                Ya asignado
                                            </span>
                                        @else
                                            <span class="badge bg-success w-100">
                                                <i class="fa-regular fa-circle-check"></i>
                                                Disponible
                                            </span>
                                        @endif
                                    </div>

                                </label>

                            </div>

                        @empty
                            <div class="col-12 text-center">
                                No hay indicadores
                            </div>
                        @endforelse

                    </div>
                </form>

            </div>

            <!-- FOOTER -->
            <div class="modal-footer">
                <button form="formIndicadores" type="submit" class="btn btn-primary w-100 py-3">
                    <h6>Guardar selección</h6>
                </button>
            </div>

        </div>
    </div>
</div>




    <div class="modal fade" id="del_ob{{$objetivo->id}}" tabindex="-1" aria-labelledby="eliminarDepartamentoLabel{{$objetivo->id}}" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white border-0 py-3">
                    <h5 class="modal-title fw-bold" id="eliminarDepartamentoLabel{{$objetivo->id}}">
                        <i class="fa-solid fa-triangle-exclamation me-2"></i>
                        Confirmar Eliminación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <i class="fa-solid fa-trash text-danger" style="font-size: 3rem;"></i>
                        </div>
                        <h6 class="fw-semibold">¿Estás seguro de eliminar esta perspectiva?</h6>
                        <p class="text-muted mb-0">
                            <strong>{{$objetivo->nombre}}</strong>
                        </p>

                        <small class="text-muted d-block">
                            Esta acción no se puede deshacer.
                        </small>
                    </div>

                    <form action="{{route('objetivo.delete', $objetivo->id)}}" method="POST">
                        @csrf 
                        @method('DELETE')
                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-secondary flex-fill" data-mdb-ripple-init data-mdb-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-danger flex-fill" data-mdb-ripple-init>
                                <i class="fa-solid fa-trash me-2"></i>
                                Eliminar
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>      









    <div class="modal fade" id="edit_ob{{$objetivo->id}}" tabindex="-1" aria-labelledby="editarDepartamentoLabel{{$objetivo->id}}" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0 py-3">
                    <h5 class="modal-title fw-bold" id="editarDepartamentoLabel{{$objetivo->id}}">
                        <i class="fa-solid fa-edit me-2"></i>
                        Editar Objetivo
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form action="{{route('objetivo.update', $objetivo->id)}}" method="POST">
                        @csrf 
                        @method('PATCH')
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-outline" data-mdb-input-init>
                                    <input type="text"  class="form-control {{ $errors->first('nombre_objetivo_edit') ? 'is-invalid' : '' }}"  id="nombre_dep{{$objetivo->id}}"  name="nombre_objetivo_edit"  value="{{old('nombre_objetivo_edit', $objetivo->nombre)}}" required>
                                    <label class="form-label" for="nombre_edit{{$objetivo->id}}">
                                        Nombre Perspectiva
                                        <span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->first('nombre_objetivo_edit'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('nombre_objetivo_edit') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-outline" data-mdb-input-init>
                                    <input type="number" min="1" max="100"  class="form-control {{ $errors->first('ponderacion_objetivo_edit') ? 'is-invalid' : '' }}"  id="ponderacion{{$objetivo->id}}"  name="ponderacion_objetivo_edit"  value="{{old('ponderacion_objetivo_edit', $objetivo->ponderacion)}}" required>
                                        <label class="form-label" for="ponderacion{{$objetivo->id}}">
                                            Ponderación del Objetivo
                                            <span class="text-danger">*</span>
                                        </label>
                                        @if ($errors->first('ponderacion_objetivo_edit'))
                                            <div class="invalid-feedback">
                                                {{ $errors->first('ponderacion_objetivo_edit') }}
                                            </div>
                                        @endif
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-4">
                            <button type="button" class="btn btn-outline-secondary" data-mdb-ripple-init data-mdb-dismiss="modal">
                                Cancelar
                            </button>
                            <button type="submit" class="btn btn-primary" data-mdb-ripple-init>
                                <i class="fa-solid fa-save me-2"></i>
                                Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endforeach

@endsection


@section('scripts')
    
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Detectar click en cada indicador
        document.querySelectorAll(".indicador-item").forEach(item => {

            item.addEventListener("click", function (e) {

                let checkbox = item.querySelector(".indicador-checkbox");

                // Si está deshabilitado → mostrar toastr
                if (checkbox.disabled) {

                    e.preventDefault();

                    toastr.warning("Este indicador ya está ocupado y no se puede seleccionar.");

                }

            });

        });

});
</script>
<script>
document.getElementById('buscadorIndicadores')
.addEventListener('keyup', function () {

    let filtro = this.value.toLowerCase();
    let contenedores = document.querySelectorAll('.item-indicador');

    contenedores.forEach(function (contenedor) {

        let nombre = contenedor.dataset.nombre || '';

        if (nombre.includes(filtro)) {
            contenedor.style.display = "";
        } else {
            contenedor.style.display = "none";
        }

    });
});
</script>

@endsection

