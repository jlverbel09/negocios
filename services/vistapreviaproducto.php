
<?php require_once('../db/conexion.php');
$query = "select * from producto where id = ".$_GET['idproducto'];
$r = $conexion->query($query)->fetch();
//
if(!empty($r['img_url'])){
    $imagen = $r['img_url'];
}else{
$imagen = "https://picsum.photos/200/200?random=".rand(1,100);
$imagen = 'https://tempfile.aiquickdraw.com/m/1748023530_d3cb4955824d447ba637cedbbd2837ea.png';
}
?>

<div class="card justify-content-center d-flex align-items-center" >
    <h5>Vista Previa</h5>
    <img class="card-img-top w-75" src="<?=$imagen?>" alt="Unsplash">
    <div class="card-header">
        <h5 class="card-title mb-0"><?=$r['nombre']?></h5>
    </div>
    <div class="card-body">
        <p class="card-text"><?=$r['descripcion']?></p>
        <a href="#" class="btn btn-primary">Seleccionar</a>
    </div>
</div>