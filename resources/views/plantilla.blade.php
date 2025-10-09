<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.90">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=groups" />

    
    <link rel="stylesheet" href="{{asset('css/mdb.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <style>

        body{
            margin: 0px;
            padding: 0px;
        }

        .input.activo {
            border: 2px solid blue;
            background-color: #e0f0ff;
        }

    </style>

</head>
<body>
    
    @yield('contenido')



    {{-- <footer class="container-fluid  fixed-bottom">
        <div class="row bg-primary p-1 d-flex align-items-center">
            <div class="col-12 cascadia-code text-center text-white">
                With <i class="fa fa-gear "></i> by: <a href="https://github.com/resendiz1" class="text-white">Arturo Resendiz López</a>
            </div>
        </div>
    </footer> --}}


    <script type="text/javascript" src="{{asset('js/mdb.umd.min.js')}}"></script> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/interactjs/dist/interact.min.js"></script>
    <script src="{{asset('js/draggable.js')}}"></script>
    @yield('scripts')

    <script>
        if(document.getElementById("fecha")){
            let mostrar_fecha = document.getElementById("fecha");
            let fecha = new Date();
            mostrar_fecha.innerHTML = " <i class='fa fa-calendar'></i>  " + fecha.toLocaleDateString("es-Es", {month: 'long'}) +" "+ fecha.getFullYear();
        }
    </script>



</body>
</html>