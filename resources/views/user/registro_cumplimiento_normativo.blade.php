@extends('plantilla')
@section('title', 'Registro de Cumplimiento Mensual')

@section('contenido')


<div class="container-fluid">
    <div class="row bg-primary d-flex align-items-center justify-content-start ">
        <div class="col-12 col-sm-12 col-md-6 col-lg-10  py-4">
            <h2 class="text-white">
                <i class="fa-regular fa-file-lines"></i>
                {{Auth::user()->departamento->nombre}} - {{$norma->nombre}}
            </h2>
            <h4 class="text-white" id="fecha"></h4>

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



<div class="row justify-content-center mt-4">
    <div class="col-12 col-lg-10">

        <div class="card border-0 shadow-sm">

            {{-- Header --}}
            <div class="card-header bg-white border-bottom py-4 text-center">
                <h4 class="fw-bold text-uppercase mb-2">
                    <i class="fa-regular fa-file-lines text-primary me-2"></i>
                    Apartados de {{ $norma->nombre }}
                </h4>

                <p class="text-muted mb-0" style="text-align: justify;">
                    {{ $norma->descripcion }}
                </p>

                @if (session('eliminado'))
                    <div class="alert alert-danger alert-sm mt-3 mb-0 d-inline-block">
                        <i class="fa-solid fa-circle-exclamation me-1"></i>
                        {{ session('eliminado') }}
                    </div>
                @endif
            </div>

            {{-- Body --}}
            <div class="card-body p-0">

                @if (!$apartados->isEmpty())
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">

                            <thead class="table-light border-bottom">
                                <tr>
                                    <th class="ps-4" style="min-width: 220px;">
                                        <small class="text-muted fw-semibold text-uppercase">Apartado</small>
                                    </th>
                                    <th style="min-width: 320px;">
                                        <small class="text-muted fw-semibold text-uppercase">Entregables</small>
                                    </th>
                                    <th class="text-center pe-4" style="width: 160px;">
                                        <small class="text-muted fw-semibold text-uppercase">Acciones</small>
                                    </th>
                                </tr>
                            </thead>

                            <tbody>
                                @foreach ($apartados as $apartado)
                                    <tr class="border-bottom">

                                        {{-- Apartado --}}
                                        <td class="ps-4 fw-semibold text-dark">
                                            {{ $apartado->apartado }}
                                        </td>

                                        {{-- Descripción --}}
                                        <td>
                                            <small class="text-muted">
                                                {{ $apartado->descripcion }}
                                            </small>
                                        </td>

                                        {{-- Acciones --}}
                                        <td class="text-center pe-4">
                                            <div class="btn-group btn-group-sm" role="group">

                                                <button
                                                    class="btn btn-outline-success"
                                                    data-mdb-ripple-init
                                                    data-mdb-modal-init
                                                    data-mdb-target="#reg{{ $apartado->id }}"
                                                    {{ Auth::user()->tipo_usuario !== 'principal' ? 'disabled' : '' }}
                                                    title="Registrar cumplimiento">
                                                    <i class="fa-regular fa-square-check"></i>
                                                </button>

                                                <a href="{{ route('ver.evidencia.cumplimiento.normativo', $apartado->id) }}"
                                                   class="btn btn-outline-primary"
                                                   title="Ver evidencias">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                @else
                    {{-- Empty state --}}
                    <div class="text-center py-5">
                        <div class="mb-4">
                            <img src="{{ asset('/img/iconos/emtpy.png') }}"
                                 class="img-fluid"
                                 style="max-width: 180px; opacity: .6;"
                                 alt="Sin datos">
                        </div>
                        <h6 class="text-muted mb-2">
                            No hay apartados registrados
                        </h6>
                        <p class="text-muted mb-0">
                            <small>No cuenta con datos para esta norma.</small>
                        </p>
                    </div>
                @endif

            </div>
        </div>
    </div>
</div>





</div>





@forelse ($apartados as $apartado)
    <div class="modal fade" id="reg{{$apartado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary py-4">
                    <h3 class="text-white mb-0 pb-0" id="exampleModalLabel">
                        <i class="fa-regular fa-square-check"></i>
                        Registrar Actividad
                    </h3>
                    <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body py-4">
                    <form action="{{route('registro.actividad.cumplimiento.norma', $apartado->id)}}" id="form_cumplimiento_normativo"  method="POST" enctype="multipart/form-data">
                        @csrf 
                        <div class="form-group">
                            <div class="form-outline" data-mdb-input-init>
                                <textarea  class="form-control form-control-lg {{ $errors->first('descripcion_actividad') ? 'is-invalid' : '' }} " value="{{old("descripcion_actividad")}}"  name="descripcion_actividad" required></textarea>
                                <label class="form-label" for="descripcion_actividad" >Descripción Actividad <span class="text-danger">*</span> </label>
                            </div>
                        </div>

                        <div class="form-group mt-4">
                            <label class="bg-light my-2">
                                <i class="fa fa-exclamation-circle"></i>
                                Puedes subir PDF, imagenes, documentos de word y videos de no mas de 10 mb.
                            </label>
                            <input type="file" name="evidencias[]" multiple class="form-control" accept=".jpg,.png,.pdf,.docx,.mp4" required>
                        </div>


                        <div class="form-group mt-3">
                            <button  class="btn btn-primary w-100 " data-mdb-ripple-init>
                                <i class="fa fa-save"></i>
                                Guardar Registro
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>    
@empty
    
@endforelse





{{-- DESDE AQUI LIMPIO LOS DATOS QUE VIENEN DEL CONTROLADOR Y LOS PASO A HTML PARA QUE JS LOS PUEDA TOMAR, SEGURO QUE SE PUEDE HACER DE UNA MEJOR MANERA PERO ASI ESTA BIEN DE MOMENTO. --}}

<div id="data-norma"
    data-user = "{{Auth::user()->name}}"
    data-correos = '@json($correos)''
    data-correo = "{{Auth::user()->email}}"
     data-norma="{{ $norma->nombre }}"
     data-departamento="{{ Auth::user()->departamento->nombre }}">
</div>


@endsection


@section('scripts')
    

<script>


 const data = document.getElementById('data-norma');

let filas = `Se agrego evidencia a: ${data.dataset.norma}
del departamento ${data.dataset.departamento}`;



const correos = JSON.parse(data.dataset.correos);

document.getElementById('form_cumplimiento_normativo')
.addEventListener('submit', function (e) {

    e.preventDefault();


    const inputs = document.querySelectorAll('.input');

    // 🔹 Enviar correo con EmailJS
    emailjs.send('service_ns6885s', 'template_zfgln7k', {
        name: data.dataset.user,
        time: new Date().toLocaleString(),
        message: filas,
        correo: data.dataset.correo,
        mails: correos

    }).then(() => {

        // 🔹 Cuando el correo se envía, ahora sí mandamos el form a Laravel
        e.target.submit();

    }).catch(error => {
        console.error('Error al enviar correo:', error);
        alert('Error al enviar notificación por correo');
    });

});

</script>

@endsection