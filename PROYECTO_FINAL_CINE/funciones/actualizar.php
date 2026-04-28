<?php
include("../conexion.php");

if(!isset($_GET['id'])){
    die("❌ No se recibió ID");
}

$id = $_GET['id'];

// 🔵 OBTENER DATOS ACTUALES
$sql = "SELECT * FROM funciones WHERE id=$id";
$resultado = $conexion->query($sql);

if($resultado->num_rows == 0){
    die("❌ Función no encontrada");
}

$fila = $resultado->fetch_assoc();

// 🔵 ACTUALIZAR
if(isset($_POST['actualizar'])){

    $pelicula_id = $_POST['pelicula_id'];
    $sala_id = $_POST['sala_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $precio = $_POST['precio'];

    // 🔴 EVITAR DUPLICADOS (EXCLUYENDO EL MISMO ID)
    $check = $conexion->query("
        SELECT * FROM funciones 
        WHERE pelicula_id='$pelicula_id'
        AND sala_id='$sala_id'
        AND fecha='$fecha'
        AND hora='$hora'
        AND id != $id
    ");

    if($check->num_rows > 0){
        echo "<script>alert('❌ Ya existe otra función con esos datos');</script>";
    } else {

        $update = "UPDATE funciones SET 
                    pelicula_id='$pelicula_id',
                    sala_id='$sala_id',
                    fecha='$fecha',
                    hora='$hora',
                    precio='$precio'
                   WHERE id=$id";

        $conexion->query($update);

        header("Location: index.php");
        exit;
    }
}

// 🔵 LISTAS
$peliculas = $conexion->query("SELECT * FROM peliculas");
$salas = $conexion->query("SELECT * FROM salas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Actualizar Función</title>

<!-- 🎨 MISMO ESTILO QUE TU SISTEMA -->
<link rel="stylesheet" href="../estilos.css">

<style>
body{
    font-family: Arial;
    background:#f4f4f4;
    padding:20px;
}

h1{
    text-align:center;
}

form{
    background:white;
    width:320px;
    margin:auto;
    padding:20px;
    border-radius:10px;
    box-shadow:0 0 10px rgba(0,0,0,0.1);
}

input, select{
    width:100%;
    padding:8px;
    margin-bottom:10px;
}

button{
    width:100%;
    padding:10px;
    background:black;
    color:white;
    border:none;
    cursor:pointer;
}

a{
    text-decoration:none;
    color:blue;
}
</style>

</head>
<body>

<h1>🎬 Actualizar Función</h1>

<a href="index.php">⬅ Volver</a>

<form method="POST">

<label>Película:</label>
<select name="pelicula_id" required>
<?php while($p = $peliculas->fetch_assoc()){ ?>
<option value="<?= $p['id'] ?>"
<?= ($p['id'] == $fila['pelicula_id']) ? 'selected' : '' ?>>
<?= $p['titulo'] ?>
</option>
<?php } ?>
</select>

<label>Sala:</label>
<select name="sala_id" required>
<?php while($s = $salas->fetch_assoc()){ ?>
<option value="<?= $s['id'] ?>"
<?= ($s['id'] == $fila['sala_id']) ? 'selected' : '' ?>>
<?= $s['nombre'] ?>
</option>
<?php } ?>
</select>

<label>Fecha:</label>
<input type="date" name="fecha" value="<?= $fila['fecha'] ?>" required>

<label>Hora:</label>
<input type="time" name="hora" value="<?= $fila['hora'] ?>" required>

<label>Precio:</label>
<input type="number" name="precio" value="<?= $fila['precio'] ?>" required>

<button type="submit" name="actualizar">Actualizar</button>

</form>

</body>
</html>
