@extends('plantilla')
@section('title', 'Perfil Administrador')



@section('contenido')

<div class="container-fluid">

    <div class="row bg-primary d-flex align-items-center justify-content-start">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10 pt-2">
            <h3 class="text-white league-spartan">Administrador</h3>

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

        <div class="col-12 col-sm-12 col-md-5 col-lg-5 mt-2">
            <div class="card shadow-3 rounded-4 p-3 border" style="max-width: 400px;">

            <div class="card-body p-1">
                <h4 class="text-muted text-uppercase fw-bold">{{$departamento->nombre}}</h4>



                <!-- Gráfico -->
                <canvas id="{{$departamento->id}}" class="" height="200"></canvas>

                <div class="mt-3">
                <p class="fw-bold text-muted mb-2">Indicadores (4)</p>

                <!-- Producto -->
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">

                        <div class="position-relative me-2">

                            <div class="progress progress-circular " style="--percentage: 72;">
                                <div class="progress-bar bg-success"></div>
                                <div class="progress-label"></div>
                            </div>

                            <span class="position-absolute top-50 start-50 translate-middle small fw-bold text-success">
                                72%
                            </span>
                        </div>

                        <div>
                            <p class="fw-bold mb-0">Indicador uno</p>
                            <small class="bg-dark text-white px-2 py-1 rounded-pill">72%</small>
                        </div>
                        </div>
                    </div>



                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                        <div class="position-relative me-2">

                            <div class="progress progress-circular " style="--percentage: 23;">
                                <div class="progress-bar bg-danger"></div>
                                <div class="progress-label"></div>
                            </div>

                            <span class="position-absolute top-50 start-50 translate-middle small fw-bold text-danger">23%</span>
                        </div>
                        <div>
                            <p class="fw-bold mb-0">Indicador Dos</p>
                            <small class="bg-dark text-white px-2 py-1 rounded-pill">23%</small>
                        </div>
                        </div>
                    </div>




                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <div class="d-flex align-items-center">
                        <div class="position-relative me-2">

                            <div class="progress progress-circular " style="--percentage: 64;">
                                <div class="progress-bar bg-success"></div>
                                <div class="progress-label"></div>
                            </div>

                            <span class="position-absolute top-50 start-50 translate-middle small fw-bold text-succcess">64%</span>
                        </div>
                        <div>
                            <p class="fw-bold mb-0">Inidcador 3</p>
                            <small class="bg-dark text-white px-2 py-1 rounded-pill">64%</small>
                        </div>
                        </div>

                    </div>



                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                        <div class="position-relative me-2">

                            <div class="progress progress-circular " style="--percentage: 64;">
                                <div class="progress-bar bg-success"></div>
                                <div class="progress-label"></div>
                            </div>

                            <span class="position-absolute top-50 start-50 translate-middle small fw-bold text-success">69%</span>
                        </div>
                        <div>
                            <p class="fw-bold mb-0">Indicador 4</p>
                            <small class="bg-dark text-white px-2 py-1 rounded-pill">69%</small>
                        </div>
                        </div>
                    </div>



                </div>

                <div class="text-center mt-4">
                <a href="{{route('lista.indicadores.admin', $departamento->id)}}" class="btn btn-primary btn-sm rounded-pill">
                    Ver todo <i class="fas fa-arrow-right ms-1"></i>
                </a>
                </div>
            </div>
            </div>
        </div>


        @empty
            <div class="col-8 text-center py-5 bg-white shadow shadow-sm border">
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


    </div>










<!-- Modal -->


@endsection



@section('scripts')

@forelse ($departamentos as $departamento)


<script>

const ctx{{$departamento->id}} = document.getElementById({{$departamento->id}});

new Chart(ctx{{$departamento->id}}, {
  data: {
    labels: ["Enero", "Febrero", "Marzo", "Abril"],
    datasets: [
      {
        type: "bar",  // Barras
        label: "Ventas",
        data: [30, 50, 40, 60],

        backgroundColor: function(context) {
          const value = context.raw;
          return value < 50
            ? "rgba(255, 99, 132, 0.7)"  // rojo
            : "rgba(75, 192, 75, 0.7)";  // verde
        },
        borderColor: function(context) {
          const value = context.raw;
          return value < 50 ? "red" : "green";
        },

        borderWidth: 1
      },
      {
        type: "line", // Línea sobrepuesta
        label: "Mínimo",
        data: [50, 50, 50, 50],
        borderColor: "red",
        borderWidth: 2,
        fill: false
      },
      {
        type: "line", // Línea sobrepuesta
        label: "Máximo",
        data: [100, 100, 100, 100],
        borderColor: "green",
        borderWidth: 2,
        fill: false
      }
    ]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: "top" }
    },
    scales: {
      y: { beginAtZero: true }
    }
  }
});
</script>






@empty
    
@endforelse


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