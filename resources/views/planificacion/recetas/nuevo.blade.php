{{-- Extendemos el template de views/layouts/main.blade.php --}}
<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Unidad[] $unidades */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Categoria[] $categorias */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var \Illuminate\Foundation\Auth\User  */
    /* @var \App\Models\Tipo $tipos */
?>
@section('title', 'Crear Nueva Receta')
@extends('layout.main')
@section('main')

    <h1 class="visually-hidden">Panel para crear una nueva receta</h1>

    <section class="container">
        <h2 class="visually-hidden">Panel para crear un nuevo ingrediente</h2>
        <div class="container d-flex flex-column text-center bg-light p-3">
            <h3 class="text-secondary py-2">Crear Nueva Receta</h3>
            <h4 class="text-secondary font-size-19">Completá el Formulario</h4>
        </div>
        <form action="{{route('recetas.crear')}}" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="usuario_id" value="{{auth()->user()->usuario_id}}">
            <div class="form-group">
                <label class="py-2" for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control @error('nombre') is-invalid @enderror" value="{{ old('nombre') }}"
                       @error('nombre') aria-describedby="error-nombre"
                    @enderror>
                @error('nombre')
                <div class="alert alert-danger" id="error-nombre">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="py-2" for="categoria_id">Tipo</label>
                <select id="tipo_id" name="tipo_id" class="form-control">
                    @foreach($tipos as $tipo)
                        <option value="{{ $tipo->tipo_id }}"
                                @if(old('$this->tipo_id') == $tipo->tipo_id)
                                selected @endif>{{ $tipo->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="usuario_id" value="{{auth()->user()->usuario_id}}">
            <div class="form-group">
                <label class="py-2" for="base">Base</label>
                <input type="number" min="1" id="base" name="base" class="form-control @error('base') is-invalid @enderror" value="{{ old('base') }}"
                       @error('base') aria-describedby="error-base"
                    @enderror>
                @error('base')
                <div class="alert alert-danger" id="error-base">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                    <label class="py-2" for="descripcion">Descripción</label>
                    <textarea name="descripcion" id="descripcion" rows="3" class="form-control @error('descripcion') is-invalid @enderror" value="{{ old('descripcion') }}">
                    </textarea>
            </div>
            <button class="btn btn-block btn-primary my-3">Crear</button>
        </form>
    </section>
@endsection
