<?php
/** @var \Illuminate\Support\ViewErrorBag|\Illuminate\Support\MessageBag $errors */
/** @var \App\Models\Receta[]|Illuminate\Database\Eloquent\Collection $recetas */
/** @var \App\Models\Cliente $clientes */
/** @var \App\Models\Tipo $tipos */
/** @var $cliente */
/** @var $clienteNombre */
/** @var \App\Http\Controllers\PlanificacionItemController $planificacionItem*/
/** @var $etiquetaNombre */
$etiquetaNombre='';
/** @var \App\Models\ServicioPlanificado $servicios
/** @var $fecha */
use Illuminate\Support\Carbon;

$fecha='';
$costo = 0;
$cant = 0;
$costoEtiqueta = 0;
$tot = 0;
$totalFinal = 0;
$primeroEtiqueta = 0;
$totDia = 0;
$costoEtiquetaGravado = 0;
$costoEtiquetaExento = 0;
$recetaCosto = 0;
$costoFecha = 0;
$fi = '';
$ff = '';

/** @var \App\Models\Receta $recetas */
/** @var \App\Models\RecetaItem $recetaItem */
/** @var \App\Models\Ingrediente $ingredientes */
?>
@section('title', 'Detalle de Servicios Planificados')
@extends('layout.main')
@section('main')
<div class="container d-flex flex-column my-4 text-center bg-ligh minheight430">
    <h1 class="fs-4 py-3 text-secondary bg-light">Servicios Planificados </h1>

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
{{--     {{$servicios[0]->fecha}}--}}
<div class="container m-auto">
    <table class="table bg-light p-2">
        <thead>
            <tr>
                <th class="d-none-mobile">Día</th>
                <th>Fecha</th>
                <th>Servicio</th>
                <th class="d-none-mobile">Cant</th>
                <th>Receta</th>
                <th>Cant</th>
                <th class="d-none-mobile">Costo Unitario</th>
                <th class="d-none-mobile">Costo Total</th>
            </tr>
        </thead>
 <tbody>
    <?php
        $fi = '1900-01-01';
        $ff = '1900-01-01';

        $finArray = count($servicios); ?>
        @foreach($servicios as $i => $servicio)
            @if ($fi <= $servicio->fi and $servicio->ff >= $ff)
                <?php
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
                ?>
                <tr>
                    <td class="d-none-mobile">{{$servicio->dia}}</td>
                    <td>{{$servicio->fecha}}</td>
                    <td>{{$servicio->etiquetaNombre}}</td>
                    <td class="d-none-mobile">{{$servicio->cant}}</td>
                    <td>{{$servicio->recetaNombre}}</td>
                    <td>{{$servicio->cant_rec}}</td>
                    <?php
                        $costo = 0;
                        $costoEtiqueta = 0; ?>
                    @foreach($recetaItem as $recetaIte)
                        @if ($recetaIte->receta_id == $servicio->receta_id)
                            @foreach($ingredientes as $ingrediente)
                                @if ($recetaIte->ingrediente_id == $ingrediente->ingrediente_id)
                                    @php
                                        $costo = $costo + $recetaIte->cant * $ingrediente->precio/100;
                                    @endphp
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    <?php $totDia = $costoEtiqueta + $totDia; ?>
                     <td class="d-none-mobile">
                         <?php $primeroEtiqueta = $primeroEtiqueta + $costoEtiqueta/$servicio->base * $servicio->cant_rec;?>
                         ${{$costo/$servicio->base}}.-
                     </td>
                    <td class="d-none-mobile">${{$costo/$servicio->base * $servicio->cant_rec}}</td>
                </tr>
            @endif
          </tbody>
        @endforeach
      </table>
    </div>
</div>
@endsection





