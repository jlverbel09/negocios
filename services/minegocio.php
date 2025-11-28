<?php
require_once '../db/conexion.php';

if (isset($_GET['accion']) && $_GET['accion'] == 'detallesNegocio') {
    $sql = "SELECT * from negocio where id = " . $_GET['idMiNegocio'];
    $res = $conexion->query($sql)->fetch();

    
    $data = [
        'nombre' => $res['nombre'],
        'estado' => $res['estado'],
        'slogan' => $res['slogan'],
        'administrador' => $res['administrador'],
        'fecha_creacion' => $res['fecha_creacion'],
        'tema' => $res['tema'],
        'whatsapp' => $res['whatsapp'],
        'facebook' => $res['facebook'],
        'instagram' => $res['instagram'],
        'ubicacion' => $res['ubicacion'],
        'correo' => $res['correo']
    ];

    echo json_encode($data);
}
if (isset($_GET['accion']) && $_GET['accion'] == 'GuardardetallesNegocio') {
    $array = [
        $_POST['nombreNegocio'],
        $_POST['estadoNegocio'],
        $_POST['sloganNegocio'],
        $_POST['administradorNegocio'],
        date('Y-m-d'),
        $_POST['temaNegocio'],
        $_POST['wpNegocio'],
        $_POST['facebookNegocio'],
        $_POST['igNegocio'],
        $_POST['ubicacionNegocio'],
        $_POST['correoNegocio']
    ];

    $sql = "UPDATE negocio SET 
            nombre = ?,
            estado = ?,
            slogan = ?,
            administrador = ?,
            fecha_creacion = ?,
            tema = ?,
            whatsapp = ?,
            facebook = ?,
            instagram = ?,
            ubicacion = ?,
            correo = ?

        WHERE id = " . $_POST['idMiNegocio'];

    $stmt = $conexion->prepare($sql);
    $response = $stmt->execute($array);
    echo $response;
}
