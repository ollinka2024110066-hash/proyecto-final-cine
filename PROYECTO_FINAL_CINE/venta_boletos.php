<?php
session_start();
include("../conexion.php");

$sql = "SELECT * FROM funciones";
$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Venta de Boletos</title>
<link rel="stylesheet" href="../estilos.css">
</head>
<body>

<h2>Selecciona una función</h2>

<?php while($row = mysqli_fetch_assoc($resultado)) { ?>

<div>
    <p>Película: <?php echo $row['pelicula']; ?></p>
    <p>Sala: <?php echo $row['sala']; ?></p>
    <p>Fecha: <?php echo $row['fecha']; ?></p>
    <p>Hora: <?php echo $row['hora']; ?></p>

    <a href="elegir_asientos.php?id=<?php echo $row['id']; ?>">
        Seleccionar
    </a>

    <hr>
</div>

<?php } ?>

<a href="../dashboard.php">Volver</a>

</body>
</html>
