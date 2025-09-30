@extends('plantilla')
@section('title', 'Contestando Cuestionario')

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
        @if (!$preguntas->isEmpty())
            <div class="col-8 p-4">
                <div class="row">
                    <div class="col-12 text-center my-2">
                        <h2>Preguntas de {{$encuesta->nombre}}</h2>
                    </div>  
                </div>
                <form action="{{route('contestar.encuesta', $encuesta->id)}}" method="POST" class="row mt-2 d-flex  justify-content-center">
                    @csrf
                    
                    @php
                        $contador_preguntas = 0;
                    @endphp

                    @forelse ($preguntas as $pregunta) 
                    @php
                        $contador_preguntas ++;
                    @endphp
                        <div class="col-11  p-2 gap-2 my-3">
                            <div class="row">
                                <div class="col-12">
                                    <h4>{{$pregunta->pregunta}}</h4>
                                </div>
                                @if ($pregunta->cuantificable)
                                    <div class="col-9">
                                        <select name="respuestas[]" class="form-select" id="" required>
                                            <option value="" disabled selected>Seleccione una Opción</option>
                                            <option value="0" >En Desacuerdo</option>
                                            <option value="5" >Medianamente de acuerdo</option>
                                            <option value="10" >Completamente de acuerdo</option>
                                        </select>
                                    </div>
                                @endif
                                @if(!$pregunta->cuantificable)
                                    <div class="col-9">
                                        <input type="text" value="{{old($contador_preguntas)}}" name="respuestas[]" placeholder="Por favor anote su respuesta" class="form-control" name="{{$pregunta->id}}" required>
                                    </div>
                                @endif
                                    <input type="hidden" name="id[]" value="{{$pregunta->id}}">
                            </div>            
                        </div>
                    @empty
                        
                    @endforelse
                        <div class="col-4 text-center mt-5">
                            <button class="btn btn-primary btn-lg py-3">
                                <i class=" fa fa-paper-plane"></i>
                                Enviar
                            </button>
                        </div>
                </form>
            </div>
        @else
            <div class="col-12">
                <div class="row justify-content-center p-5 ">
                    <div class="col-8 border text-center p-5 border-2 rounded-7">
                        <img src="{{asset('/img/empty.svg')}}" class="img-fluid w-50" alt="">
                        <h4> <i class="fa fa-exclamation-circle text-danger"></i> Aún no se agregan preguntas a esta encuesta.</h4>
                    </div>
                </div>
            </div>
        @endif


    </div>


</div>



@endsection