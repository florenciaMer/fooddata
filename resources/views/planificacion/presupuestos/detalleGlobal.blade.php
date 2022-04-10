
<?php

/** @var array $servicios */
/** @var array $servicios1 */
/** @var @ $servicio */
$costoTotalGravado = 0;
$costoTotalExento = 0;
$cantidadTotal = 0;
$etiqueta_id = '';

?>
<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        var serviciosJS = <?= json_encode($servicios,
            JSON_HEX_QUOT | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS
        ) ?>;

        serviciosJS.sort((o1, o2) => {
            if (o1.etiquetaNombre < o2.etiquetaNombre) {
                return -1;
            } else if (o1.etiquetaNombre > o2.etiquetaNombre) {
                return 1;
            } else {
                return 0;
                // las dos cadenas son iguales
            }
        })

        console.log(serviciosJS);
        servicios1 =JSON.stringify(serviciosJS);
{{--//        <?php // $servicios1 = $_GET['servicios'];?>--}}
        form.submit('servicios1');
        // window.location.href='window.location.href?servicios='+serviciosJS;
    })

</script>
@section('title', 'Costos de Servicios período')

@extends('layout.main')
@section('main')

    <table class="table ">
{{--        cabecera--}}
        <tr>
            <th>Fecha Inicial</th>
            <th>Fecha Final</th>
            <th>Contexto</th>
            <th>Iva</th>
        </tr>

        <tr>
            <td>{{$servicios[0]->fechaI}}</td>
            <td>{{$servicios[0]->fechaF}}</td>
            <td>{{$servicios[0]->contexto}}</td>
            <td>{{$servicios[0]->condicion_id}}</td>
            <td>Ver</td>
        </tr>
    </table>
    <table class="table">
        <tr>
            <th>Servicio</th>
            <th>Costo del Servicio</th>
            <th>Comensales</th>
            <th>Costo por Comensal</th>
            <th>Ver</th>
        </tr>

    <?php

        $finArray = count($servicios)-1;
        $etiqueta_id = $servicios[0]->etiqueta_id;

//        $servicios1 = $_REQUEST['servicios'];

//         $servicios1 = parseJSON($servicios1);
//        $servicios1 = json_decode($servicios1);

var_dump($servicios1);
        foreach($servicios1 as $i => $servicio) {
           if ($servicio->etiqueta_id == $etiqueta_id || $i < $finArray){
               $cantidadTotal = $cantidadTotal + $servicio->cant;
                if ($servicio->condicion_id == 1){
                   $costoTotalGravado = $costoTotalGravado + $servicio->costoGravado * $servicio->cant_rec;
                 }else{
                    $costoTotalExento = $costoTotalExento + $servicio->costoExento * $servicio->cant_rec;;
                }
           }else {

                   $etiqueta_id = $servicio->etiqueta_id;
                   ?>
                   {{$servicio->etiquetaNombre}}
                   {{$servicio->cant}}
          <?php
           var_dump($servicios1);}
          }
        ?>
 </table>

@endsection




