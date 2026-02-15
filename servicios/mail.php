<?php
require_once '../db/conexion.php';
// 2. Recoger datos del GET
$nombre = isset($_GET['nombre']) ? $_GET['nombre'] : '';
$email  = isset($_GET['email'])  ? $_GET['email']  : '';
$plan   = isset($_GET['plan'])   ? $_GET['plan']   : '';

if (empty($nombre) || empty($email)) {
    die("Datos incompletos");
}

// 4. Guardar en la base de datos (Seguridad con Prepared Statements)
$stmt = $conexion->query("INSERT INTO solicitudes_web (nombre, email, plan) VALUES ('$nombre', '$email', '$plan')");

if ($stmt->execute()) {
    // 5. Si se guardó en DB, enviar el correo de aviso
    $destinatario = "jlverbel09@gmail.com";
    $asunto = "Nuevo Lead guardado: " . $nombre;
    $cuerpo = "Se ha registrado un nuevo contacto en la DB:\n\nNombre: $nombre\nEmail: $email\nPlan: $plan";
    $headers = "From: sistema@georkingweb.com";

    mail($destinatario, $asunto, $cuerpo, $headers);

    echo "Exito: Registro guardado y correo enviado";
} else {
    header('HTTP/1.1 500 Internal Server Error');
    echo "Error al guardar en base de datos";
}
