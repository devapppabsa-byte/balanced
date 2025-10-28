<div class="row py-2" style="background-color: #5476ac; font-size:14px">

    <div class="col-auto  mx-1 zoom_link {{ request()->routeIs('perfil.admin') ? 'link_selected' : '' }}">
        <a href="{{route("perfil.admin")}}" class="text-white text-decoration-none fw-bold ">
            <i class="fa fa-home"></i>
            Inicio
        </a> 
    </div>

    <div class="col-auto mx-1 zoom_link {{ request()->routeIs('departamentos.show.admin') ? 'link_selected' : '' }}">
        <a href="{{route("departamentos.show.admin")}}" class="text-white text-decoration-none fw-bold ">
            <i class="fa-solid fa-briefcase"></i>
            Gestionar Departamentos
        </a>
    </div>

    <div class="col-auto mx-1 zoom_link {{ request()->routeIs('usuarios.show.admin') ? 'link_selected' : '' }}">
        <a href="{{route("usuarios.show.admin")}}" class="text-white text-decoration-none fw-bold  ">
            <i class="fa fa-users"></i> 
            Usuarios
        </a>
    </div>

    <div class="col-auto mx-1 zoom_link {{ request()->routeIs('clientes.show.admin') ? 'link_selected' : '' }}">
        <a href="{{route("clientes.show.admin")}}" class="text-white text-decoration-none fw-bold ">
            <i class="fa-solid fa-users-viewfinder"></i>
            Clientes
        </a>
    </div>

    <div class="col-auto mx-1 zoom_link {{ request()->routeIs('encuestas.show.admin') ? 'link_selected' : '' }}">
        <a href="{{route("encuestas.show.admin")}}" class="text-white text-decoration-none fw-bold ">
            <i class="fa-solid fa-clipboard-list"></i>
            Encuestas
        </a>
    </div>

    <div class="col-auto mx-1 zoom_link {{ request()->routeIs('proveedores.show.admin') ? 'link_selected' : '' }}">
        <a href="{{route("proveedores.show.admin")}}" class="text-white text-decoration-none fw-bold  ">
            <i class="fa-solid fa-clipboard-check"></i>
            Evaluaciones a Proveedores
        </a>
    </div>
    
    <div class="col-auto mx-1 zoom_link {{ request()->routeIs('informacion.foranea.show.admin') ? 'link_selected' : '' }}">
        <a href="{{route("informacion.foranea.show.admin")}}" class="text-white text-decoration-none fw-bold ">
            <i class="fa-solid fa-exclamation-circle"></i>
            Cargar información
        </a>
    </div>



</div>
