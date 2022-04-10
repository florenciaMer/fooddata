<?php

use Illuminate\Database\Eloquent\Model;


$db = mysqli_connect("localhost", "florenci_tesis", "Santino07/", "florenci_tesis");
$tipo = mysqli_real_escape_string($db, $_GET['i']);

$query =
    "SELECT * FROM recetas where tipo_id = $tipo";

$res = mysqli_query($db, $query);

while($fila = mysqli_fetch_assoc($res)) {
    echo "<option value='" . $fila['receta_id'] . "'>" . $fila['nombre'] . "</option>";
}





