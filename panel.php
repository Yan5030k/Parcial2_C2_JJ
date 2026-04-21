<?php
session_start();
if (!isset($_SESSION['usuario'])) { header("Location: login.php"); exit(); }
require 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validación básica
    $nombre = $conn->real_escape_string(trim($_POST['nombre']));
    $cat = $_POST['categoria'];
    $meses = (int)$_POST['meses'];
    $obs = !empty($_POST['observaciones']) ? "'".$conn->real_escape_string($_POST['observaciones'])."'" : "NULL";

    if (!empty($nombre) && !empty($cat)) {
        $sql = "INSERT INTO hogar_inteligente (nombre_equipo, categoria_hogar, garantia_meses, observaciones) 
                VALUES ('$nombre', '$cat', $meses, $obs)";
        $conn->query($sql);
        echo "<script>alert('Producto de Hogar registrado');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administración Xiaomi</title>
</head>
<body style="font-family: Arial; padding: 30px;">
    <h2>Bienvenido: <?php echo $_SESSION['usuario']; ?></h2>
    <a href="logout.php">Cerrar Sesión</a> | <a href="index.html">Ver Web</a>
    <hr>

    <h3>Registrar Producto de Hogar</h3>
    <form method="POST">
        <label>Nombre del Producto:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Categoría:</label><br>
        <select name="categoria" required>
            <option value="Limpieza">Limpieza (Aspiradoras)</option>
            <option value="Cocina">Cocina</option>
            <option value="Salud">Salud y Deporte</option>
            <option value="Cámaras">Cámaras y Seguridad</option>
        </select><br><br>

        <label>Meses de Garantía:</label><br>
        <input type="radio" name="meses" value="6" checked> 6 Meses
        <input type="radio" name="meses" value="12"> 12 Meses
        <input type="radio" name="meses" value="24"> 24 Meses<br><br>

        <label>Observaciones (Opcional - acepta nulos):</label><br>
        <textarea name="observaciones"></textarea><br><br>

        <button type="submit">Guardar en Hogar Inteligente</button>
    </form>
</body>
</html>