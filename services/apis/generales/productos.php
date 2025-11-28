<?php
require_once('../../../db/conexion.php');

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
