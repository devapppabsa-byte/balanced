@extends('plantilla')
@section('title', 'Logs del sistema')

@section('contenido')
<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center">
        <div class="col-auto pt-2 text-white">
            <h3 class="mt-1 league-spartan">Cargar Información Externa</h3>
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
            @if (session('eliminado'))
                <div class="text-white fw-bold ">
                    <i class="fa fa-check-circle mx-2"></i>
                    {{session('eliminado')}}
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
    <div class="row justify-content-center">

        <div class="col-11  mx-5 bg-white rounded border p-5 shadow-sm">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <h2>
                        <i class="fa-solid fa-book"></i>
                        Logs del sistema
                    </h2>

                </div>
            </div>
                @if (!$logs->isEmpty())
                    <div class="table-responsive shadow-sm">
                        <table class="table table-responsive mb-0 border shadow-sm table-hover">
                                <thead class="table-dark text-white cascadia-code">
                                    <tr>
                                    <th>ID</th>
                                    <th>Autor</th>
                                    <th>Descripción</th>
                                    <th>Dirección IP</th>
                                    <th>Acción</th>
                                    <th>Fecha</th>
                                    </tr>
                                </thead>
                            <tbody>
                @endif

                @forelse ($logs as $log)
                    <tr>
                        <td>
                            <p class="my-0 py-0 fw-bold">
                               # {{$log->id}}
                            </p> 
                        </td>

                        <td>
                            <p class="my-0 py-0">
                                {{$log->autor}}
                            </p>    
                        </td>
                        
                        <td>
                            <p class="my-0 py-0">
                                {{$log->descripcion}}
                            </p>
                        </td>

                        <td>
                            <p class="my-0 py-0">
                                {{$log->ip}}
                            </p>
                        </td>

                        <td>
                            <p class="my-0 py-0">
                                <i class="fa 
                                    {{ $log->accion == 'add' ? 'fa-plus-circle text-primary' : 
                                    ($log->accion == 'start_session' ? 'fa-right-to-bracket' :
                                    ($log->accion == 'excel' ? ' fa-file-excel text-success' : 
                                    ($log->accion == 'deleted' ? 'fa-trash text-danger' : 
                                    ($log->accion == 'update' ? 'fa-edit text-warning' : '')))) }}">
                                </i>
                            </p>
                        </td>

                        <td>
                            <p class="my-0 py-0">
                                {{$log->created_at->locale('es')->translatedFormat('d F Y')}}
                            </p>
                        </td>


                    </tr>
                @empty
                    <div class="col-12 p-5 text-center p-5 border">

                        <div class="row">
                            
                            <div class="col-12">
                                <i class="fa fa-exclamation-circle text-danger"></i>
                                No hay logs que mostrar
                            </div>

                        </div>
                        <h5>
                        </h5>
                    </div>
                @endforelse
                </tbody>
            </table>
        </div>
        <div class="row mt-4">
            <div class="col-12 text-center  ">
                {{$logs->links()}}
            </div>
        </div>
        </div>
    </div>
</div>



@endsection