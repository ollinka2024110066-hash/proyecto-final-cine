<?php
include("../conexion.php");

if(!isset($_GET['id'])){
    die("No se recibió ID");
}

$id = $_GET['id'];

$sql = "DELETE FROM funciones WHERE id=$id";

if($conexion->query($sql)){
    header("Location: index.php");
    exit();
} else {
    die("Error al eliminar: " . $conexion->error);
}
?>
