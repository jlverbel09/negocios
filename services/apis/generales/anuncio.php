<?php
require_once('../../../db/conexion.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if (isset($_GET['accion']) && $_GET['accion'] == 'anuncioInicial') {

    $horaActual = date('H:i:s');
    $fechaActual = date('Y-m-d');
    $query = "SELECT * from anuncio where id_negocio = " . $_GET['id_negocio'] . " and  fecha_reg = '$fechaActual' and '$horaActual' BETWEEN hora_inicio  and hora_fin order by id desc limit 1";
   
    $data = $conexion->query($query)->fetch();
}
$jsonProductos = json_encode($data, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $jsonProductos;
