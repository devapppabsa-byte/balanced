@extends('plantilla')
@section('title', 'Perfil Administrador')



@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center">

        <div class="col-12 col-sm-12 col-md-6 col-lg-5  py-4 ">
            <h1 class="text-white">Perfil del administrador</h1>

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

        <div class="col-5"></div>
        
        <div class="col-2 text-center ">
            <form action="{{route('cerrar.session')}}" method="POST">
                @csrf 
                <button  class="btn btn-primary text-danger text-white fw-bold">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Cerrar Sesión
                </button>
            </form>
        </div>
        
    </div>
</div>

{{-- elaborando el perfil del usuario --}}

<div class="container-fluid">
    <div class="row border py-2">

        <div class="col-12 col-sm-12 col-md-6 col-lg-2 my-1">
            <button class="btn btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_usuario">
                <i class="fa fa-plus"></i>
                Agregar Usuarios
            </button>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-2 my-1">
            <button class="btn btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_departamento">
                <i class="fa fa-plus"></i>
                Agregar Departamentos
            </button>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-2 my-1">
            <button class="btn btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#precargar_campos">
                <i class="fa fa-plus"></i>
                Precargar Campos - para pruebas
            </button>
        </div>

    </div>
</div>


<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-12 ">
            <div class="row justify-content-center">
                <div class="col-12 text-center my-3">
                    <h2>Departamentos</h2>
                    @if (session('eliminado'))
                        <h5 class="">
                            <i class="fa fa-exclamation-circle text-danger"></i>
                            {{session('eliminado')}}
                        </h5>
                    @endif
                </div>
                @forelse ($departamentos as $departamento)

                    <div class="col-10 col-sm-10 col-md-4 col-lg-2 m-2 text-center border border-3 shadow shadow-3 py-3">

                        <div class="row justify-content-center">
                            <div class="col-12">
                                <a href="{{route('agregar.indicadores.index', $departamento->id)}}" class="btn btn-outline-secondary w-100 h-100 d-block h5 py-4">
                                    {{$departamento->nombre}}    
                                </a>   
                            </div>
                            <div class="col-12 mt-3">
                                <div class="row">
                                    <div class="col-auto">
                                        <a href="#" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del_dep{{$departamento->id}}" class="text-danger">
                                            <i class="fa fa-trash"></i>
                                            Eliminar
                                        </a>
                                    </div>
                                    <div class="col-auto">
                                        <a href="edit_dep{{$departamento->id}}" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#edit_dep{{$departamento->id}}"  class="text-primary">
                                            <i class="fa fa-edit"></i>
                                            Editar
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                @empty
                    <li>No hay datos disponibles</li>
                @endforelse
            </div>
        </div>








    </div>
</div>







{{-- bucle que nos va a darlos modales para la edicion y eliminado de los departamentos--}}

@forelse ($departamentos as $departamento)

    <div class="modal fade" id="del_dep{{$departamento->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header bg-danger py-4">
                <h3 class="text-white" id="exampleModalLabel">¿Eliminar {{$departamento->nombre}} ?</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{route('eliminar.departamento', $departamento->id)}}" method="POST">
                    @csrf @method('DELETE')
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


    <div class="modal fade" id="edit_dep{{$departamento->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header bg-primary py-4">
                <h5 class="text-white" id="exampleModalLabel">Editando Departamento {{$departamento->nombre}}</h5>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{route('actualizar.departamento', $departamento->id)}}" method="POST">
                    @csrf @method('PATCH')
                    
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg w-100{{ $errors->first('nombre_departamento') ? 'is-invalid' : '' }} " id="nombre_dep{{$departamento->id}}" name="nombre_departamento" value="{{old('nombre_departamento', $departamento->nombre)}}" style="font-size: 30px">
                            <label class="form-label" for="nombre_dep{{$departamento->id}}" >Nombre nuevo </label>
                        </div>
                    </div>

                    <div class="form-group mt-4">
                        <button  class="btn btn-primary w-100 btn-lg" data-mdb-ripple-init>
                            <i class="fa fa-pencil mx-2"></i>
                            Editar
                        </button>
                    </div>


                </form>
            </div>
            {{-- <div class="modal-footer">
            </div> --}}
            </div>
        </div>
    </div>
@empty
    
@endforelse










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




<div class="modal fade" id="agregar_departamento" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary">
        <h5 class="text-white" id="exampleModalLabel">Agregar Departamento</h5>
        <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form action="{{route('agregar.departamento')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg w-100" id="nombre_departamento" name="nombre_departamento">
                            <label class="form-label" for="nombre_departamento" >Nombre </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button  class="btn btn-primary w-100" data-mdb-ripple-init>Guardar</button>
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