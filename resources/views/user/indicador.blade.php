@extends('plantilla')
@section('title', 'LLenado de Indicadores')

    


@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center">

        <div class="col-8 col-sm-8 col-md-6 col-lg-9  py-4  py-4 ">
            <h1 class="text-white"> {{$indicador->nombre}} </h1>
            <h3 class="text-white text-uppercase" id="fecha"></h3>
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
  
        <div class="col-4 col-sm-4 col-md-6 col-lg-3 text-end ">
            <form action="{{route('cerrar.session')}}" method="POST">
                @csrf 
                <button  class="btn btn-primary text-danger text-white fw-bold">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Cerrar Sesión
                </button>
            </form>
        </div>
    </div>
    @include('user.assets.nav')
</div>


<div class="container-fluid">
    <div class="row">
        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-primary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#llenado_indicadores">
                <i class="fa fa-plus"></i>
                Llenar indicadores
            </button>
        </div>
    </div>
</div>

<div class="container-fluid">

    <div class="row gap-4 p-2 justify-content-start border-bottom pb-5 mt-3">
        <div class="col-12">
            <h5>Información para este indicador</h5>
        </div>
        @forelse ($campos_llenos as $campo_lleno)
        <div class="col-auto border border-4 p-2 text-center shadow-sm">
            <span>{{$campo_lleno->nombre}}</span>
            <h6>{{$campo_lleno->informacion_precargada}}</h6>
            <small>{{$campo_lleno->descripcion}}</small>
        </div>
        @empty
            <div class="col-11 border border-4 p-5 text-center">
                <h2>
                    <i class="fa fa-exclamation-circle text-danger"></i>
                    No se encontraron datos
                </h2>
            </div>
        @endforelse
    </div>



    <div class="row justify-content-around pb-5 mt-4 border-bottom d-flex align-items-center">
        <div class="col-12 mb-3">
            <h5>Seguimiento del Indicador</h5>
        </div>

        <div class="col-auto mx-2">
            <div class="table-responsive p-0 border shadow-sm ">
            <table class="table">
                <thead class="table-primary">
                <tr>
                    <th scope="col">Mes</th>
                    <th scope="col">Toneladas Presupuestadas</th>
                    <th scope="col">Toneladas Producidas</th>
                    <th scope="col">% Cumplimiento</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <th scope="row">Julio</th>
                    <td>4000</td>
                    <td>3950</td>
                    <td class="text-success fw-bold">98.75%</td>
                </tr>                    

                <tr>
                    <th scope="row">Agosto</th>
                    <td>4000</td>
                    <td>2000</td>
                    <td class="text-danger fw-bold">50%</td>
                </tr>
                <tr>
                    <th scope="row">Septiembre</th>
                    <td>4000</td>
                    <td>3950</td>
                    <td class="text-success fw-bold">98.75%</td>
                </tr>
                <tr>
                    <th scope="row">Octubre</th>
                    <td>4000</td>
                    <td>3950</td>
                    <td class="text-success fw-bold">98.75%</td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>

        <div class="col-11 col-sm-10 col-md-8 col-lg-5 mt-4 shadow p-5" >
            <canvas class="w-100 h-100" id="grafico"></canvas>
        </div>

    </div>
</div>



<div class="modal fade" id="llenado_indicadores" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-primary py-4">
                <h3 class="text-white" id="exampleModalLabel">{{$indicador->nombre}}</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <div class="row gap-4 p-2">
                    @forelse ($campos_vacios as $campo_vacio)
                        <div class="col-11  col-sm-11 col-md-5 col-lg-4 text-start border border-4 mb-4 p-3 shadow-sm campos_vacios">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <label for="" class="fw-bold">{{$campo_vacio->nombre}}</label>
                                </div>
                                <div class="col-12">
                                    <input type="{{$campo_vacio->tipo}}" min="1" class="form-control input" name="{{$campo_vacio->id_input}}" id="{{$campo_vacio->id_input}}" placeholder="{{$campo_vacio->nombre}}">
                                </div>
                                <div class="col-11 bg-light m-4">
                                    <small>{{$campo_vacio->descripcion}}</small>
                                </div>
                            </div>
                            
                        </div>  
                    @empty
                        <div class="col-11 border border-4 p-5 text-center">
                            <h2>
                                <i class="fa fa-exclamation-circle text-danger"></i>
                                No se encontraron datos
                            </h2>
                        </div>
                    @endforelse
                </div>
                <div class="row justify-content-center bg-light  rounded p-4">
                    <div class="col-12">
                        <i class="fa fa-exclamation-circle"></i>
                        <span class="fw-bold">Descripción:</span>
                    </div>
                    <div class="col-12">
                        <span>{{$indicador->descripcion}}</span>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                @if (!$campos_vacios->isEmpty())
                <button  class="btn btn-primary w-100 py-3" data-mdb-ripple-init>
                    <h6>Guardar</h6>
                </button>
                @endif
            </div>
        </div>
    </div>
</div>









@endsection











@section('scripts')

<script>
    let mostrar_fecha = document.getElementById("fecha");
    let fecha = new Date();
    mostrar_fecha.innerHTML = " <i class='fa fa-calendar'></i>  " + fecha.toLocaleDateString("es-Es", {month: 'long'}) +" "+ fecha.getFullYear();
</script>

<script>
const ctx = document.getElementById('grafico').getContext('2d');

new Chart(ctx, {
  data: {
    labels: ["Enero", "Febrero", "Marzo", "Abril"],
    datasets: [
      {
        type: "bar",  // Barras
        label: "Ventas",
        data: [30, 50, 40, 60],
        backgroundColor: "rgba(75, 192, 192, 0.5)"
      },
      {
        type: "line", // Línea sobrepuesta
        label: "Promedio",
        data: [50, 50, 50, 50],
        borderColor: "red",
        borderWidth: 2,
        fill: false
      },
      {
        type: "line", // Línea sobrepuesta
        label: "Promedio",
        data: [100, 100, 100, 100],
        borderColor: "blue",
        borderWidth: 2,
        fill: false
      }
    ]
  },
  options: {
    responsive: true,
    plugins: {
      legend: { position: "top" }
    }
  }
});
</script>

@endsection