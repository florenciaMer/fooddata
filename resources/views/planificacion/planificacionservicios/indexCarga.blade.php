<?php
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var \App\Models\Receta[]|Illuminate\Database\Eloquent\Collection $recetas */
/** @var \App\Models\Cliente $clientes */
/** @var \App\Models\Tipo $tipos */
/** @var $cliente */
/** @var \App\Http\Controllers\PlanificacionItemController $planificacionItem*/
/** @var \App\Models\Planificacion $planificacion */
?>
@section('title', 'Carga Planificación de Servicios')
@extends('layout.main')
@section('main')

    <div class="container d-flex flex-column text-center bg-light p-3">
        <h1 class="text-secondary ">Planificación de Servicios</h1>
    </div>
        <section class="container m-4">
            <form action="{{ route('planificacion.agregarCabecera') }}" method="post"
                  enctype="multipart/form-data">
                @csrf
                <h2 class="visually-hidden">Carga de Servicios</h2>
                <div class="card w-50 p-2 m-3 m-auto form-group">
                    <div class="card-body d-flex flex-row">
                        <select class="form-select" id="cliente_id" name="cliente_id" aria-label="Default select example">
                            @foreach($clientes as $cliente)
                                <option value="{{$cliente->cliente_id }}" @if(old('cliente_id', $cliente->cliente_id) == $cliente->cliente_id)
                                @endif>{{$cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                <div class="card-body d-flex flex-row form-group">
                    <label for="fecha" class="my-2 visually-hidden">Fecha</label><input class="form-control p-2" name="fecha" type="date" id="fecha" aria-label="default input example">
                    @error('fecha')
                    <div class="alert alert-danger" id="error-fecha">{{ $message }}</div>
                    @enderror
               </div>
                <div class="card-body d-flex flex-row form-group">
                    <select class="form-control" id="contexto" name="contexto" aria-label="Seleccione la opcion">
                        <option value="Escenario">Escenario</option>
                        <option value="Cotización">Cotización</option>
                        <option value="Licitación">Licitación</option>
                        <option value="Servicio Habitual">Servicio Habitual</option>
                        <option value="Servicio Especial">Servicio Especial</option>
                    </select>
                    </div>
                <div class="card-body d-flex flex-row form-group">
                    <label for="observaciones" class="my-2 visually-hidden">Observaciones</label>
                    <textarea name="observaciones" class="form-control p-2" placeholder="Observación" id="observaciones" aria-label="default input example"></textarea>
                </div>
                <div class="card-body d-flex flex-row form-group">
                    <label for="cant" class="my-2 visually-hidden">Cant</label>
                    <input class="form-control p-2"  name="cant" type="number" min="1" required placeholder="Cantidad" id="cant" aria-label="default input example">
                    @error('cant')
                    <div class="alert alert-danger" id="error-cant">{{ $message }}</div>
                    @enderror
                </div>
                    <button title="Cargar" class="btn btn-success" type="submit" name="cargar" value="boton">Cargar Servicio</button>
            </div>
          </form>
      </section>

{{--        fin presentacion cuadro para carga de recetas--}}
{{--        carga de recetas por dia--}}
@endsection




