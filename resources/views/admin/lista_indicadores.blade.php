@extends('plantilla')
@section('title', 'Lista de Indicadores del departamento')
@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  pt-2 text-white
">
            <h3 class="mt-1 mb-0">
                {{$departamento->nombre}}
            </h3>

            <small>
                Lista de indicadores de {{$departamento->nombre}}
            </small>

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
<div class="container-fluid">
    <div class="row  border-bottom  bg-white border-bottom shadow-sm">


        <div class="col-12 col-sm-12 col-md-4 col-lg-3 my-1">
            <button  class="btn btn-sm btn-primary w-100"  data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#exampleModal">
                <i class="fa fa-eye mx-1"></i>
                Cumplimiento general
            </button>
        </div>


    </div>
</div>




<div class="container-fluid">
    <div class="row jusfify-content-center">
        @forelse ($indicadores as $indicador)
                @php
                    $contador = 0;
                    $suma = 0;
                @endphp
            @foreach($indicador->indicadorLleno as $indicador_lleno)

                @if ($indicador_lleno->final == 'on')

                    @php
                        $contador++;
                        $suma = $suma + $indicador_lleno->informacion_campo;
                    @endphp

                @endif


            @endforeach


            @if ($contador > 0)
            @php
                $cumplimiento = $suma/$contador;
            @endphp

                <div class="col-10 col-sm-10 col-md-6 col-lg-4 my-3">
                    <div class="card text-white {{($cumplimiento < $indicador->meta_minima) ? 'bg-danger' : 'bg-success'}} shadow-2-strong">
                        <a href="{{route('indicador.lleno.show.admin', $indicador->id)}}" class="text-white w-100">
                        <div class="card-body">
                            <div class="row justify-content-around d-flex align-items-center">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                                    <h3 class="card-title fw-bold display-6 x">
                                        {{round($cumplimiento, 3)}}   
                                    </h3>
                                    <p class="card-text fw-bold">{{$indicador->nombre}}</p>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-4 p-0 m-0">
                                    <i class="fas fa-chart-line fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-2">
                                <div class="row  d-flex justify-content-between align-items-center">
                                    <div class="col-auto">
                                            Ver Detalles
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </div>
                                </div>
                        </div>
                        </a>
                    </div>
                </div>
            @else

                <div class="col-10 col-sm-10 col-md-6 col-lg-4 my-3">
                    <div class="card text-white bg-dark shadow-2-strong">
                        <a href="{{route('indicador.lleno.show.admin', $indicador->id)}}" class="text-white w-100">
                        <div class="card-body">
                            <div class="row justify-content-around d-flex align-items-center">
                                <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                                    <h5 class="card-title fw-bold  x">
                                        Sin registros aún.
                                    </h5>
                                    <p class="card-text fw-bold">{{$indicador->nombre}}</p>
                                </div>
                                <div class="col-12 col-sm-12 col-md-12 col-lg-4 p-0 m-0">
                                    <i class="fas fa-chart-line fa-3x"></i>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer p-2">
                                <div class="row  d-flex justify-content-between align-items-center">
                                    <div class="col-auto">
                                            Ver Detalles
                                    </div>
                                    <div class="col-auto">
                                        <i class="fas fa-arrow-circle-right"></i>
                                    </div>
                                </div>
                        </div>
                        </a>
                    </div>
                </div>


            @endif


        @empty

        @endforelse








{{-- Foreach de las encuestas --}}


    @forelse ($resultado_normas as $norma)

        <div class="col-10 col-sm-10 col-md-6 col-lg-4 my-3">
            <div class="card text-white {{($norma['meta_minima'] > $norma['porcentaje']) ? 'bg-danger' : 'bg-success'}} shadow-2-strong">
                <a href="{{route('apartado.norma', $norma['id_norma'])}}" class="text-white w-100">
                <div class="card-body">
                    <div class="row justify-content-around d-flex align-items-center">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                            <h2 class="card-title fw-bold display-6 x">{{$norma['porcentaje']}}%</h2>
                            <p class="card-text fw-bold">{{$norma['norma']}}</p>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 p-0 m-0">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2">
                        <div class="row  d-flex justify-content-between align-items-center">
                            <div class="col-auto">
                                    Ver Detalles
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </div>
                </div>
                </a>
            </div>
        </div>

    @empty

    @endforelse 


{{-- Foreach de las encuestas --}}



{{-- Foreach del cumplimiento a normas --}}
    @forelse ($encuestas as $encuesta)

        <div class="col-10 col-sm-10 col-md-6 col-lg-4 my-3">
            <div class="card text-white {{($encuesta->porcentaje_cumplimiento < $encuesta->meta_minima) ? 'bg-danger' : 'bg-success'}} shadow-2-strong">
                <a href="{{route('encuesta.index', $encuesta->id)}}" class="text-white w-100">
                <div class="card-body">
                    <div class="row justify-content-around d-flex align-items-center">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-7 ">
                            <h2 class="card-title fw-bold display-6 x">{{$encuesta->porcentaje_cumplimiento}}%</h2>
                            <p class="card-text fw-bold">{{$encuesta->nombre}}</p>
                        </div>
                        <div class="col-12 col-sm-12 col-md-12 col-lg-4 p-0 m-0">
                            <i class="fas fa-chart-line fa-3x"></i>
                        </div>
                    </div>
                </div>
                <div class="card-footer p-2">
                        <div class="row  d-flex justify-content-between align-items-center">
                            <div class="col-auto">
                                    Ver Detalles
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-arrow-circle-right"></i>
                            </div>
                        </div>
                </div>
                </a>
            </div>
        </div>

    @empty

    @endforelse

{{-- Foreach del cumplimiento a normas --}}
    </div>


    @if ($encuestas->isEmpty() && count($resultado_normas) == 0  &&  $indicadores->isEmpty() )
        <div class="row mt-5 justify-content-center">
            <div class="col-9 p-5 text-center bg-white shadow shadow-sm border">
                <h4>
                    <i class="fa fa-exclamation-circle text-danger"></i>
                    No se encontro Información.
                </h4>
            </div>
        </div>
    @endif




</div>







{{-- MODALES CON GRAFICAS --}}
<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered ">
    <div class="modal-content">

      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">
          <i class="fa fa-chart-simple"></i>
          Cumplimiento General {{ $departamento->nombre }}
        </h5>
        <button type="button" class="btn-close" data-mdb-dismiss="modal"></button>
      </div>

      <div class="modal-body p-4">

        <!-- Tabs -->
        <ul class="nav nav-tabs nav-justified mb-4" role="tablist">
          <li class="nav-item">
            <a class="nav-link active" data-mdb-tab-init href="#tab-barras" role="tab">
              <i class="fa-solid fa-chart-column me-2"></i>Barras
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-mdb-tab-init href="#tab-linea" role="tab">
              <i class="fa-solid fa-chart-line me-2"></i>Línea
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-mdb-tab-init href="#tab-pie" role="tab">
              <i class="fa-solid fa-chart-pie me-2"></i>Pie
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" data-mdb-tab-init href="#tab-donut" role="tab">
              <i class="fa-solid fa-chart-donut me-2"></i>Donut
            </a>
          </li>
        </ul>

        <!-- Tabs content -->
        <div class="tab-content">

          <div class="tab-pane fade show active" id="tab-barras">
            <canvas id="chartBar" height="120"></canvas>
          </div>

          <div class="tab-pane fade" id="tab-linea">
            <canvas id="chartLine" height="120"></canvas>
          </div>

          <div class="tab-pane fade" id="tab-pie" >
            <div class="p-5 text-center row justify-content-center" style="max-height: 700px">
                <canvas id="chartPie" height="120"></canvas>
            </div>
          
        </div>

          <div class="tab-pane fade" id="tab-donut">
            <div class="p-5 text-center row justify-content-center" style="max-height: 700px">
                <canvas id="chartDonut" height="120"></canvas>
            </div>
          </div>

        </div>
      </div>

      <div class="modal-footer">
        <button class="btn btn-secondary" data-mdb-dismiss="modal">Cerrar</button>
      </div>

    </div>
  </div>
</div>














@endsection


@section('scripts')

<script>
    const cumplimientoData = @json($cumplimiento_general);

    const labels = cumplimientoData.map(item => item.mes);
    const dataValues = cumplimientoData.map(item => item.total);
</script>



<script>
document.addEventListener('DOMContentLoaded', () => {


//   const labels = ['Indicador 1', 'Indicador 2', 'Indicador 3', 'Indicador 4'];
//   const dataValues = [85, 70, 90, 60];

  // BARRAS
  new Chart(document.getElementById('chartBar'), {
    type: 'bar',
    data: {
      labels,
      datasets: [{
        label: 'Cumplimiento %',
        data: dataValues,
        backgroundColor: '#0d6efd'
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: { beginAtZero: true, max: 100 }
      }
    }
  });

  // LINEA
  new Chart(document.getElementById('chartLine'), {
    type: 'line',
    data: {
      labels,
      datasets: [{
        label: 'Tendencia',
        data: dataValues,
        borderColor: '#198754',
        fill: false,
        tension: 0.4
      }]
    },
    options:{
        responsive:true,
        maininAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
  });



  // PIE
  new Chart(document.getElementById('chartPie'), {
    type: 'pie',
    data: {
      labels,
      datasets: [{
        data: dataValues,
        backgroundColor: ['#0d6efd', '#dc3545', '#ffc107', '#198754']
      }]
    },
    options:{
        responsive:true,
        maininAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
  });



  // DONUT
  new Chart(document.getElementById('chartDonut'), {
    type: 'doughnut',
    data: {
      labels,
      datasets: [{
        data: dataValues,
        backgroundColor: ['#6610f2', '#20c997', '#fd7e14', '#0dcaf0']
      }]
    },
    options:{
        responsive:true,
        maininAspectRatio: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
  });

});
</script>

@endsection