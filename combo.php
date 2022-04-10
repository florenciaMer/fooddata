<?php
header('Access-Control-Allow-Origin: *');

'Access-Control-Allow-Origin: fooddata.com.ar';
'Access-Control-Allow-Credentials: true';
'Access-Control-Allow-Methods: POST';
'Access-Control-Allow-Headers: Content-Type';
header('Access-Control-Allow-Methods: GET, POST, PUT, PATCH, DELETE, OPTIONS');

header('Content-Type: application/json; charset=UTF-8');
'Access-Control-Allow-Headers: Authorization';


$db = mysqli_connect('localhost', 'florenci_tesis', 'Santino07/', 'florenci_tesis');

mysqli_set_charset($db, 'utf8mb4');


$id_ingrediente = mysqli_real_escape_string($db, $_GET['ip']);

$query = "SELECT precio
              FROM ingredientes WHERE ingrediente_id = $id_ingrediente";

$res = mysqli_query($db, $query);

$fila = mysqli_fetch_assoc($res);

//echo ($fila['precio']/100);

echo json_encode($fila['precio']/100);

