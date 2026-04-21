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

        .logo {
            background-color: #ff6900; color: white; display: inline-block; padding: 10px 15px;
            font-size: 28px; font-weight: bold; border-radius: 12px; margin-bottom: 20px;
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
        <div class="logo">mi</div>
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