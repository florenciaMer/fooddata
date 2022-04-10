<?php
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var \App\Models\Receta[]|Illuminate\Database\Eloquent\Collection $recetas */
/** @var \App\Models\Cliente $clientes */
/** @var \App\Models\Tipo $tipos */
/** @var $cliente */
/** @var \App\Http\Controllers\PlanificacionItemController $planificacionItem*/
/** @var \App\Models\Planificacion $planificacion */

//$numero = 3;
//$fecha = DateTime::createFromFormat('!m', $numero);
//$mes = $fecha->format('F'); // March
//echo $mes
//
//$oldDate = strtotime('03/08/2020');
//
//$cadena_fecha_mysql = "2015-08-24";
//$objeto_DateTime = DateTime::createFromFormat('Y-m-d', $cadena_fecha_mysql);
?>
@section('title', 'Servicios Planificados')
@extends('layout.main')
@section('main')
    <div class="container minheight570">
        <div class="container d-flex flex-column text-center p-3">
            <h1 class="text-secondary ">Servicios Planificados</h1>
        </div>
        <section class="container m-auto my-4 bg-light">
            <form action="{{ route('serviciosPlanificados.listadoServiciosPlanificados') }}" method="post"
                  enctype="multipart/form-data" class="w-100 p-4">
                @csrf
                <h2 class="visually-hidden">Servicios Planificados</h2>

                <div class="card w-75 p-2 m-3 m-auto my-3 form-group">
                    <div class="card-body d-flex flex-row">
                        <select class="form-select" id="cliente_id" name="cliente_id" aria-label="Default select example">
                            @foreach($clientes as $cliente)
                                <option value="{{$cliente->cliente_id }}" @if(old('cliente_id', $cliente->cliente_id) == $cliente->cliente_id)
                                    @endif>{{$cliente->nombre }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="card-body d-flex flex-row form-group mx-4">
                       <label for="fi">Inicio</label>
                        <input class="mx-3" type="date" name="fi">

                        <label for="fi" class="mx-2">Fin</label>
                        <input type="date" class="mx-3" name="ff">
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
                        <button class="btn btn-success d-flex text-center">Cargar Servicio</button>
                    </div>
                </div>
            </form>
        </section>
    </div>
@endsection




