<?php
include("../conexion.php");

$id = $_GET['id'];

$sql = "SELECT * FROM salas WHERE id=$id";
$resultado = $conexion->query($sql);
$fila = $resultado->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Editar Sala</title>

<link rel="stylesheet" href="../estilos.css">

<style>
body{
    font-family: Arial;
    background:#f4f4f4;
}

.contenedor{
    width: 400px;
    margin: 60px auto;
    background: white;
    padding: 25px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

h2{
    text-align:center;
    margin-bottom:20px;
}

input{
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 6px;
}

button{
    width: 100%;
    padding: 10px;
    background: #28a745;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
}

button:hover{
    background: #218838;
}

a{
    display:block;
    text-align:center;
    margin-top:15px;
    text-decoration:none;
    color:#333;
}
</style>

</head>
<body>

<div class="contenedor">

<h2>Editar Sala</h2>

<form action="actualizar_sala.php" method="POST">

<input type="hidden" name="id" value="<?php echo $fila['id']; ?>">

<label>Nombre</label>
<input type="text" name="nombre" value="<?php echo $fila['nombre']; ?>" required>

<label>Capacidad</label>
<input type="number" name="capacidad" value="<?php echo $fila['capacidad']; ?>" required>

<button type="submit">Actualizar Sala</button>

</form>

<a href="index.php">← Volver</a>

</div>

</body>
</html>
