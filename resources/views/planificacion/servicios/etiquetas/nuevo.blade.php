{{-- Extendemos el template de views/layouts/main.blade.php --}}
<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Etiqueta[] $etiquetas */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
?>
@section('title', 'Crear Nueva Etiqueta')
@extends('layout.main')

@section('main')
    <h1 class="visually-hidden">Panel para crear una nueva Etiqueta de Servicio</h1>
    <section class="container">
            <h2 class="visually-hidden">Panel para crear una nueva Etiqueta</h2>
        <div class="container d-flex flex-column text-center bg-light p-3">
            <h3 class="text-secondary py-2">Crear Nueva Etiqueta</h3>
            <h4 class="text-secondary font-size-19">Completá el Formulario</h4>
        </div>
        <form action="{{route('etiquetas.crear')}}" method="post" class="mb-4">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                       @error('nombre') aria-describedby="error-nombre"
                    @enderror>
                @error('nombre')
                <div class="alert alert-danger" id="error-nombre">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-block btn-primary">Crear</button>
        </form>

    </section>
@endsection
