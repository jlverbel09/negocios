<?php require_once('../db/conexion.php');

/* Listado de usuarios  */
if (isset($_GET['accion']) && $_GET['accion'] == 'listUsuarios') {
    include './modales.php';
    $query = "SELECT u.*, r.rol from usuario u 
    inner join rol r on r.id = u.id_rol 
    left join negocio n on n.id = u.id_negocio 
    where u.id_negocio = 0 or  n.estado = 'A'
    order by id_rol";
    $response = $conexion->query($query)->fetchAll(); ?>

    <div class="row m-0">
        <h1 class="h3 mb-3 col-lg-10">Usuarios</h1>
        <button class="btn btn-info col-md-2" data-bs-toggle="modal" data-bs-target="#modalUsuario"><i class="fa fa-user me-2"></i>Crear Usuario</button>
    </div>
    <div class="row">
        <div class="col-12 col-xl-12">
            <div class="card">
                <div class="card-header pb-0">
                    <h5 class="card-title">Listado de Usuarios</h5>
                    <h6 class="card-subtitle text-muted">Todos los usuarios registrado para este negocio
                    </h6>
                </div>
                <table class="table table-responsive d-lg-table  d-block">
                    <thead>
                        <tr>
                            <th style="width:30%;">Nombre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                            <th style="width:15%">Correo Electrónico</th>
                            <th style="width:25%">Usuario</th>
                            <th style="width:5%">Rol</th>
                            <th style="width:10%">Estado</th>
                            <th style="width:45%">Fecha&nbsp;Reg.&nbsp;&nbsp;</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($response as $data): ?>
                            <tr>
                                <td><?= ucwords($data['nombre']) ?></td>
                                <td><?= $data['correo'] ?></td>
                                <td><?= $data['user'] ?></td>
                                <td><?= $data['rol'] ?></td>
                                <td><?= ($data['status'] == 1) ?  'Activo' : 'Inactivo' ?></td>
                                <td><?= $data['created_at'] ?></td>
                                <td class="table-action">
                                    <a href="#" onclick="editarUsuario(<?= $data['id'] ?>)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                                            <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                        </svg>
                                    </a>&nbsp;
                                    <a href="#" onclick="eliminarUsuario(<?= $data['id'] ?>)">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash align-middle" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                                            <polyline points="3 6 5 6 21 6"></polyline>
                                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>

                        <?php endforeach ?>



                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php }

/* Guardado y modificado de datos de usuario */
if (isset($_GET['accion']) && $_GET['accion'] == 'guardarUsuario') {

    if ($_GET['id_negocio_global']) {
        $id_negocio_global = $_GET['id_negocio_global'];
    } else {
        $id_negocio_global = 0;
    }
    if (empty($_POST['id'])) {
        $stm = $conexion->prepare("INSERT INTO usuario (nombre, correo, avatar, user, password,id_rol, status, created_at, id_negocio)  
    VALUES (?,?,?,?,?,?,?,?,?)");
        $resultado =  $stm->execute([
            $_POST['nombre'],
            $_POST['correo'],
            'avatar_default.png',
            $_POST['usuario'],
            $_POST['password'],
            $_POST['rol'],
            $_POST['estado'],
            date('Y-m-d'),
            $id_negocio_global
        ]);

        echo $resultado;
    } else {
        if (empty($_POST['password'])) {
            $password = "";
            $array = [
                $_POST['nombre'],
                $_POST['correo'],
                'avatar_default.png',
                $_POST['usuario'],
                $_POST['rol'],
                $_POST['estado'],
                date('Y-m-d'),
                $id_negocio_global
            ];
        } else {
            $password = "password = ?, ";
            $array = [
                $_POST['nombre'],
                $_POST['correo'],
                'avatar_default.png',
                $_POST['usuario'],
                $_POST['password'],
                $_POST['rol'],
                $_POST['estado'],
                date('Y-m-d'),
                $id_negocio_global
            ];
        }
        $sql = "UPDATE usuario SET 
       nombre = ?, 
       correo = ?, 
       avatar = ?, 
       user = ?, 
       " . $password . "
       id_rol = ?, 
       status = ?, 
       updated_at = ?,
       id_negocio = ?
       
        WHERE id = " . $_POST['id'];
        $stmt = $conexion->prepare($sql);
        $response = $stmt->execute($array);
        echo $response;
    }
}

/* Eliminacion de usuario */
if (isset($_GET['accion']) && $_GET['accion'] == 'eliminarUsuario') {
    $query = "DELETE FROM usuario u where u.id = " . $_POST['id'];
    $response = $conexion->query($query)->execute();
    echo $response;
}

/* Carga de datos para la edicion de usuario */
if (isset($_GET['accion']) && $_GET['accion'] == 'editarUsuario') {
    $query = "SELECT * FROM usuario u where u.id = " . $_POST['id'];
    $response = $conexion->query($query)->fetch(); ?>
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edición de Usuario</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body row">
                <div class="col-md-6">
                    <input type="hidden" value="<?= $_POST['id'] ?>" id="id_usuario">
                    <label class="mb-1">Nombre Completo</label>
                    <input type="text" class="form-control" id="nombre" value="<?= $response['nombre'] ?>">
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Correo Electrónico</label>
                    <input type="text" class="form-control" id="correo" value="<?= $response['correo'] ?>">
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Usuario</label>
                    <input type="text" class="form-control" id="usuario" value="<?= $response['user'] ?>">
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Contraseña</label>
                    <input type="password" class="form-control" id="password">
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Rol</label>
                    <select class="form-select" name="rol" id="rol"></select>
                    <script>
                        listRoles(<?= $response['id_rol'] ?>)
                    </script>
                </div>
                <div class="col-md-6">
                    <label class="mb-1">Estado</label>
                    <select class="form-select" name="estado" id="estado">
                        <option <?= (($response['status'] == 1) ? 'selected' : '') ?> value="1">Activo</option>
                        <option <?= (($response['status'] == 0) ? 'selected' : '') ?> value="0">Inactivo</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary cerrarModal" data-bs-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-warning" onclick="guardarUsuario()">Editar</button>
            </div>
        </div>
    </div>

<?php
}
