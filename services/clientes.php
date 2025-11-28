<?php require_once('../db/conexion.php');
$query = "select * from usuario where id_negocio = " . $_GET['idnegocio']." order by id desc";
$response = $conexion->query($query)->fetchAll();
?>

<?php include './modales.php'; ?>
<div class="row">
    <div class="col-12">
        <button class="btn btn-info " onclick="soloClientes()" data-bs-toggle="modal" data-bs-target="#modalUsuario"><i class="fa fa-plus"></i> Nuevo Cliente</button>
    </div>
    <div class="col-12 d-flex ">
        <div class="card flex-fill scrollproductos">
            <div class="card-header">
                <h5 class="card-title mb-0">Clientes</h5>
            </div>
            <table class="table table-hover   table-responsive d-lg-table  d-block  my-0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Avatar</th>
                        <th>Nombre&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                        <th>Correo</th>
                        <th>Usuario</th>
                        <th>Fecha&nbsp;Registro</th>
                        <th class="text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($response)  == 0): ?>
                        <td colspan="7">No hay ningun Cliente</td>
                    <?php endif ?>
                    <?php foreach ($response as $r): ?>
                        <tr>
                            <td><?= $r['id'] ?></td>
                            <td><img style="width:50px" class="rounded" src="../static/img/avatars/<?= $r['avatar'] ?>" alt=""></td>
                            <td style="width:400px"><?= $r['nombre'] ?></td>
                            <td><?= $r['correo'] ?></td>
                            <td><?= $r['user'] ?></td>
                            <td><?= $r['created_at'] ?></td>
                            <td class="table-action text-center">
                                <a href="#" onclick="editarUsuario(<?= $r['id'] ?>)">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit-2 align-middle" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                                        <path d="M17 3a2.828 2.828 0 1 1 4 4L7.5 20.5 2 22l1.5-5.5L17 3z"></path>
                                    </svg>
                                </a>&nbsp;
                                <a href="#" onclick="eliminarUsuario(<?= $r['id'] ?>)">
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