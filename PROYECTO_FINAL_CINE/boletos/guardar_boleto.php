<?php
session_start();
include("../conexion.php");

if(!isset($_SESSION['usuario'])){
    header("Location: ../login.php");
    exit;
}

$funcion_id = $_POST['funcion_id'];
$asientos = $_POST['asientos'] ?? [];

if(!isset($_SESSION['id_compra'])){
    $_SESSION['id_compra'] = uniqid("COMPRA_");
}

$id_compra = $_SESSION['id_compra'];

if(empty($asientos)){
    echo "<script>
    alert('Selecciona al menos un asiento');
    window.history.back();
    </script>";
    exit;
}

// obtener precio
$res = $conexion->query("SELECT precio FROM funciones WHERE id='$funcion_id'");
$funcion = $res->fetch_assoc();
$precio = $funcion['precio'];

foreach($asientos as $asiento){

    // evitar duplicados
    $ver = $conexion->query("
        SELECT * FROM boletos 
        WHERE funcion_id='$funcion_id' 
        AND asiento='$asiento'
    ");

    if($ver->num_rows == 0){

        $conexion->query("
            INSERT INTO boletos (funcion_id, asiento, precio, id_compra)
            VALUES ('$funcion_id', '$asiento', '$precio', '$id_compra')
        ");
    }
}

echo "<script>
alert('Compra realizada correctamente');
window.location.href='index.php';
</script>";
exit;
