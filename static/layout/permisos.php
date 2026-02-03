<?php

if ($_SESSION['usuario']['id_rol'] == 1) {
    $permisos = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
    $permisosNegocio = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, 18, 19, 20];
} else {

    $query = "select *  from permiso_seccion ps
    inner join usuario u on u.id_rol  = ps.id_rol where ps.estado = 'A' and u.id = " . $_SESSION['usuario']['id'] . "";
    $response = $conexion->query($query)->fetchAll();
    $permisos = [];
    foreach ($response as $permiso) {
        $permisos[] = $permiso['id_seccion'];
    }

    $query = "select *, n.id as negocio  from permiso_seccion ps 
inner join negocio n on n.administrador = ps.id_user 
where ps.estado = 'A' and id_user = " . $_SESSION['usuario']['id'] . "";
    $response = $conexion->query($query)->fetchAll();
    $permisosNegocio = [];
    foreach ($response as $permiso) {
        $permisosNegocio[] = $permiso['negocio'];
    }
}
