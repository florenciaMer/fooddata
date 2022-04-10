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
@section('title', 'Carga Planificación de Servicios')
@extends('layout.main')
@section('main')
    <div class="minheight570">
        <div class="text-center p-3">
            <h1 class="text-secondary">Costos por Servicio</h1>
        </div>
        <section class="container bg-light">
            <form action="{{ route('serviciosPlanificados.cargaServicios') }}" class="m-auto p-5" method="post"
                  enctype="multipart/form-data">
                @csrf
                <h2 class="visually-hidden">Servicios Planificados</h2>
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
                        <select class="form-control" id="anio" name="anio" aria-label="Seleccione la opcion">
                            <option value="2020">2020</option>
                            <option selected value="2021">2021</option>
                            <option value="2022">2022</option>
                            <option value="2023">2023</option>
                            <option value="2024">2024</option>
                            <option value="2025">2025</option>
                        </select>
                    </div>
                    <div class="card-body d-flex flex-row form-group">
                        <select class="form-control" id="mes" name="mes" aria-label="Seleccione la opcion">
                            <option value="1">Enero</option>
                            <option value="2">Febrero</option>
                            <option value="3">Marzo</option>
                            <option value="4">Abril</option>
                            <option value="5">Mayo</option>
                            <option value="6">Junio</option>
                            <option value="7">Julio</option>
                            <option value="8">Agosto</option>
                            <option value="9">Septiembre</option>
                            <option value="10">Octubre</option>
                            <option value="11">Noviembre</option>
                            <option value="12">Diciembre</option>
                        </select>
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




