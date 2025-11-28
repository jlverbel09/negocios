
<?php require_once '../db/conexion.php'; 
 session_start();
if(!empty($_SESSION['usuario'])){
	header('Location: index.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="Sistema de administracion de informacion de todos los negocios asociados">
	<meta name="author" content="GeorkingWeb">
	<meta name="keywords" content="web, business">

	<link rel="shortcut icon" href="img/icons/icono.png" />

	<!-- <link rel="canonical" href="https://demo-basic.adminkit.io/" /> -->

	<title>Georking Business</title>

	<link href="css/app.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="./css/style.css">
	<!-- <link rel="stylesheet" href="./css/style.dark.css"> -->
	<link rel="stylesheet" href="./css/login.css">
	<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />

</head>

<body>

	<div class="preloader flex-column justify-content-center align-items-center bg-principal" style="height: 0px;">
		<img class="animation__wobble" src="../../dist/assets/img/logo.png" alt="logo" height="60" width="60"
			style="display: none;">
	</div>
	<div class="fondos">
		<img src="../static/img/photos/login/4.jpg" alt="">
		<img src="../static/img/photos/login/1.jpg" alt="">
		<img src="../static/img/photos/login/2.avif" alt="">
		<img src="../static/img/photos/login/3.jpg" alt="">
	</div>


	<main class="d-flex w-100">
		<div class="container d-flex flex-column">
			<div class="row vh-100">
				<div class="col-sm-10 col-md-8 col-lg-6 col-xl-5 mx-auto d-table h-100">
					<div class="d-table-cell align-middle">


						<div class="card">
							<div class="card-body">

								<div class="text-center mt-4">
									<img class=" w-25 mb-1" src="./img/icons/icono.png" alt="">
									<h1 class="h2">Georking Business</h1>
									<p class="lead">
										Inicia sesión en tu cuenta para continuar
									</p>
								</div>
								<div class="m-sm-3">
									<form action="./index.php" method="get">
										<div class="mb-3">
											<label class="form-label">Correo Electrónico/ Usuario</label>
											<input class="form-control form-control-lg" type="email" name="email" id="user" placeholder="Ingresa tu correo o usuario" />
										</div>
										<div class="mb-3">
											<label class="form-label">Contraseña</label>
											<input class="form-control form-control-lg" type="password" name="password" id="password" placeholder="Ingresa tu contraseña" />
										</div>
										<div>
											<div class="form-check align-items-center">
												<input id="customControlInline" type="checkbox" class="form-check-input" value="remember-me" name="remember-me" checked>
												<label class="form-check-label text-small" for="customControlInline">Recordarme</label>
											</div>
										</div>
										<div class="d-grid gap-2 mt-3">
											<a onClick="ingresar()" class="btn btn-lg btn-primary">Iniciar Sesión</a>
										</div>
									</form>
								</div>
							</div>
						</div>
						<div class="text-center mb-3">
							Don't have an account? <a href="pages-sign-up.html">Sign up</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</main>
	<script src="js/login.js"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
	<script type="text/javascript" src="//cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script>
	<script>
		$('.fondos').slick({
			dots: true,
			infinite: true,
			speed: 500,
			fade: true,
			cssEase: 'linear',
			//autoplay: true,
			arrows: false,
			pauseOnHover: false
		});
	</script>
	<script src="js/app.js"></script>

</body>

</html>