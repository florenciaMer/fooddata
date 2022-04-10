{{-- Extendemos el template de views/layouts/main.blade.php --}}
<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Condicion[] $condiciones */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var \Illuminate\Foundation\Auth\User  */
?>
@section('title', 'Crear Nuevo Cliente')
@extends('layout.main')
@section('main')

    <h1 class="visually-hidden">Panel para crear un nuevo cliente</h1>

    <section class="container">
        <h2 class="visually-hidden">Panel para crear un nuevo Cliente</h2>
        <div class="container d-flex flex-column text-center bg-light p-3">
            <h3 class="text-secondary py-2">Crear Nuevo Cliente</h3>
            <h4 class="text-secondary font-size-19">Completá el Formulario</h4>
        </div>
        <form action="{{route('clientes.crear')}}" method="post" enctype="multipart/form-data">
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
                <label class="py-2" for="nombreFantasia">Nombre Fantasía</label>
                <input type="text" id="nombreFantasia" name="nombreFantasia" class="form-control @error('nombreFantasia') is-invalid @enderror" value="{{ old('nombreFantasia') }}"
                       @error('nombreFantasia') aria-describedby="error-nombreFantasia"
                    @enderror>
                @error('nombreFantasia')
                <div class="alert alert-danger" id="error-nombreFantasia">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="py-2" for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" class="form-control @error('direccion') is-invalid @enderror" value="{{ old('direccion') }}"
                       @error('direccion') aria-describedby="error-direccion"
                    @enderror>
                @error('direccion')
                <div class="alert alert-danger" id="error-nombreFantasia">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="py-2" for="categoria_id">Condición</label>
                <select id="condicion_id" name="condicion_id" class="form-control">
                    @foreach($condiciones as $condicion)
                        <option value="{{ $condicion->condicion_id }}"
                            @if(old('$this->condicion_id') == $condicion->condicion_id)
                            selected @endif>{{ $condicion->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="usuario_id" value="{{auth()->user()->usuario_id}}">
            <button class="btn btn-block btn-primary my-3">Crear</button>
        </form>
    </section>
@endsection
