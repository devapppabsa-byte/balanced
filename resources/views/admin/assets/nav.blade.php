{{-- <style>
  .sidebar {
    position: fixed;
    top: 0;
    left: -260px;
    width: 260px;
    height: 100%;
    background-color: #5476ac !important;
    transition: left 0.3s ease;
    z-index: 1050;
  }

  .sidebar.active {
    left: 0;
  }

  .sidebar a {
    text-decoration: none;
  }

  .zoom_link:hover {
    transform: scale(1.05);
    transition: 0.2s;
  }

  .link_selected {
    background-color: rgba(255,255,255,0.2);
    border-radius: 5px;
    padding: 4px 8px;
  }

  #menu-toggle {
    border: none;
  }
</style>

<nav class="navbar navbar-light bg-light mx-0">
  <button id="menu-toggle" class="btn btn-primary">
    <i class="fas fa-bars"></i>
  </button>
  <span class="navbar-brand ml-2">Panel de Administración</span>
</nav>

<!-- SIDEBAR -->
<div id="sidebar" class="sidebar bg-primary text-white">
  <div class="sidebar-header d-flex justify-content-between align-items-center p-3">
    <h5 class="mb-0">Menú</h5>
    <button id="close-sidebar" class="btn btn-sm btn-light">
      <i class="fa fa-times"></i>
    </button>
  </div>

  <div class="sidebar-body px-3 pb-3" style="font-size:14px;">

    <a href="{{route('perfil.admin')}}" class="d-block text-white fw-bold mb-2 zoom_link {{ request()->routeIs('perfil.admin') ? 'link_selected' : '' }}">
      <i class="fa fa-home mr-2"></i> Inicio
    </a>

    <a href="{{route('departamentos.show.admin')}}" class="d-block text-white fw-bold mb-2 zoom_link {{ request()->routeIs('departamentos.show.admin') ? 'link_selected' : '' }}">
      <i class="fa fa-briefcase mr-2"></i> Gestionar Departamentos
    </a>

    <a href="{{route('usuarios.show.admin')}}" class="d-block text-white fw-bold mb-2 zoom_link {{ request()->routeIs('usuarios.show.admin') ? 'link_selected' : '' }}">
      <i class="fa fa-users mr-2"></i> Usuarios
    </a>

    <a href="{{route('clientes.show.admin')}}" class="d-block text-white fw-bold mb-2 zoom_link {{ request()->routeIs('clientes.show.admin') ? 'link_selected' : '' }}">
      <i class="fa fa-users-viewfinder mr-2"></i> Clientes
    </a>

    <a href="{{route('encuestas.show.admin')}}" class="d-block text-white fw-bold mb-2 zoom_link {{ request()->routeIs('encuestas.show.admin') ? 'link_selected' : '' }}">
      <i class="fa fa-clipboard-list mr-2"></i> Encuestas
    </a>

    <a href="{{route('lista.quejas.cliente')}}" class="d-block text-white fw-bold mb-2 zoom_link {{ request()->routeIs('lista.quejas.cliente') ? 'link_selected' : '' }}">
      <i class="fa fa-comment mr-2"></i> Quejas y sugerencias
    </a>

    <a href="{{route('proveedores.show.admin')}}" class="d-block text-white fw-bold mb-2 zoom_link {{ request()->routeIs('proveedores.show.admin') ? 'link_selected' : '' }}">
      <i class="fa fa-clipboard-check mr-2"></i> Evaluaciones a Proveedores
    </a>

    <a href="{{route('informacion.foranea.show.admin')}}" class="d-block text-white fw-bold mb-2 zoom_link {{ request()->routeIs('informacion.foranea.show.admin') ? 'link_selected' : '' }}">
      <i class="fa fa-exclamation-circle mr-2"></i> Cargar información
    </a>

  </div>
</div>




<script>
  document.getElementById('menu-toggle').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('active');
  });
  document.getElementById('close-sidebar').addEventListener('click', function() {
    document.getElementById('sidebar').classList.remove('active');
  });
</script> --}}



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


    <div class="col-auto mx-1 zoom_link {{ request()->routeIs('lista.quejas.cliente') ? 'link_selected' : '' }}">
        <a href="{{route("lista.quejas.cliente")}}" class="text-white text-decoration-none fw-bold ">
            <i class="fa-solid fa-comment"></i>
            Quejas y sugerencias
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


    <div class="col-auto mx-1 zoom_link {{ request()->routeIs('logs.show.admin') ? 'link_selected' : '' }}">
        <a href="{{route("logs.show.admin")}}" class="text-white text-decoration-none fw-bold ">
            <i class="fa-solid fa-book"></i>
            Logs
        </a>
    </div>


</div>






