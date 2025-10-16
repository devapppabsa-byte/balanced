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

<div class="container-fluid border-bottom my-5">

    <div class="row justify-content-center">
        @forelse ($departamentos as $departamento)

            <div class="col-12 col-sm-10 col-md-4 col-lg-3 my-3">
                <a href="{{route('lista.indicadores.admin', $departamento->id)}}"> 
                    <div class="card text-white border border-3 border-light  shadow-2-strong" style="background-color: rgb(92, 151, 55)" data-mdb-tooltip-init title="80%  Cumplimiento en {{ $departamento->nombre }}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                <h3>{{$departamento->nombre}}</h3>
                                <p class="mb-1">Cumplimiento</p>
                                <h5 class="mb-2 fw-bold">80%</h5>
                                </div>
                                <i class="fas fa-chart-line fa-4x"></i>
                            </div>
                            <div class="progress rounded-0 mt-2" style="height: 4px;" >
                                <div class="progress-bar" style="width: 80%; background-color:rgb(53, 112, 2)"></div>
                            </div>
                            <span class="mt-2 d-block fw-bold">
                                4 Indicadores.
                            </span>
                        </div>
                    </div>
                </a>
            </div>


        @empty
            <div class="col-8 text-center py-5">
                <div class="col-12">
                    <img src="{{asset('/img/iconos/empty.png')}}" class="img-fluid" alt="">
                </div>
                <div class="col-12">
                    <h2>
                        <i class="fa fa-exclamation-circle text-danger"></i>
                        No hay datos disponibles!
                    </h2>
                </div>
            </div>
        @endforelse


            <div class="col-12 col-sm-10 col-md-4 col-lg-3 my-3">
                <a href="{{route('lista.indicadores.admin', $departamento->id)}}"> 
                    <div class="card text-white border border-3 border-light  shadow-2-strong" style="background-color: rgb(151, 55, 55)">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                <h3>Sanidad</h3>
                                <p class="mb-1">Cumplimiento</p>
                                <h5 class="mb-2 fw-bold">70%</h5>
                                </div>
                                <i class="fas fa-chart-line fa-4x"></i>
                            </div>
                            <div class="progress rounded-0 mt-2" style="height: 4px;">
                                <div class="progress-bar" style="width: 70%; background-color:rgb(112, 2, 2)"></div>
                            </div>
                            <span class="mt-2 d-block fw-bold">
                                4 Indicadores.
                            </span>
                        </div>
                    </div>
                </a>
            </div>

    </div>










<!-- Modal -->


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