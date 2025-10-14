@extends('plantilla')
@section('title', 'Cumplimiento a Normatividad')
@section('contenido')
<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center justify-content-start ">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  py-4">
            <h2 class="text-white">
                <i class="fa-regular fa-file-lines"></i>
                {{Auth::user()->departamento->nombre}} - Cumplimiento Normativo
            </h2>
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
    @include('user.assets.nav')
</div>
    



<div class="container-fluid">
    <div class="row justify-content-around p-3">
        @forelse ($normas as $norma)
        <div class="col-11 col-sm-11 col-md-5  col-lg-3  shadow-sm m-2 border bg-white shadow-sm border-4 text-center">
            <a href="{{route('registro.cumplimiento.normativa.index', $norma->id)}}" class="text-dark w-100 h-100 start-0 top-0 p-4">
                <h4 class="fw-bold">
                
                    {{$norma->nombre}}
                 </h4>
                <p class="text-justify lh-sm" style="text-align: justify">
                    {{$norma->descripcion}}
                </p>      
            </a>
        </div>
            

        @empty
            <div class="col-8 py-5 bg-white shadow-sm border-4 text-center">
                <div class="row">
                    <div class="col-12">
                        <img src="{{asset('/img/iconos/empty.png')}}" alt="" class="img-fluid">
                    </div>
                    <div class="col-12">
                        <h2>
                            <i class="fa fa-exclamation-circle text-danger"></i>
                            No hay datos para mostrar.
                        </h2>
                    </div>
                </div>
            </div>
        @endforelse
    </div>
</div>



@endsection