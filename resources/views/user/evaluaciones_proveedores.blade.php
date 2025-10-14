@extends('plantilla')
@section('title', 'Evaluaciones a proveedores')

@section('contenido')
<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center">

        <div class="col-8 col-sm-8 col-md-6 col-lg-9  py-4  py-4 ">
            <h2 class="text-white"> Evaluaciones Porveedores</h2>
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


<div class="container-fliud">
    <div class="row border-bottom py-2 bg-white">
        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-outline-primary btn-sm w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_servicio">
            <i class="fa-solid fa-edit"></i>
                Evaluar Servicio / Entrega de Porveedor
            </button>
        </div>
    </div>
</div>




<div class="container-fluid py-4">
     <div class="row justify-content-center">
        <div class="col-10 bg-white border rounded rounded-5 py-5">
            <div class="row d-flex align-items-center justify-content-center pb-5 mt-4 ">
                <div class="col-11 ms-5 ">
                    <h4>
                        <i class="fa-solid fa-check-to-slot"></i>
                        Evaluaciones realizadas por {{Auth::user()->departamento->nombre}}
                    </h4>
                </div>


                <div class="col-12 col-sm-12 col-md-12 col-lg-11  ">
                    @if (!$evaluaciones->isEmpty())
                        <div class="table-responsive shadow-sm mx-2 border">
                            <table class="table ">
                                <thead class="table-primary">
                                <tr class="fjalla-one-regular ">
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Proveedor</th>
                                    <th scope="col">Servicio y/o Entrega</th>
                                    <th scope="col">Observaciones</th>
                                    <th scope="col">Calificación Otorgada </th>
                                </tr>
                                </thead>
                                <tbody>
                        @endif
                                @forelse ($evaluaciones as $evaluacion)
                                <tr>
                                    <th scope="row">
                                        <i class="fa fa-calendar"></i>
                                        {{$evaluacion->fecha}}
                                    </th>
                                    <td>{{$evaluacion->proveedor->nombre}}</td>
                                    <td>{{$evaluacion->descripcion}}</td>
                                    <td>{{$evaluacion->observaciones}}</td>
                                    <td class="{{($evaluacion->calificacion >= 80) ? 'text-success fw-bold' : 'text-danger fw-bold'}}" >
                                        <i class="fa  {{($evaluacion->calificacion >= 80) ? 'fa-check-circle' : 'fa-xmark-circle'}}"></i>
                                        {{$evaluacion->calificacion}} Puntos
                                    </td>
                                </tr>                   
                                @empty
                                   <div class="col-12  py-5 text-center border">
                                        <div class="row justify-content-center">
                                            <div class="col-12">
                                                <img src="{{asset('/img/iconos/empty.png')}}" class="img-fluid" alt="">
                                            </div>
                                            <div class="col-12">
                                                <h2>
                                                    <i class="fa fa-exclamation-circle text-danger"></i>
                                                    No hay evaluciones aún.
                                                </h2>
                                            </div>
                                        </div>
                                   </div>
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center mt-4">
                        {{$evaluaciones->links()}}
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