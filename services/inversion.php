<?php

require_once('../db/conexion.php');

if (isset($_GET['accion']) && $_GET['accion'] == 'guardarInversion') {
    $array = [
        $_POST['valorInvertir'],
        date('Y-m-d'),
        $_POST['idNegocio']
    ];
    $sql = "INSERT into inversion (valor, fecha_reg, id_negocio) values(?,?,?)";
    $stm = $conexion->prepare($sql);
    $resultado =  $stm->execute($array);
    echo $resultado;
}

if (isset($_GET['accion']) && $_GET['accion'] == 'cargarInversion') {
    $ultimaInversion = 0;
    $sql = "SELECT sum(valor) as valor_invertido from inversion i where id_negocio  = " . $_GET['idNegocio'];
    $res = $conexion->query($sql)->fetch();
    if ($res['valor_invertido'] <> 0) {
        $ultimaInversion = number_format($res['valor_invertido'], 2, ',', '.');
    }
    echo $ultimaInversion;
}

if (isset($_GET['accion']) && $_GET['accion'] == 'cargarHistroialInversion') {

    $sql = "SELECT * from inversion i where id_negocio  = " . $_GET['idNegocio'] . " order by fecha_reg";
    $res = $conexion->query($sql)->fetchAll();
    $i = 0;
    $html = '<tbody>';
?>
    <?php if (count($res)  == 0): ?>
       <tr> <td colspan="4">No se ha realizado inversiones</td></tr>
    <?php endif ?>

    <?php
    foreach ($res as $r) {
        $i++
    ?>
        <tr>
            <td><?= $i ?></td>
            <td><?= $r['fecha_reg'] ?></td>
            <td>€ <?= number_format($r['valor'], 2, ',', '.') ?></td>
            <td class="text-center">
                <a href="#" class="btn btn-outline-info" onclick="eliminarInversion(<?= $r['id'] ?>)"><i class="fa fa-trash"></i></a>
            </td>
        </tr>
<?php
    }
    $html = '</tbody>';
    echo $html;
}

if (isset($_GET['accion']) && $_GET['accion'] == 'eliminarInversion') {
    $query = "DELETE FROM inversion where id = " . $_GET['idInversion'];
    $response = $conexion->query($query)->execute();
    echo $response;
}
