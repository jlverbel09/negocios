<?php
require_once('../db/conexion.php');
include './modales.php';
/* GRAFICO */
$sql = "
WITH RECURSIVE numeros AS (
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
  count(e.id)as cantidad, 
  DATE_FORMAT(f.fecha, '%Y%m') as mes
FROM fechas f
LEFT JOIN usuario e ON f.fecha = e.created_at and e.id_negocio = " . $_GET['idnegocio'] . "
group by 2 order by 2 desc";

$res = $conexion->query($sql)->fetchAll();

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
foreach ($res as $r) {
    $i++;
    $cantidad = $r['cantidad'] . ',' . $cantidad;
    $meses = "'" . $mesExacto[$r['mes']] . "'," . $meses;
}
$cantidad = substr($cantidad, 0, -1);
$meses = substr($meses, 0, -1);

/* TOTAL CLIENTES */
$sql = "SELECT COUNT(id) as cantidadClientes FROM usuario WHERE id_negocio = " . $_GET['idnegocio'];
$res2 = $conexion->query($sql)->fetch();

/* TOTAL PEDIDOS PENDIENTES*/
$sql = "SELECT coalesce(sum(case when (p2.promocion*p.cantidad)<> 0 then (p2.promocion*p.cantidad) else (p2.precio*p.cantidad) end ),0) as total, COUNT(p.id) as cantidadPedidos FROM pedido p
inner join producto p2 on p2.id = p.id_producto
inner join estado_pedido ep  on ep.id = p.id_estado 
WHERE abrev <> 'VEN' AND p.id_negocio =  " . $_GET['idnegocio'];
$res4 = $conexion->query($sql)->fetch();

/* TOTAL VENTAS */
$sql = "SELECT coalesce(sum(case when (p2.promocion*p.cantidad)<> 0 then (p2.promocion*p.cantidad) else (p2.precio*p.cantidad) end),0)  as total, COUNT(p.id) as cantidadVentas FROM pedido p
inner join producto p2 on p2.id = p.id_producto
inner join estado_pedido ep  on ep.id = p.id_estado 
WHERE abrev = 'VEN' and p.id_negocio = " . $_GET['idnegocio'];
$res5 = $conexion->query($sql)->fetch();

/* INVERSION DEL MES */
$sql = "SELECT COALESCE(sum(valor),0) as valor_invertido from inversion i where id_negocio  = " . $_GET['idnegocio'] . " and DATE_FORMAT(fecha_reg, '%Y%m') = DATE_FORMAT(now(), '%Y%m')";
$res6 = $conexion->query($sql)->fetch();

/* GANANCIAS DEL MES */
$sql = "SELECT sum(case when (p2.promocion*p.cantidad)<> 0 then (p2.promocion*p.cantidad) else (p2.precio*p.cantidad) end) as vendido from pedido p
inner join producto p2 on p2.id = p.id_producto
where p.id_negocio = " . $_GET['idnegocio'] . " and 
p.fecha_venta is not null and DATE_FORMAT(p.fecha_venta, '%Y%m') = DATE_FORMAT(now(), '%Y%m')";
$res7 = $conexion->query($sql)->fetch();
$gananciasMes = $res7['vendido'] - $res6['valor_invertido'];


/* DIAS CORRIENDO */
$sql = "
select count(fecha) as dias, 
sum(case when fecha <= fecha2 then 1 end) as cantidad_dias, round(sum(case when fecha <= fecha2 then 1 end)/count(fecha)*100) as porcentaje
from (

WITH RECURSIVE numeros AS (
    SELECT 0 AS n
    UNION ALL
    SELECT n + 1
    FROM numeros
    WHERE n < DATEDIFF( LAST_DAY(now()), DATE_FORMAT(now(), '%Y%m%01')) -- Rango de días deseado
),
fechas AS (
    SELECT DATE_ADD(DATE_FORMAT(now(), '%Y%m%01'), INTERVAL n DAY) AS fecha
    FROM numeros
)
select fecha,DATE_FORMAT(now(), '%Y-%m-%d') as fecha2  from fechas
) j ";

$res3 = $conexion->query($sql)->fetch();
?>

<div class="row">
    <div class="col-12">
        <h5 class="card-title mb-3">Estadisticas</h5>
    </div>
    <div class="col-md-6   ">
        <div class="card flex-fill w-100">
            <div class="card-header">

                <h5 class="card-title mb-0">Suscripciones de Clientes 2025</h5>
            </div>
            <div class="card-body py-3">
                <div class="chart chart-sm">
                    <canvas id="chartjs-dashboard-line"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-12 col-lg-6   row m-0 p-0">
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Total Clientes</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="fa fa-user"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3"><?= $res2['cantidadClientes'] ?></h1>
                </div>
            </div>
        </div>


        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Pedidos Pendientes</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="fa fa-list"></i>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="mt-1 mb-3"><?= $res4['cantidadPedidos'] ?></h1>
                        <div class="mb-0 text-right">
                            <span class="text-warning">€ <?= number_format($res4['total'], 2, ',', '.') ?></span>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-4">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">Total Ventas</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="fa fa-money"></i>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <h1 class="mt-1 mb-3"><?= $res5['cantidadVentas'] ?></h1>
                        <div class="mb-0 text-right">
                            <span class="text-success">€ <?= number_format($res5['total'], 2, ',', '.') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">INVERSION DEL MES</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="fa fa-money"></i>
                            </div>
                        </div>
                    </div>
                    <h1 class="mt-1 mb-3">€ <?= number_format($res6['valor_invertido'], 2, ',', '.') ?></h1>
                </div>
            </div>
        </div>
        <div class="col-md-12 col-lg-6">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col mt-0">
                            <h5 class="card-title">GANANCIAS DEL MES</h5>
                        </div>

                        <div class="col-auto">
                            <div class="stat text-primary">
                                <i class="fa fa-money"></i>
                            </div>
                        </div>
                    </div>
                    <?php
                    if ($gananciasMes > 0) {
                        $color = ' text-success';
                    } else {
                        $color = ' text-danger';
                    }

                    ?>
                    <h1 class="mt-1 mb-3 <?= $color ?>">€ <?= number_format($gananciasMes, 2, ',', '.') ?></h1>
                </div>
            </div>
        </div>


    </div>


    <div class="col-12">
        <h5 class="card-title mb-0">Cierre de Mes</h5>
        <div class="progress">
            <div class="progress-bar " style="width: <?= $res3['porcentaje'] ?>%;" role="progressbar" aria-valuenow="10" aria-valuemin="0" aria-valuemax="100"><?= $res3['cantidad_dias'] ?> Dias</div>
        </div>
    </div>

    <script>
        var arregloMeses = [<?= $meses ?>]
        var cantidadSuscritos = [<?= $cantidad ?>]

        var ctx = document.getElementById("chartjs-dashboard-line").getContext("2d");
        var gradient = ctx.createLinearGradient(0, 0, 0, 225);
        gradient.addColorStop(0, "rgba(215, 227, 244, 1)");
        gradient.addColorStop(1, "#222e3c");
        // Line chart
        new Chart(document.getElementById("chartjs-dashboard-line"), {
            type: "bar",
            data: {
                labels: arregloMeses,
                datasets: [{
                    label: "Suscripciones",
                    fill: true,
                    backgroundColor: gradient,
                    borderColor: window.theme.primary,
                    data: cantidadSuscritos
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
                            stepSize: 2
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
    </script>