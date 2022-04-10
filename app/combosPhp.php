
ESTE ES EL DETALLE DEL PHP QUE BUSCA EL PRECIO QUE SIEMPRE DEVUELVE 0

<?php

use Illuminate\Database\Eloquent\Model;

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: fooddata.com.ar');
header('Access-Control-Allow-Methods: VAL, GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Credentials: true');

$db = mysqli_connect("localhost", "root", "", "tesis");
mysqli_set_charset($db, "utf8mb4");

$query = "SELECT * FROM ingredientes";

$res = mysqli_query($db, $query);

$id_ingrediente = mysqli_real_escape_string($db, $_GET["ip"]);

$query = "SELECT precio
          FROM ingredientes WHERE ingrediente_id = $id_ingrediente";

$res = mysqli_query($db, $query);

$fila = mysqli_fetch_assoc($res);

echo ($fila["precio"]/100);
//*************************************************

//ESTE ES EL PHP QUE BUSCA LA UNIDAD DE MEDIDA QUE SIEMPRE DEVUELVE QUE NO HAY DATOS DE RESPUESTA

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: fooddata.com.ar');
header('Access-Control-Allow-Methods: VAL, GET, POST, PUT, PATCH, DELETE, OPTIONS');
header('Access-Control-Allow-Credentials: true');

$db = mysqli_connect('localhost.', 'root', '', 'tesis');

$id_ingrediente = mysqli_real_escape_string($db, $_GET['i']);

$query = " Select unidades.nombre FROM unidades INNER JOIN ingredientes WHERE ingredientes.ingrediente_id = $ingrediente_id and ingredientes.unidad_id = unidades.unidad_id";

$res = mysqli_query($db, $query);

$fila = mysqli_fetch_assoc($res);
echo $fila['nombre'] ;
