<?php
session_start();
include("../conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
}

$funciones = $conexion->query("
SELECT funciones.id,
peliculas.titulo,
salas.nombre,
funciones.fecha,
funciones.hora

FROM funciones

INNER JOIN peliculas
ON funciones.pelicula_id = peliculas.id

INNER JOIN salas
ON funciones.sala_id = salas.id
");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Venta de Boletos</title>
<link rel="stylesheet" href="../estilos.css">
</head>
<body>

<div class="container">

<h1>🎟️ Venta de Boletos</h1>

<a href="../dashboard.php">Volver</a>

<h2>Selecciona una función</h2>

<?php while($f = $funciones->fetch_assoc()){ ?>

<div style="border:1px solid #ccc; padding:15px; margin:15px; border-radius:10px;">

<p><strong>Película:</strong> <?php echo $f['titulo']; ?></p>
<p><strong>Sala:</strong> <?php echo $f['nombre']; ?></p>
<p><strong>Fecha:</strong> <?php echo $f['fecha']; ?></p>
<p><strong>Hora:</strong> <?php echo $f['hora']; ?></p>

<a href="elegir_asientos.php?id=<?php echo $f['id']; ?>">
<button>Seleccionar</button>
</a>

</div>

<?php } ?>

</div>

</body>
</html>

