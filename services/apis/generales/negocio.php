<?php
require_once('../../../db/conexion.php');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if (isset($_GET['accion']) && $_GET['accion'] == 'detalleNegocio') {

    $query = "SELECT * from negocio where id = " . $_GET['id_negocio'];
    $data = $conexion->query($query)->fetchAll();
}

if (isset($_GET['accion']) && $_GET['accion'] == 'visitasNegocio') {
    $query = "UPDATE negocio SET visitas = visitas + 1 WHERE id = " . $_GET['id_negocio'];
    $data = $conexion->query($query)->fetchAll();
}
if (isset($_GET['accion']) && $_GET['accion'] == 'contadorVisitasNegocio') {

    $query = "SELECT visitas FROM negocio WHERE id = " . $_GET['id_negocio'];
    $data = $conexion->query($query)->fetchAll();
}

if (isset($_GET['accion']) && $_GET['accion'] == 'reservasNegocio') {

    $query = "UPDATE negocio SET reservas = reservas + 1 WHERE id = " . $_GET['id_negocio'];
    $data = $conexion->query($query)->fetchAll();
}


$jsonProductos = json_encode($data, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $jsonProductos;
