<?php
session_start();
include("conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
}

/* total boletos */
$res1 = mysqli_query($conexion,
"SELECT COUNT(*) AS total FROM boletos");
$tb = mysqli_fetch_assoc($res1);

/* ingresos */
$res2 = mysqli_query($conexion,
"SELECT SUM(funciones.precio) AS total
FROM boletos
INNER JOIN funciones
ON boletos.funcion_id = funciones.id");

$ti = mysqli_fetch_assoc($res2);

/* detalle ventas */
$sql = "SELECT boletos.id,
               peliculas.titulo,
               salas.nombre,
               funciones.hora,
               funciones.precio,
               boletos.asiento,
               boletos.fecha_compra

FROM boletos

INNER JOIN funciones
ON boletos.funcion_id = funciones.id

INNER JOIN peliculas
ON funciones.pelicula_id = peliculas.id

INNER JOIN salas
ON funciones.sala_id = salas.id

ORDER BY boletos.id DESC";

$resultado = mysqli_query($conexion, $sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Reporte Ventas</title>
<link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="container">

<h1>📊 Reporte de Ventas</h1>

<a href="dashboard.php">Volver</a>

<p><strong>Total Boletos:</strong>
<?php echo $tb['total']; ?></p>

<p><strong>Total Ingresos:</strong>
$<?php echo number_format($ti['total'] ?? 0,2); ?></p>

<table>

<tr>
<th>ID</th>
<th>Película</th>
<th>Sala</th>
<th>Hora</th>
<th>Asiento</th>
<th>Precio</th>
<th>Fecha</th>
</tr>

<?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

<tr>
<td><?php echo $fila['id']; ?></td>
<td><?php echo $fila['titulo']; ?></td>
<td><?php echo $fila['nombre']; ?></td>
<td><?php echo $fila['hora']; ?></td>
<td><?php echo $fila['asiento']; ?></td>
<td>$<?php echo $fila['precio']; ?></td>
<td><?php echo $fila['fecha_compra']; ?></td>
</tr>

<?php } ?>

</table>

</div>

</body>
</html>
