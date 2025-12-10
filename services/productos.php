<?php

require_once('../db/conexion.php');

if (isset($_GET['accion']) && $_GET['accion'] == 'listarProductos') {
    /* LISTAR PRODUCTOS */
    include './modales.php';
    $query = "SELECT * from producto where id_negocio = " . $_GET['idnegocio'] . " order by id desc";
    $response = $conexion->query($query)->fetchAll(); ?>
    <div class="col-12">
        <input type="hidden" value="<?= $_GET['idnegocio'] ?>" id="idNegocio">
        <button class="btn btn-info  mb-2" data-bs-toggle="modal" data-bs-target="#modalProducto"><i class="fa fa-plus"></i> Nuevo Producto</button>
    </div>
    <div class="row m-0 p-0 ">
        <div class="card flex-fill scrollproductos col-md-5 col-sm-12">
            <div class="card-header">
                <h5 class="card-title mb-0">Productos</h5>
            </div>
            <table class="table d-lg-table  d-block table-responsive  my-0">
                <thead>
                    <tr>
                        <!-- <th>Vista&nbsp;Previa</th> -->
                        <th colspan="3">Acciones</th>
                        <th>ID</th>
                        <th>Nombre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Precio</th>
                        <th>Promocion</th>
                        <th>Categoria</th>
                        <th>Descripcion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Fecha&nbsp;Registro</th>
                    </tr>
                </thead>
                <tbody class="">
                    <?php if (count($response)  == 0): ?>
                        <td colspan="9">No hay ningun producto</td>
                    <?php endif ?>
                    <?php foreach ($response as $r): ?>
                        <tr>
                            <td class="text-center" role="button" onclick="visualizar(<?= $r['id'] ?>)">
                                <i class="fa fa-eye"></i>
                            </td>
                            <td class="text-center" role="button" data-bs-toggle="modal" data-bs-target="#modalProducto" onclick="cargarModalProducto(<?= $r['id'] ?>)">
                                <i class="fa fa-edit"></i>
                            </td>
                            <td class="text-center" role="button" onclick="eliminarProducto(<?= $r['id'] ?>)">
                                <i class="fa fa-trash"></i>
                            </td>
                            <td><?= $r['id'] ?></td>
                            <td><?= $r['nombre'] ?></td>
                            <td>€&nbsp;<?= number_format($r['precio'], 2, ',', '.'); ?></td>
                            <td>€&nbsp;<?= number_format($r['promocion'], 2, ',', '.'); ?></td>
                            <td><?= $r['categoria'] ?></td>
                            <td><?= $r['descripcion'] ?></td>
                            <td><?= $r['fecha_reg'] ?></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
        <div class="col-md-3 col-sm-12  align-items-center d-flex text-center justify-content-center  card" id="vitapreviaproducto">
            Vista Previa
        </div>
    </div>




<?php
}


if (isset($_GET['accion']) && $_GET['accion'] == 'saveProductos') {

    $array = [
        $_POST['nombreProducto'],
        $_POST['precioProducto'],
        $_POST['promocionProducto'],
        $_POST['categoriaProducto'],
        $_POST['imagenProducto'],
        date('Y-m-d'),
        $_POST['idnegocio'],
        $_POST['descripcionProducto'],
    ];
    if (empty($_POST['idProducto'])) {
        $stm = $conexion->prepare("INSERT INTO producto (nombre,precio,promocion, categoria, img_url, fecha_reg, id_negocio, descripcion)  
    VALUES (?,?,?,?,?,?,?,?)");
        $resultado =  $stm->execute($array);

        echo $resultado;
    } else {

        $sql = "UPDATE producto SET 
            nombre = ?, 
            precio = ?, 
            promocion = ?, 
            categoria = ?, 
            img_url = ?, 
            fecha_upd = ?, 
            id_negocio = ?, 
            descripcion = ?
        WHERE id = " . $_POST['idProducto'];
        $stmt = $conexion->prepare($sql);
        $response = $stmt->execute($array);
        echo $response;
    }
}


if (isset($_GET['accion']) && $_GET['accion'] == 'cargarModalProducto') {
    $sql = "SELECT * from producto where id = " . $_GET['idproducto'];
    $res = $conexion->query($sql)->fetch();

    $data = [
        'id' => $res['id'],
        'nombre' => $res['nombre'],
        'precio' => $res['precio'],
        'promocion' => $res['promocion'],
        'categoria' => $res['categoria'],
        'img_url' => $res['img_url'],
        'fecha_reg' => $res['fecha_reg'],
        'id_negocio' => $res['id_negocio'],
        'descripcion' => $res['descripcion']
    ];
    echo json_encode($data);
}


if (isset($_GET['accion']) && $_GET['accion'] == 'eliminarProducto') {
    $query = "DELETE FROM producto where id = " . $_GET['idproducto'];
    $response = $conexion->query($query)->execute();
    echo $response;
}
