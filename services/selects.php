<?php require_once('../db/conexion.php');

/* LISTADO DE ROLES - Listado de roles para los usuarios */
if (isset($_GET['accion']) && $_GET['accion'] == 'listRoles') {
    $idRol = $_GET['id'];
    $query = "select * from rol";
    $response = $conexion->query($query)->fetchAll();
    $html = "<option>Seleccionar</option>";
    foreach ($response as $r) {
        $html .= "<option " . (($idRol == $r['id']) ? 'selected' : '') . " value=" . $r['id'] . ">" . $r['rol'] . "</option>";
    }
    echo $html;
}

/* LISTADO USUARIOS - segun rol */
if (isset($_GET['accion']) && $_GET['accion'] == 'listSelectUsuarios') {


    $idUsuario = $_GET['idCliente'];
    $isAdmin = $_GET['isAdmin'];
    $soloAdmin = '';
    if($isAdmin <> 0){
        $soloAdmin = " AND id_rol = 2";
    }
    $query = "SELECT * from usuario where id_negocio = " . $_GET['idNegocio'].$soloAdmin;
    $response = $conexion->query($query)->fetchAll();
    $html = "<option>Seleccionar</option>";
    foreach ($response as $r) {
        $html .= "<option " . (($idUsuario == $r['id']) ? 'selected' : '') . " value=" . $r['id'] . ">" . ucwords($r['nombre']) . "</option>";
    }
    echo $html;
}

/* LISTADO PRODUCTOS - SELECT SEGUN (*)  */
if (isset($_GET['accion']) && $_GET['accion'] == 'listSelectProducto') {

    $idProducto = $_GET['idProducto'];
    $query = "SELECT * from producto where id_negocio = " . $_GET['idNegocio'];

    $response = $conexion->query($query)->fetchAll();
    $html = "<option>Seleccionar</option>";
    foreach ($response as $r) {
        $html .= "<option " . (($idProducto == $r['id']) ? 'selected' : '') . " value=" . $r['id'] . ">" . ucwords($r['nombre']) . "</option>";
    }
    echo $html;
}

/* LISTADO ESTADO PEDIDOS  */
if (isset($_GET['accion']) && $_GET['accion'] == 'listSelectEstadoPedido') {
    $idEstadoProducto = $_GET['idEstadoProducto'];
    $query = "SELECT * from estado_pedido";
    $response = $conexion->query($query)->fetchAll();
    $html = "<option>Seleccionar</option>";
    foreach ($response as $r) {
        $html .= "<option " . (($idEstadoProducto == $r['id']) ? 'selected' : '') . " value=" . $r['id'] . ">" . ($r['estado']) . "</option>";
    }
    echo $html;
}
