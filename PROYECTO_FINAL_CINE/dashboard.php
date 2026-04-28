<?php
session_start();

if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Panel Principal</title>
<link rel="stylesheet" href="estilos.css">
</head>
<body>

<h1>🎬 Panel Principal</h1>

<h2>Bienvenido <?php echo $_SESSION['usuario']; ?></h2>

<div style="max-width:500px; margin:auto;">

<a href="peliculas/index.php">
<button>🎥 Gestionar Películas</button>
</a>

<br><br>

<a href="salas/index.php">
<button>🏢 Gestionar Salas</button>
</a>

<br><br>

<a href="funciones/index.php">
<button>📅 Gestionar Funciones</button>
</a>

<br><br>

<a href="boletos/index.php">
<button>🎟️ Venta de Boletos</button>
</a>

<br><br>

<a href="reporte_ventas.php">
<button>📊 Reporte de Ventas</button>
</a>

<br><br>

<a href="logout.php">
<button>🚪 Cerrar Sesión</button>
</a>

</div>

</body>
</html>
