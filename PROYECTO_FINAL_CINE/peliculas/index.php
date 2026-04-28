<?php
session_start();
include("../conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
}

if(isset($_POST['guardar'])){

    $titulo = $_POST['titulo'];
    $genero = $_POST['genero'];
    $duracion = $_POST['duracion'];
    $clasificacion = $_POST['clasificacion'];

    $sql = "INSERT INTO peliculas(titulo,genero,duracion,clasificacion)
            VALUES('$titulo','$genero','$duracion','$clasificacion')";

    $conexion->query($sql);
}

if(isset($_GET['eliminar'])){
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM peliculas WHERE id=$id");
}

$resultado = $conexion->query("SELECT * FROM peliculas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Películas</title>
<link rel="stylesheet" href="../estilos.css">
</head>
<body>

<h1>Gestión de Películas</h1>

<a href="../dashboard.php">Volver</a>

<h2>Agregar Película</h2>

<form method="POST" onsubmit="return validarPelicula()">

<input type="text" name="titulo" id="titulo" placeholder="Título" required>

<br><br>

<label>Género:</label><br>

<select name="genero" id="genero" required>
    <option value="">Selecciona</option>
    <option value="Acción">Acción</option>
    <option value="Comedia">Comedia</option>
    <option value="Terror">Terror</option>
    <option value="Drama">Drama</option>
    <option value="Romance">Romance</option>
    <option value="Animación">Animación</option>
</select>

<br><br>

<input type="number" name="duracion" id="duracion" placeholder="Duración en minutos" required>

<br><br>

<label>Clasificación:</label><br>

<select name="clasificacion" id="clasificacion" required>
    <option value="">Selecciona</option>
    <option value="AA">AA</option>
    <option value="A">A</option>
    <option value="B">B</option>
    <option value="B15">B15</option>
    <option value="C">C</option>
</select>

<br><br>

<button type="submit" name="guardar">Guardar</button>

</form>

<h2>Lista de Películas</h2>

<table>

<tr>
<th>ID</th>
<th>Título</th>
<th>Género</th>
<th>Duración</th>
<th>Clasificación</th>
<th>Acción</th>
</tr>

<?php while($fila = $resultado->fetch_assoc()){ ?>

<tr>
<td><?php echo $fila['id']; ?></td>
<td><?php echo $fila['titulo']; ?></td>
<td><?php echo $fila['genero']; ?></td>
<td><?php echo $fila['duracion']; ?> min</td>
<td><?php echo $fila['clasificacion']; ?></td>
<td>
<a href="editar.php?id=<?php echo $fila['id']; ?>">Editar</a> |
<a href="?eliminar=<?php echo $fila['id']; ?>">Eliminar</a>
</td>
</tr>

<?php } ?>

</table>

<script>
function validarPelicula(){

let titulo = document.getElementById("titulo").value;
let genero = document.getElementById("genero").value;

let regexTexto = /^[A-Za-zÁÉÍÓÚáéíóúñÑ0-9\s]{3,50}$/;

if(!regexTexto.test(titulo)){
    alert("Título inválido");
    return false;
}

if(genero == ""){
    alert("Selecciona un género");
    return false;
}

return true;
}
</script>

</body>
</html>
