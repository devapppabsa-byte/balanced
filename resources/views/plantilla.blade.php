<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.90">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" />
    <!-- Google Fonts Roboto -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" />
    <!-- MDB -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    
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

    <script type="text/javascript" src="{{asset('js/mdb.umd.min.js')}}"></script> 
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    @yield('scripts')


</body>
</html>