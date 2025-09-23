@extends('plantilla')
@section('title', 'Cuestionario del cliente')


@section('contenido')

<div class="container-fluid">
    <div class="row">
        <div class="col-12 py-2" style="background: #528053; color:white;">
            <h1>Inicio de Sesión</h1>
        </div>
    </div>
</div>


<div class="container ">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-7 col-lg-5 mt-5 shadow p-5">
            <div class="row justify-content-center">

                <div class="col-12 mb-2 mb-4">
                    <h1>Inicio de Sesión</h1>
                    @if (session("error"))
                        <span class="text-danger fw-bold">
                            <i class="fa fa-exclamation-circle"></i>
                            {{session("error")}}
                        </span>
                    @endif
                </div>

                <form action="#" method="POST">
                    @csrf
                    <div class="col-12">
    
                        <div class="form-group">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="text" id="email" name="email" class="form-control form-control-lg" />
                                <label class="form-label" for="email">Correo Eléctronico </label>
                            </div>
                        </div>
    
                        <div class="form-group mt-3">
                            <div class="form-outline" data-mdb-input-init>
                                <input type="password" class="form-control form-control-lg" id="password" name="password">
                                <label class="form-label" for="password" >Contraseña </label>
                            </div>
                        </div>
    
                        <div class="form-group mt-4">
                            <button class="btn w-100 w-lg-25 btn-lg" style="background: #528053; color:white;">
                                Ingresar
                            </button>
                        </div>

                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

@endsection