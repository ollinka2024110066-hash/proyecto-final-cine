<?php
session_start();
include("../conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit;
}

if(!isset($_SESSION['id_compra'])){
    $_SESSION['id_compra'] = uniqid("COMPRA_");
}


$id = $_GET['id'];

/* función + sala */
$sql = $conexion->query("
SELECT funciones.*,
peliculas.titulo,
salas.nombre,
salas.capacidad

FROM funciones

INNER JOIN peliculas
ON funciones.pelicula_id = peliculas.id

INNER JOIN salas
ON funciones.sala_id = salas.id

WHERE funciones.id='$id'
");

if(!$sql){
    die("Error en consulta: " . $conexion->error);
}

$funcion = $sql->fetch_assoc();

/* ocupados */
$ocupados = [];

$res = $conexion->query("
SELECT asiento FROM boletos
WHERE funcion_id='$id'
");

while($fila = $res->fetch_assoc()){
    $ocupados[] = $fila['asiento'];
}

/* precio (CORRECTO) */
$precio = $funcion['precio'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Elegir Asientos</title>

<style>
.pantalla{
    background:black;
    color:white;
    padding:15px;
    text-align:center;
    margin:20px auto;
    width:300px;
    border-radius:10px;
    font-weight:bold;
}

.resumen{
    text-align:center;
    margin-top:10px;
    font-weight:bold;
    font-size:18px;
}

.sala{
    display:grid;
    grid-template-columns:repeat(10, 65px);
    gap:12px;
    justify-content:center;
    margin-top:30px;
}

.asiento{
    width:60px;
    height:60px;
    border:none;
    border-radius:12px;
    cursor:pointer;
    font-weight:bold;
    transition:0.2s;
}

/* azul libre */
.libre{
    background:#2f80ed;
    color:white;
}

.libre:hover{
    background:#1c6dd0;
    transform:scale(1.05);
}

/* ocupado */
.ocupado{
    background:#999;
    color:white;
    cursor:not-allowed;
    opacity:0.5;
}

/* seleccionado */
.seleccionado{
    background:#0d47a1 !important;
    color:white;
    transform:scale(1.05);
    box-shadow:0 0 10px rgba(13,71,161,0.6);
}

/* botón */
button[type="submit"]{
    margin-top:25px;
    padding:12px 20px;
    background:#2f80ed;
    color:white;
    border:none;
    border-radius:10px;
    cursor:pointer;
    font-weight:bold;
}

button[type="submit"]:hover{
    background:#1c6dd0;
}
</style>

<script>
let precio = <?php echo $precio; ?>;
let seleccionados = 0;

function seleccionar(btn, checkbox){

    checkbox.checked = !checkbox.checked;

    if(checkbox.checked){
        btn.classList.add("seleccionado");
    }else{
        btn.classList.remove("seleccionado");
    }

    let todos = document.querySelectorAll("input[name='asientos[]']");
    seleccionados = 0;

    todos.forEach(el => {
        if(el.checked) seleccionados++;
    });

    document.getElementById("contador").innerText = seleccionados;
    document.getElementById("total").innerText = seleccionados * precio;
}

</script>

</head>
<body>

<div class="container">

<h1>🎟️ Selecciona tus asientos</h1>

<p><strong>Película:</strong> <?php echo $funcion['titulo']; ?></p>
<p><strong>Sala:</strong> <?php echo $funcion['nombre']; ?></p>
<p><strong>Hora:</strong> <?php echo $funcion['hora']; ?></p>

<div class="pantalla">PANTALLA</div>

<div class="resumen">
🎟️ Seleccionados: <span id="contador">0</span> |
💰 Total: $<span id="total">0</span>
</div>

<form action="guardar_boleto.php" method="POST">
<input type="hidden" name="funcion_id" value="<?php echo $id; ?>">

<div class="sala">

<?php
$capacidad = $funcion['capacidad'];

$columnas = 10;
$filas = ceil($capacidad / $columnas);

$letras = range('A', 'Z');
$contador = 0;

for($f = 0; $f < $filas; $f++){

    for($c = 1; $c <= $columnas; $c++){

        if($contador < $capacidad){

            $asiento = $letras[$f] . $c;

            if(in_array($asiento, $ocupados)){
                ?>

                <button type="button" class="asiento ocupado" disabled>
                    <?php echo $asiento; ?>
                </button>

                <?php
            }else{
                ?>

                <div>
                    <input type="checkbox" name="asientos[]" value="<?php echo $asiento; ?>" hidden>

                    <button type="button"
                        class="asiento libre"
                        onclick="seleccionar(this, this.parentNode.querySelector('input'))">

                        <?php echo $asiento; ?>

                    </button>
                </div>

                <?php
            }

            $contador++;
        }

    }

}
?>

</div>

<br>
<button type="submit">🎟️ Comprar seleccionados</button>

</form>

</div>

</body>
</html>
