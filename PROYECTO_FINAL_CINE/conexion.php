<?php
$conexion = new mysqli("localhost", "root", "", "cine_db");

if ($conexion->connect_error) {
    die("Error de conexión");
}
?>
