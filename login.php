<?php
session_start();
require 'conexion.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string(trim($_POST['username']));
    $password = trim($_POST['password']);

    if (!empty($username) && !empty($password)) {
        // Validación directa para el parcial
        $sql = "SELECT * FROM usuarios WHERE username = '$username' AND password = '$password'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $_SESSION['logeado'] = true;
            $_SESSION['usuario'] = $username;
            header("Location: panel.php");
            exit();
        } else {
            $error = "Credenciales incorrectas. Intenta de nuevo.";
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso Administrativo | Xiaomi SV</title>
    <style>
        /* Reseteo básico */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        body { background-color: #f0f2f5; display: flex; justify-content: center; align-items: center; height: 100vh; }

        /* Contenedor principal de la tarjeta */
        .login-container {
            background-color: #ffffff; width: 100%; max-width: 400px; padding: 40px 30px;
            border-radius: 10px; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1); text-align: center;
        }

        .login-container h2 { color: #333; margin-bottom: 20px; font-size: 24px; }

        /* Estilo para la imagen del logo */
        .logo-img {
            width: 80px; 
            border-radius: 12px; 
            margin-bottom: 20px;
        }

        .input-group { margin-bottom: 20px; text-align: left; }
        .input-group label { display: block; margin-bottom: 5px; color: #555; font-weight: 500; }
        .input-group input {
            width: 100%; padding: 12px; border: 1px solid #ccc; border-radius: 6px; font-size: 16px; transition: border-color 0.3s;
        }
        .input-group input:focus { border-color: #ff6900; outline: none; box-shadow: 0 0 5px rgba(255, 105, 0, 0.2); }

        .btn-submit {
            width: 100%; background-color: #ff6900; color: white; padding: 12px; border: none;
            border-radius: 6px; font-size: 16px; font-weight: bold; cursor: pointer; transition: background-color 0.3s; margin-top: 10px;
        }
        .btn-submit:hover { background-color: #e65c00; }

        .back-link { display: inline-block; margin-top: 20px; color: #777; text-decoration: none; font-size: 14px; transition: color 0.3s; }
        .back-link:hover { color: #ff6900; }

        .error-message {
            background-color: #fee2e2; color: #dc2626; padding: 10px; border-radius: 6px; margin-bottom: 20px; font-size: 14px; border: 1px solid #fca5a5;
        }

        /* --- NUEVO ESTILO: Credenciales para el Docente --- */
        .credenciales-docente {
            margin-top: 25px;
            padding-top: 15px;
            border-top: 1px dashed #d1d5db;
            font-size: 13px;
            color: #6b7280;
            text-align: center;
        }
        .credenciales-docente span {
            font-family: monospace;
            background-color: #f3f4f6;
            padding: 2px 6px;
            border-radius: 4px;
            color: #111827;
            font-weight: bold;
        }
    </style>
</head>
<body>

    <div class="login-container">
        <img src="data:image/png;base64,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" alt="Logo Xiaomi" class="logo-img">
        
        <h2>Portal Administrativo</h2>
        
        <?php if($error): ?>
            <div class="error-message">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="input-group">
                <label for="username">Usuario</label>
                <input type="text" id="username" name="username" required autocomplete="off" placeholder="Ingresa tu usuario">
            </div>
            
            <div class="input-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" required placeholder="Ingresa tu contraseña">
            </div>
            
            <button type="submit" class="btn-submit">Iniciar Sesión</button>
        </form>

        <div class="credenciales-docente">
            <p><strong>Credenciales</strong></p>
            <p>Usuario: <span>admin</span> | Clave: <span>admin123</span></p>
        </div>

        <a href="index.html" class="back-link">← Volver al catálogo público</a>
    </div>

</body>
</html>