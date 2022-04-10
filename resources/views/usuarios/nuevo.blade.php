<?php
{{-- Extendemos el template de views/layouts/main.blade.php --}}
?>
@section('title', 'Login')
@extends('layout.mainLogin')
@section('main')
    <div class="container d-flex flex-column text-center bg-light p-3">
        <h1 class="text-secondary py-2">Registro de Usuario</h1>
        <h2 class="text-secondary font-size-19">Completá el Formulario</h2>
    </div>
    <section class="container d-flex flex-row justify-content-center">
        <h3 class="visually-hidden">Sección para completar los datos de registro de usuario</h3>
        <article class="col-8 m-3">
            <h3 class="visually-hidden">Formulario</h3>
            <form action="{{route('usuarios.crear')}}" method="post" class="mb-4">
                @csrf
                <div class="form-group">
                    <label for="nombre" class="p-1">Nombre</label>
                    <input type="text" id="nombre" name="nombre" class="p-2 form-control @error('nombre') is-invalid @enderror"
                           @error('nombre') aria-describedby="error-nombre"
                        @enderror>
                    @error('nombre')
                    <div class="alert alert-danger" id="error-nombre">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="p-1" for="email">Email</label>
                    <input type="text" id="email" name="email" class="p-2 form-control @error('email') is-invalid @enderror"
                           @error('email') aria-describedby="error-email"
                        @enderror>
                    @error('email')
                    <div class="alert alert-danger" id="error-email">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="p-1" for="password">Password</label>
                    <input type="password" id="password" name="password" class="p-2 form-control @error('password') is-invalid @enderror"
                           @error('password') aria-describedby="error-password"
                        @enderror>
                    @error('password')
                    <div class="alert alert-danger" id="error-password">{{ $message }}</div>
                    @enderror
                </div>
                <div class="form-group">
                    <label class="p-1" for="password">Confirmar Password</label>
                    <input type="password" id="password_confirm" name="password_confirm" class="p-2 form-control @error('password_confirm') is-invalid @enderror"
                           @error('password_confirm') aria-describedby="error-password_confirm"
                        @enderror>
                    @error('password_confirm')
                    <div class="alert alert-danger" id="error-password_confirm">{{ $message }}</div>
                    @enderror
                </div>
                <input type="hidden" name="rol" value="2">
                <button class="btn btn-block btn-primary m-2">Crear</button>
            </form>
        </article>

    </section>
@endsection
