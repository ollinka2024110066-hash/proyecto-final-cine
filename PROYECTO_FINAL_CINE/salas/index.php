<?php
session_start();
include("../conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit();
}

/* GUARDAR SALA */
if(isset($_POST['guardar'])){

    $nombre = $_POST['nombre'];
    $capacidad = $_POST['capacidad'];

    $sql = "INSERT INTO salas(nombre,capacidad)
            VALUES('$nombre','$capacidad')";

    $conexion->query($sql);
}

/* ELIMINAR SALA */
if(isset($_GET['eliminar'])){
    $id = $_GET['eliminar'];
    $conexion->query("DELETE FROM salas WHERE id=$id");
}

/* CONSULTA */
$resultado = $conexion->query("SELECT * FROM salas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Salas</title>
<link rel="stylesheet" href="../estilos.css">
</head>
<body>

<h1>Gestión de Salas</h1>

<a href="../dashboard.php">Volver</a>

<h2>Agregar Sala</h2>

<form method="POST" onsubmit="return validarSala()">

<input type="text" name="nombre" id="nombre" placeholder="Nombre de sala" required>

<input type="number" name="capacidad" id="capacidad" placeholder="Capacidad" required>

<button type="submit" name="guardar">Guardar</button>

</form>

<h2>Lista de Salas</h2>

<table border="1">

<tr>
<th>ID</th>
<th>Nombre</th>
<th>Capacidad</th>
<th>Acción</th>
</tr>

<?php while($fila = $resultado->fetch_assoc()){ ?>

<tr>
<td><?php echo $fila['id']; ?></td>
<td><?php echo $fila['nombre']; ?></td>
<td><?php echo $fila['capacidad']; ?></td>
<td>

   <!-- EDITAR -->
   <a href="editar_sala.php?id=<?php echo $fila['id']; ?>">
      Editar
   </a>

   |

   <!-- ELIMINAR -->
   <a href="index.php?eliminar=<?php echo $fila['id']; ?>" 
      onclick="return confirm('¿Seguro que deseas eliminar esta sala?')">
      Eliminar
   </a>

</td>
</tr>

<?php } ?>

</table>

<script>
function validarSala(){

let nombre = document.getElementById("nombre").value;
let capacidad = document.getElementById("capacidad").value;

let regexNombre = /^[A-Za-z0-9\s]{1,20}$/;

if(!regexNombre.test(nombre)){
    alert("Nombre inválido");
    return false;
}

if(capacidad <= 0 || capacidad > 500){
    alert("Capacidad inválida");
    return false;
}

return true;
}
</script>

</body>
</html>
