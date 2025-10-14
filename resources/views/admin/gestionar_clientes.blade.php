@extends('plantilla')
@section('title', 'Gestionar clientes de la empresa')

@section('contenido')
<div class="container-fluid">
    <div class="row bg-primary  d-flex align-items-center   ">
        <div class="col-auto py-4 text-white">
            <h1 class="mt-1">Clientes de la empresa</h1>
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
    <div class="row  border-bottom mb-5 bg-white shadow-sm">
        <div class="col-12 col-sm-12 col-md-6 col-lg-auto my-1">
            <button class="btn btn-secondary w-100" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_cliente">
                <i class="fa fa-plus-circle"></i>
                Agregar Cliente
            </button>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row justify-content-center">

        <div class="col-12 col-sm-12 col-md-10 col-lg-9  mx-5 bg-white rounded border p-5 shadow-sm">
            <div class="row justify-content-center">
                <div class="col-12 text-center">
                    <h2>
                        <i class="fa fa-users"></i>
                        Lista de Clientes
                    </h2>
                    @if (session('eliminado'))
                        <h5 class="">
                            <i class="fa fa-exclamation-circle text-danger"></i>
                            {{session('eliminado')}}
                        </h5>
                    @endif
                </div>
            </div>
                @if (!$clientes->isEmpty())
                    <div class="table-responsive shadow-sm">
                        <table class="table table-responsive mb-0 border shadow-sm table-hover">
                                <thead class="table-secondary text-white cascadia-code">
                                    <tr>
                                    <th>Id</th>
                                    <th>Nombre</th>
                                    <th>Correo</th>
                                    <th>Linea</th>
                                    <th>Teléfono</th>
                                    <th>Acciones</th>
                                    </tr>
                                </thead>
                            <tbody>
                @endif

                @forelse ($clientes as $cliente)
                    <tr>
                        <td>
                            {{$cliente->id_interno}}
                        </td>

                        <td>
                           {{$cliente->nombre}}
                        </td>

                        <td>
                            <a href="mailto:{{$cliente->email}}" class="text-dark fw-bold" data-mdb-tooltip-init title="Mandar un correo a {{$cliente->email}}" >
                            <i class="fa-solid fa-envelopes-bulk"></i>
                                {{$cliente->email}}
                            </a>
                        </td>
                        <td>
                            {{$cliente->linea}}
                        </td>

                        <td>
                            <a href="tel:+52{{$cliente->telefono}}" data-mdb-tooltip-init title="Llamar a  {{$cliente->telefono}}"  class="text-dark fw-bold">
                                <i class="fa fa-square-phone"></i>
                                {{$cliente->telefono}}
                            </a>
                        </td>

                        <td class="">
                            <a class="text-danger cursor-pointer" data-mdb-tooltip-init title="Eliminar {{$cliente->nombre}}"  data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#del_client{{$cliente->id}}" style="cursor: pointer">
                                <i class="fa fa-trash"></i> 
                            </a>

                            <a class="text-primary cursor-pointer" data-mdb-tooltip-init title="Editar {{$cliente->nombre}}"  data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#edit_client{{$cliente->id}}"  style="cursor: pointer">
                                <i class="fa fa-edit"></i> 
                            </a>

                        </td>
                    </tr>
                @empty
                    <div class="col-12 p-5 text-center p-5 border">

                        <div class="row">
                            
                            <div class="col-12">
                                <i class="fa fa-exclamation-circle text-danger"></i>
                                No cuenta con clientes, pero los puedes agregar aqui
                            </div>
                            
                            <div class="col-12">
                                <a class="btn btn-secondary btn-sm" data-mdb-ripple-init data-mdb-modal-init data-mdb-target="#agregar_cliente">
                                    Agregar Cliente
                                </a>
                            </div>

                        </div>
                        <h5>
                        </h5>
                    </div>
                @endforelse
                </tbody>
            </table>
        </div>
        </div>
    </div>
</div>




{{-- Ciclos de los modales de los clientes --}}

@forelse ($clientes as $cliente)

<div class="modal fade" id="del_client{{$cliente->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-danger py-4">
                <h3 class="text-white" id="exampleModalLabel">¿Eliminar {{$cliente->nombre}} ?</h3>
                <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body py-4">
                <form action="{{route('eliminar.cliente', $cliente->id)}}" method="POST">
                    @csrf @method('DELETE')
                    <button  class="btn btn-danger w-100 py-3" data-mdb-ripple-init>
                        <h6>Eliminar</h6>
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="edit_client{{$cliente->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Editar Cliente</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('editar.cliente', $cliente->id)}}"  method="post" onkeydown="return event.key !='Enter';">
            @csrf @method('PATCH')

            <div class="row">

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('id_cliente_edit') ? 'is-invalid' : '' }} " value="{{old("id_cliente_edit", $cliente->id_interno)}}"  name="id_cliente_edit">
                            <label class="form-label" for="id_cliente_edit" >ID Interno </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('nombre_cliente_edit') ? 'is-invalid' : '' }} "  value="{{old("nombre_cliente_edit", $cliente->nombre)}}" name="nombre_cliente_edit">
                            <label class="form-label" for="nombre_cliente_edit" >Nombre del cliente </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('correo_cliente_edit') ? 'is-invalid' : '' }} "  name="correo_cliente_edit" value="{{old("correo_cliente_edit", $cliente->email)}}">
                            <label class="form-label" for="correo_cliente_edit" >Correo del cliente</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('telefono_cliente_edit') ? 'is-invalid' : '' }}" name="telefono_cliente_edit" value="{{old("telefono_cliente_edit", $cliente->telefono)}}">
                            <label class="form-label" for="telefono_cliente_edit" >Teléfono del cliente</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('password_cliente_edit') ? 'is-invalid' : '' }}" name="password_cliente_edit" value="{{old("password_cliente_edit")}}">
                            <label class="form-label" for="password" >Contraseña </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group mt-3">
                        <select name="linea_edit" class="form-control form-control-lg" >
                            <option value="" disabled selected>Linea</option>
                            <option value="Mascotas" {{old("linea_edit", $cliente->linea)  == 'Mascotas' ? 'selected' : '' }} >Mascotas</option>
                            <option value="Pecuarios" {{old("linea_edit", $cliente->linea) == 'Pecuarios' ? 'selected' : '' }} >Pecuarios</option>
                            <option value="Pecuarios y Mascotas" {{old("linea_edit", $cliente->linea)  == 'Pecuarios y Mascotas' ? 'selected' :'' }} >Pecuarios y Mascotas</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button  class="btn btn-primary w-100 pt-3" data-mdb-ripple-init>
                <h6>Guardar Cliente</h6>
            </button>
        </form>
      </div>
    </div>
  </div>
</div>
@empty
    
@endforelse









<div class="modal fade" id="agregar_cliente" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true" data-mdb-backdrop="static">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary py-4">
        <h3 class="text-white" id="exampleModalLabel">Agregar Cliente</h3>
        <button type="button" class="btn-close " data-mdb-ripple-init data-mdb-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body py-4">
        <form action="{{route('agregar.cliente')}}"  method="post" onkeydown="return event.key !='Enter';">
            @csrf

            <div class="row">

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('id_cliente') ? 'is-invalid' : '' }} " value="{{old("id_cliente")}}" id="id_cliente" name="id_cliente">
                            <label class="form-label" for="id_cliente" >ID Interno </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('nombre_cliente') ? 'is-invalid' : '' }} " id="nombre_usuario" value="{{old("nombre_cliente")}}" name="nombre_cliente">
                            <label class="form-label" for="nombre_cliente" >Nombre del cliente </label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('correo_cliente') ? 'is-invalid' : '' }} "  name="correo_cliente" value="{{old("correo_cliente")}}">
                            <label class="form-label" for="correo_cliente" >Correo del cliente</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('telefono_cliente') ? 'is-invalid' : '' }}" name="telefono_cliente" value="{{old("telefono_cliente")}}">
                            <label class="form-label" for="telefono_cliente" >Teléfono del cliente</label>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-12 col-lg-6">
                    <div class="form-group mt-3">
                        <div class="form-outline" data-mdb-input-init>
                            <input type="text" class="form-control form-control-lg {{ $errors->first('password_cliente') ? 'is-invalid' : '' }}" name="password_cliente" value="{{old("password_cliente")}}">
                            <label class="form-label" for="password" >Contraseña </label>
                        </div>
                    </div>
                </div> 

                <div class="col-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="form-group mt-3">
                        <select name="linea" class="form-control form-control-lg" id="">
                            <option value="" disabled selected>Linea</option>
                            <option value="Mascotas" {{old("linea")  == 'Mascotas' ? 'selected' : '' }} >Mascotas</option>
                            <option value="Pecuarios" {{old("linea") == 'Pecuarios' ? 'selected' : '' }} >Pecuarios</option>
                            <option value="Pecuarios y Mascotas" {{old("linea")  == 'Pecuarios y Mascotas' ? 'selected' :'' }} >Pecuarios y Mascotas</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button  class="btn btn-primary w-100 pt-3" data-mdb-ripple-init>
                <h6>Guardar Cliente</h6>
            </button>
        </form>
      </div>
    </div>
  </div>
</div>








@endsection