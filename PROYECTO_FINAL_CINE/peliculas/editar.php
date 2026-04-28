<?php
session_start();
include("../conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

if(!isset($_GET['id'])){
    die("❌ No se recibió ID");
}

$id = $_GET['id'];

$resultado = $conexion->query("SELECT * FROM peliculas WHERE id=$id");

if(!$resultado || $resultado->num_rows == 0){
    die("❌ Película no encontrada");
}

$fila = $resultado->fetch_assoc();

if(isset($_POST['actualizar'])){

    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $duracion = $_POST['duracion'];
    $clasificacion = $_POST['clasificacion'];

    $sql = "UPDATE peliculas SET
            titulo='$titulo',
            genero='$genero',
            duracion='$duracion',
            clasificacion='$clasificacion'
            WHERE id=$id";

    if($conexion->query($sql)){
        header("Location: index.php");
        exit();
    } else {
        die("❌ Error al actualizar: " . $conexion->error);
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Película</title>
<link rel="stylesheet" href="../estilos.css">
</head>
<body>

<h1>Editar Película</h1>

<form method="POST">

<input type="text" name="titulo" value="<?= $fila['titulo'] ?>" required>
<br><br>

<input type="text" name="genero" value="<?= $fila['genero'] ?>" required>
<br><br>

<input type="number" name="duracion" value="<?= $fila['duracion'] ?>" required>
<br><br>

<input type="text" name="clasificacion" value="<?= $fila['clasificacion'] ?>" required>
<br><br>

<button type="submit" name="actualizar">Actualizar</button>

</form>

<br>
<a href="index.php">Volver</a>

</body>
</html>
