<?php
session_start();
include("conexion.php");

if(isset($_POST['login'])){

    $correo = $_POST['correo'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM usuarios WHERE correo='$correo' AND password='$password'";
    $resultado = $conexion->query($sql);

    if($resultado->num_rows > 0){
        $fila = $resultado->fetch_assoc();

        $_SESSION['usuario'] = $fila['nombre'];
        $_SESSION['rol'] = $fila['rol'];

        header("Location: dashboard.php");
        exit();

    }else{
        echo "<script>alert('Datos incorrectos');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Login Cine</title>
<link rel="stylesheet" href="estilos.css">
</head>
<body>

<div class="login-box">
<h2>Iniciar Sesión</h2>

<form method="POST" onsubmit="return validarLogin()">

<input type="email" name="correo" id="correo" placeholder="Correo" required>

<input type="password" name="password" id="password" placeholder="Contraseña" required>

<button type="submit" name="login">Entrar</button>

</form>

</div>

<script>
function validarLogin(){

let correo = document.getElementById("correo").value;
let password = document.getElementById("password").value;

let regexCorreo = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
let regexPass = /^.{6,}$/;

if(!regexCorreo.test(correo)){
    alert("Correo inválido");
    return false;
}

if(!regexPass.test(password)){
    alert("La contraseña mínimo 6 caracteres");
    return false;
}

return true;
}
</script>

</body>
</html>
