<?php require_once('../db/conexion.php');



if (isset($_GET['accion']) && $_GET['accion'] == 'listarPedidos') {
    include './modales.php';
    $query = "select p.*, u.nombre as cliente, p2.nombre as producto, p2.precio, p2.promocion, ep.estado from pedido p
        inner join usuario u on u.id =p.id_cliente
        inner join producto p2  on p2.id  =p.id_producto
        inner join estado_pedido ep on ep.id = p.id_estado 
        where abrev <> 'VEN' and p.id_negocio = " . $_GET['idnegocio'] ." order by p.id desc";
    $response = $conexion->query($query)->fetchAll();
    $totalFinal = 0; ?>

    <div class="row">
        <div class="col-12">
            <input type="hidden" value="<?= $_GET['idnegocio'] ?>" id="idNegocio">
            <button class="btn btn-info  mb-2" onclick="listSelectUsuarios(<?= $_GET['idnegocio'] ?>);listSelectProducto(<?= $_GET['idnegocio'] ?>);listSelectEstadoPedido()" data-bs-toggle="modal" data-bs-target="#modalPedido"><i class="fa fa-plus"></i> Nuevo Pedido</button>
        </div>

        <div class="col-12 d-flex ">
            <div class="card flex-fill scrollproductos">
                <div class="card-header">

                    <h5 class="card-title mb-0">Pedidos</h5>
                </div>
                <table class="table table-hover table-responsive d-lg-table  d-block my-0 table-responsive">
                    <thead>
                        <tr>
                            <th>ID&nbsp;Pedido</th>
                            <th>Producto&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th>Cliente&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th>Mensaje&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th>Fecha&nbsp;Reg.&nbsp;&nbsp;&nbsp;</th>
                            <th>Fecha&nbsp;Entrega</th>
                            <th>Direccion&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th>Estado</th>
                            <th>Cantidad</th>
                            <th>Precio</th>
                            <th>Promocion</th>
                            <th colspan="2">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (count($response)  == 0): ?>
                            <td colspan="12">No hay ningun Pedido</td>
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
                                <td><?= $r['direccion'] ?></td>
                                <td><?= $r['estado'] ?></td>
                                <td class="text-center"><?= $r['cantidad'] ?></td>
                                <td>€&nbsp;<?= number_format($r['precio'], 2, ',', '.'); ?></td>
                                <td>€&nbsp;<?= number_format($r['promocion'], 2, ',', '.'); ?></td>
                                <td class="text-center" role="button" data-bs-toggle="modal" data-bs-target="#modalPedido" onclick="cargarModalPedido(<?= $r['id'] ?>)">
                                    <i class="fa fa-edit"></i>
                                </td>
                                <td class="text-center" role="button" onclick="eliminarPedido(<?= $r['id'] ?>,'pedidos')">
                                    <i class="fa fa-trash"></i>
                                </td>
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
<?php
}

if (isset($_GET['accion']) && $_GET['accion'] == 'savePedidos') {
    
    if ($_POST['estadoPedido'] == 4) {
        $fechaVenta = date('Y-m-d');
    } else {
        $fechaVenta = NULL;
    }

    $array = [
        $_POST['idNegocio'],
        $_POST['clientePedido'],
        $_POST['productoPedido'],
        $_POST['descripcionPedido'],
        date('Y-m-d'),
        $fechaVenta,
        $_POST['fechaentregaPedido'],
        $_POST['estadoPedido'],
        $_POST['cantidadPedido'],
        $_POST['direccionPedido']
    ];

    if (empty($_POST['idPedido'])) {
        $stm = $conexion->prepare("INSERT into pedido (id_negocio, id_cliente,id_producto,mensaje,fecha_reg,fecha_venta,fecha_entrega,id_estado, cantidad,direccion )
    VALUES (?,?,?,?,?,?,?,?,?,?)");
        $resultado =  $stm->execute($array);

        echo $resultado;
    } else {

        $sql = "UPDATE pedido SET 
            id_negocio = ?,
            id_cliente = ?,
            id_producto = ?,
            mensaje = ?,
            fecha_reg = ?,
            fecha_venta = ?,
            fecha_entrega = ?,
            id_estado = ?,
            cantidad = ?,
            direccion = ?

        WHERE id = " . $_POST['idPedido'];
        
        $stmt = $conexion->prepare($sql);
        $response = $stmt->execute($array);
        echo $response;
    }
}

if (isset($_GET['accion']) && $_GET['accion'] == 'cargarModalPedido') {
    $sql = "SELECT * from pedido where id = " . $_GET['idPedido'];
    $res = $conexion->query($sql)->fetch();

    $data = [
        'id' => $res['id'],
        'id_negocio' => $res['id_negocio'],
        'id_cliente' => $res['id_cliente'],
        'id_producto' => $res['id_producto'],
        'mensaje' => $res['mensaje'],
        'fecha_entrega' => $res['fecha_entrega'],
        'id_estado' => $res['id_estado'],
        'cantidad' => $res['cantidad'],
        'direccion' => $res['direccion']
    ];
    echo json_encode($data);
}

if (isset($_GET['accion']) && $_GET['accion'] == 'eliminarPedido') {
    $query = "DELETE FROM pedido where id = " . $_GET['idPedido'];
    $response = $conexion->query($query)->execute();
    echo $response;
}
