@extends('plantilla')
@section('title', 'Perfil del usuario')



@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center justify-content-start ">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  py-4">
            <h1 class="text-white">{{Auth::user()->departamento->nombre}}</h1>

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

    <div class="row border-bottom py-2">
        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-primary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_servicio">
            <i class="fa-solid fa-edit"></i>
                Evaluar Servicio / Entrega de Porveedor
            </button>
        </div>
    </div>
</div>



<div class="container-fluid border-bottom py-4">
     <div class="row">
        <div class="col-12 ">
            <h5>Indicadores de {{Auth::user()->departamento->nombre}}</h5>
        </div>
     </div>

    <div class="row ">
        @forelse ($indicadores as $indicador)
        <div class="col-auto m-2">
            <a href="{{route('show.indicador.user', $indicador->id)}}" class="btn btn-outline-secondary py-3 ">
                {{$indicador->nombre}}
            </a>
        </div>
        @empty
        <li>No hay datos </li>
        @endforelse
    </div>
</div>


<div class="container-fluid border-bottom py-4">

     <div class="row">
        <div class="col-12">
            <div class="row justify-content-start pb-5 mt-4 border-bottom">
                <div class="col-12 mb-3">
                    <h5>Evaluaciones realizadas por {{Auth::user()->departamento->nombre}}</h5>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-11 border shadow-sm mx-2">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">Fecha</th>
                                <th scope="col">Proveedor</th>
                                <th scope="col">Servicio y/o Entrega</th>
                                <th scope="col">Observaciones</th>
                                <th scope="col">Calificación Otorgada </th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($evaluaciones as $evaluacion)
                                <tr>
                                    <th scope="row">{{$evaluacion->fecha}}</th>
                                    <td>{{$evaluacion->proveedor->nombre}}</td>
                                    <td>{{$evaluacion->descripcion}}</td>
                                    <td>{{$evaluacion->observaciones}}</td>
                                    <td class="{{($evaluacion->calificacion > 80) ? 'text-success fw-bold' : 'text-danger fw-bold'}}" >
                                        <i class="fa  {{($evaluacion->calificacion > 80) ? 'fa-check-circle' : 'fa-xmark-circle'}}"></i>
                                        {{$evaluacion->calificacion}} Puntos
                                    </td>
                                </tr>                   
                                @empty
                                    
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
     </div>
</div>




<div class="modal fade" id="agregar_servicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Registrar entrega y/o servicio</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('evaluacion.servicio.store', Auth::user()->id)}}" method="post">
            @csrf
            <div class="row">

                <div class="col-12 text-center">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <div class="form-outline" data-mdb-input-init>
                                <textarea class="form-control w-100 {{ $errors->first('descrpcion_servicio') ? 'is-invalid' : '' }}" id="descrpcion_servicio" name="descripcion_servicio" required ></textarea>
                                <label class="form-label" for="descrpcion_servicio">Descripción del servicio y/o entrega.</label>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="col-12 text-center">
                    <div class="form-group mt-2">
                        <div class="form-group" >
                            <select name="proveedor" id="" class="form-control" required>
                                <option value="" disabled selected>Selecciona al proveedor</option>
                                @forelse ($proveedores as $proveedor)
                                    <option value="{{$proveedor->id}}">{{$proveedor->nombre}}</option>
                                @empty
                                <option value="" disabled selected>No hay Datos</option>                                    
                                @endforelse
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <div class="form-outline" data-mdb-input-init>
                                <textarea class="form-control w-100 {{ $errors->first('observaciones_servicio') ? 'is-invalid' : '' }}" id="observaciones_servicio" name="observaciones_servicio" required ></textarea>
                                <label class="form-label" for="observaciones_servicio">Observaciones</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 text-center">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="number" min="0" max="100" class="form-control w-100 {{ $errors->first('calificacion') ? 'is-invalid' : '' }} " id="calificacion" name="calificacion" required>
                            <label class="form-label" for="calificacion" >Calificacion del 1 al 100</label>
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

