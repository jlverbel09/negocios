<?php
require_once('../../../db/conexion.php');


if (isset($_GET['accion']) && $_GET['accion'] == 'listPedidos') {

    $query = "SELECT * from pedido p where id_negocio = " . $_GET['id_negocio'];
    $data = $conexion->query($query)->fetchAll();
}

if (isset($_GET['accion']) && $_GET['accion'] == 'ventas_mes') {
    $query = "SELECT * from pedido where DATE_FORMAT(fecha_venta, '%Y-%m-%d')  = DATE_FORMAT(now(), '%Y-%m-%d') and  id_negocio = " . $_GET['id_negocio'];
    $data = $conexion->query($query)->fetchAll();
}
$jsonProductos = json_encode($data, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $jsonProductos;
