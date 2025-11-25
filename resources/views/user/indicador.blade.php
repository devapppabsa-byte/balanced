@extends('plantilla')
@section('title', 'LLenado de Indicadores')
@section('contenido')
@php
use App\Models\CampoCalculado;
use App\Models\CampoInvolucrado;
use App\Models\CampoPrecargado;
use App\Models\CampoVacio;
use App\Models\InformacionInputVacio;
@endphp

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center">

        <div class="col-8 col-sm-8 col-md-6 col-lg-9  py-4  py-4 ">
            <h1 class="text-white"> {{$indicador->nombre}} </h1>
            <h5 class="text-white fw-bold" id="fecha"></h5>
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
    <div class="row border-bottom mb-2 bg-white">
        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-outline-primary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#llenado_indicadores">
                <i class="fa fa-plus"></i>
                Llenar este Indicador
            </button>
        </div>
    </div>
</div>

<div class="container-fluid">

    <div class="row gap-4  justify-content-center ">

        <div class="col-12 col-sm-12 border col-md-11 col-lg-10 bg-white boder  shadow shadow-sm py-5 px-5">

            <div class="row justify-content-center">
                <div class="col-12">
                    <h5>
                        <i class="fa fa-exclamation-circle text-primary"></i>
                        Información para este indicador
                    </h5>
                </div>

                {{-- aqui vamos a consultar los campos precargados --}}

                @forelse ($campos_unidos as $campo)
                <div class="col-11 col-sm-11 col-md-5 col-lg-3 border border-4 p-4 shadow-sm m-3">

                    <span class="fw-bold">{{$campo->nombre}}</span>
                    <input type="text" class="form-control"  name="{{$campo->nombre}}" value="{{$campo->informacion_precargada}}" disabled>
                    <small>{{$campo->descripcion}}</small>

                </div>                    
                @empty
                    
                @endforelse


                {{-- aqui vamos a consultar los campos precargados --}}


                {{-- @forelse ($campos_llenos as $campo_lleno)
                <div class="col-11 col-sm-11 col-md-5 col-lg-3 border border-4 p-4 shadow-sm m-3">

                    <span class="fw-bold">{{$campo_lleno->nombre}}</span>
                    <input type="text" class="form-control"  name="{{$campo_lleno->nombre}}" value="{{$campo_lleno->informacion_precargada}}" disabled>
                    <small>{{$campo_lleno->descripcion}} Aqui va a ir la descripción de cada campo agregado.</small>

                </div>
                @empty
                    <div class="col-11 border border-4 p-5 text-center">
                        <h2>
                            <i class="fa fa-exclamation-circle text-danger"></i>
                            No se encontraron datos a
                        </h2> 
                    </div>
                @endforelse --}}

            </div>

        </div>
        
    </div>



    <div class="row justify-content-around pb-5 m border-bottom d-flex align-items-center">
        <div class="col-12 mb-3 border-dashed my-5 p-3">
            <h3>Campo de pruebas :p</h3>
            <div class="row">

            @php
                $informacion_campos_vacios_final = [];
                $id_inputs_involucrados = [];
                $informacion_input_vacio = [];
                $suma = 0;
            @endphp




            @forelse ($campos_calculados as $campo_calculado) 
                
            
                <div class="col-6 border shadow bg-white p-3">

                    <h4>{{$campo_calculado->nombre}}</h4>
                    <h5>{{$campo_calculado->operacion}}</h5>
                    <h6>{{$campo_calculado->id_input}}</h6>

                    <hr>

                    {{-- ciclo hijo, aqui se consultan los inputs involucrados --}}
                    @foreach ($campo_calculado->campo_involucrado as $campo_involucrado)
            
                        @php
                            //Este cacho de codigo une los registros de la tabla: 
                            $informacion = InformacionInputVacio::where('id_input_vacio', $campo_involucrado->id_input)->first();

                            array_push($informacion_input_vacio, $informacion );
                        @endphp
                        
                        
                        *Tipo: {{$campo_involucrado->tipo}} <br>
                        Id_input: {{$campo_involucrado->id_input}} <br>
                        Created_at: {{$campo_involucrado->created_at}} <br>
                        @if ($informacion)
                        Informacion: {{$informacion->informacion}} <br>
                        
                    @endif
                    
                    @endforeach


                    @foreach ($informacion_input_vacio as $datos)
                        @php                            
                            if ($datos){
                                
                                if($campo_calculado->operacion === "promedio"){

                                    echo $datos->informacion;
                                    $suma = $suma + $datos->informacion;
                                
                                }
                            }
                        @endphp
                    @endforeach


                </div>


                <h2>{{$suma/2}}</h2>
                <br><br><br>

                
            @endforeach


            <br>



            </div>
        </div>




        <div  class="col-11 col-sm-10 col-md-10 col-lg-10  mx-2 bg-white shadow-sm p-5">
            
            <h5>
                <i class="fa fa-chart-simple"></i>
                Seguimiento del Indicador
            </h5>



            <div class="table-responsive  border ">
            <table class="table">
                <thead class="table-primary fjalla-one-regular">
                <tr>
                    <th scope="col">Año</th>
                    <th scope="col">Mes</th>
                    <th scope="col">Toneladas Presupuestadas</th>
                    <th scope="col">Toneladas Producidas</th>
                    <th scope="col">% Cumplimiento</th>
                </tr>
                </thead>
                <tbody>

                <tr>
                    <th>2025</th>
                    <th scope="row">Julio</th>
                    <td>4000</td>
                    <td>3950</td>
                    <td class="text-success fw-bold">98.75%</td>
                </tr>                    

                <tr>
                    <th>2025</th>
                    <th scope="row">Agosto</th>
                    <td>4000</td>
                    <td>2000</td>
                    <td class="text-danger fw-bold">50%</td>
                </tr>
                <tr>
                    <th>2025</th>
                    <th scope="row">Septiembre</th>
                    <td>4000</td>
                    <td>3950</td>
                    <td class="text-success fw-bold">98.75%</td>
                </tr>
                <tr>
                    <th>2025</th>
                    <th scope="row">Octubre</th>
                    <td>4000</td>
                    <td>3950</td>
                    <td class="text-success fw-bold">98.75%</td>
                </tr>
                </tbody>
            </table>
            </div>
        </div>

        <div class="col-11 col-sm-10 col-md-10 col-lg-5 mt-4 shadow p-5 bg-white" >
            <select name="" class="form-select border-0" id="periodo">
                <option value="2024">2024</option>
                <option value="2025">2025</option>

            </select>
            <canvas class="w-100 h-100" id="grafico"></canvas>
        </div>

    </div>
</div>



<div class="modal fade" id="llenado_indicadores" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-xl modal-fullscreen-md-down">
        <div class="modal-content">
            <div class="modal-header bg-primary py-4">
                <h3 class="text-white" id="exampleModalLabel">{{$indicador->nombre}}</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Cloeesdasdse"></button>
            </div>
            <div class="modal-body py-4">

                <form id="formulario_llenado_indicadores" method="POST" action="{{route('llenado.informacion.indicadores', $indicador->id)}}" class="row gap-4 p-2 justify-content-center">
                    @csrf
                    @forelse ($campos_vacios as $campo_vacio)
                        <div class="col-11  col-sm-11 col-md-4 col-lg-5 text-start border border-4 mb-4 p-3 shadow-sm campos_vacios">
                            <div class="row justify-content-center">
                                <div class="col-12">
                                    <label for="" class="fw-bold">{{$campo_vacio->nombre}}</label>
                                </div>
                                <div class="col-12">
                                    <input type="{{$campo_vacio->tipo}}" min="1" class="form-control input" name="informacion_indicador[]" id="{{$campo_vacio->id_input}}" placeholder="{{$campo_vacio->nombre}}">

                                    {{-- campos ocultos para llevar informacion al controlador --}}
                                        <input type="text" name="id_input[]" value="{{$campo_vacio->id}}">
                                        <input type="text" name="tipo_input[]" value="{{$campo_vacio->tipo}}">
                                        <input type="text" name="id_input_vacio[]" value="{{$campo_vacio->id_input}}">
                                    {{-- campos ocultos para llevar informacion al controlador --}}

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
                </form>

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
                <button  class="btn btn-primary w-100 py-3" form="formulario_llenado_indicadores" data-mdb-ripple-init>
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
const ctx = document.getElementById('grafico').getContext('2d');

new Chart(ctx, {
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

@endsection