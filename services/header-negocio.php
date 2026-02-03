<script>
    cargarInversion()
</script>
<?php
session_start();
require_once('../db/conexion.php');
require_once '../static/layout/permisos.php';
if (isset($_GET['id'])) {
    $id_negocio_global = $_GET['id'];

    /* HISTORICO */
} else {
    $id_negocio_global = 0;
}
?>
<input type="hidden" id="id_negocio_global" value="<?= $_GET['id'] ?>">
<div class="row">
    <div class="col-md-12 col-lg-3 align-items-center d-flex">
        <h3 class="m-0 mb-1"><?= ucwords($_GET['negocio']) ?> </h3>
    </div>
    <?php
    if (in_array(10, $permisos)) {
    ?>
        <div class="col-md-12 col-lg-6 d-flex align-items-center mb-2 row ">
            <div class="d-flex col-md-12 col-lg-8 align-items-center mb-2 ">
                <label class="p-0 m-0">VALOR&nbsp;A&nbsp;INVERTIR:&nbsp;€</label>&nbsp;
                <input type="number" value="" id="valorInvertir" placeholder="0.00" class="form-control bg-dark text-white">
                <button class="btn btn-info mx-1" onclick="guardarInversion()"><i class="fa fa-arrow-right"></i></i> </button>
            </div>
            <div class="d-flex col-md-12 col-lg-4 align-items-center mb-2 ">
                <label>INVERTIDO: </label>
                <div class="d-flex align-items-center ">
                    <b>&nbsp;€&nbsp;<span id="valorInvertido"></span></b>
                </div>

            </div>
        </div>
    <?php
    }
    ?>
    <?php
    if (in_array(9, $permisos)) {
    ?>
        <div class="col-md-3 justify-content-end d-flex align-items-center" id="reportesSeccion">
            <button class="btn  btn-secondary mx-1 py-1" title="Historial de Inversiones" onclick="cargarHistorialInversion()" data-bs-toggle="modal" data-bs-target="#modalHistorial"><i class="fa fa-clock"></i></button>
            <button class="btn btn-sm m-1 btn-success"><i class="fa fa-file-excel"></i> Reportes</button>
            <button class="btn btn-sm m-1 btn-secondary"><i class="fa fa-file-pdf"></i> Reportes</button>
        </div>

    <?php
    }
    ?>
    <!-- MENU -->
    <input type="hidden" value="<?= $id_negocio_global ?>" id="id_negocio_global">
    <div class="row menumovil p-0 m-0 d-flex justify-content-start">
        <div class="columna">
            <div class="card text-center menu bg-secondary " role="button" onclick="cargarNegocio(<?= $_GET['id'] ?>)" data-bs-toggle="modal" data-bs-target="#modalNegocio">
                <div class="card-body" style="padding: 3px !important;">
                    <img class="w-50" src="../static/logos/<?= $_GET['id'] ?>.png" alt="">

                    <!-- <h6 class="mt-1 mb-1 ">Negocio</h1> -->
                </div>
            </div>
        </div>
        <?php if (in_array(3, $permisos)): ?>
            <div class="columna">
                <div class="card text-center menu btnproductos" role="button" onclick="listarProductos(<?= $_GET['id'] ?>)">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="fa fa-table"></i>
                                </div>
                            </div>
                        </div>
                        <h6 class="mt-1 mb-1">Productos</h1>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (in_array(4, $permisos)): ?>
            <div class="columna">
                <div class="card text-center menu btnclientes " role="button" onclick="listarClientes(<?= $_GET['id'] ?>)">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="fa fa-user" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <h6 class="mt-1 mb-1">Clientes</h1>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (in_array(5, $permisos)): ?>
            <div class="columna">
                <div class="card text-center menu btnPedidos " role="button" onclick="listarPedidos(<?= $_GET['id'] ?>)">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="fa fa-list"></i>
                                </div>
                            </div>
                        </div>
                        <h6 class="mt-1 mb-1">Pedidos</h1>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (in_array(6, $permisos)): ?>
            <div class="columna">
                <div class="card text-center menu btnVentas " role="button" onclick="listarVentas(<?= $_GET['id'] ?>)">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="fa fa-money" aria-hidden="true"></i>
                                </div>
                            </div>
                        </div>
                        <h6 class="mt-1 mb-1">Ventas</h1>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (in_array(7, $permisos)): ?>
            <div class="columna">
                <div class="card text-center menu btnEstadisticas " role="button" onclick="listarEstadisticas(<?= $_GET['id'] ?>)">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="fa fa-chart-line"></i>
                                </div>
                            </div>
                        </div>
                        <h6 class="mt-1 mb-1">Estadìsticas</h1>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if (in_array(8, $permisos)): ?>
            <div class="columna">
                <div class="card text-center menu btnApis " role="button" onclick="listarApis(<?= $_GET['id'] ?>)">
                    <div class="card-body">
                        <div class="row justify-content-center">
                            <div class="col-auto">
                                <div class="stat text-primary">
                                    <i class="fa fa-globe"></i>
                                </div>
                            </div>
                        </div>
                        <h6 class="mt-1 mb-1">APIs</h1>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>