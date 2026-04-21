<?php
session_start();
require 'conexion.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación básica de entrada
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        $sql = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['logeado'] = true;
            $_SESSION['usuario'] = $username;
            header("Location: panel.php");
            exit();
        } else {
            $error = "Credenciales incorrectas.";
        }
    } else {
        $error = "Por favor, complete todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Login - Xiaomi SV</title>
</head>
<body style="font-family: Arial; padding: 50px;">
    <h2>Acceso Administrativo</h2>
    <?php if($error) echo "<p style='color:red;'>$error</p>"; ?>
    
    <form method="POST" action="">
        <label>Usuario:</label><br>
        <input type="text" name="username" required><br><br>
        
        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>
        
        <button type="submit">Ingresar</button>
        <a href="index.html">Volver al catálogo</a>
    </form>
</body>
</html>