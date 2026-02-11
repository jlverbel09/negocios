<script>
    cargarInversion()
</script>
<?php
session_start();
require_once('../db/conexion.php');
require_once '../static/layout/permisos.php';
if (isset($_GET['id'])) {
    $id_negocio_global = $_GET['id'];
    $tipo_rolGlobal = $_SESSION['usuario']['id_rol'];
    /* HISTORICO */
} else {
    $id_negocio_global = 0;
    $tipo_rolGlobal = 0;
}
?>
<input type="hidden" id="id_negocio_global" value="<?= $_GET['id'] ?>">
<div class="row">
    <!--  <div class="col-md-12 col-lg-3 align-items-center d-flex">
        <h3 class="m-0 mb-1"><?= ucwords($_GET['negocio']) ?> </h3>
    </div> -->

    <!-- MENU -->
    <input type="hidden" value="<?= $id_negocio_global ?>" id="id_negocio_global">
    <input type="hidden" value="<?= $tipo_rolGlobal ?>" id="tipo_rol_global">
    <div class="menu-wrapper position-relative">
        <button class="menu-arrow menu-arrow-left" id="arrowLeft" onclick="scrollMenuLeft()" style="display:none;">
            <i class="fa fa-chevron-left"></i>
        </button>
        <div class="row menumovil p-0 m-0 d-flex justify-content-start" id="menuScroll">
            <div class="columna">
                <div class="card text-center menu bg-secondary " role="button" onclick="cargarNegocio(<?= $_GET['id'] ?>)" data-bs-toggle="modal" data-bs-target="#modalNegocio">
                    <div class="card-body perfil">
                        <img class="w-50" src="../static/logos/<?= $_GET['id'] ?>.png" alt="">

                        <!-- <h6 class="mt-1 mb-1 ">Negocio</h1> -->
                    </div>
                </div>
            </div>

            

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
                            <h6 class="mt-1 mb-1">Estadísticas</h1>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (in_array(12, $permisos)): ?>
                <div class="columna">
                    <div class="card text-center menu btnMesas " role="button" onclick="listarMesas(<?= $_GET['id'] ?>)">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="bi bi-table"></i>
                                    </div>
                                </div>
                            </div>
                            <h6 class="mt-1 mb-1">Mesas</h1>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
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
            <?php if (in_array(11, $permisos)): ?>
                <div class="columna">
                    <div class="card text-center menu btnAnuncios " role="button" onclick="listarAnuncios(<?= $_GET['id'] ?>)">
                        <div class="card-body">
                            <div class="row justify-content-center">
                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="fa fa-bullhorn"></i>
                                    </div>
                                </div>
                            </div>
                            <h6 class="mt-1 mb-1">Anuncios</h1>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <button class="menu-arrow menu-arrow-right" id="arrowRight" onclick="scrollMenuRight()">
            <i class="fa fa-chevron-right"></i>
        </button>
    </div>
</div>