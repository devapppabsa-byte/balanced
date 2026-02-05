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


<div class="container-fluid">
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
</div>




<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-12 col-xl-11">
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

        
                <!-- Departamentos Grid -->
            <div class="row g-4">
                @forelse ($objetivos as $objetivo)
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                        <div class="card border-0 shadow-sm h-100 ">
                            <div class="card-body p-4 d-flex flex-column">

                                <!-- Nombre del Departamento -->
                                <div class="flex-grow-1 mb-1 row">
                                    <div class="col-12">
                                        <h4 class="fw-bold mb-0 department-name text-truncate" data-mdb-tooltip-init title="{{ $objetivo->nombre }}" >
                                            <i class="fa-regular fa-eye me-2 text-primary"></i>
                                            {{ $objetivo->nombre }}
                                        </h4>
                                    </div> 
                                    <div class="col-12 text-center mt-3">
                                        <span class="text-center  fw-bold department-name p-2 mt-2 rounded">
                                            Ponderación {{ $objetivo->ponderacion }}%
                                        </span>
                                    </div>
                                    <hr>
                                    <div class="col-12 ">
                                        <span class="fw-bold">Indicadores:</span>
                                    </div>
                                    <div class="col-12">
                                        <div class="row">

                                            @php
                                                $indicadoresObjetivo = \App\Models\Indicador::where(
                                                    'id_objetivo_perspectiva',
                                                    $objetivo->id
                                                )->get();

                                                $suma=0;
                                            @endphp

                                            @forelse($indicadoresObjetivo as $indicador)

                                                    <div class="col-12 my-2">
                                                        <div class="p-2 rounded shadow-sm border border-2 bg-white indicador-card">

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
                                                            </div>
                                                            <hr>
                                                            <!-- Info secundaria -->
                                                            <div class="d-flex gap-3 mt-1 flex-wrap text-muted" style="font-size: 13px;">

                                                                <span>
                                                                    <i class="fa-solid fa-percent me-1"></i>
                                                                    {{ $indicador->ponderacion }}%
                                                                </span>

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
                                                                    Promedio: 
                                                                    @if (!empty($array_datos))
                                                                       <span class="fw-bold">
                                                                            {{  round(array_sum($array_datos) / count($array_datos), 4)   }}%
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
                                                                    {{ round(($indicador->ponderacion_indicador * round(array_sum($array_datos) / count($array_datos), 4)) / 100, 4) }}%
                                                                    @php
                                                                        $suma = $suma + round(($indicador->ponderacion_indicador * round(array_sum($array_datos) / count($array_datos), 4)) / 100, 4);
                                                                    @endphp
                                                                </span>
                                                                @else
                                                                    <span class="fw-bold">0</span>
                                                                @endif

                                                            </div>

                                                        </div>

                                                    </div>





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
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0 py-3">
                    <h5 class="modal-title fw-bold" id="agregarDepartamentoLabel">
                        <i class="fa-solid fa-plus-circle me-2"></i>
                        Indicadores Disponibles
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form action="{{ route('add.indicador.objetivo', $objetivo->id) }}" method="POST">
                        @csrf

                        <div class="row justify-content-center">

                            @forelse ($indicadores as $indicador)
                                <div class="col-9 border my-2 mx-1 py-2 rounded indicador-item">

                                    <label for="indicador{{ $indicador->id }}"
                                        class="form-check w-100 indicador-label"
                                        style="cursor: pointer;">

                                        <input class="form-check-input me-2 indicador-checkbox" type="checkbox" name="indicadores[]" value="{{ $indicador->id }}" id="indicador{{ $indicador->id }}"
                                            {{ $indicador->id_objetivo_perspectiva != null ? 'disabled' : '' }}>

                                        {{-- //quiero ordenar estos datos --}}
                                        <span style="font-size: 14px">
                                            {{ $indicador->nombre }} (ID: {{ $indicador->id }})

                                            @if($indicador->id_objetivo_perspectiva != null)
                                                <span class="badge bg-danger ms-2">
                                                    Ocupado
                                                </span>
                                            @else
                                                <span class="badge bg-success ms-2">
                                                    Disponible
                                                </span>
                                            @endif
                                        </span>
                                        {{-- //quiero ordenar estos datos --}}


                                    </label>

                                </div>


                            @empty

                                <div class="col-12 text-center">
                                    No hay indicadores
                                </div>

                            @endforelse

                        </div>

                        <div class="text-center mt-4">
                            <button type="submit" class="btn btn-primary">
                                Guardar selección
                            </button>
                        </div>

                    </form>


                    

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

@endsection

