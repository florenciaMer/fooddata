{{-- Extendemos el template de views/layouts/main.blade.php --}}
<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Unidad[] $unidades */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Categoria[] $categorias */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var \Illuminate\Foundation\Auth\User  */
?>
@section('title', 'Crear Nuevo Ingrediente')
@extends('layout.main')
@section('main')

    <h1 class="visually-hidden">Panel para crear un nuevo ingrediente</h1>

    <section class="container">
        <h2 class="visually-hidden">Panel para crear un nuevo ingrediente</h2>
        <div class="container d-flex flex-column text-center bg-light p-3">
            <h3 class="text-secondary py-2">Crear Nuevo Ingrediente</h3>
            <h4 class="text-secondary font-size-19">Completá el Formulario</h4>
        </div>
        <form action="{{route('ingredientes.crear')}}" method="post" enctype="multipart/form-data">
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
                <label class="py-2" for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id" class="form-control">
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->categoria_id }}"
                                @if(old('$this->categoria_id') == $categoria->categoria_id)
                                selected @endif>{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="usuario_id" value="{{auth()->user()->usuario_id}}">

            <div class="form-group">
                <label class="py-2" for="unidad_id">Unidad de Medida</label>
                <select id="unidad_id" name="unidad_id" class="form-control">
                    @foreach($unidades as $unidad)
                        <option value="{{ $unidad->unidad_id }}" @if(old('unidad_id') == $unidad->unidad_id) selected @endif>{{ $unidad->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label class="py-2" for="impuesto">Impuesto</label>
                <input type="text" id="impuesto"  name="impuesto" class="form-control @error('impuesto') is-invalid @enderror" value="{{ old('impuesto') }}"
                       @error('impuesto') aria-describedby="error-impuesto"
                    @enderror>
                @error('impuesto')
                <div class="alert alert-danger" id="error-precio">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label class="py-2" for="precio">Precio</label>
                <input type="text" id="precio" name="precio" class="form-control @error('precio') is-invalid @enderror" value="{{ old('precio') }}"
                       @error('precio') aria-describedby="error-precio"
                    @enderror>
                @error('precio')
                <div class="alert alert-danger" id="error-precio">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group d-none">
                <label for="nivel">Nivel de Usuario</label>
                <input type="text" id="nivel" value="usuario" name="nivel" class="form-control" disabled>

            </div>
            <button class="btn btn-block btn-primary my-3">Crear</button>
        </form>
        <a class="btn btn-info my-3 bg-primary" href="<?= url('/ingredientes')?>">
            <span><ion-icon name="arrow-back-circle-outline"></ion-icon></span><span class="m-2">Volver </span>

        </a>
    </section>
@endsection
