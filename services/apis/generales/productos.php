<?php
require_once('../../../db/conexion.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if (isset($_GET['accion']) && $_GET['accion'] == 'listProductos') {
    $query = "SELECT * from producto where id_negocio = " . $_GET['id_negocio'];
    $data = $conexion->query($query)->fetchAll();
}

if (isset($_GET['accion']) && $_GET['accion'] == 'productos_vendidos') {
    $query = "select * from producto p  where id in (
        select id_producto  from pedido p where   id_negocio = " . $_GET['id_negocio'] . " group by id_producto )";
    $data = $conexion->query($query)->fetchAll();
}

$jsonProductos = json_encode($data, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $jsonProductos;
