<?php

require_once '../db/conexion.php';


?>

<?php

if (isset($_GET['accion']) && $_GET['accion'] == 'listarMesas') {
    include './modales.php';
    $id_negocio = $_GET['idnegocio'];
    $mesa = $conexion->prepare("SELECT *, mesa.id as id_mesa FROM mesa 
    inner join estado_mesa on estado_mesa.id = mesa.id_estado
    WHERE id_negocio = ?");
    $mesa->execute(array($id_negocio));
    $mesas = $mesa->fetchAll(PDO::FETCH_ASSOC);
?>

    <div class="container d-flex justify-content-between align-items-center mb-3">
        <div>
            <button class="btn btn-info  mb-2" onclick="abrirModalMesa()"><i class="fa fa-plus"></i> Nueva Mesa</button>
        </div>
        <div class="estados">
            <?php
            $estados = $conexion->prepare("SELECT * FROM estado_mesa ORDER BY prioridad ASC");
            $estados->execute();
            $estados = $estados->fetchAll(PDO::FETCH_ASSOC);
            foreach ($estados as $estado) {
            ?>
                <div class="estado">
                    <div class="color" style="background-color: <?= $estado['color'] ?>;"></div>
                    <div class="texto"><?= $estado['estado'] ?></div>
                </div>
            <?php
            }
            ?>
        </div>
    </div>

    <div class="row d-flex justify-content-between">
        <?php
        foreach ($mesas as $mesa) {
        ?>
            <div class="mesa  rounded m-1 " title="<?= $mesa['estado'] ?>" style="background-color: <?= $mesa['color'] . '40' ?>;" width="100%" role="button" onclick="cargarMesa(<?= $mesa['id_mesa'] ?>)">
                <div class="numeroMesa">
                    <h2 class="text-center mt-2"><strong><?= $mesa['alias'] ?></strong></h2>
                </div>
                <img src="../src/img/icons/mesa.png" width="100%" alt="">
            </div>

        <?php
        }
        ?>
    </div>
<?php

}

function getEstadosMesa($id_estado)
{
    global $conexion;
    $estados = $conexion->prepare("SELECT * FROM estado_mesa ORDER BY prioridad ASC");
    $estados->execute();
    $estados = $estados->fetchAll(PDO::FETCH_ASSOC);
    $options = '';
    foreach ($estados as $estado) {
        if ($estado['id'] == $id_estado) {
            $options .= '<option value="' . $estado['id'] . '" selected>' . $estado['estado'] . '</option>';
        } else {
            $options .= '<option value="' . $estado['id'] . '">' . $estado['estado'] . '</option>';
        }
    }
    return $options;
}

if (isset($_GET['accion']) && $_GET['accion'] == 'cargarMesa') {

    if (!isset($_GET['idmesa']) || $_GET['idmesa'] == '') {
        $modal = '<div class="modal fade" id="modalMesa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nueva Mesa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMesa">
                    <input type="hidden" id="idMesa" value="">
                    <div class="mb-3">
                        <label for="aliasMesa" class="form-label">Alias de la mesa</label>
                        <input type="text" class="form-control" id="aliasMesa" value="">
                    </div>
                    <div class="mb-3">
                        <label for="estadoMesa" class="form-label">Estado de la mesa</label>
                        <select class="form-select" id="estadoMesa">
                            ' . getEstadosMesa(1) . '
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarMesa()">Guardar cambios</button>
            </div>
        </div>';
    } else {


        $id_negocio = $_GET['idnegocio'];
        $id_mesa = $_GET['idmesa'];
        $mesa = $conexion->prepare("SELECT * FROM mesa WHERE id_negocio = ? AND id = ?");
        $mesa->execute(array($id_negocio, $id_mesa));
        $mesa = $mesa->fetch(PDO::FETCH_ASSOC);

        $modal = '<div class="modal fade" id="modalMesa" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">  

        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Mesa: ' . $mesa['alias'] . '</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formMesa">
                    <input type="hidden" id="idMesa" value="' . $mesa['id'] . '">
                    <div class="mb-3">
                        <label for="aliasMesa" class="form-label">Alias de la mesa</label>
                        <input type="text" class="form-control" id="aliasMesa" value="' . $mesa['alias'] . '">
                    </div>
                    <div class="mb-3">
                        <label for="estadoMesa" class="form-label">Estado de la mesa</label>
                        <select class="form-select" id="estadoMesa">
                           ' . getEstadosMesa($mesa['id_estado']) . '       
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" onclick="guardarMesa()">Guardar cambios</button>
            </div>
        </div>';
    }

    echo ($modal);
}
if (isset($_GET['accion']) && $_GET['accion'] == 'guardarMesa') {
    $id_negocio = $_GET['idnegocio'];
    $id_mesa = $_POST['idMesa'];
    $alias_mesa = $_POST['aliasMesa'];
    $estado_mesa = $_POST['estadoMesa'];

    if ($id_mesa != '') {
        $mesa = $conexion->prepare("UPDATE mesa SET alias = ?, id_estado = ? WHERE id_negocio = ? AND id = ?");
        $mesa->execute(array($alias_mesa, $estado_mesa, $id_negocio, $id_mesa));
        echo 'Mesa actualizada';
    } else {
        $mesa = $conexion->prepare("INSERT INTO mesa (alias, id_estado, id_negocio) VALUES (?, ?, ?)");
        $mesa->execute(array($alias_mesa, $estado_mesa, $id_negocio));
        echo 'Mesa creada';
    }
}
