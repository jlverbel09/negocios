<?php require_once('../db/conexion.php');
include './modales.php';
$query = "select p.*, u.nombre as cliente, p2.nombre as producto, p2.precio, p2.promocion, ep.estado from pedido p
inner join usuario u on u.id =p.id_cliente
inner join producto p2  on p2.id  =p.id_producto
inner join estado_pedido ep on ep.id = p.id_estado 
where abrev = 'VEN' and p.id_negocio = " . $_GET['idnegocio']." order by p.id desc";

$response = $conexion->query($query)->fetchAll();
$totalFinal = 0;
?>

<div class="row">
    <input type="hidden" value="<?= $_GET['idnegocio'] ?>" id="idNegocio">
    <div class="col-12 d-flex ">
        <div class="card flex-fill scrollproductos">
            <div class="card-header">

                <h5 class="card-title mb-0">Ventas</h5>
            </div>
            <table class="table table-hover table-responsive d-lg-table  d-block my-0">
                <thead>
                    <tr>
                        

                        <th>ID&nbsp;Pedido</th>
                        <th>Producto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Cliente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Mensaje&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Fecha&nbsp;Reg.&nbsp;&nbsp;&nbsp;</th>
                        <th>Fecha&nbsp;Entrega</th>
                        <th>Estado</th>
                        <th>Cantidad</th>
                        <th>Precio&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Promocion</th>


                        <!-- <th colspan="2">Acciones</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($response)  == 0): ?>
                        <td colspan="11">No hay ninguna venta</td>
                    <?php endif ?>
                    <?php foreach ($response as $r): ?>
                        <?php
                        if ($r['promocion'] * $r['cantidad'] <> 0) {
                            $valor =  $r['promocion'] * $r['cantidad'];
                        } else {
                            $valor =  $r['precio'] * $r['cantidad'];
                        }
                        $totalFinal = $totalFinal + $valor;
                        ?>
                        <tr>
                            <td><?= str_pad($r['id'], 5, '0', STR_PAD_LEFT) ?></td>
                            <td><?= $r['producto'] ?></td>
                            <td><?= $r['cliente'] ?></td>
                            <td><?= $r['mensaje'] ?></td>
                            <td><?= $r['fecha_reg'] ?></td>
                            <td><?= $r['fecha_entrega'] ?></td>
                            <td><?= $r['estado'] ?></td>
                            <td class="text-center"><?= $r['cantidad'] ?></td>
                            <td>€ <?= number_format($r['precio'], 2, ',', '.'); ?></td>
                            <td>€ <?= number_format($r['promocion'], 2, ',', '.'); ?></td>
                            <!-- <td class="text-center" role="button" data-bs-toggle="modal" data-bs-target="#modalPedido" onclick="cargarModalPedido(<?= $r['id'] ?>)">
                                <i class="fa fa-edit"></i>
                            </td>
                            <td class="text-center" role="button" onclick="eliminarPedido(<?= $r['id'] ?>,'ventas')">
                                <i class="fa fa-trash"></i>
                            </td> -->
                        </tr>
                    <?php endforeach ?>

                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2">
                            <b>TOTAL: €&nbsp;<?= number_format($totalFinal, 2, ',', '.') ?></b>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>