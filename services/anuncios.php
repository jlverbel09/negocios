<?php


require_once('../db/conexion.php');

if (isset($_GET['accion']) && $_GET['accion'] == 'listarAnuncios') {
    /* LISTAR PRODUCTOS */
    include './modales.php';

    $query = "SELECT * from anuncio where estado = 'A' and id_negocio = " . $_GET['idnegocio'] . " order by fecha_reg, id desc";
    $response = $conexion->query($query)->fetchAll(); ?>
    <div class="col-12">
        <input type="hidden" value="<?= $_GET['idnegocio'] ?>" id="idNegocio">
        <button class="btn btn-info  mb-2" data-bs-toggle="modal" data-bs-target="#modalAnuncio"><i class="fa fa-plus"></i> Nuevo Anuncio</button>
    </div>
    <div class="row m-0 p-0 ">
        <div class="card flex-fill scrollproductos col-md-5 col-sm-12">
            <div class="card-header">
                <h5 class="card-title mb-0">Anuncio</h5>
            </div>
            <table class="table d-lg-table  d-block table-responsive  my-0">
                <thead>
                    <tr>
                        <!-- <th>Vista&nbsp;Previa</th> -->
                        <th class="text-center">Acciones</th>
                        <th>ID</th>
                        <th>Imagen</th>
                        <th>Fecha&nbsp;Registro</th>
                        <th>Hora&nbsp;Inicio</th>
                        <th>Hora&nbsp;Fin</th>

                    </tr>
                </thead>
                <tbody class="">
                    <?php if (count($response)  == 0): ?>
                        <td colspan="9">No hay ningúnanuncio</td>
                    <?php endif ?>
                    <?php foreach ($response as $r): ?>
                        <tr>
                            <td class="text-center" role="button" onclick="eliminarAnuncio(<?= $r['id'] ?>)">
                                <i class="fa fa-trash"></i>
                            </td>
                            <td><?= $r['id'] ?></td>
                            <td>
                                <img width="100" src="<?= $r['imagen'] ?>" alt="">
                            </td>
                            <td><?= $r['fecha_reg'] ?></td>

                            <td><?= $r['hora_inicio'] ?></td>
                            <td><?= $r['hora_fin'] ?></td>
                        </tr>
                    <?php endforeach ?>

                </tbody>
            </table>
        </div>
    </div>
<?php
}



if (isset($_GET['accion']) && $_GET['accion'] == 'saveAnuncio') {

    $idnegocio = isset($_POST['idnegocio']) ? $_POST['idnegocio'] : (isset($_GET['idnegocio']) ? $_GET['idnegocio'] : 0);
    $horaInicio = isset($_POST['horaInicio']) ? $_POST['horaInicio'] : '';
    $horaFin = isset($_POST['horaFin']) ? $_POST['horaFin'] : '';

    $imagenPath = '';

    if (isset($_FILES['imagenAnuncio'])) {
        if (is_array($_FILES['imagenAnuncio']['name'])) {
            $name = $_FILES['imagenAnuncio']['name'][0];
            $tmp = $_FILES['imagenAnuncio']['tmp_name'][0];
            $error = $_FILES['imagenAnuncio']['error'][0];
        } else {
            $name = $_FILES['imagenAnuncio']['name'];
            $tmp = $_FILES['imagenAnuncio']['tmp_name'];
            $error = $_FILES['imagenAnuncio']['error'];
        }

        if ($error === UPLOAD_ERR_OK && $name !== '') {
            $carpeta_destino = '../uploads/nazca/anuncios/';
            if (!is_dir($carpeta_destino)) {
                mkdir($carpeta_destino, 0755, true);
            }
            $ext = pathinfo($name, PATHINFO_EXTENSION);
            $filename = uniqid('anuncio_') . ($ext ? '.' . $ext : '.jpg');
            $archivo_subido = $carpeta_destino . $filename;
            if (move_uploaded_file($tmp, $archivo_subido)) {
                $imagenPath = $archivo_subido;
            } else {
                echo 'Error al mover el archivo.';
                exit;
            }
        } else {
            echo 'Error en la subida o no se seleccionó archivo.';
            exit;
        }
    } else {
        echo 'No se ha enviado archivo.';
        exit;
    }

    $array = [
        $imagenPath,
        date('Y-m-d'),
        $horaInicio,
        $horaFin,
        $idnegocio,
    ];

    $stm = $conexion->prepare("INSERT INTO anuncio (imagen,fecha_reg,hora_inicio, hora_fin, id_negocio)  
            VALUES (?,?,?,?,?)");
    $resultado =  $stm->execute($array);

    echo $resultado;
}

if (isset($_GET['accion']) && $_GET['accion'] == 'eliminarAnuncio') {
    $query = "UPDATE anuncio SET estado = 'I' WHERE id = " . $_GET['idanuncio'];
    $response = $conexion->query($query)->execute();
    echo $response;
}
