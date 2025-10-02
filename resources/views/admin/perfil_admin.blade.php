@extends('plantilla')
@section('title', 'Perfil Administrador')



@section('contenido')

<div class="container-fluid">

    <div class="row bg-primary d-flex align-items-center justify-content-start">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  py-4">
            <h1 class="text-white">Administrador</h1>

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

            @if (session('eliminado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('eliminado')}}
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

{{-- elaborando el perfil del usuario --}}

<div class="container-fluid">
    <div class="row border py-2">

        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_usuario">
                <i class="fa fa-plus"></i>
                Agregar Usuarios
            </button>
        </div>



        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#precargar_campos">
                <i class="fa fa-plus"></i>
                Precargar Campos - para pruebas
            </button>
        </div>

    </div>
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-12 text-center">
            <h2>Departamentos de la empresa</h2>
        </div>
    </div>
    <div class="row border py-2">
        <div class="col-auto p-2  text-white text-center mx-2" style="background-color: rgb(155, 0, 0)">
            <div class="row">
                <div class="col-12">
                    <h3>Atencion a clientes</h3>
                </div>
                <div class="col-12">
                    <h2>60%</h2>
                </div>
            </div>
        </div>

        <div class="col-auto p-2 text-white text-center mx-2" style="background-color: rgb(34, 138, 34)">
            <div class="row">
                <div class="col-12">
                    <h3>Producción</h3>
                </div>
                <div class="col-12">
                    <h2>80%</h2>
                </div>
            </div>
        </div>


        <div class="col-auto p-2 text-white text-center mx-2" style="background-color: rgb(155, 0, 0)">
            <div class="row">
                <div class="col-12">
                    <h3>Atencion a clientes</h3>
                </div>
                <div class="col-12">
                    <h2>60%</h2>
                </div>
            </div>
        </div>

        <div class="col-auto p-2  text-white text-center mx-2" style="background-color: rgb(34, 138, 34)">
            <div class="row">
                <div class="col-12">
                    <h3>Costos e Inventarios</h3>
                </div>
                <div class="col-12">
                    <h2>90%</h2>
                </div>
            </div>
        </div>


    </div>
</div>






{{-- Modales del perfil de administrador --}}

{{-- precargado de campos --}}
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
                        <div class="form-outline" id="contenedor_input" >

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






<!-- Modal -->
<div class="modal fade" id="agregar_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Agregar Usuarios</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('agregar.usuario')}}"  method="post" onkeydown="return event.key !='Enter';">
            @csrf

            <div class="row">

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('nombre_usuario') ? 'is-invalid' : '' }} " id="nombre_usuario" name="nombre_usuario">
                            <label class="form-label" for="nombre_usuario" >Nombre </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('correo_usuario') ? 'is-invalid' : '' }} "  name="correo_usuario">
                            <label class="form-label" for="correo_usuario" >Correo </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="password" class="form-control form-control-lg {{ $errors->first('password_usuario') ? 'is-invalid' : '' }}" name="password_usuario">
                            <label class="form-label" for="password" >Contraseña </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-3">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="puesto" class="form-control form-control-lg {{ $errors->first('puesto_usuario') ? 'is-invalid' : '' }}" name="puesto_usuario">
                            <label class="form-label" for="puesto" >Puesto </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <select name="planta" class="form-control form-control-lg" id="">
                            <option value="" disabled selected>Selecciona la planta a la que pertenece</option>
                            <option value="Planta 1">Planta 1</option>
                            <option value="Planta 2">Planta 2</option>
                            <option value="Planta 3">Planta 3</option>
                        </select>
                    </div>
                </div>

                <div class="col-12 ">
                    <div class="form-group mt-3">
                        <select id="departamentoSelect" name="departamento" class="form-control form-control-lg {{$errors->first('departamento') ? 'is-invalid' : ''}}" data-mdb-select-init data-mdb-filter="true" 
                        data-mdb-clear-button="true">
                            <option value="" disabled selected>Selecciona el departamento al que pertenece</option>
                            @forelse ($departamentos as $departamento)
                                <option value="{{$departamento->id}}" {{old('departamento', $departamento->nombre ?? '') == $departamento->id ? 'selected' : '' }}>

                                    {{$departamento->nombre}}

                                </option>
                            @empty
                                
                            @endforelse
                        </select>
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



@section('scripts')

<script>

  const select = document.getElementById("tipo_info");
  const contenedor = document.getElementById("contenedor_input");

  select.addEventListener("change", function () {
    contenedor.innerHTML = ""; // limpiar lo anterior

    let input;
    let label;

    
    if(this.value == "number"){
        input = document.createElement("input");
        input.type = "number";
        input.classList.add("form-control", 'border');
        input.placeholder = "Ingresa un número";
        input.name = "informacion";
        input.required = true;


        label = document.createElement("label");
        label.textContent = "Ingresa un número";

    }

    if(this.value == "string"){
        input = document.createElement("input");
        input.type = "text";
        input.classList.add("form-control", "border");
        input.placeholder = "Ingresa el texo";
        input.name = "informacion";
        input.required = true;

        label = document.createElement("label");
        label.textContent = "Ingresa el texto";

    }

    if(this.value == "date"){

        input = document.createElement("input");
        input.type = "date";
        input.classList.add('form-control', 'border');
        input.placeholder = "Fecha";
        input.name = "informacion";
        input.required = true;

        label = document.createElement("label");
        label.textContent = "Selecciona una fecha";

    }

    if(this.value == "month"){

        input = document.createElement("input");
        input.type = "month";
        input.classList.add('form-control', 'border');
        input.placeholder = "Mes";
        input.name = "informacion";
        input.required = true;

        label = document.createElement("label");
        label.textContent = "Selecciona un Mes";

    }

    if(this.value == "year"){
        
        input = document.createElement('input');
        input.type = "number";
        input.classList.add('form-control', 'border');
        input.placeholder = "Ingresa un año";
        input.min = "1900";
        input.max = "2025";
        input.name = "informacion";
        input.required = true;

        label = document.createElement("label");
        label.textContent = "Ingresa un año yyyy";

    }

    if (input){

        contenedor.appendChild(label);
        contenedor.appendChild(input);
    
    } 


  });
</script>

@endsection