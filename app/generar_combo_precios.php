<?php
// En este php vamos a recibir el id del país que el usuario elige en el select, y vamos
// a generar una lista de los options para reemplazar los existentes en el select de ciudad.
use Illuminate\Database\Eloquent\Model;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: fooddata.com.ar');
header('Access-Control-Allow-Methods: VAL, GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Credentials: true');

$db = mysqli_connect("localhost", "florenci_tesis", "Santino07/", "florenci_tesis");


$id_ingrediente = mysqli_real_escape_string($db, $_GET["ip"]);

$query = "SELECT precio
          FROM ingredientes WHERE ingrediente_id = $id_ingrediente";

$res = mysqli_query($db, $query);

$fila = mysqli_fetch_assoc($res);

echo ($fila["precio"]/100);
