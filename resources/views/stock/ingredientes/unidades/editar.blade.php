{{-- Extendemos el template de views/layouts/main.blade.php --}}
<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Categoria[] $unidades */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
?>
@section('title', 'Editar Unidad')
@extends('layout.main')

@section('main')
    <div class="container d-flex flex-column text-center bg-light p-3">
        <h1 class="text-secondary py-2">Panel de Unidades</h1>
    </div>
    <section class="container">
        <h2 class="text-secondary font-size-19 p-2">Editá el Campo</h2>

        <form action="{{ route('unidades.editar', ['unidad' => $unidad->unidad_id]) }}" method="post">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $unidad->nombre) }}"
                       @error('nombre') aria-describedby="error-nombre"
                    @enderror>
                @error('nombre')
                <div class="alert alert-danger" id="error-nombre">{{ $message }}</div>
                @enderror
            </div>

            <button class="btn btn-block btn-primary m-2">Editar</button>
        </form>
    </section>
@endsection
