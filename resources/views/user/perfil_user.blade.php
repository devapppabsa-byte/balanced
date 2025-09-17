@extends('plantilla')
@section('title', 'Perfil del usuario')



@section('contenido')

<div class="container-fluid">
    <div class="row bg-primary justify-content-start d-flex align-items-center">

        <div class="col-8 col-sm-8 col-md-6 col-lg-9  py-4 ">
            <div class="row">
                <div class="col-auto">
                    <h1 class="text-white">{{Auth::user()->departamento->nombre}}</h1>
                </div>
            </div>
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
     <div class="row">
        <div class="col-12 text-center my-3">
            <h4>Indicadores de {{Auth::user()->departamento->nombre}}</h4>
        </div>
     </div>
</div>



<div class="container-fluid">
    <div class="row justify-content-center">
        @forelse ($indicadores as $indicador)
        <div class="col-auto m-2">
            <a href="{{route('show.indicador.user', $indicador->id)}}" class="btn btn-secondary py-3">
                {{$indicador->nombre}}
            </a>
        </div>
        @empty
            
        @endforelse
    </div>
</div>



@endsection



@section('scripts')

    {{-- <script>
        const campos = @json($campos)
        console.log(campos);
    </script> --}}


@endsection