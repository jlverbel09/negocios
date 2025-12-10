<?php
/* LOCAL */
/* $host = 'localhost';
$user = 'root';
$pass = '';
$db = 'negocios';
$port = 3306;
 */
$host = 'localhost';
$user = 'u295124209_gkbusiness';
$pass = 'Jlvd-7069';
$db = 'u295124209_gkbusiness';
$port = 3306;

try {
    $conexion = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
} catch (PDOException $e) {

    /* PRODUCCION */
    $host = '193.203.168.80';
    $user = 'u295124209_gkbusiness';
    $pass = 'Jlvd-7069';
    $db = 'u295124209_gkbusiness';
    $port = 3306;

    try {
        $conexion = new PDO("mysql:host=$host;port=$port;dbname=$db", $user, $pass);
    } catch (PDOException $e) {
        echo $e->getMessage();
        die();
    }
}
