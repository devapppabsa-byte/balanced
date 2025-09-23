@extends('plantilla')
@section('title', 'LLenado de Indicadores')

    


@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center">

        <div class="col-8 col-sm-8 col-md-6 col-lg-9  py-4  py-4 ">
            <h1 class="text-white"> {{$indicador->nombre}} </h1>
            <h3 class="text-white" id="fecha"></h3>
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


    <div class="row mb-5 mt-2 gap-3 justify-content-center">
        <div class="col-12">
            <h3>Campos a rellenar</h3>
        </div>

        <div class="row gap-3 justify-content-center" id="campos_vacios">
            @forelse ($campos_vacios as $campo_vacio)
                <div class="col-11 col-sm-11 col-md-3 col-lg-3 text-start border mb-4 p-3 shadow-sm campos_vacios">
                    <label for="">{{$campo_vacio->nombre}}</label>
                    <input type="{{$campo_vacio->tipo}}" min="1" class="form-control input" name="{{$campo_vacio->id_input}}" id="{{$campo_vacio->id_input}}"
                    placeholder="{{$campo_vacio->nombre}}">
                </div>  
            @empty
                <li>No hay campos vacios :p</li>
            @endforelse
        </div>
        
    </div>








    <div class="row mb-5 mt-2 gap-3 justify-content-center">

        <div class="col-12">
            <h4>Campos Calculados</h4>
        </div>
    
        
        @forelse ($campos_calculados as $campo_calculado)
            <div class="col-11 col-sm-11 col-md-3 col-lg-3 text-start border mb-4 py-3 shadow-sm campo_calculado">
                    <label for="">{{$campo_calculado->nombre}}</label>
                    <input type="{{$campo_calculado->tipo}}" class="form-control input_padre" id="{{$campo_calculado->id_input}}"
                        placeholder="0" disabled>

                @forelse ($campo_calculado->campo_involucrado as $involucrado)
        
                        <input type="text" value="{{$involucrado->id_input}}" class="form-control form-control-sm input_hijo" >
                                
                @empty
                    
                @endforelse
                    
            </div> 
        @empty

            <li>No hay campos</li>
            
        @endforelse
    </div>






    <div class="row justify-content-center gap-4  py-4 my-5" id="contenedor_campos" >

    </div>


@if ($campo_resultado_final)
    <div class="row justify-content-center gap-4  py-4 my-5" id="contenedor_resultado_final">
        <h3 class="">Cumplimiento</h3>
        
        <div class="form-group">
            <label for="{{$campo_resultado_final->id_input}}">{{$campo_resultado_final->nombre}}</label>
            <input type="{{$campo_resultado_final->tipo}}"  class="form-control w-25" id="{{$campo_resultado_final->id_input}}" >
        </div>


    </div>
    @endif
    
    
        <div class="form-group">
            <button class="btn btn-success" id="suma" >
                iam a button
            </button>
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