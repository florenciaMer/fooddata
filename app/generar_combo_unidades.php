<?php

$db = mysqli_connect("localhost", "florenci_tesis", "Santino07/", "florenci_tesis");
mysqli_set_charset($db, 'utf8mb4');

$id_ingrediente = mysqli_real_escape_string($db, $_GET['i']);

$query = "SELECT unidades.nombre, unidades.unidad_id
          FROM unidades INNER JOIN ingredientes WHERE ingredientes.ingrediente_id = $id_ingrediente
          AND ingredientes.unidad_id = unidades.unidad_id";

$res = mysqli_query($db, $query);

$fila = mysqli_fetch_assoc($res);
    echo $fila['nombre'] ;

hola
