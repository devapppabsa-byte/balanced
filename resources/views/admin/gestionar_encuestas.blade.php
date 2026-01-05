@extends('plantilla')
@section('title', 'Encuestas a los clientes')

@section('contenido')
<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center">
        <div class="col-auto pt-2 text-white">
            <h3 class="mt-1 league-spartan">Encuestas para los clientes</h3>
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
            @if (session('editado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('editado')}}
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
    <div class="row  border-bottom bg-white shadow-sm ">
        <div class="col-12 col-sm-12 col-md-3 col-lg-auto my-1">
            <button class="btn btn-sm btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_cuestionario">
                <i class="fa fa-plus-circle"></i>
                Agregar Encuesta
            </button>
        </div>
    </div>
</div>


<button class="btn btn-primary flotante2 btn-lg" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#grafico_mes">
   <h6 class="mt-2">
    <i class="fa fa-calendar"></i>
       Graficas 
   </h6> 
</button>




<div class="container-fluid">

    <form class="row   justify-content-center " action="{{route('encuestas.show.admin')}}" method="GET">
        <div class="col-9  mx-5  ">
            <div class="row justify-content-center p-3">
                @csrf @method("GET")
                        <div class="col-12 col-sm-12 col-md-8 col-lg-5  shadow shadow-sm p-3 border bg-white px-4">
                            <div class="row justify-content-center"> 
                                <div class="col-6 ">
                                    <div class="form-group">
                                        <label for="" class="fw-bold">Fecha Inicio: </label>
                                        <input type="date" name="fecha_inicio" value="{{request('fecha_inicio')}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-6 ">
                                    <div class="form-group">
                                        <label for="" class="fw-bold">Fecha Final: </label>
                                        <input type="date" name="fecha_fin" value="{{request('fecha_fin')}}" class="form-control">
                                    </div>
                                </div>

                                <div class="col-12 m-2">
                                    <div class="form-group">
                                        <button class="btn btn-primary btn-sm ">
                                            <i class="fa fa-filter"></i>
                                            Filtrar
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div>
            </div>
        </div>
    </form>


    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-11 col-lg-8 shadow-sm rounded border  bg-white px-4 py-3">
            <div class="row ">
                <div class="col-12 text-center">
                    <h2>
                        <i class="fa-regular fa-newspaper"></i>
                        Encuestas
                    </h2>
                    <p>Promedio total de los resultados contando clientes y meses.</p>
                </div>
            </div>
            <div class="row">
                <div class="col-12 ">
                    <div class="row   table-responsive">
                        @if (!$encuestas->isEmpty()) {{-- Esto es para ocultar la cabecera de la tabla cuando no haya datos --}}
                        
                            <table class="table mb-0 border table-hover">
                                <thead class="table-secondary text-white cascadia-code">
                                    <tr>
                                    <th>Nombre</th>
                                    <th>Departamento</th>
                                    <th>Acciones</th>
                                    <th>Creada</th>
                                    <th>Cumplimiento</th>
                                    </tr>
                                </thead>
                            <tbody>
                        @endif

                        @forelse ($encuestas as $encuesta)
                            <tr>
                                <td>
                                    <a href="{{route('encuesta.index', $encuesta->id)}}" data-mdb-tooltip-init title="Detalles de {{$encuesta->nombre}}" class="text-decoration-none text-dark fw-bold">
                                        {{$encuesta->nombre}}
                                    </a>
                                    <p>
                                        {{$encuesta->descripcion}}
                                    </p>
                                </td>
                                <td>{{$encuesta->departamento->nombre}}</td>

                                <td class="tex-start">
                                    <a class="text-danger mx-1" data-mdb-tooltip-init title="Eliminar {{$encuesta->nombre}}"  data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del_en{{$encuesta->id}}" style="cursor: pointer">
                                        <i class="fa fa-trash"></i> 
                                    </a>

                                    <a class="text-primary" data-mdb-tooltip-init title="Editar {{$encuesta->nombre}}"  data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#edit_en{{$encuesta->id}}"  style="cursor: pointer">
                                        <i class="fa fa-edit"></i> 
                                    </a>

                                    <a class=" mx-1" data-mdb-tooltip-init title="Ver {{$encuesta->nombre}}" href="{{route('encuesta.index', $encuesta->id)}}">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                
                                </td>

                                <td>
                                  {{$encuesta->created_at}}
                                </td>

                                <td class="text-start">

                                    @php  $suma=0; $contador=0;    @endphp

                                    @forelse ($encuesta->preguntas as $pregunta)

                                        @if ($pregunta->cuantificable === 1)

                                            @forelse ($pregunta->respuestas as $respuesta)
                                                @php
                                                    $suma = $suma + $respuesta->respuesta;
                                                @endphp
                                                @php $contador++;  @endphp {{--Este contador me ayuda a saber cuantas preguntas del cuestionario con cuantificables --}}
                                                
                                            @empty
                                                @if ($loop->first)
                                                    <span>No hay respuestas disponibles.</span>
                                                @endif
                                            @endforelse

                                        @else
                                        {{-- si no son cuantificables no las muestra --}}
                                        @endif

                                    @empty
                                        <span>Aún no se han registrado preguntas.</span>                                        
                                    @endforelse

                                    @if ($suma>0)
                                        {{-- Aqui esta el porcentaje de cumplimiento --}}
                                        <h6 class="badge fs-6  p-2 {{($suma/($contador*10)*100 > $encuesta->meta_minima) ? "badge-success border border border-success" : "badge-danger border border-danger" }}" data-mdb-tooltip-init title="{{round($suma/($contador*10)*100, 3)}}%">
                                            {{round(($suma/($contador*10))*100, 3) }} %
                                            <i class="fa {{($suma/($contador*10)*100 > 50) ? "fa-check-circle" : "fa-xmark-circle" }} "></i>
                                        </h6>
                                        @endif
                                
                                </td>

                            </tr>
                        @empty
                            <div class="col-12 p-5 text-center p-5 border">

                                <div class="row">
                                    
                                    <div class="col-12">
                                        <i class="fa fa-exclamation-circle text-danger"></i>
                                        No cuenta con indicadores, pero los puedes agregar aqui
                                    </div>
                                    
                                    <div class="col-12">
                                        <a class="btn btn-secondary btn-sm" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_cuestionario">
                                            Agregar Cuestionario
                                        </a>
                                    </div>

                                </div>
                                <h5>
                                </h5>
                            </div>
                        @endforelse
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="agregar_cuestionario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Agregar Encuesta</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('encuesta.store.two')}}" method="post">
            @csrf
            <div class="row">
                <div class="col-12 text-center">
                    <div class="form-group mt-2">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('nombre_encuesta') ? 'is-invalid' : '' }} " id="nombre_encuesta" value="{{old('nombre_encuesta')}}" name="nombre_encuesta" required>
                            <label class="form-label" for="nombre_encuesta" >Nombre para la Encuesta</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <div class="form-outline" data-mdb-input-init>
                                <textarea class="form-control w-100 {{ $errors->first('descripcion_cuestionario') ? 'is-invalid' : '' }}" id="descrpcion_encuesta" name="descripcion_encuesta" required >{{old('descripcion_encuesta')}}</textarea>
                                <label class="form-label" for="descrpcion_encuesta">Descripción del Cuestionario</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group mt-3">
                        <select name="departamento" id=""  class="form-select" >
                            <option value="" selected disabled>Selecciona un Departamento</option>
                            @forelse ($departamentos as $departamento)
                            <option value="{{$departamento->id}}">{{$departamento->nombre}}</option>
                            @empty
                                
                            @endforelse
                        </select>
                    </div>
                </div>


                <div class="col-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <div class="form-outline" data-mdb-input-init>
                                <input type="number" min="0" max="100" class="form-control w-100 {{ $errors->first('meta_minima_encuesta') ? 'is-invalid' : '' }}" id="meta_minima_encuesta" name="meta_minima_encuesta" value="{{old('meta_minima_encuesta')}}" required >
                                <label class="form-label" for="meta_minima_encuesta">Meta Minima</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <div class="form-outline" data-mdb-input-init>
                                <input type="number" min="0" max="100" class="form-control w-100 {{ $errors->first('meta_esperada_encuesta') ? 'is-invalid' : '' }}" id="meta_esperada_encuesta" name="meta_esperada_encuesta" value="{{old('meta_esperada_encuesta')}}" required >
                                <label class="form-label" for="meta_esperada_encuesta">Meta Esperada</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <div class="form-outline" data-mdb-input-init>
                                <input type="number" min="0" max="100" class="form-control w-100 {{ $errors->first('descripcion_cuestionario') ? 'is-invalid' : '' }}" id="ponderacion_encuesta" name="ponderacion_encuesta" required >
                                <label class="form-label" for="ponderacion_encuesta">Ponderación</label>
                            </div>
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




@forelse ($encuestas as $encuesta)
    <div class="modal fade" id="del_en{{$encuesta->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
            <div class="modal-header bg-danger py-4">
                <h3 class="text-white" id="exampleModalLabel">¿Eliminar la encuesta {{$encuesta->nombre}} ?</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{route('encuesta.delete', $encuesta->id)}}" method="POST">
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


    <div class="modal fade" id="edit_en{{$encuesta->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
        <div class="modal-header bg-primary py-4">
            <h3 class="text-white" id="exampleModalLabel">Editando Encuesta</h3>
            <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body py-4">
            <form action="{{route('encuesta.edit', $encuesta->id)}}" method="post">
                @csrf @method("PATCH")
                <div class="row">
                    <div class="col-12 text-center">
                        <div class="form-group mt-2">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="text" class="form-control form-control-lg {{ $errors->first('nombre_encuesta_edit') ? 'is-invalid' : '' }} " id="nombre_encuesta" value="{{$encuesta->nombre}}" name="nombre_encuesta_edit" required>
                                <label class="form-label" for="nombre_encuesta_edit" >Nombre para la Encuesta</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group mt-3">
                            <div class="form-outline" data-mdb-input-init>
                                <div class="form-outline" data-mdb-input-init>
                                    <input type="number" value="{{$encuesta->meta_minima}}" min="0" max="100" class="form-control w-100 {{ $errors->first('meta_minima_encuesta_edit') ? 'is-invalid' : '' }}" id="meta_minima_encuesta_edit" name="meta_minima_encuesta_edit" required >
                                    <label class="form-label" for="meta_minima_encuesta_edit">Meta Minima</label>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="col-6">
                        <div class="form-group mt-3">
                            <div class="form-outline" data-mdb-input-init>
                                <div class="form-outline" data-mdb-input-init>
                                    <input type="number" value="{{$encuesta->meta_esperada}}" min="0" max="100" class="form-control w-100 {{ $errors->first('meta_esperada_encuesta_edit') ? 'is-invalid' : '' }}" id="meta_esperada_encuesta_edit" name="meta_esperada_encuesta_edit" required >
                                    <label class="form-label" for="meta_esperada_encuesta_edit">Meta Esperada</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <div class="form-group mt-3">
                            <div class="form-outline" data-mdb-input-init>
                                <div class="form-outline" data-mdb-input-init>
                                    <input type="number" value="{{$encuesta->ponderacion}}" min="0" max="100" class="form-control w-100 {{ $errors->first('ponderacion_encuesta_edit') ? 'is-invalid' : '' }}" id="ponderacion_encuesta_edit" name="ponderacion_encuesta_edit" required >
                                    <label class="form-label" for="ponderacion_encuesta_edit">Ponderación</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center">
                        <div class="form-group mt-3">
                            <div class="form-outline" data-mdb-input-init>
                                <div class="form-outline" data-mdb-input-init>
                                    <textarea class="form-control w-100 {{ $errors->first('descripcion_encuesta_edit') ? 'is-invalid' : '' }}" id="descrpcion_encuesta_edit" name="descripcion_encuesta_edit" required >{{$encuesta->descripcion}}</textarea>
                                    <label class="form-label" for="descrpcion_encuesta_edit">Descripción del la Encuesta</label>
                                </div>
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
@empty
    
@endforelse








{{-- modal de la grafica de cumplimiento por mes de las encuestas --}}
<div class="modal fade" id="grafico_mes" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-xl modal-fullscreen-sm-down">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="exampleModalLabel">Gráfica</h5>
        <button type="button" class="btn-close" data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
        <div class="modal-body">
            <div class="col-12" >
                <!-- Tabs navs -->
                <ul class="nav nav-tabs nav-justified mb-3" id="ex1" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark active" id="ex3-tab-1" href="#ex3-tabs-1" role="tab" aria-controls="ex3-tabs-1" aria-selected="true">
                            <i class="fa-solid fa-chart-simple"></i>
                            Grafico de Barras
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark" id="ex3-tab-2" href="#ex3-tabs-2" role="tab" aria-controls="ex3-tabs-2" aria-selected="false">
                            <i class="fa fa-chart-line"></i>
                            Grafico de Linea
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a data-mdb-tab-init class="nav-link fw-bold h-4 text-dark" id="ex3-tab-3" href="#ex3-tabs-3" role="tab" aria-controls="ex3-tabs-3" aria-selected="false">
                            <i class="fa fa-circle"></i>
                            Grafico de Pie
                        </a>
                    </li>
                </ul>
                <!-- Tabs navs -->

                <!-- Tabs content -->
                <div class="tab-content" id="ex2-content">
                    <div class="tab-pane  show active" id="ex3-tabs-1" role="tabpanel" aria-labelledby="ex3-tab-1" >
                        <canvas id="grafico_encuestas_barras_"></canvas>
                    </div>
                    <div class="tab-pane  p-5" id="ex3-tabs-2" role="tabpanel" aria-labelledby="ex3-tab-2">
                        <canvas id="grafico_encuestas_lineas"></canvas>
                    </div>
                    <div class="tab-pane " id="ex3-tabs-3" role="tabpanel" aria-labelledby="ex3-tab-3">
                        <canvas id="grafico_encuestas_pie"></canvas>
                    </div>
                </div>
                <!-- Tabs content -->

            </div>
        </div>
    </div>
  </div>
</div>


@endsection


@section('scripts')
    



<script>

const graficas_encuestas = @json($resultado_encuestas);

if (!graficas_encuestas || graficas_encuestas.length === 0) {
  console.warn('No hay datos para graficar');
} else {

  const meses = [
    "Enero","Febrero","Marzo","Abril","Mayo","Junio",
    "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"
  ];

  // 🔹 Labels globales (todos los meses usados)
  const labelsRaw = [...new Set(
    graficas_encuestas.flatMap(g => g.labels)
  )].sort();

  const labels = labelsRaw.map(fecha => {
    const [year, month] = fecha.split("-");
    return `${meses[month - 1]} ${year}`;
  });

  // 🔹 Colores automáticos
  const colores = [
    "rgba(54, 162, 235, 0.7)",
    "rgba(255, 99, 132, 0.7)",
    "rgba(75, 192, 192, 0.7)",
    "rgba(255, 159, 64, 0.7)",
    "rgba(153, 102, 255, 0.7)",
    "rgba(201, 203, 207, 0.7)"
  ];

  // 🔹 Datasets por encuesta (alineados por mes)
  const datasets = graficas_encuestas.map((g, index) => {
    const dataAlineada = labelsRaw.map(mes => {
      const pos = g.labels.indexOf(mes);
      return pos !== -1 ? g.data[pos] * 10 : 0;
    });

    return {
      label: g.encuesta,
      data: dataAlineada,
      backgroundColor: colores[index % colores.length],
      borderColor: colores[index % colores.length].replace('0.7', '1'),
      borderWidth: 1
    };
  });

  const ctx = document
    .getElementById('grafico_encuestas_barras_')
    .getContext('2d');

  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: labels,
      datasets: datasets
    },
options: {
  responsive: true,
  plugins: {
    legend: {
      position: 'top'
    },
    tooltip: {
      callbacks: {
        label: function(context) {
          return `${context.dataset.label}: ${context.raw}%`;
        }
      }
    }
  },
  scales: {
    y: {
      beginAtZero: true,
      max: 100,
      ticks: {
        callback: function(value) {
          return value + '%';
        }
      }
    }
  }
}

  });
}

</script>



<script>

if (!graficas_encuestas || graficas_encuestas.length === 0) {
  console.warn('No hay datos para graficar');
} else {

  const meses = [
    "Enero","Febrero","Marzo","Abril","Mayo","Junio",
    "Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"
  ];

  // 🔹 Labels globales (todos los meses usados)
  const labelsRaw = [...new Set(
    graficas_encuestas.flatMap(g => g.labels)
  )].sort();

  const labels = labelsRaw.map(fecha => {
    const [year, month] = fecha.split("-");
    return `${meses[month - 1]} ${year}`;
  });

  // 🔹 Colores automáticos
  const colores = [
    "rgba(54, 162, 235, 1)",
    "rgba(255, 99, 132, 1)",
    "rgba(75, 192, 192, 1)",
    "rgba(255, 159, 64, 1)",
    "rgba(153, 102, 255, 1)",
    "rgba(201, 203, 207, 1)"
  ];

  // 🔹 Datasets por encuesta (alineados por mes)
  const datasets = graficas_encuestas.map((g, index) => {

    const dataAlineada = labelsRaw.map(mes => {
      const pos = g.labels.indexOf(mes);
      return pos !== -1 ? g.data[pos] * 10 : null; // null rompe la línea
    });

    return {
      label: g.encuesta,
      data: dataAlineada,
      borderColor: colores[index % colores.length],
      backgroundColor: colores[index % colores.length],
      borderWidth: 2,
      tension: 0.3,
      fill: false,
      pointRadius: 4,
      pointHoverRadius: 6
    };
  });

  const ctx = document
    .getElementById('grafico_encuestas_lineas')
    .getContext('2d');

  new Chart(ctx, {
    type: 'line',
    data: {
      labels: labels,
      datasets: datasets
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'top'
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return `${context.dataset.label}: ${context.raw}%`;
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          max: 100,
          ticks: {
            callback: function(value) {
              return value + '%';
            }
          }
        }
      }
    }
  });

}
</script>



<script>



if (!graficas_encuestas || graficas_encuestas.length === 0) {
  console.warn('No hay datos para graficar');
} else {

  // 🔹 Obtener el último mes global
  const labelsRaw = [...new Set(
    graficas_encuestas.flatMap(g => g.labels)
  )].sort();

  const ultimoMes = labelsRaw[labelsRaw.length - 1];

  // 🔹 Datos del pie (una rebanada por encuesta)
  const labelsPie = [];
  const dataPie = [];

  graficas_encuestas.forEach(g => {
    const pos = g.labels.indexOf(ultimoMes);
    if (pos !== -1) {
      labelsPie.push(g.encuesta);
      dataPie.push(g.data[pos] * 10); // a %
    }
  });

  // 🔹 Colores
  const colores = [
    "rgba(54, 162, 235, 0.8)",
    "rgba(255, 99, 132, 0.8)",
    "rgba(75, 192, 192, 0.8)",
    "rgba(255, 159, 64, 0.8)",
    "rgba(153, 102, 255, 0.8)",
    "rgba(201, 203, 207, 0.8)"
  ];

  const ctx = document
    .getElementById('grafico_encuestas_pie')
    .getContext('2d');

  new Chart(ctx, {
    type: 'pie',
    data: {
      labels: labelsPie,
      datasets: [{
        data: dataPie,
        backgroundColor: colores.slice(0, labelsPie.length),
        borderColor: '#fff',
        borderWidth: 2
      }]
    },
    options: {
      responsive: true,
      plugins: {
        legend: {
          position: 'right'
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return `${context.label}: ${context.raw}%`;
            }
          }
        }
      }
    }
  });

}



</script>



@endsection
    