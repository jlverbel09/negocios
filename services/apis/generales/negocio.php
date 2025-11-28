<?php
require_once('../../../db/conexion.php');


if (isset($_GET['accion']) && $_GET['accion'] == 'detalleNegocio') {

    $query = "SELECT * from negocio where id = " . $_GET['id_negocio'];
    $data = $conexion->query($query)->fetchAll();
}

$jsonProductos = json_encode($data, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $jsonProductos;
