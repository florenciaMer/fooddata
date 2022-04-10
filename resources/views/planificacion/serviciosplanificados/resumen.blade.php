<?php
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var \App\Models\Receta[]|Illuminate\Database\Eloquent\Collection $recetas */
/** @var \App\Models\Cliente $clientes */
/** @var \App\Models\ClienteServicios $clienteServicios */
/** @var \App\Models\Tipo $tipos */
/** @var $cliente */
/** @var $clienteNombre */
/** @var \App\Http\Controllers\PlanificacionItemController $planificacionItem*/
/** @var $etiquetaNombre */
/** @var \App\Models\ServicioPlanificado $servicios */
/** @var \App\Models\RecetaItem $recetaItem */
/** @var \App\Models\Ingrediente $ingredientes */
use Illuminate\Support\Carbon;

$etiqueta_id = 0;
$costoEtiqueta = 0;
$costo = 0;
$etiquetaNombre = '';
$planificacion_id =0;
$bandera = 0;
$costoTotal = 0;
$costoTot = 0;
$totTot = 0;
$ctoEtiqueta = 0;
$totTot = 0;
$cto = 0;
$cant = 0;
$cantidadTotalFinal = 0;
$cantidadTotal = 0;
$ventaTot = 0;
$precio = 0;
$etiqueta_id_total = 0;
?>
@section('title', 'Costos por Servicio')
@extends('layout.main')
@section('main')
<div class="container d-flex flex-column text-center bg-light minheight700">
    <h1 class="fs-4 py-3 text-secondary ">Costos por Servicio </h1>
    @if (isset($cliente->nombre))
        <p class="fw-bold">Cliente: {{$cliente->nombre}}</p>
    @else
        <p class="fw-bold">Cliente: {{$clienteNombre->nombre}}</p>
    @endif
    <p>Contexto: {{$servicios[0]->contexto}}</p>

    <?php
    $fecha = $servicios[0]->fecha;
    $fecha = Carbon::parse($fecha);
    if ($fecha->format('m') == '01') {
    ?>
     <p>Mes: {{'Enero'}}</p>
    <?php }
    if ($fecha->format('m') == '02') {
    ?>
    <p>Mes: {{'Febrero'}}</p>
    <?php }

    if ($fecha->format('m') == '03') {
    ?>
    <p>Mes: {{'Marzo'}}</p>
    <?php }

    if ($fecha->format('m') == '04') {
    ?>
    <p>Mes: {{'Abril'}}</p>
    <?php }

    if ($fecha->format('m') == '05') {
    ?>
    <p>Mes: {{'Mayo'}}</p>
    <?php }

    if ($fecha->format('m') == '06') {
    ?>
    <p>Mes: {{'Junio'}}</p>
    <?php }

    if ($fecha->format('m') == '07') {
    ?>
    <p>Mes: {{'Julio'}}</p>
    <?php }

    if ($fecha->format('m') == '08') {
    ?>
    <p>Mes: {{'Agosto'}}</p>
    <?php }

    if ($fecha->format('m') == '09') {
    ?>
    <p>Mes: {{'Septiembre'}}</p>
    <?php }

    if ($fecha->format('m') == '10') {
    ?>
    <p>Mes: {{'Octubre'}}</p>
    <?php }

    if ($fecha->format('m') == '11') {
    ?>
    <p>Mes: {{'Noviembre'}}</p>
    <?php }

    if ($fecha->format('m') == '12') {
    ?>
    <p>Mes: {{'Diciembre'}}</p>
    <?php }
    ?>
    <div class="container">
        <table class="table">
            <thead>
            <tr>
                <th>Servicio</th>
                <th>Costo total</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Precio Vta</th>
                <th> % </th>
                <th class="d-none-mobile">Ver</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $etiqueta_id = $servicios[0]->etiqueta_id;
            $etiquetaNombre = $servicios[0]->etiquetaNombre;
            $finArray = count($servicios);
            $fi = $servicios[0]->fecha;
            $ff = $servicios[0]->fecha;
            $planificacion_id = $servicios[0]->planificacion_id;
            $cantidadTotalFinal = $servicios[0]->cant;

            foreach ($clienteServicios as $clienteSer){
                $planificacion_id_total = $servicios[0]->planificacion_id;
                $cantidadd = $servicios[0]->cant;
                if ($servicios[0]->etiqueta_id == $clienteSer->etiqueta_id) {
                    $cantidadd =  $servicios[0]->cant;
                    $precio = $clienteSer->precio;
                    if ($precio !== 0) {
                        $ventaTot = $precio * $cantidadd + $ventaTot;
                        $planificacion_id_total = 500;
                    }
                }
            }

            ?>
             @foreach($servicios as $i => $ser)
             <?php
             foreach ($recetas as $recetaIte) {
                 if ($ser->receta_id == $recetaIte->receta_id) {
                 //encuentro la receta
                     $recetaItem = DB::table('recetasitems')
                         ->select('*')
                         ->where('receta_id', '=', $ser->receta_id)
                         ->get();
                     foreach ($recetaItem as $recetaIte) {
                        foreach ($ingredientes as $ingrediente) {
                             if ($recetaIte->ingrediente_id == $ingrediente->ingrediente_id) {
                             $cto = $cto + $recetaIte->cant * $ingrediente->precio/100;
                             } //cierro el if receta
                         }
                     }
                     //cierro el foreach de ingredientes
                 }
             }// cierro el foreach de recetas
//                 precio de venta totales
// el primero
                    foreach ($clienteServicios as $clienteSer){
                        if ($planificacion_id_total != $ser->planificacion_id) {
                         if ($ser->etiqueta_id== $clienteSer->etiqueta_id) {
                                $cantidadd = $ser->cant;
                                $precio = $clienteSer->precio;

                                if ($precio !== 0) {
                                     $ventaTot = $precio * $cantidadd + $ventaTot;
                                     $planificacion_id_total = $ser->planificacion_id;
                                }
                            }
                        }
                      }
                     $ctoEtiqueta = $cto / $ser->base ;
                     $totTot = $ctoEtiqueta * $ser->cant_rec + $totTot;
                     $ctoEtiqueta = 0;
                     $cto = 0;
                     if ($planificacion_id !== $ser->planificacion_id) {
                     $cantidadTotalFinal = $cantidadTotalFinal + $ser->cant;
                     $planificacion_id = $ser->planificacion_id;
                 }
                    ?>

             @endforeach
{{--            fin de totales--}}

            @foreach($servicios as $i => $servicio)
                <?php
//para calcular el costo total

                    if ($servicio->fecha < $fi){
                        $fi = $servicio->fecha;
                    }else{
                        if ($servicio->fecha > $ff){
                            $ff = $servicio->fecha;
                        }
                    }
                ?>
                @if ($i < $finArray -1)
                    @if ($servicio->etiqueta_id == $etiqueta_id)
                        <?php
                            $etiquetaNombre = $servicio->etiquetaNombre;
                            $costo = 0;

                        if ($servicio->planificacion_id !== $planificacion_id) {
                            $cant = $cant + $servicio->cant;
                            $planificacion_id = $servicio->planificacion_id;
                        }else {
                            $cant = $servicio->cant;
                        }
                            foreach ($recetas as $recetaIte) {
                                if ($servicio->receta_id == $recetaIte->receta_id) {
                                    //encuentro la receta
                                    $recetaItem = DB::table('recetasitems')
                                        ->select('*')
                                        ->where('receta_id', '=', $servicio->receta_id)
                                        ->get();
                                    foreach ($recetaItem as $recetaIte) {
                                        foreach ($ingredientes as $ingrediente) {
                                            if ($recetaIte->ingrediente_id == $ingrediente->ingrediente_id) {
                                                $costo = $costo + $recetaIte->cant * $ingrediente->precio/100;
                                            } //cierro el if receta
                                        }
                                    }
                                    //cierro el foreach de ingredientes
                                }
                            }// cierro el foreach de recetas
                            $costoEtiqueta = $costoEtiqueta + $costo * $servicio->cant_rec / $servicio->base;
                            $costoTotal = $costoEtiqueta + $costoTotal;
                            $etiquetaNombre = $servicio->etiquetaNombre;
                            $etiqueta_id = $servicio->etiqueta_id;
                            $cantAnterior = $servicio->cant;
                            ?>
                    @else  {{--cambia etiqueta--}}
                    <td><input type="text" id="eti{{$i}}" class="text-center form-control" disabled value="{{$etiquetaNombre}}"></td>
                    <td><input type="text" id="cost{{$i}}" class="text-center form-control" disabled value="$ {{$costoEtiqueta}}.-"></td>
                    <td><input type="text" id="num{{$i}}" class="text-center form-control" disabled value="{{$cant}}"></td>
                    <td><input type="text" id="num{{$i}}" class="text-center form-control" disabled value="$ {{number_format($costoEtiqueta/$cant,2)}}.-"></td>

                    <td>
                        <?php
                           foreach ($clienteServicios as $clienteServicio){
                            if ($etiqueta_id == $clienteServicio->etiqueta_id) {
                                $bandera = 1;
                                $precio = $clienteServicio->precio;
                             ?>
                                <input type="text" id="precio_cat{{$i}}" class="text-center form-control w-75"
                                 disabled value="$ {{$clienteServicio->precio}}.-">
                           <?php }
                           }
                            if ($bandera == 0) { ?>
                            <input type="text" id="sin_precio{{$i}}" class="text-center form-control w-75 alert-pink"
                                   disabled value="Sin Precio">
                            <?php }
                            $bandera = 0;
                        ?>
                    </td>
                    <?php if ($precio !== 0) { ?>

                    <td><input type="text" id="num{{$i}}" class="text-center form-control" disabled value="{{number_format($costoEtiqueta/$cant/$precio * 100,2)}} %"></td>
                    <?php
                    }else {
                       ?> <td></td><?php
                    }
                     $precio = 0;?>
                    <td class="d-none-mobile">
                        <form action="{{ route('serviciosPlanificados.aperturaSeleccion') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="etiqueta_id"  id="etiqueta_id{{$i}}" value="{{$etiqueta_id}}">
                            <input type="hidden" name="fi" id="fi{{$i}}" value="{{$fi}}">
                            <input type="hidden" name="ff" id="ff{{$i}}" value="{{$ff}}">
                            <input type="hidden" name="cliente_id" id="cliente_id{{$i}}" value="{{$servicio->cliente_id}}">
                            <input type="hidden" name="contexto" id="contexto{{$i}}" value="{{$servicio->contexto}}">
                            <input type="hidden" name="planificacion_id" id="planificacion_id{{$i}}" value="{{$servicio->planificacion_id}}">

                            <button title="Ver" class="btn btn-warning" type="submit" name="cargar" value="boton"><ion-icon name="eye-outline"></ion-icon></button>
                        </form>
                    </td>

                    <?php
                    $cant = 0;
                    $costo = 0;
                    $costoEtiqueta = 0;
                    $etiqueta_id = $servicio->etiqueta_id;
                    $etiquetaNombre = $servicio->etiquetaNombre;
                    foreach ($recetas as $recetaIte) {
                        if ($servicio->receta_id == $recetaIte->receta_id) {
                            //encuentro la receta
                            $recetaItem = DB::table('recetasitems')
                                ->select('*')
                                ->where('receta_id', '=', $servicio->receta_id)
                                ->get();
                            foreach ($recetaItem as $recetaIte) {
                                foreach ($ingredientes as $ingrediente) {
                                    if ($recetaIte->ingrediente_id == $ingrediente->ingrediente_id) {
                                        $costo = $costo + $recetaIte->cant * $ingrediente->precio/100;
                                    } //cierro el if receta
                                }
                            }
                            //cierro el foreach de ingredientes
                        }
                    }// cierro el foreach de recetas
                    $costoEtiqueta = $costoEtiqueta + $costo * $servicio->cant_rec / $servicio->base;
                    $costoTotal = $costoEtiqueta + $costoTotal;
                    $cant = $cant + $servicio->cant;
                    $etiquetaNombre = $servicio->etiquetaNombre;
                    $etiqueta_id = $servicio->etiqueta_id;
                    ?>
                    </tr>
                    @endif
                @else  {{--CAMBIA FIN ARRAY--}}
                <?php
                $costo = 0;
                if ($servicio->planificacion_id !== $planificacion_id) {
                    $cant = $servicio->cant;
                    $planificacion_id = $servicio->planificacion_id;
                }else {
                    $cant = $cant + $servicio->cant;
                }
                foreach ($recetas as $recetaIte) {
                    if ($servicio->receta_id == $recetaIte->receta_id) {
                        //encuentro la receta
                        $recetaItem = DB::table('recetasitems')
                            ->select('*')
                            ->where('receta_id', '=', $servicio->receta_id)
                            ->get();
                        foreach ($recetaItem as $recetaIte) {
                            foreach ($ingredientes as $ingrediente) {
                                if ($recetaIte->ingrediente_id == $ingrediente->ingrediente_id) {
                                    $costo = $costo + $recetaIte->cant * $ingrediente->precio/100;
                                } //cierro el if receta
                            }
                        }
                        //cierro el foreach de ingredientes
                    }
                }// cierro el foreach de recetas
                $costoEtiqueta = $costoEtiqueta + $costo * $servicio->cant_rec / $servicio->base;
                $costoTotal = $costoEtiqueta + $costoTotal;
                ?>
                    <td><input type="text" id="eti{{$i}}" class="text-center form-control" disabled value="{{$etiquetaNombre}}"></td>
                    <td><input type="text" id="cost{{$i}}" class="text-center form-control" disabled value="$ {{$costoEtiqueta}}.-"></td>
                    <td><input type="text" id="can{{$i}}" class="text-center form-control" disabled value="{{$cant}}"></td>
                    <td><input type="text" id="num{{$i}}" class="text-center form-control" disabled value="$ {{number_format($costoEtiqueta/$cant,2)}}.-"></td>
                    <td>
                        <?php
                        foreach ($clienteServicios as $clienteServicio){
                            if ($etiqueta_id == $clienteServicio->etiqueta_id) {
                                $bandera = 1;
                            ?>
                            <input type="text" id="precio_cat{{$i}}" class="text-center form-control w-75"
                                   disabled value="$ {{$clienteServicio->precio}}.-">
                        <?php   $precio = $clienteServicio->precio;
                            }
                        }
                        if ($bandera == 0) { ?>
                            <input type="text" id="sin_precio{{$i}}" class="text-center form-control w-75 alert-pink"
                                   disabled value="Sin Precio">
                        <?php }
                        $bandera = 0;
                        ?>
                    </td>
                <?php if ($precio !== 0) { ?>
                    <td><input type="text" class="text-center form-control" disabled value="{{number_format($costoEtiqueta/$cant/$precio * 100,2)}} %"></td>
                    <?php $precio = 0;
                    }else {
                        ?><td></td>
                   <?php }
                    ?>
                    <td class="d-none-mobile">
                        <form action="{{ route('serviciosPlanificados.aperturaSeleccion') }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="etiqueta_id"  id="etiqueta_id{{$i}}" value="{{$etiqueta_id}}">
                            <input type="hidden" name="fi" id="fi{{$i}}" value="{{$fi}}">
                            <input type="hidden" name="ff" id="ff{{$i}}" value="{{$ff}}">
                            <input type="hidden" name="cliente_id" id="cliente_id{{$i}}" value="{{$servicio->cliente_id}}">
                            <input type="hidden" name="contexto" id="contexto{{$i}}" value="{{$servicio->contexto}}">
                            <input type="hidden" name="planificacion_id" id="planificacion_id{{$i}}" value="{{$servicio->planificacion_id}}">
                            <button title="Ver" class="btn btn-warning" type="submit" name="cargar" value="boton"><ion-icon name="eye-outline"></ion-icon></button>
                        </form>
                    </td>
                </tr>
                @endif
            @endforeach
            </tbody>
        </table>
    </div>
    <table class="table-success">
        <thead>
            <th>Descripción</th>
            <th>Totales</th>

        </thead>
            <tr>
                <td>Costos totales</td>
                <td><input type="text" id="totCosto{{$i}}" class="text-center form-control" disabled value="$ {{number_format($totTot,2)}}.-"></td>
            </tr>
            <tr>
                <td>Ventas totales</td>
                <td><input type="text" id="totVentas{{$i}}" class="text-center form-control" disabled value="$ {{$ventaTot}}.-"></td>
            </tr>
            <tr>
                <td>% de Materias Primas</td>
                <td><input type="text" id="porcentaje{{$i}}" class="text-center form-control" disabled value="$ {{number_format($totTot/$ventaTot * 100,2)}} %"></td>
            </tr>
    </table>

</div>
@endsection







