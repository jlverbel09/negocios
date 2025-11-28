<?php

require_once('../db/conexion.php');
include './modales.php';
$query = "SELECT * from apis where id_negocio= 0 or id_negocio = " . $_GET['idnegocio'];
$response = $conexion->query($query)->fetchAll();
$adicional = '';

$realDocRoot = realpath($_SERVER['DOCUMENT_ROOT']);
$realDirPath = realpath(__DIR__);
$suffix = str_replace($realDocRoot, '', $realDirPath);
$prefix = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
$folderUrl = $prefix . $_SERVER['HTTP_HOST'] . $suffix;
?>

<div class="row">


    <div class="col-12 d-flex ">
        <div class="card flex-fill scrollproductos">
            <div class="card-header">

                <h5 class="card-title mb-0">Apis</h5>
            </div>
            <table class="table table-hover table-responsive d-lg-table  d-block my-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Descripcion</th>
                        <th colspan="2">Url</th>
                        <th>Fecha&nbsp;Reg.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                    </tr>
                </thead>
                <tbody> 
                    <?php if (count($response)  == 0): ?>
                        <td colspan="4">No hay ninguna Api</td>
                    <?php endif ?>
                    <?php foreach ($response as $r): ?>

                        <?php

                        $adicional = '&id_negocio=' . $_GET['idnegocio'];

                        ?>
                        <tr>
                            <td><?= $r['id'] ?></td>
                            <td><?= $r['descripcion'] ?></td>
                            <td><code><?= $folderUrl . '/' . $r['url'] . $adicional ?></code></td>
                            <td><a class="btn btn-success" href="<?= $folderUrl . '/' . $r['url'] . $adicional ?>" target="_blank"><?= $r['descripcion'] ?></a></td>
                            <td><?= $r['fecha_reg'] ?></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
</div>