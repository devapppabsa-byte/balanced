@extends('plantilla')
@section('title', 'Información Foranea')

@section('contenido')


<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center">
        <div class="col-auto pt-2 text-white">
            <h3 class="mt-1 league-spartan">Cargar Información Externa</h3>
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
            @if ($errors->any())
                <div class="text-white fw-bold bad_notifications">
                    <i class="fa fa-xmark-circle mx-2"></i>
                    {{$errors->first()}}
                </div>
            @endif
        </div>
    </div>
    @include('admin.assets.nav')
</div>


<div class="container-fluid">
    <div class="row  border-bottom  bg-white border-bottom shadow-sm">

        <div class="col-12 col-sm-12 col-md-4 col-lg-2 my-1">
            <button class="btn btn-sm btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#precargar_campos">
                <i class="fa fa-plus"></i>
                Precargar Campos - para pruebas
            </button>
        </div>

        <div class="col-12 col-sm-12 col-md-3 col-lg-2 my-1">
            <button class="btn btn-sm btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#cargar_excel">
                <i class="fa fa-file-excel mx-1"></i>
                Cargar Excel
            </button>
        </div>
    </div>
</div>





<div class="container-fluid mt-3">
    <div class="row justify-content-center">
        <div class="col-11 bg-white rounded rounded-3 shadow shadow-sm border p-4" style="min-height: 600px">
            
            <div class="row">
                <div class="col-12 text-center mt-3">
                    <h2>
                        <i class="fa fa-exclamation-circle text-primary"></i>
                        Información cargada de fuera
                    </h2>
                </div>
            </div>

            <div class="row justify-content-around mt-5">

                <div class="col-12 col-sm-12 col-md-5 my-2 col-lg-3 text-center py-4 border border-4 border-dark">
                    <h2 class="text-dark">Toneladas Vendidas</h2>
                    <span class="fs-1 fw-bold">
                        3000
                    </span> <br>
                    <span class="fw-bold">
                        <i class="fa fa-calendar"></i>
                        Octubre 2025
                    </span>
                </div>

                <div class="col-12 col-sm-12 col-md-5 my-2 col-lg-3 text-center py-4 border border-4 border-dark">
                    <h2 class="text-dark">Costo de mano de Obra</h2>
                    <span class="fs-1 fw-bold">
                        3000
                    </span> <br>
                    <small class="fw-bold">
                        <i class="fa fa-calendar"></i>
                        Octubre 2025
                    </small>
                </div>
            
                <div class="col-12 col-sm-12 col-md-5 my-2 col-lg-3 text-center py-4 border border-4 border-dark">
                    <h2 class="text-dark">Costo de mano de Obra</h2>
                    <span class="fs-1 fw-bold">
                        3000
                    </span> <br>
                    <small class="fw-bold">
                        <i class="fa fa-calendar"></i>
                        Octubre 2025
                    </small>
                </div>


            </div>

        </div>
    </div>
</div>





{{-- Modales del perfil de administrador --}}

{{-- precargado de campos --}}
<div class="modal fade" id="cargar_excel" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">
            <i class="fa fa-file-excel mx-1"></i>
            Cargando Información Foranea
        </h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body py-4">
            <form action="#"  method="post">
                @csrf 
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group mt-3">
                            <input type="file" accept=".xlsx,xls" class="form-control form-control-lg" name="nombre_info" required>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button  class="btn btn-primary w-100 py-3" data-mdb-ripple-init>
                <h6>Guardar</h6>
            </button>

      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="precargar_campos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Cargando Información foranea de prueba</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('agregar.info.foranea')}}"  method="post">
            @csrf 
            <div class="row">

                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg" name="nombre_info" required>
                            <label class="form-label" for="nombre_info" >Nombre </label>
                        </div>
                    </div>
                </div>



                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group mt-3">
                        <select name="tipo_info" class="form-select" id="tipo_info"required>
                            <option value="" disabled selected>Selecciona un tipo de dato</option>
                            <option value="number">Número</option>
                            <option value="string">Texto</option>
                            <option value="date">Fecha</option>
                            <option value="month">Mes</option>
                            <option value="year">Año</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group mt-3">
                        <div class="form-outline" id="contenedor_input" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg" name="informacion" required>
                            <label class="form-label" for="informacion" >Información </label>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <button  class="btn btn-primary w-100 py-3" data-mdb-ripple-init>
                <h6>Guardar</h6>
            </button>
        </form>

      </div>
    </div>
  </div>
</div>


@endsection