<?php
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var \App\Models\Receta[]|Illuminate\Database\Eloquent\Collection $recetas */
/** @var \App\Models\Cliente $clientes */
/** @var \App\Models\Tipo $tipos */
/** @var $cliente */
/** @var \App\Http\Controllers\PlanificacionItemController $planificacionItem*/
/** @var \App\Models\ServicioPlanificado $serviciosPlanificados */
/** @var $etiquetaNombre */
$etiquetaNombre='';
/** @var $fecha */
$fecha='';
/** @var $dia */
/** @var $receta */
$receta='';

?>
@section('title', 'Detalle de Servicios')
@extends('layout.main')
@section('main')
<div class="container d-flex flex-column text-center bg-light p-3">
<h1 class="text-secondary ">Detalle de de Servicios</h1>
</div>
<div class="container m-auto m-4">
    <ul class="my-3 m-auto my-2 bg-light w-50 text-center list-unstyled bg-light">
    @foreach($serviciosPlanificados as $servicio)
       @if ($servicio->fecha !== $fecha)
           <li class="fw-bold">{{$dia}}</li>
           <li class="fw-bold"> {{date('d-m-Y', strtotime($servicio->fecha))}}
           <span class="visually-hidden">{{$fecha = $servicio->fecha}}</span>
           <span class="visually-hidden">{{$etiquetaNombre = ''}}</span>
           </li>
       @endif
       @if ($servicio->etiquetaNombre !== $etiquetaNombre)
               <li class="padding-10 fw-bold"> {{$servicio->etiquetaNombre}}</a></li>
               <span class="visually-hidden">{{$etiquetaNombre = $servicio->etiquetaNombre}}</span>
       @endif
           <table class="table">
               <thead>
               @if ($receta == '')
                   <th>Receta</th>
                   <th>Cantidad</th>
                   <span class="visually-hidden">{{$receta=1}}</span>
                </thead>
               @endif
                <tr>
                    <td>{{$servicio->recetaNombre}}</td>
                    <td>{{$servicio->cant_rec}} </td>
                </tr>
        @endforeach
      </table>
    </ul>
</div>
@endsection




