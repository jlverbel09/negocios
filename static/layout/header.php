<?php

require_once '../db/conexion.php';
session_start();
if (empty($_SESSION['usuario'])) {
	header('Location: login.php');
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
	<link rel="stylesheet" href="./css/style.dark.css">
	<link rel="stylesheet" href="./css/style_responsive.css">

	<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>

<body>
	<div class="wrapper">
		<?php include './layout/nav.php' ?>
		<main class="content">