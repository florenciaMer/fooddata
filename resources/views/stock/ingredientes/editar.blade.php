{{-- Extendemos el template de views/layouts/main.blade.php --}}
<?php
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Unidad[] $unidades */
/** @var \Illuminate\Database\Eloquent\Collection|\App\Models\Categoria[] $categorias */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
?>
@section('title', 'Editar Ingrediente')
@extends('layout.main')
@section('main')
    <div class="container">
        <div class="container d-flex flex-column text-center bg-light p-3">
            <h1 class="text-secondary py-2">Editar Ingrediente</h1>
            <h2 class="text-secondary font-size-19">Completá el Formulario</h2>
        </div>
        <form action="{{ route('ingredientes.editar', ['ingrediente' => $ingrediente->ingrediente_id]) }}" method="post"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="categoria_id" class="my-2">Categoría</label>
                <select id="categoria_id" name="categoria_id" class="p-2 form-control">
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->categoria_id }}" @if(old('categoria_id', $ingrediente->categoria->categoria_id) == $categoria->categoria_id) selected @endif>{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="ingrediente_id" value="{{$ingrediente->ingrediente_id}}">
            <div class="form-group">
                <label for="nombre" class="my-2">Nombre</label>
                <input type="text" id="nombre" name="nombre" class="form-control p-2 @error('nombre') is-invalid @enderror"
                       value="{{ old('nombre', $ingrediente->nombre) }}"
                       @error('nombre') aria-describedby="error-nombre"
                    @enderror>
                @error('nombre')
                <div class="alert alert-danger" id="error-nombre">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="unidad_id" class="my-2">Unidad de Medida</label>
                <select id="unidad_id" name="unidad_id" class="form-control p-2">
                    @foreach($unidades as $unidad)
                        <option value="{{ $unidad->unidad_id }}" @if(old('unidad_id', $ingrediente->unidad->unidad_id) == $unidad->unidad_id)
                        selected @endif>{{ $unidad->nombre }}</option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="ingrediente_id" value="{{$ingrediente->ingrediente_id}}">
            <div class="form-group">
                <label for="impuesto" class="my-2">Impuesto</label>
                <input type="text" id="impuesto" name="impuesto" class="form-control p-2 @error('impuesto') is-invalid @enderror"
                       value="{{ old('impuesto', $ingrediente->impuesto) }}"
                       @error('impuesto') aria-describedby="error-impuesto"
                    @enderror>
                @error('impuesto')
                <div class="alert alert-danger" id="error-impuesto">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="precio" class="my-2">Precio</label>
                <input type="text" id="precio" name="precio" class="form-control p-2
               @error('precio') is-invalid @enderror"
                       value="{{ old('precio', $ingrediente->precio) }}"
                       @error('precio') aria-describedby="error-precio"
                    @enderror>
                @error('precio')
                <div class="alert alert-danger" id="error-precio">{{ $message }}</div>
                @enderror
            </div>
            <button class="btn btn-block btn-primary m-2">Editar</button>
        </form>
        <a class="btn m-4 bg-" href="<?= url('/ingredientes')?>">
            <span><ion-icon name="arrow-back-circle-outline"></ion-icon></span><span class="m-2">Volver </span>
        </a>
    </div>

@endsection
