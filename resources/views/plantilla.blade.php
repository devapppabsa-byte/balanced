<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=0.90">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=groups" />
    <meta http-equiv="Cache-Control" content="no-store" />   
    <link rel="stylesheet" href="{{asset('css/mdb.min.css')}}" />
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/toastr.min.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.snow.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>

        body{
            margin: 0px;
            padding: 0px;
            cursor: 
        }

        .input.activo {
            border: 2px solid blue;
            background-color: #e0f0ff;
        }


    </style>

</head>
<body>
    {{-- <div class="container-fluid bg-white">
        <div class="row">
            <div class="col-12">
                <span style="font-size: 10px;"><b>MetricHub </b> by: <a href="https://github.com/resendiz1" target="_blank" class="text-dark fw-bold">Arturo Resendiz López</a> with <i class="fa fa-code text-dark fw-bold"></i> </span>
            </div>
        </div>
    </div> --}}
    @yield('contenido')



    {{-- <footer class="container-fluid  fixed-bottom">
        <div class="row bg-primary p-1 d-flex align-items-center">
            <div class="col-12 cascadia-code text-center text-white">
                With <i class="fa fa-gear "></i> by: <a href="https://github.com/resendiz1" class="text-white">Arturo Resendiz López</a>
            </div>
        </div>
    </footer> --}}
    <script src="{{asset('js/jquery-3.6.0.min.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/mdb.umd.min.js')}}"></script> 
    <script src="{{asset('js/chart.js')}}"></script>
    <script src="{{asset('js/interact.min.js')}}"></script>
    <script src="{{asset('js/draggable.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@2.0.3/dist/quill.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/emailjs-com@3/dist/email.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>


    <script>
        flatpickr(".datepicker", {
            locale: "es",
            dateFormat: "Y-m-d",
            altInput: true,
            altFormat: "d F Y",
        });
    </script>

    @yield('scripts')


    <script>
    (function(){
        emailjs.init("Qg1Uw0UBaSzCmDi1D");
    })();
    </script>


    <script>

        if(document.getElementById('editor')){
    
            const editor = new Quill("#editor", {theme:'snow',})
            
            const formulario = document.getElementById('formularioQueja')
            formulario.addEventListener('submit', function(e){
                
                document.getElementById('queja').value = editor.root.innerHTML;
                
            })        
        }

    </script>
    
    <script>
        if(document.getElementById("fecha")){
            let mostrar_fecha = document.getElementById("fecha");
            let fecha = new Date();
            mostrar_fecha.innerHTML = " <i class='fa fa-calendar'></i>  " + fecha.toLocaleDateString("es-Es", {month: 'long'}) +" "+ fecha.getFullYear();
        }    
    </script>

    {{-- notificaciones de todo --}}

        @if (session("error_input"))
            <script>
                toastr.error('{{session("error_input")}}', 'Error!')  
            </script>        
        @endif


        @if (session("error"))
            <script>
                toastr.error('{{session("error")}}', 'Error!');
            </script>
        @endif

        @if (session('deleted'))
            <script>
                toastr.error('{{session("deleted")}}', 'Eliminado!');
            </script>
        @endif


        @if (session('success'))
            <script>
                toastr.success('{{session("success")}}', 'Exito!');
            </script>
        @endif

        @if (session('actualizado'))
            <script>
                toastr.success('{{session("actualizado")}}', 'Exito!');
            </script>
        @endif

        @if (session('eliminado'))
            <script>
                toastr.warning('{{session("eliminado")}}', 'Exito!');
            </script>
        @endif

        @if (session('editado'))
            <script>
                toastr.success('{{session("editado")}}', 'Exito!');
            </script>
        @endif

        @if (session('eliminado_user'))
            <script>
                toastr.warning('{{session("eliminado_user")}}', 'Exito!');
            </script>
        @endif


        @if ($errors->any())
            <script>
                toastr.error('{{$errors->first()}}', 'Error!')
            </script>

        @endif


    {{-- notificaciones de todo --}}




    {{-- Esto hace que el tab-panel se regrese al lugar donde lo dejaste despues de cargar la pagina --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabLinks = document.querySelectorAll('[data-mdb-tab-init]');
        const tabContent = document.getElementById('ex1-content');

        const savedTab = localStorage.getItem('activeTab');

        if (savedTab) {
            const tabTrigger = document.querySelector(`[href="${savedTab}"]`);
            if (tabTrigger) {
                // Primero activamos la tab visualmente
                document.querySelectorAll('.nav-link').forEach(link => {
                    link.classList.remove('active');
                });
                tabTrigger.classList.add('active');
                
                // Activamos el contenido correspondiente
                document.querySelectorAll('.tab-pane').forEach(pane => {
                    pane.classList.remove('show', 'active');
                });
                const targetPane = document.querySelector(savedTab);
                if (targetPane) {
                    targetPane.classList.add('show', 'active');
                }
            }
        }

        // Mostrar contenido una vez listo
        tabContent.classList.remove('d-none');

        tabLinks.forEach(tab => {
            tab.addEventListener('shown.mdb.tab', e => {
                localStorage.setItem('activeTab', e.target.getAttribute('href'));
            });
        });
    });
    </script>




<!-- PARA QUE SE MUESTRE PRTIERO LA PARTE DE ABAJO LOS INDICADORES -->
    <script>
        if(document.querySelector('.indicador-container')){

                document.querySelectorAll('.indicador-container').forEach(contenedor => {
                contenedor.scrollTop = contenedor.scrollHeight;
                });


        }

    </script>




{{-- FORMAEANDO LOS NUMEROS QUE SE MUESTRAN --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('.format-number').forEach(el => {
        const n = el.textContent.replace(/,/g, '');
        if (!isNaN(n) && n !== '') {
        el.textContent = Number(n).toLocaleString('en-US');
        }
    });
});
</script>


</body>
</html>