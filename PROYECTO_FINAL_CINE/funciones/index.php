<?php
session_start();
include("../conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit;
}

/* =========================
   GUARDAR FUNCION
========================= */
if(isset($_POST['guardar'])){

    $pelicula_id = $_POST['pelicula_id'];
    $sala_id = $_POST['sala_id'];
    $fecha = $_POST['fecha'];
    $hora = $_POST['hora'];
    $precio = $_POST['precio'];

    // 🔴 VALIDAR DUPLICADOS
    $check = $conexion->query("
        SELECT * FROM funciones 
        WHERE pelicula_id='$pelicula_id' 
        AND sala_id='$sala_id' 
        AND fecha='$fecha' 
        AND hora='$hora'
    ");

    if($check->num_rows > 0){
        echo "<script>alert('❌ Ya existe una función en ese horario');</script>";
    } else {

        $sql = "INSERT INTO funciones(pelicula_id, sala_id, fecha, hora, precio)
                VALUES('$pelicula_id','$sala_id','$fecha','$hora','$precio')";

        $conexion->query($sql);

        // 🟢 REDIRECCIÓN
        header("Location: index.php");
        exit;
    }
}

/* =========================
   ELIMINAR FUNCION
========================= */
if(isset($_GET['eliminar'])){
    $id = $_GET['eliminar'];

    $conexion->query("DELETE FROM funciones WHERE id=$id");

    // 🟢 REDIRECCIÓN
    header("Location: index.php");
    exit;
}

/* =========================
   CONSULTA LISTADO
========================= */
$resultado = $conexion->query("
    SELECT 
        funciones.id,
        peliculas.titulo AS pelicula,
        salas.nombre AS sala,
        funciones.fecha,
        funciones.hora,
        funciones.precio
    FROM funciones
    INNER JOIN peliculas ON funciones.pelicula_id = peliculas.id
    INNER JOIN salas ON funciones.sala_id = salas.id
");

$peliculas = $conexion->query("SELECT * FROM peliculas");
$salas = $conexion->query("SELECT * FROM salas");
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Funciones</title>
<link rel="stylesheet" href="../estilos.css">
</head>
<body>

<h1>Gestión de Funciones</h1>

<a href="../dashboard.php">Volver</a>

<!-- ➕ FORMULARIO -->
<h2>Agregar Función</h2>

<form method="POST">

<label>Película:</label><br>
<select name="pelicula_id" required>
    <option value="">Selecciona</option>
    <?php while($p = $peliculas->fetch_assoc()){ ?>
        <option value="<?= $p['id'] ?>"><?= $p['titulo'] ?></option>
    <?php } ?>
</select>

<br><br>

<label>Sala:</label><br>
<select name="sala_id" required>
    <option value="">Selecciona</option>
    <?php while($s = $salas->fetch_assoc()){ ?>
        <option value="<?= $s['id'] ?>"><?= $s['nombre'] ?></option>
    <?php } ?>
</select>

<br><br>

<input type="date" name="fecha" required>
<br><br>

<input type="time" name="hora" required>
<br><br>

<input type="number" name="precio" placeholder="Precio" step="0.01" required>

<br><br>

<button type="submit" name="guardar">Guardar</button>

</form>

<!-- 📋 TABLA -->
<h2>Lista de Funciones</h2>

<table>

<tr>
<th>ID</th>
<th>Película</th>
<th>Sala</th>
<th>Fecha</th>
<th>Hora</th>
<th>Precio</th>
<th>Acción</th>
</tr>

<?php while($fila = $resultado->fetch_assoc()){ ?>

<tr>
<td><?= $fila['id'] ?></td>
<td><?= $fila['pelicula'] ?></td>
<td><?= $fila['sala'] ?></td>
<td><?= $fila['fecha'] ?></td>
<td><?= $fila['hora'] ?></td>
<td>$<?= $fila['precio'] ?></td>
<td>
<a href="actualizar.php?id=<?= $fila['id'] ?>">Editar</a> |
<a href="?eliminar=<?= $fila['id'] ?>" onclick="return confirm('¿Eliminar función?')">Eliminar</a>
</td>
</tr>

<?php } ?>

</table>

</body>
</html>
