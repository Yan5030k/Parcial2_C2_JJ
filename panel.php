<?php
session_start();
require 'conexion.php';

// Validar que solo un usuario registrado pueda ingresar
if (!isset($_SESSION['logeado']) || $_SESSION['logeado'] !== true) {
    header("Location: login.php");
    exit();
}

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validaciones de los datos ingresados
    $nombre = trim($_POST['nombre']);
    $categoria = $_POST['categoria'];
    $version_global = isset($_POST['version']) ? $_POST['version'] : '';
    $detalles = trim($_POST['detalles']);
    
    // Si detalles está vacío, lo convertimos en un NULL real para la BD
    $detalles_sql = empty($detalles) ? "NULL" : "'" . $conn->real_escape_string($detalles) . "'";

    // Validar que los campos obligatorios no estén vacíos
    if (empty($nombre) || empty($categoria) || $version_global === '') {
        $mensaje = "<span style='color:red;'>Error: Nombre, Categoría y Versión son obligatorios.</span>";
    } else {
        // Evitar inyección SQL
        $nombre = $conn->real_escape_string($nombre);
        $categoria = $conn->real_escape_string($categoria);
        $version_global = (int)$version_global;

        $sql = "INSERT INTO productos (nombre_equipo, categoria, es_version_global, detalles_extra) 
                VALUES ('$nombre', '$categoria', $version_global, $detalles_sql)";

        if ($conn->query($sql) === TRUE) {
            $mensaje = "<span style='color:green;'>Producto registrado correctamente.</span>";
        } else {
            $mensaje = "<span style='color:red;'>Error al registrar: " . $conn->error . "</span>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo | Xiaomi</title>
</head>
<body style="font-family: Arial; padding: 20px;">
    <h2>Bienvenido, <?php echo $_SESSION['usuario']; ?></h2>
    <a href="logout.php">Cerrar Sesión</a> | <a href="index.html">Ver Catálogo Público</a>
    <hr>

    <h3>Ingresar Nuevo Producto</h3>
    <?php echo $mensaje; ?><br><br>

    <form method="POST" action="">
        <label>Nombre del Equipo (Obligatorio):</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Categoría (Obligatorio):</label><br>
        <select name="categoria" required>
            <option value="">-- Selecciona una categoría --</option>
            <option value="Smartphones">Smartphones</option>
            <option value="Tablets">Tablets</option>
            <option value="Audio">Audio</option>
            <option value="Wearables">Wearables (Smartbands/Watches)</option>
            <option value="Hogar Inteligente">Hogar Inteligente</option>
        </select><br><br>

        <label>¿Es versión Global? (Obligatorio):</label><br>
        <input type="radio" id="si" name="version" value="1" required>
        <label for="si">Sí</label><br>
        <input type="radio" id="no" name="version" value="0" required>
        <label for="no">No (Versión China/India)</label><br><br>

        <label>Detalles extras (Opcional - Acepta Nulos):</label><br>
        <textarea name="detalles" rows="4" cols="30"></textarea><br><br>

        <button type="submit">Guardar Producto</button>
    </form>
</body>
</html>