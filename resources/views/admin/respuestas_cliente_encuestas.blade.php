@extends('plantilla')
@section('title', 'Respuestas del cliente')

@section('contenido')
<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center px-4">
        <div class="col-auto py-4 text-white">
            <h1 class="mt-1">Respuestas de la encuesta</h1>
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
    <div class="row justify-content-center d-flex aligns-items-center">

        <div class="col-12 col-sm-12 col-md-10 col-lg-8 mt-5 mb-0">
            <h3 class="text-center">Respuestas de {{$cliente->nombre}}</h3>
                <table class="table border shadow-sm">
                    <thead class="table-secondary border">
                        <th scope="col">Pregunta</th>
                        <th scope="col">Calificación</th>
                      
                    </thead>
                    <tbody class="">
                        @forelse ($preguntas as $pregunta)
                            <tr>
                                <th>{{$pregunta->pregunta}}</th>
                                    @foreach ($pregunta->respuestas as $respuesta)

                                        @if ($pregunta->cuantificable === 1 )
                                            <td >
                                                {{ $respuesta->respuesta}} Puntos
                                                <input type="hidden" value="{{$respuesta->respuesta}}" class="sumar">
                                            </td>
                                            
                                        @else
                                            <td>
                                                {{$respuesta->respuesta}} 
                                            </td>
                                        @endif
                                    @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td>
                                    <div class="row justify-content-center">
                                        <div class="col-auto">
                                            <i class="fa fa-exclamation-circle text-danger"></i>
                                            No cuenta con respuestas.
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
        </div>

        <div class="col-12 col-sm-12 col-md-6 col-lg-8 mt-0 text-center  border">
            <div class="row justify-content-around bg-light">
                
                <div class="col-auto  p-3">
                    <h3 class="fw-bold">Puntuación Maxima </h3>
                    <h3 id="puntuacion_maxima">1</h3>
                </div>
                
                <div class="col-auto p-3">
                    <h3 class="fw-bold">Puntuación Obtenida </h3>
                    <h3 id="puntuacion_obtenida"></h3>
                </div>

                <div class="col-auto p-3">
                    <h3 class="fw-bold">Cumplimiento</h3>
                    <h3 id="cumplimiento"></h3>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
    



@section('scripts')
<script>

    let suma = 0;
    const celdas = document.querySelectorAll('.sumar');
    const cumplimiento = document.getElementById("cumplimiento");
    const puntuacion_maxima = document.getElementById("puntuacion_maxima");
    const puntuacion_obtenida = document.getElementById("puntuacion_obtenida"); 

    console.log(celdas)
    
    celdas.forEach(input => {
        const valor = parseFloat(input.value.trim()) || 0;
        suma += valor;
    });

    //Esto me ayuda a sacar el porcentaje de las respuestas gardadas por el usurio
    puntuacion_maxima.textContent = celdas.length*10;
    puntuacion_obtenida.textContent = suma;
    cumplimiento.textContent =  ((Number(puntuacion_obtenida.textContent) / Number(puntuacion_maxima.textContent)) * 100 ) + " %" ;

</script>
@endsection