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

    <div class="row mb-5 mt-2">
        <div class="col-12">
            <h2>Rellenado del indicador de {{$indicador->nombre}}</h2>
        </div>
    </div>

    <div class="row justify-content-start border py-4 m-1" id="contenedor_campos">

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
    const campos_ = @json($campos_unidos);
    const campos = Object.values(campos_);
    const contenedor = document.getElementById('contenedor_campos')
    
    
    campos.forEach(campo => {
        
        const columna = document.createElement('div');
        columna.classList.add("col-12", "col-sm-8", "col-md-3", "col-lg-2", "text-start", "border", "mb-2", "p-2", "border-3");
           // 

        const form_outline = document.createElement('div');
        form_outline.classList.add("form-outline");
        form_outline.setAttribute('data-mdb-input-init', '');


        const input = document.createElement("input");
        input.name = campo.nombre;
        input.placeholder = campo.nombre;
        input.classList.add("form-control");

        if(campo.informacion_precargada){
            input.value = campo.informacion_precargada;
            input.disabled = true;
        } 

        if(campo.tipo) input.type = campo.tipo;
        if(campo.tipo_dato) input.type = campo.tipo_dato;

        const small = document.createElement("small");
        small.textContent = campo.descripcion; 
            


        const label = document.createElement("label");
        label.textContent = campo.nombre;

        columna.appendChild(label)
        columna.appendChild(input)
        columna.appendChild(small)
        contenedor.appendChild(columna);


    });


</script>    

@endsection