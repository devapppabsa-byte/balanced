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


    <div class="row gap-4 p-2 mt-4  border-bottom pb-5">
        <div class="col-12">
            <h2>Llenar Indicador</h2>
        </div>
        @forelse ($campos_vacios as $campo_vacio)
            <div class="col-11  col-sm-11 col-md-3 col-lg-2 text-start border border-4 mb-4 p-3 shadow-sm campos_vacios">
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
        @if (!$campos_vacios->isEmpty())
            <div class="col-12 text-center">
                <div class="row justify-content-center">
                    <div class="col-10 col-sm-10 col-md-4  col-lg-2">
                        <button class="btn btn-primary py-3 w-100">
                            <i class="fa fa-save mx-2"></i>
                            Guardar
                        </button>
                    </div>
                </div>
            </div>
        @endif
    </div>


    <div class="row justify-content-center pb-5 mt-5 border-bottom">
        <div class="col-12 mb-5">
            <h2>Tabla de seguimiento del indicador</h2>
        </div>

        <div class="col-10 col-sm-10 col-md-9 col-lg-8 border shadow-sm">
            <div class="table-responsive">
            <table class="table">
                <thead>
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
                    <td>3950</td>
                    <td class="text-success fw-bold">98.75%</td>
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

    </div>


@endsection











@section('scripts')

<script>
    let mostrar_fecha = document.getElementById("fecha");
    let fecha = new Date();
    mostrar_fecha.innerHTML = " <i class='fa fa-calendar'></i>  " + fecha.toLocaleDateString("es-Es", {month: 'long'}) +" "+ fecha.getFullYear();
</script>





<script>

document.getElementById("suma").addEventListener('click', function(){
        

    const campos_calculados = @json($campos_calculados);

    //console.log(calculado.id_input); //necesito agrupar  los inputs consus
    let inputs_involucrados = [];
    let suma =0;
    let contador = 0;


    campos_calculados.forEach(calculado => { //recorro todos los inputs calculados

        calculado.campo_involucrado.forEach(involucrado =>{ //recorro los campos involucrados, ew el ciclo dentro de otro ciclo.

            inputs_involucrados.push(document.getElementById(involucrado.id_input).value);
            //aqui arriba se agregan los iputs involucrados a un array, este array se va  a imprimir al ultimo.

            suma = Number(suma) + Number(document.getElementById(involucrado.id_input).value);


            
            
        });

        
        console.log(document.getElementById(calculado.id_input).value = suma);

        contador++;
        //console.log(document.getElementById(calculado.id_input).value = suma)
        console.log(suma)        

    });
});   


</script>



<script>

</script>



@endsection