@extends('plantilla')
@section('title', 'Perfil Cliente')

@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center px-4">
        <div class="col-auto py-4 text-white">
            <h1 class="mt-1">Hola {{strtok(Auth::guard("cliente")->user()->nombre, " ");}}</h1>
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
            @if ($errors->any())
                <div class="text-white fw-bold bad_notifications">
                    <i class="fa fa-xmark-circle mx-2"></i>
                    {{$errors->first()}}
                </div>
            @endif
        </div>
    </div>
</div>


<div class="container-fluid">

    <div class="row justify-content-center mt-3">
        <div class="col-12">
            <div class="row">
                <div class="col-12 text-center my-4">
                    <h2>Cuestionarios Disponibles</h2>
                </div>
            </div>
            <div class="row mt-5 d-flex  justify-content-center">

                @forelse ($encuestas as $encuesta) 
                <div class="col-3  p-4 gap-2 m-2 bg-primary text-white text-center">
                    <a href="{{route('contestar.encuesta', $encuesta->id)}}" class="text-white">
                        <div class="row">
                            <div class="col-12">
                                <h4>{{$encuesta->nombre}}</h4>
                            </div>
                        </div>
                    </a>               
                </div>
                @empty
                    
                @endforelse

            </div>
        </div>
    </div>


</div>



@endsection