<!doctype html>
<?php
use App\Http\Controllers\AuthController;

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
<div class="container-fluid">
    <img src="{{URL::asset('img/logo.png')}}" width="75px">
</div>
<section class="minheight700">
    @if(Session::has('message'))
        <div class="m-4 alert alert-{{ Session::get('message_type') ?? 'success' }}">{{ Session::get('message') }}</div>
    @endif
    @yield('main')
</section>
<div class="footer">
    <p>Copyright &copy; Florencia Merzario 2021</p>
</div>
@yield('scripts')
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.min.js" integrity="sha384-j0CNLUeiqtyaRmlzUHCPZ+Gy5fQu0dQ6eZ/xAww941Ai1SxSY+0EQqNXNE6DZiVc" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


<!--
    <script src="<?= url('/js/bootstrap.min.js');?>"></script>
    <script src="<?= url('/js/jquery-3.4.1.js');?>"></script>
-->

{{--    @yield('js')--}}
@stack('js')
</body>
</html>

