@extends('plantilla')
@section('title', 'Inicio de sesión del usuario')



@section('contenido')

<div class="container-fluid bg-primary py-3 px-4 text-white">
    <div class="row d-flex align-items-center">
        <div class="col-6 text-start ">
            <h3>Inicio de sesión</h3>
        </div>
        <div class="col-6 text-end">
            <a href="{{route('admin.login.index')}}" class="btn btn-primary btn-lg">
                <i  class="fa fa-user mx-1"></i>
                Admin
            </a>
        </div>
    </div>
</div>




<div class="container ">
    <div class="row justify-content-center">
        <div class="col-12 col-sm-12 col-md-7 col-lg-5 mt-5 shadow p-5">
            <div class="row justify-content-center">

                <div class="col-12 mb-2 mb-4">
                    <h1>Inicio de Sesión</h1>
                </div>

                <form action="{{route('login.user')}}" method="POST">
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
                            <button class="btn btn-primary w-100 w-lg-25 btn-lg">
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


















@section('scripts')

@endsection
