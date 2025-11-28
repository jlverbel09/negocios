<?php
require '../db/conexion.php';
/* CANTIDAD DE NEGOCIOS */
$sql = "SELECT coalesce(count(id),0) as cantidadNegocios from negocio n where estado = 'A'";
$res1 = $conexion->query($sql)->fetch();

/* TOTAL DE GANANCIAS DE TODOS LOS NEGOCIOS */
$sql = "SELECT coalesce(sum(case when (p2.promocion*p.cantidad)<> 0 then (p2.promocion*p.cantidad) else (p2.precio*p.cantidad) end),0) as ganancia from pedido p
inner join producto p2 on p2.id  = p.id_producto
inner join negocio n on n.id = p.id_negocio and n.estado = 'A'
inner join estado_pedido ep on ep.id =p.id_estado
where ep.abrev  = 'VEN'";
$res2 = $conexion->query($sql)->fetch();

/* TOTAL GENERAL DE CLIENTES*/
$sql = "SELECT coalesce(count(u.id),0) as cantidadClientes  from usuario u
inner join negocio n on n.id = u.id_negocio and n.estado= 'A'
inner join rol r  on r.id = u.id_rol
where r.abrev  = 'CLTE'";
$res3 = $conexion->query($sql)->fetch();

/* GANANCIAS POR NEGOCIO */
$sql = "SELECT n.nombre as negocio,  sum(case when (p2.promocion*p.cantidad)<> 0 then (p2.promocion*p.cantidad) else (p2.precio*p.cantidad) end) as ganancia from pedido p
inner join producto p2 on p2.id  = p.id_producto
inner join negocio n on n.id = p.id_negocio and n.estado = 'A'
inner join estado_pedido ep on ep.id =p.id_estado
where ep.abrev  = 'VEN'
group by 1 ";
$res4 = $conexion->query($sql)->fetchAll();;

$listaNegocios = '';
$listaGanancias = '';

foreach ($res4 as $r) {
    $listaNegocios .= '"' . $r['negocio'] . '",';
    $listaGanancias .= $r['ganancia'] . ',';
}

$listaNegocios = substr($listaNegocios, 0, -1);
$listaGanancias = substr($listaGanancias, 0, -1);

/* GANANCIAS POR MES */

$sql = "WITH RECURSIVE numeros AS (
    SELECT 0 AS n
    UNION ALL
    SELECT n + 1
    FROM numeros
    WHERE n < DATEDIFF(now(), '2025-01-01') -- Rango de días deseado
),
fechas AS (
    SELECT DATE_ADD('2025-01-01', INTERVAL n DAY) AS fecha
    FROM numeros
)
SELECT
  sum(precio) as cantidad, 
  DATE_FORMAT(pe.fecha_venta, '%Y%m') as mes
FROM fechas f
inner join pedido pe on  pe.fecha_venta = f.fecha
inner join negocio n on n.id = pe.id_negocio and n.estado = 'A'
inner join producto p on p.id = pe.id_producto
where fecha_venta  is not null
group by 2 order by 2 desc";

$res5 = $conexion->query($sql)->fetchAll();

$mesExacto = [
    202501 => 'ENERO',
    202502 => 'FEBRERO',
    202503 => 'MARZO',
    202504 => 'ABRIL',
    202505 => 'MAYO',
    202506 => 'JUNIO',
    202507 => 'JULIO',
    202508 => 'AGOSTO',
    202509 => 'SEPTIEMBRE',
    202510 => 'OCTUBRE',
    202511 => 'NOVIEMBRE',
    202512 => 'DICIEMBRE',
];
$cantidad = '';
$meses = '';
$i = 0;
foreach ($res5 as $r) {
    $i++;
    $cantidad = $r['cantidad'] . ',' . $cantidad;
    $meses = "'" . $mesExacto[$r['mes']] . "'," . $meses;
}
$cantidad = substr($cantidad, 0, -1);
$meses = substr($meses, 0, -1);
?>
<h1 class="h3 mb-3"><strong>Dashboard</strong> </h1>

<div class="row">
    <div class="col-xl-6    d-flex">
        <div class="w-100">
            <div class="row">


                <div class="col-sm-6">
                    <!-- NEGOCIOS -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Negocios</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="fa fa-store"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-0"><?= number_format($res1['cantidadNegocios'], 0, ',', '.') ?></h1>
                        </div>
                    </div>

                    <!-- GANANCIAS -->
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col mt-0">
                                    <h5 class="card-title">Ganancias</h5>
                                </div>

                                <div class="col-auto">
                                    <div class="stat text-primary">
                                        <i class="fa fa-money" data-feather="users"></i>
                                    </div>
                                </div>
                            </div>
                            <h1 class="mt-1 mb-0">€<?= number_format($res2['ganancia'], 2, ',', '.') ?></h1>
                        </div>
                    </div>

                    <!-- CLIENTES -->
                    <div class="col-sm-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col mt-0">
                                        <h5 class="card-title">Clientes</h5>
                                    </div>
                                    <div class="col-auto">
                                        <div class="stat text-primary">
                                            <i class="fa fa-users"></i>
                                        </div>
                                    </div>
                                </div>
                                <h1 class="mt-1 mb-0"><?= number_format($res3['cantidadClientes'], 0, ',', '.') ?></h1>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- GANANCIAS POR NEGOCIO -->
                <div class="col-lg-6 col-md-12 d-flex order-2 order-xxl-3 row p-0 m-0">
                    <div class="col-sm-12">
                        <div class="card flex-fill w-100">
                            <div class="card-header">
                                <h5 class="card-title mb-0">Ganancias por negocio</h5>
                            </div>
                            <div class="card-body d-flex">
                                <div class="align-self-center w-100">
                                    <div class="py-3">
                                        <div class="chart chart-xs">
                                            <canvas id="chartjs-dashboard-pie"></canvas>
                                        </div>
                                    </div>

                                    <table class="table mb-0">

                                        <tbody>
                                            <?php
                                            foreach ($res4 as $r4) {
                                            ?>
                                                <tr>
                                                    <td><?= ucwords($r4['negocio']) ?></td>
                                                    <td class="text-end">€&nbsp;<?= number_format($r4['ganancia'], 2, ',', '.') ?></td>
                                                </tr>
                                            <?php
                                            }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- CALENDARIO -->
                <div class="col-6 d-none">
                    <div class="card flex-fill">
                        <div class="card-header">

                            <h5 class="card-title mb-0">Calendario</h5>
                        </div>
                        <div class="card-body d-flex">
                            <div class="align-self-center w-100">
                                <div class="chart">
                                    <div id="datetimepicker-dashboard"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- GANANCIAS POR MES -->
    <div class="col-xl-6">
        <div class="card flex-fill w-100">
            <div class="card-header">
                <h5 class="card-title mb-0">Ganancias x Mes</h5>
            </div>
            <div class="card-body py-3">
                <div class="chart chart-xl">
                    <canvas id="chartjs-dashboard-line"></canvas>
                </div>
            </div>
        </div>

        <!-- TABLA -->
        <div class="col-12  d-flex d-none">
            <div class="card flex-fill">
                <div class="card-header">

                    <h5 class="card-title mb-0">Latest Projects</h5>
                </div>
                <table class="table table-hover my-0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th class="d-none d-xl-table-cell">Start Date</th>
                            <th class="d-none d-xl-table-cell">End Date</th>
                            <th>Status</th>
                            <th class="d-none d-md-table-cell">Assignee</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Project Apollo</td>
                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                            <td><span class="badge bg-success">Done</span></td>
                            <td class="d-none d-md-table-cell">Vanessa Tucker</td>
                        </tr>
                        <tr>
                            <td>Project Fireball</td>
                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                            <td><span class="badge bg-danger">Cancelled</span></td>
                            <td class="d-none d-md-table-cell">William Harris</td>
                        </tr>
                        <tr>
                            <td>Project Hades</td>
                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                            <td><span class="badge bg-success">Done</span></td>
                            <td class="d-none d-md-table-cell">Sharon Lessman</td>
                        </tr>
                        <tr>
                            <td>Project Nitro</td>
                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                            <td><span class="badge bg-warning">In progress</span></td>
                            <td class="d-none d-md-table-cell">Vanessa Tucker</td>
                        </tr>
                        <tr>
                            <td>Project Phoenix</td>
                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                            <td><span class="badge bg-success">Done</span></td>
                            <td class="d-none d-md-table-cell">William Harris</td>
                        </tr>
                        <tr>
                            <td>Project X</td>
                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                            <td><span class="badge bg-success">Done</span></td>
                            <td class="d-none d-md-table-cell">Sharon Lessman</td>
                        </tr>
                        <tr>
                            <td>Project Romeo</td>
                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                            <td><span class="badge bg-success">Done</span></td>
                            <td class="d-none d-md-table-cell">Christina Mason</td>
                        </tr>
                        <tr>
                            <td>Project Wombat</td>
                            <td class="d-none d-xl-table-cell">01/01/2023</td>
                            <td class="d-none d-xl-table-cell">31/06/2023</td>
                            <td><span class="badge bg-warning">In progress</span></td>
                            <td class="d-none d-md-table-cell">William Harris</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<!-- INSERVIBLES -->

<div class="row d-none">

    <div class="col-12 col-md-12 col-xxl-6 d-flex order-3 order-xxl-2">
        <div class="card flex-fill w-100">
            <div class="card-header">

                <h5 class="card-title mb-0">Real-Time</h5>
            </div>
            <div class="card-body px-4">
                <div id="world_map" style="height:350px;"></div>
            </div>
        </div>
    </div>

</div>

<div class="row d-none">

    <div class="col-12 col-lg-4 col-xxl-3 d-flex">
        <div class="card flex-fill w-100">
            <div class="card-header">

                <h5 class="card-title mb-0">Monthly Sales</h5>
            </div>
            <div class="card-body d-flex w-100">
                <div class="align-self-center chart chart-lg">
                    <canvas id="chartjs-dashboard-bar"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 
<script src="./js/dashboard.js"></script> -->
<script>
    $(document).ready(function() {
        /* ganancias por mes */

        var arregloMeses = [<?= $meses ?>]
        var cantidadGanancias = [<?= $cantidad ?>]

        var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradient.addColorStop(1, "rgba(215, 227, 244, 0)");
        // Line chart
        new Chart(document.getElementById("chartjs-dashboard-line"), {
            type: "line",
            data: {
                labels: arregloMeses,
                datasets: [{
                    label: "Ganancia de (€)",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: window.theme.primary,
                    data: cantidadGanancias
                }]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                tooltips: {
                    intersect: false
                },
                hover: {
                    intersect: true
                },
                plugins: {
                    filler: {
                        propagate: false
                    }
                },
                scales: {
                    xAxes: [{
                        reverse: true,
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            stepSize: 30
                        },
                        display: true,
                        borderDash: [3, 3],
                        gridLines: {
                            color: "rgba(0,0,0,0.0)"
                        }
                    }]
                }
            }
        });





        // Pie chart
        new Chart(document.getElementById("chartjs-dashboard-pie"), {
            type: "pie",
            data: {
                labels: [<?= $listaNegocios ?>],
                datasets: [{
                    data: [<?= $listaGanancias ?>],
                    backgroundColor: [
                        window.theme.primary,
                        window.theme.warning,
                        window.theme.danger
                    ],
                    borderWidth: 5
                }]
            },
            options: {
                responsive: !window.MSInputMethodContext,
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                cutoutPercentage: 75
            }
        });


        var date = new Date(Date.now() - 5 * 24 * 60 * 60 * 1000);
        var defaultDate = date.getUTCFullYear() + "-" + (date.getUTCMonth() + 1) + "-" + date.getUTCDate();
        document.getElementById("datetimepicker-dashboard").flatpickr({
            inline: true,
            prevArrow: "<span title=\"Previous month\">&laquo;</span>",
            nextArrow: "<span title=\"Next month\">&raquo;</span>",
            defaultDate: defaultDate
        });
    })
</script>