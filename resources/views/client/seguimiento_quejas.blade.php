@extends('plantilla')
@section('title', 'Seguimiento a quejas y sugerencias')

@section('contenido')
 <div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center ">
        <div class="col-9 col-sm-9 col-md-8 col-lg-10 pt-2 text-white">
            <h3 class="mt-1 mb-0">
                Hola {{strtok(Auth::guard("cliente")->user()->nombre, " ")}}, 
            </h3>
            <span>Bienvenido a tus encuestas</span>
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

        <div class="col-3 col-sm-3 col-md-4 col-lg-2 text-center ">
            <form action="{{route('cerrar.session')}}" method="POST">
                @csrf 
                <button  class="btn  btn-sm text-danger text-white fw-bold">
                    <i class="fa-solid fa-arrow-right-from-bracket"></i>
                    Cerrar Sesión
                </button>
            </form>
        </div>

    </div>

    @include('client.assets.nav')

    <div class="row bg-white shadow-sm border-bottom">
        <div class="col-12 col-sm-12 col-md-4 col-lg-auto m-1 p-2">
            <a class="btn btn-danger btn-sm w-100 px-3 py-1" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#sugerencia">
                <i class="fa-solid fa-comments"></i>
                Queja o sugerencia
            </a>
        </div>
    </div>


    <div class="container-fluid mt-4 fade-out" id="content">
        <div class="row justify-content-center">
            <div class="col-8 bg-white shadow rounded-5">



                

                <div class="row p-2">

                    <div class="col-6 p-3">
                        <div class="row">
                            <div class="col-12 text-center m-2">
                                <h2>
                                    <i class="fa fa-camera"></i>
                                    Evidencias
                                </h2>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-2 p-3 border border-3 m-2 rounded-5">
                                <img src="{{asset('/img/iconos/mp4.png')}}" class="img-fluid" alt="">
                            </div>

                            <div class="col-2 p-3 border border-3 m-2 rounded-5">
                                <img src="{{asset('/img/iconos/docx.png')}}" class="img-fluid" alt="">
                            </div>

                            <div class="col-2 p-3 border border-3 m-2 rounded-5">
                                <img src="{{asset('/img/iconos/jpg.png')}}" class="img-fluid" alt="">
                            </div>

                            <div class="col-2 p-3 border border-3 m-2 rounded-5">
                                <img src="{{asset('/img/iconos/pdf.png')}}" class="img-fluid" alt="">
                            </div>



                        </div>
                    </div>


                    <div class="col-6 cascadia bg-light p-4 reportes-scroll border-0">
                        <h3>Seguimiento: </h3>

                        <div class="row">
                                <div class="col-12 my-4">
                                    <b class="font-size-18">something: </b>
                                    <p class="mb-0">Comentareio del seguimietno</p>
                                    <small class="font-weight-bold bd-highlight">27 de enero del 2026</small>
                                </div>



                                <div class="col-12 mt-5 ">
                                    <form action="#" method="POST">
                                        <div class="form-group">
                                            <i class="fa fa-comment text-primary"></i>
                                            <b>Nombre del usuario: </b>
                                            <textarea name="comentario" class="form-control w-100 h-25" autofocus></textarea>
                                        </div>
                                        <div class="from-group mt-3">
                                            <button class="btn btn-primary btn-sm">Enviar</button>
                                        </div>
                                    </form>
                                </div>




                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>




</div>       



@endsection