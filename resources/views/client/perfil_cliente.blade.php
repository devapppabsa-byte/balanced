@extends('plantilla')
@section('title', 'Perfil Cliente')
@section('contenido')
@php
    use App\Models\ClienteEncuesta;
@endphp
<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center px-4">
        <div class="col-12 col-sm-12 col-md-8 col-lg-10 py-4 text-white">
            <h1 class="mt-1">
                <i class="fa fa-clipboard-list"></i>
                Hola {{strtok(Auth::guard("cliente")->user()->nombre, " ")}}, 
            </h1>
            <h2>Bienvenido a tus encuestas</h2>
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
            @if (session('contestado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('contestado')}}
                </div>
            @endif

            @if(session('contestada'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('contestada')}}
                </div>
            @endif

            @if ($errors->any())
                <div class="text-white fw-bold bad_notifications">
                    <i class="fa fa-xmark-circle mx-2"></i>
                    {{$errors->first()}}
                </div>
            @endif
        </div>

        <div class="col-12 cl-sm-12 col-md-4 col-lg-2 text-center ">
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






<div class="container-fluid mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-10 col-lg-7">
            <div class="table-responsive shadow-sm">
                <table class="table table-responsive mb-0 border shadow-sm table-hover ">
                        <thead class="table-light  cascadia-code fs-4 ">
                        <tr>
                            <th class="text-gray">Titulo Encuesta</th>
                            <th>Estado</th>
                            <th>Ver</th>
                        </tr>
                        </thead>
                    <tbody>
                    @forelse ($encuestas as $encuesta)
                            @php //Esta logica es engorrosa pero la necesito de momento para diferenciar las encuestas //contestadas de las no contestadas
                                $existe = ClienteEncuesta::where('id_cliente', Auth::guard('cliente')->user()->id)
                                ->where('id_encuesta', $encuesta->id)
                                ->exists();
                            @endphp 
                        @if ($existe)

                                <tr>
                                    <td class="fs-6 fw-bold">
                                        <i class="fa fa-check-circle text-success me-3" ></i>
                                        {{$encuesta->nombre}}
                                    </td>
                                    <td class="fw-bold">
                                        <i class="fa fa-bone mx-2"></i>
                                        Contestada
                                    </td>
                                    <td>
                                        <a class="btn btn-light  btn-sm btn-floating p-3 " disabled onclick="alert('Este cuestionario ya fue contestado.')">
                                            <i class="fa fa-eye"></i>            
                                        </a>
                                    </td>
                                </tr>
  

                            @else
                                <tr>
                                    <td class="fs-6 fw-bold">
                                        <i class="fa fa-exclamation-circle text-dark me-3" ></i>
                                        {{$encuesta->nombre}}
                                    </td>
                                    <td>
                                        <i class="fa fa-exclamation-circle text-danger"></i>
                                        Aún no es contestada
                                    </td>
                                    <td>
                                        <a class="btn btn-primary btn-sm btn-floating p-3 " href="{{route('index.encuesta', $encuesta->id)}}">
                                            <i class="fa fa-eye "></i>            
                                        </a>
                                    </td>
                                </tr>
                            @endif
   
                    @empty
                        <div class="col-12 p-5 text-center p-5 border">

                            <div class="row">
                                
                                <div class="col-12">
                                    <i class="fa fa-exclamation-circle text-danger"></i>
                                    No cuenta con clientes, pero los puedes agregar aqui
                                </div>
                                
                                <div class="col-12">
                                    <a class="btn btn-secondary btn-sm" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_cliente">
                                        Agregar Cliente
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



@endsection