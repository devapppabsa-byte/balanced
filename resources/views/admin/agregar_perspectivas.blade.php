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
            <h3 class="mt-1 mb-0 league-spartan">Perspectivas</h3>
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
                                Perspectivas
                            </h2>
                            <p class="text-muted mb-0">
                                <small>Se calcula el cumplimiento total de la empresa dividido en perspectivas.</small>
                            </p>
                        </div>
                        <div class="mt-2 mt-md-0">
                            <button class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_perspectiva">
                                <i class="fa-solid fa-plus-circle me-2"></i>
                                Agregar Perspectiva
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        
                <!-- Departamentos Grid -->
            <div class="row g-4">

                @php
                    $total_cumplimiento_perspectiva = 0;
                @endphp

                @forelse ($perspectivas as $perspectiva)
                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                        <div class="card border-0 shadow-sm h-100 department-card">
                            <div class="card-body p-4 d-flex flex-column">

                                <!-- Nombre del Departamento -->
                                <div class="flex-grow-1 mb-3">
                                    <a href="{{ route('detalle.perspectiva', $perspectiva->id) }}" 
                                        class="text-decoration-none text-dark">
                                        <h5 class="fw-bold mb-0 department-name">
                                            <i class="fa-regular fa-eye me-2 text-primary"></i>
                                            {{ $perspectiva->nombre }}   -   Ponderación: {{ $perspectiva->ponderacion }}%
                                        </h5>
                                    </a>
                                </div>

                                <!-- Botón Principal -->
                                <div class="my-4 text-center">
                                    <a href="{{ route('detalle.perspectiva', $perspectiva->id) }}"
                                        class=" w-100 fw-semibold">
                                        <i class="fa-solid fa-magnifying-glass me-2"></i>                                        
                                        Explorar Perspectiva
                                    </a>
                                </div>


                                <div class="row">



                                    @forelse ($perspectiva->objetivos as $objetivo)


                                        @php

                                            $indicadoresObjetivo = \App\Models\Indicador::where(
                                                'id_objetivo_perspectiva',
                                                $objetivo->id
                                            )->get();

                                            $suma_ponderacion = 0;                                            
                                        
                                        @endphp
                                        


                                        {{-- de aqui se esta mostrando el nombre del objetivo, el resultadoi esta mas abajo --}}

                                        <h5 class="league-spartan">
                                        {{ $objetivo->nombre }} :
                                        </h5>
                                        @forelse ($indicadoresObjetivo  as $indicador)
                                            {{-- //Aqui tengo que consultar la informacion del indicador lleno y sumarla
                                            //despues de sumarla la multiplico por la ponderacion que se le dio al
                                            //indicador dentro del objetivo y sumo todo para obtener el porcentaje general --}}


                                            {{-- Operaciones para realizar la suma de los resultados de cada indicador en el objetivo. --}}
                                            @php

                                              $suma_ponderacion = $suma_ponderacion +  ($objetivo->ponderacion * $indicador->ponderacion_indicador)/ 100
                                                
                                            @endphp
                                            
                                            
                                            @empty
                                            
                                            
                                            
                                            @endforelse
                                            
                                            <h4 class="fw-bold">{{ $suma_ponderacion }}%</h4>
                                            @php
                                                 $total_cumplimiento_perspectiva = $total_cumplimiento_perspectiva + $suma_ponderacion;
                                            @endphp

                                            <br>
                                    
                                    @empty

                                        <span class="text-muted text-center">No hay datos.</span>
                                        
                                    @endforelse

                                </div>



                                <h5 class="mt-5 fw-bold">
                                    Total cumplimiento del indicador:
                                </h5>
                                <h3 class="fw-bold">
                                    {{ $total_cumplimiento_perspectiva }}%
                                </h3>




                                <!-- Acciones -->
                                <div class="d-flex justify-content-end align-items-center pt-2 border-top">
                                    <div class="btn-group" role="group">
                                        <button class="btn btn-sm btn-outline-primary" data-mdb-tooltip-init title="Editar " data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#edit_pe{{$perspectiva->id}}">
                                            <i class="fa-solid fa-edit"></i>
                                        </button>

                                        <button class="btn btn-sm btn-outline-danger" data-mdb-tooltip-init title="Eliminar" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del_per{{$perspectiva->id}}">
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
                        <h5 class="text-muted mb-2">No se han registrado perspectivas.</h5>
                        <p class="text-muted mb-4">
                            <small>Comienza agregando tu primer perspectiva.</small>
                        </p>
                        <button class="btn btn-primary" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_perspectiva">
                            <i class="fa-solid fa-plus-circle me-2"></i>
                            Agregar Perspectiva
                        </button>
                    </div>
                </div>  
                @endforelse

            </div>

        </div>
    </div>
</div>





<div class="modal fade" id="agregar_perspectiva" tabindex="-1" aria-labelledby="agregarDepartamentoLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header bg-primary text-white border-0 py-3">
                <h5 class="modal-title fw-bold" id="agregarDepartamentoLabel">
                    <i class="fa-solid fa-plus-circle me-2"></i>
                    Agregar Perspectiva
                </h5>
                <button type="button" class="btn-close btn-close-white" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{ route('perspectiva.store') }}" method="post">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="text" class="form-control {{ $errors->first('nombre_perspectiva') ? 'is-invalid' : '' }}" id="nombre_perspectiva" name="nombre_perspectiva" |value="{{old('nombre_perspectiva')}}"required>
                                <label class="form-label" for="nombre_perspectiva">
                                    Perspectiva
                                    <span class="text-danger">*</span>
                                </label>
                                @if ($errors->first('nombre_perspectiva'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('nombre_perspectiva') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="number" min="1" max="100" class="form-control {{ $errors->first('ponderacion') ? 'is-invalid' : '' }}" id="ponderacion" name="ponderacion" |value="{{old('ponderacion')}}"required>
                                <label class="form-label" for="ponderacion">
                                    Ponderación
                                    <span class="text-danger">*</span>
                                </label>
                                @if ($errors->first('ponderacion'))
                                    <div class="invalid-feedback">
                                        {{ $errors->first('ponderacion') }}
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


{{-- aqui va a ir el ciclo de la edicion y eliminacion de las perspectivas --}}
@foreach ($perspectivas as $perspectiva)
    <div class="modal fade" id="del_per{{$perspectiva->id}}" tabindex="-1" aria-labelledby="eliminarDepartamentoLabel{{$perspectiva->id}}" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-danger text-white border-0 py-3">
                    <h5 class="modal-title fw-bold" id="eliminarDepartamentoLabel{{$perspectiva->id}}">
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
                            <strong>{{$perspectiva->nombre}}</strong>
                        </p>

                        <small class="text-muted d-block">
                            Esta acción no se puede deshacer.
                        </small>
                    </div>
                    <form action="{{route('eliminar.perspectiva', $perspectiva->id)}}" method="POST">
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




    <div class="modal fade" id="edit_pe{{$perspectiva->id}}" tabindex="-1" aria-labelledby="editarDepartamentoLabel{{$perspectiva->id}}" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white border-0 py-3">
                    <h5 class="modal-title fw-bold" id="editarDepartamentoLabel{{$perspectiva->id}}">
                        <i class="fa-solid fa-edit me-2"></i>
                        Editar Perspectiva
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form action="{{route('edit.perspectiva', $perspectiva->id)}}" method="POST">
                        @csrf 
                        @method('PATCH')
                        <div class="row g-3">
                            <div class="col-12">
                                <div class="form-outline" data-mdb-input-init>
                                    <input type="text"  class="form-control {{ $errors->first('nombre_departamento') ? 'is-invalid' : '' }}"  id="nombre_dep{{$perspectiva->id}}"  name="nombre_perspectiva"  value="{{old('nombre_perspectiva', $perspectiva->nombre)}}" required>
                                    <label class="form-label" for="nombre_pers{{$perspectiva->id}}">
                                        Nombre Perspectiva
                                        <span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->first('nombre_perspectiva'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('nombre_perspectiva') }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-outline" data-mdb-input-init>
                                    <input type="number" min="1" max="100"  class="form-control {{ $errors->first('ponderacion_perspectiva') ? 'is-invalid' : '' }}"  id="ponderacion{{$perspectiva->id}}"  name="ponderacion_perspectiva"  value="{{old('ponderacion_perspectiva', $perspectiva->ponderacion)}}" required>
                                    <label class="form-label" for="ponderacion{{$perspectiva->id}}">
                                        Ponderación de la perspectiva
                                        <span class="text-danger">*</span>
                                    </label>
                                    @if ($errors->first('ponderacion_perspectiva'))
                                        <div class="invalid-feedback">
                                            {{ $errors->first('ponderacion_perspectiva') }}
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