
<?php

/** @var  $servicios */
/** \App\Models\Cliente $clientes */
/** \App\Models\Receta $recetas */
//$fecha = $servicios[0]->fecha;
//$etiqueta = $servicios[0]->etiqueta;

$fecha = '';
$etiqueta_id = '';
$totFechaGravado = 0;
$totEtiquetaGravado = 0;
$totFechaExento = 0;
?>
@section('title', 'Detalle de Costos de Servicios')
@extends('layout.main')
@section('main')

<table class="table ">
    <tr>
        <th>PlanificaciónItem_id</th>
        <th>Fecha</th>
        <th>Cliente</th>
        <th>Servicio</th>
        {{--etiqueta--}}
        <th>Cant</th>
        <th>Tipo</th>
        <th>Receta</th>
        <th>Cantidad de Recetas</th>
        <th>Costo Receta Gravado</th>
        <th>Costo Receta Exento</th>
        <th>Costo Total Gravado</th>
        <th>Costo Total Exento</th>
        <th>Costo Tipo Gravado</th>
        <th>Costo Etiqueta Gravado</th>
    </tr>

<?php
    $fecha = $servicios[0]->fecha;
    $etiqueta_id = $servicios[0]->etiqueta_id;

    $finArray = count($servicios)-1;

    foreach($servicios as $i => $servicio) {
        if ($i !== $finArray) {
              if($servicio->fecha == $fecha) {
                    $totFechaGravado = $totFechaGravado + $servicio->costoLineaGravado;
                    if ($servicio->etiqueta_id == $etiqueta_id) {
                    $totEtiquetaGravado = $totEtiquetaGravado + $servicio->costoLineaGravado;
                    ?>
                <tr>
                   <td>{{$servicio->planificacionItem_id}}</td>
                   <td>{{$servicio->fecha}}</td>

                   <td>
                       <select id="{{$servicio->cliente_id}}" disabled name="cliente_id">
                           @foreach($clientes as $cliente)
                               <option value="{{ $cliente->cliente_id }}"
                               @if(old('cliente_id', $cliente->cliente_id)
                                   == $cliente->cliente_id)
                               @endif>{{$cliente->nombre }}</option>
                           @endforeach
                       </select>
                   </td>
                   <td>{{$servicio->etiquetaNombre}}</td>
                   <td>{{$servicio->cant}}</td>
                   <td>{{$servicio->tipoNombre}}</td>
                   <td>{{$servicio->recetaNombre}}</td>
                   <td>{{$servicio->cant_rec}}</td>
                   {{--                    <td>{{$servicio->cant_rec * $servicio->recetaCostoGravado}}</td>--}}
                   <td>$ {{$servicio->costoRecetaGravado}}.-</td>
                   <td>$ {{$servicio->costoRecetaExento}} .-</td>
                   <td>$ {{$servicio->costoLineaGravado}}.-</td>
                   <td>$ {{$servicio->costoLineaExento}} .-</td>
                   <td>{{$servicio->costoTipoGravado}}</td>
                   <td>{{$servicio->costoEtiquetaGravado}}</td>
                   <td>{{$servicio->costoTipoGravado}}</td>
                   <td>{{$servicio->costoEtiquetaGravado}}</td>
                   <td></td>
                   <td></td>
               </tr>

            <?php
                }else {
                        //cambio de etiqueta
            ?>
            <tr>
                <td class="bg-danger">CAMBIO DE ETIQUETA TOTAL ES EL 2DO</td>
                <td>{{$totEtiquetaGravado}}</td>
            </tr>
                <?php $totEtiquetaGravado = 0; ?>
            <tr>
                <td>{{$servicio->planificacionItem_id}}</td>
                <td>{{$servicio->fecha}}</td>

                <td>
                    <select id="{{$servicio->cliente_id}}" disabled name="cliente_id">
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->cliente_id }}"
                            @if(old('cliente_id', $cliente->cliente_id)
                                == $cliente->cliente_id) @endif>{{$cliente->nombre }}</option>
                        @endforeach
                    </select>
                </td>
                <td>{{$servicio->etiquetaNombre}}</td>
                <td>{{$servicio->cant}}</td>
                <td>{{$servicio->tipoNombre}}</td>
                <td>{{$servicio->recetaNombre}}</td>
                <td>{{$servicio->cant_rec}}</td>
                {{--                    <td>{{$servicio->cant_rec * $servicio->recetaCostoGravado}}</td>--}}
                <td>$ {{$servicio->costoRecetaGravado}}.-</td>
                <td>$ {{$servicio->costoRecetaExento}} .-</td>
                <td>$ {{$servicio->costoLineaGravado}}.-</td>
                <td>$ {{$servicio->costoLineaExento}} .-</td>
                <td>{{$servicio->costoTipoGravado}}</td>
                <td>{{$servicio->costoEtiquetaGravado}}</td>
                <td>{{$servicio->costoTipoGravado}}</td>
                <td>{{$servicio->costoEtiquetaGravado}}</td>
                <td></td>
                <td></td>
            </tr>
            <?php
                $totEtiquetaGravado = $totEtiquetaGravado + $servicio->costoLineaGravado;
                $etiqueta_id = $servicio->etiqueta_id;

                }  //final de etiqueta

             } else{  //cambio de fecha
                   ?>
                <tr>
                    <td class="bg-danger">total DE ETIQUETA TOTAL ESTE ES EL 123</td>
                    <td>{{$totEtiquetaGravado}}</td>
                </tr>
                <?php  $totEtiquetaGravado = 0;?>
                <tr>
                    <td class="bg-warning">CAMBIO DE FECHA </td>
                    <td>{{$totFechaGravado}}</td>
                </tr>

               <?php $totFechaGravado = 0; ?>

                <tr>
                    <td>{{$servicio->planificacionItem_id}}</td>
                    <td>{{$servicio->fecha}}</td>

                <td>
                    <select id="{{$servicio->cliente_id}}" disabled name="cliente_id">
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->cliente_id }}"
                            @if(old('cliente_id', $cliente->cliente_id)
                                == $cliente->cliente_id) @endif>{{$cliente->nombre }}</option>
                        @endforeach
                    </select>
                </td>
                <td>{{$servicio->etiquetaNombre}}</td>
                <td>{{$servicio->cant}}</td>
                <td>{{$servicio->tipoNombre}}</td>
                <td>{{$servicio->recetaNombre}}</td>
                <td>{{$servicio->cant_rec}}</td>
                {{--                    <td>{{$servicio->cant_rec * $servicio->recetaCostoGravado}}</td>--}}
                <td>$ {{$servicio->costoRecetaGravado}}.-</td>
                <td>$ {{$servicio->costoRecetaExento}} .-</td>
                <td>$ {{$servicio->costoLineaGravado}}.-</td>
                <td>$ {{$servicio->costoLineaExento}} .-</td>
                <td>{{$servicio->costoTipoGravado}}</td>
                <td>{{$servicio->costoEtiquetaGravado}}</td>
                <td>{{$servicio->costoTipoGravado}}</td>
                <td>{{$servicio->costoEtiquetaGravado}}</td>
                <td></td>
                <td></td>
            </tr>
            <?php
                $totEtiquetaGravado = $totEtiquetaGravado + $servicio->costoLineaGravado;
                $etiqueta_id = $servicio->etiqueta_id;
                $fecha = $servicio->fecha;

                }  //final de fecha

        }else {
?>                  FINALLLLLLLLLLLLLLLLL
            <tr>
                <td class="bg-danger">CAMBIO DE ETIQUETA TOTA </td>
                <td>{{$totEtiquetaGravado}}</td>
            </tr>

<?php   }
} // cierro el foreach
?>
</table>
@endsection
