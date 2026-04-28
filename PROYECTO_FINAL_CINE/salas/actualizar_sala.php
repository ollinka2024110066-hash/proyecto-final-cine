<?php
include("../conexion.php");

$id = $_POST['id'];
$nombre = $_POST['nombre'];
$capacidad = $_POST['capacidad'];

$sql = "UPDATE salas SET 
        nombre='$nombre',
        capacidad='$capacidad'
        WHERE id=$id";

if($conexion->query($sql)){
    header("Location: index.php");
}else{
    echo "Error al actualizar sala";
}
?>
