<?php
session_start();
include("../conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit;
}

$compra = $_GET['compra'] ?? null;
$funcion = isset($_GET['funcion']) ? intval($_GET['funcion']) : null;

if(!$compra && !$funcion){
    die("No se encontró información del ticket");
}

$asientos = [];
$total = 0;
$datos = null;

/* =========================
   NUEVO SISTEMA POR COMPRA
========================= */
if($compra){

    $sql = $conexion->query("
    SELECT boletos.*,
    funciones.hora,
    funciones.fecha,
    peliculas.titulo,
    salas.nombre AS sala

    FROM boletos
    INNER JOIN funciones ON boletos.funcion_id = funciones.id
    INNER JOIN peliculas ON funciones.pelicula_id = peliculas.id
    INNER JOIN salas ON funciones.sala_id = salas.id

    WHERE boletos.id_compra = '$compra'
    ");

    if(!$sql){
        die("Error en ticket SQL: " . $conexion->error);
    }

    if($sql->num_rows == 0){
        die("No hay boletos para esta compra");
    }

    while($fila = $sql->fetch_assoc()){
        $asientos[] = $fila['asiento'];
        $total += $fila['precio'];

        if(!$datos){
            $datos = $fila;
        }
    }

}
/* =========================
   SISTEMA VIEJO POR FUNCIÓN
========================= */
else{

    $sql = $conexion->query("
    SELECT funciones.*,
    peliculas.titulo,
    salas.nombre AS sala

    FROM funciones
    INNER JOIN peliculas ON funciones.pelicula_id = peliculas.id
    INNER JOIN salas ON funciones.sala_id = salas.id

    WHERE funciones.id = '$funcion'
    ");

    if(!$sql){
        die("Error en ticket SQL: " . $conexion->error);
    }

    $datos = $sql->fetch_assoc();

    $res = $conexion->query("
    SELECT asiento FROM boletos
    WHERE funcion_id = $funcion
    ORDER BY asiento ASC
    ");

    while($fila = $res->fetch_assoc()){
        $asientos[] = $fila['asiento'];
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ticket</title>

<style>
body{
    font-family:Arial;
    background:#f2f2f2;
}

.ticket{
    width:350px;
    margin:50px auto;
    background:white;
    padding:20px;
    border-radius:15px;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
    text-align:center;
}

h1{
    color:#2f80ed;
}

.info{
    margin:10px 0;
    font-size:16px;
}

.asientos{
    margin-top:10px;
    font-weight:bold;
    color:#333;
}

.total{
    margin-top:10px;
    font-size:18px;
    color:green;
    font-weight:bold;
}

.btn{
    margin-top:20px;
    padding:10px 15px;
    background:#2f80ed;
    color:white;
    border:none;
    border-radius:10px;
    cursor:pointer;
}

.btn:hover{
    background:#1c6dd0;
}
</style>

</head>
<body>

<div class="ticket">

<h1>🎟️ Ticket de Cine</h1>

<div class="info">
<strong>Película:</strong><br>
<?php echo $datos['titulo']; ?>
</div>

<div class="info">
<strong>Sala:</strong><br>
<?php echo $datos['sala']; ?>
</div>

<div class="info">
<strong>Hora:</strong><br>
<?php echo $datos['hora']; ?>
</div>

<div class="asientos">
<strong>Asientos:</strong><br>
<?php echo implode(", ", $asientos); ?>
</div>

<div class="info">
<strong>Fecha:</strong><br>
<?php echo $datos['fecha']; ?>
</div>

<?php if($total > 0){ ?>
<div class="total">
💰 Total: $<?php echo $total; ?>
</div>
<?php } ?>

<button class="btn" onclick="window.print()">🖨️ Imprimir Ticket</button>

<br><br>

<a href="index.php">
<button class="btn">Volver</button>
</a>

</div>

</body>
</html>
