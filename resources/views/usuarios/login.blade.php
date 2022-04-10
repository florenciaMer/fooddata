<?php
{{-- Extendemos el template de views/layouts/main.blade.php --}}
?>
@section('title', 'Login')
@extends('layout.mainLogin')

@section('main')
    <div class="container d-flex flex-column text-center bg-light p-3">
        <h1 class="text-secondary py-2">Inicio de Sesión</h1>
    </div>
    <section class="container">
        <h2 class="text-secondary font-size-19 p-2">Ingresá tus credenciales:</h2>

        <form action="{{route('auth.login')}}" method="post" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="email" class="p-2">Email</label>
                <input type="text" id="email" name="email" class="form-control p-2 @error('email') is-invalid @enderror" value="{{ old('email') }}"
                       @error('email') aria-describedby="error-email"
                    @enderror>
                @error('email')
                <div class="alert alert-danger" id="error-email">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="password" class="p-2">Password</label>
                <input type="password" id="password" name="password" class="form-control p-2 @error('password') is-invalid @enderror"     @error('password') aria-describedby="error-password"
                    @enderror>
                @error('password')
                <div class="alert alert-danger" id="error-password">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-block btn-primary my-3">Ingresar</button>
            <div class="d-flex justify-content-between">
                <a class="m-2" href="<?= url('/usuarios/nuevo')?>">Click aquí para registrarte</a>
            </div>
        </form>
    </section>
@endsection

