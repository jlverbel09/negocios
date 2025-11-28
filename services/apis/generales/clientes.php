<?php
require_once('../../../db/conexion.php');

if (isset($_GET['accion']) && $_GET['accion'] == 'listClientes') {
    $query = "SELECT * from usuario u where id_rol  = 3 and id_negocio  =  " . $_GET['id_negocio'];
    $data = $conexion->query($query)->fetchAll();
}
if (isset($_GET['accion']) && $_GET['accion'] == 'totalClientes') {
    $query = "SELECT count(id) as cantidad from usuario u where id_rol  = 3 and id_negocio  =  " . $_GET['id_negocio'];
    $data = $conexion->query($query)->fetchAll();
}

$jsonProductos = json_encode($data, JSON_PRETTY_PRINT);
header('Content-Type: application/json');
echo $jsonProductos;
