<?php
session_start();
// Validar que solo el admin logueado pueda entrar
if (!isset($_SESSION['usuario'])) { 
    header("Location: login.php"); 
    exit(); 
}

require 'conexion.php';
$mensaje = '';

// Verificamos si se envió algún formulario por POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // --- LÓGICA PARA GUARDAR SMARTPHONE ---
    if (isset($_POST['btn_guardar_smartphone'])) {
        $modelo = $conn->real_escape_string(trim($_POST['modelo']));
        $serie = $conn->real_escape_string(trim($_POST['serie']));
        $precio = (float)$_POST['precio'];
        
        // Si especificaciones está vacío, mandamos un NULL a la base de datos
        $especificaciones = !empty($_POST['especificaciones']) ? "'" . $conn->real_escape_string($_POST['especificaciones']) . "'" : "NULL";

        if (!empty($modelo) && !empty($serie) && $precio > 0) {
            $sql_smart = "INSERT INTO smartphones (modelo, serie, precio, especificaciones_adicionales) 
                          VALUES ('$modelo', '$serie', $precio, $especificaciones)";
            if($conn->query($sql_smart)){
                $mensaje = "<p style='color:green; font-weight:bold;'>✅ Smartphone registrado correctamente.</p>";
            } else {
                $mensaje = "<p style='color:red;'>Error al guardar: " . $conn->error . "</p>";
            }
        }
    }

    // --- LÓGICA PARA GUARDAR HOGAR INTELIGENTE ---
    if (isset($_POST['btn_guardar_hogar'])) {
        $nombre = $conn->real_escape_string(trim($_POST['nombre']));
        $categoria = $conn->real_escape_string($_POST['categoria']);
        $meses = (int)$_POST['meses'];
        
        // Si observaciones está vacío, mandamos un NULL
        $observaciones = !empty($_POST['observaciones']) ? "'" . $conn->real_escape_string($_POST['observaciones']) . "'" : "NULL";

        if (!empty($nombre) && !empty($categoria)) {
            $sql_hogar = "INSERT INTO hogar_inteligente (nombre_equipo, categoria_hogar, garantia_meses, observaciones) 
                          VALUES ('$nombre', '$categoria', $meses, $observaciones)";
            if($conn->query($sql_hogar)){
                $mensaje = "<p style='color:green; font-weight:bold;'>✅ Producto de Hogar registrado correctamente.</p>";
            } else {
                $mensaje = "<p style='color:red;'>Error al guardar: " . $conn->error . "</p>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Administrativo | Xiaomi El Salvador</title>
    <style>
    body { 
        font-family: 'Segoe UI', Tahoma, sans-serif; 
        padding: 20px; 
        background-color: #f9f9f9; 
    }
    .contenedor { 
        display: flex; 
        gap: 40px; 
        margin-top: 20px; 
    }
    .caja-form { 
        background: white; 
        padding: 20px; 
        border-radius: 8px; 
        box-shadow: 0 2px 5px rgba(0,0,0,0.1); 
        width: 50%; 
    }
    
    
    label {
        display: block; 
        font-weight: bold;
        margin-top: 15px; 
    }
    
    input[type="text"], input[type="number"], select, textarea { 
        display: block; 
        width: 90%; 
        padding: 8px; 
        margin: 8px 0; 
        box-sizing: border-box; 
    }
    

    button { 
        background-color: #ff6900; 
        color: white; 
        border: none; 
        padding: 10px 15px; 
        cursor: pointer; 
        border-radius: 4px; 
        font-weight: bold; 
        margin-top: 10px;
    }
    button:hover { 
        background-color: #e65c00; 
    }
    hr { 
        border: 1px solid #ddd; 
    }

    input[type="radio"] {
        display: inline-block;
        width: auto;
    }
    input[type="radio"] + label {
        display: inline-block;
        font-weight: normal;
        margin-top: 0;
        margin-right: 15px;
    }
</style>
</head>
<body>
    <h2>Panel de Control - Bienvenido: <?php echo $_SESSION['usuario']; ?></h2>
    <a href="logout.php" style="color: red;">Cerrar Sesión</a> | 
    <a href="index.html" style="color: blue;">Ver Catálogo Público</a>
    <hr>

    <?php echo $mensaje; ?>

    <div class="contenedor">
        <div class="caja-form">
            <h3>Agregar Nuevo Smartphone</h3>
            <form method="POST" action="">
                <label>Modelo del Equipo:</label>
                <input type="text" name="modelo" required placeholder="Ej: Redmi Note 13">

                <label>Serie (Categoría):</label>
                <select name="serie" required>
                    <option value="">-- Selecciona una serie --</option>
                    <option value="Serie Xiaomi">Serie Xiaomi (Gama Alta)</option>
                    <option value="Serie Redmi Note">Serie Redmi Note</option>
                    <option value="Serie Redmi">Serie Redmi (Entrada)</option>
                    <option value="Serie Poco">Serie POCO</option>
                </select>

                <label>Precio de Venta ($):</label>
                <input type="number" step="0.01" name="precio" required placeholder="Ej: 250.00">

                <label>Especificaciones Extra (Opcional):</label>
                <textarea name="especificaciones" rows="3" placeholder="Acepta valores nulos en BD"></textarea>

                <button type="submit" name="btn_guardar_smartphone">Guardar Smartphone</button>
            </form>
        </div>

        <div class="caja-form">
            <h3>Agregar Producto de Hogar</h3>
            <form method="POST" action="">
                <label>Nombre del Producto:</label>
                <input type="text" name="nombre" required placeholder="Ej: Mi Robot Vacuum">

                <label>Categoría:</label>
                <select name="categoria" required>
                    <option value="">-- Selecciona --</option>
                    <option value="Limpieza">Limpieza</option>
                    <option value="Cocina">Cocina</option>
                    <option value="Salud">Salud y Deporte</option>
                    <option value="Seguridad">Seguridad</option>
                </select>

                <p style="margin-bottom: 5px;">Garantía:</p>
                <input type="radio" name="meses" value="6" id="g6" checked> <label for="g6">6 Meses</label>
                <input type="radio" name="meses" value="12" id="g12"> <label for="g12">12 Meses</label>
                <input type="radio" name="meses" value="24" id="g24"> <label for="g24">24 Meses</label>
                <br><br>

                <label>Observaciones (Opcional):</label>
                <textarea name="observaciones" rows="3" placeholder="Acepta valores nulos en BD"></textarea>

                <button type="submit" name="btn_guardar_hogar">Guardar en Hogar</button>
            </form>
        </div>
    </div>
</body>
</html>