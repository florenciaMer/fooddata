<?php
/** @var \App\Models\Cliente $clientes */
/** @var \App\Models\Etiqueta $etiquetas */
/** @var  $etiqueta */
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var  $cliente */
?>
@section('title', 'Costos de Servicios')
@extends('layout.main')
@section('main')
<div class="container">
    <div class="container d-flex flex-column text-center bg-light p-3">
        <h1 class="text-secondary py-2">Costos de Servicios</h1>
    </div>
    <form action="{{ route('presupuestos.detalleGlobal') }}" class="w-75 m-auto" method="get"
        enctype="multipart/form-data">
        @csrf
        <div class="card-body d-flex flex-row">
{{--            <label class="py-2" for="categoria_id">Clientes</label>--}}
            <select id="cliente_id" name="cliente_id" class="form-control">
                @foreach($clientes as $cliente)
                    <option value="{{ $cliente->cliente_id }}"
                        @if(old('$this->cliente_id') == $cliente->cliente_id)
                        selected @endif>{{ $cliente->nombre }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="card-body d-flex flex-row">
            <div class="d-flex">
                <input type="text" id="lbl" value="Inicio" disabled class="form-control">
                <input type="date" id="fechaI"  required name="fechaI" class="text-center form-control
                fw-bold bg-light w-390 margin-right12 @error('fecha') is-invalid @enderror">
            </div>
            <div class="d-flex">
                <input type="text" id="lbl" value="Fin" disabled class="form-control">
                <input type="date" id="fechaF"  required name="fechaF" class="text-center form-control
                fw-bold bg-light w-390 margin-right12 @error('fecha') is-invalid @enderror">
            </div>
        </div>

        <div class="card-body d-flex flex-row">
            <label for="contexto" class="visually-hidden my-2">Contexto</label>
            <select id="contexto" name="contexto" class="form-control p-2">
                <option value="Escenario" selected >Escenario</option>
                <option value="Cotización">Cotización</option>
                <option value="Licitación">Licitación</option>
                <option value="Servicio Habitual">Servicio Habitual</option>
                <option value="Servicio Especial">Servicio Especial</option>
            </select>
        </div>
        <div class="card-body d-flex flex-row">
            <button class="btn btn-success">Cargar Información</button>
        </div>
    </form>
</div>

@endsection
