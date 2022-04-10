<!doctype html>
<?php
use App\Http\Controllers\AuthController;
header('Set-Cookie: cross-site-cookie=PHPSESSID; SameSite=None; Secure');
$request='';
?>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'FOODDATA')</title>
    <link rel="stylesheet" href="<?= url('/css/bootstrap.min.css');?>">
    <link rel="stylesheet" href="<?= url('/css/estilos.css');?>">
</head>
<body>
<div class="app">
    <nav class="navbar navbar-expand-lg navbar-light bg-light w-87porc m-auto">
        <div class="container-fluid">
            <img src="{{URL::asset('img/logo.png')}}" width="75px">

            <button ontouchstart='ocultarMsg()' onclick='ocultarMsg()' class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation" >
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav w-100 justify-content-end">
                    @auth()
                        <?php $user = Auth::user();?>
                        <li class="nav-item mx-2 bg-light p-2 rounded-2 hover-black">
                            <a class="text-blue text-decoration-none hover-white" href="<?= url('/clientes')?>">Clientes</a>
                        </li>
                        <li class="nav-item mx-2 bg-light p-2 rounded-2 hover-black">
                            <a class="text-blue text-decoration-none hover-white" href="{{route('stock')}}">
                                Stock</a>
                        </li>
                        <li class="nav-item mx-2 bg-light p-2 rounded-2 hover-black">
                            <a class="text-blue text-decoration-none hover-white" href="{{route('planificacion')}}">
                                Planificacion
                            </a>
                        </li>
                        <li class="nav-item mx-2 bg-light p-2 rounded-2 hover-black">
                            <a class="aLogout text-decoration-none text-blue hover-white" <?= url()->current() == url('/logut')? 'active': '';?>
                            href="<?= url('/logout');?>">{{ auth()->user()->email }} Logout</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>
    <!-- fin del nav -->
    <section class="marginTop50">
        @if(Session::has('message'))
            <div id="mensaje" class="alert alert-{{ Session::get('message_type') ?? 'success' }}">{{ Session::get('message') }}</div>
        @endif

        @yield('main')

    </section>

    @yield('scripts')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    {{--<script src="<?= url('resources/js/jquery-3.4.1.js');?>"></script>--}}
    <script
        src="https://code.jquery.com/jquery-3.6.0.slim.min.js"
        integrity="sha256-u7e5khyithlIdTpu22PHhENmPcRdFiHRjhAuHcs05RI="
        crossorigin="anonymous">
    </script>

    {{--    @yield('js')--}}

    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    <div class="footer align-self-end align-self-end">
        <p class="m-auto"> Copyright &copy; Florencia Merzario 2021</p>
    </div>
</div>
</body>

@stack('js')
<script>
    function ocultarMsg(){

        document.getElementById("mensaje").innerText = '';
        document.getElementById("mensaje").style.display = 'none';
    }
</script>
</html>
