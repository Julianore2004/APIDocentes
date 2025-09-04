 <?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../config/database.php';

// Verificar si ya hay sesión activa
session_start();
if (isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'views/dashboard.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - API Docentes</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .message {
            padding: 10px;
            margin: 10px 0;
            border-radius: 3px;
        }
        .success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .form-group {
            margin: 15px 0;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 3px;
            box-sizing: border-box;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }
        button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Iniciar Sesión</h2>
        
        <!-- Mensajes -->
        <?php if (isset($_GET['logout']) && $_GET['logout'] == 1): ?>
            <div class="message success">
                ✅ Sesión cerrada exitosamente
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
            <div class="message error">
                ❌ Usuario o contraseña incorrectos
            </div>
        <?php endif; ?>
        
        <form action="<?php echo BASE_URL; ?>public/index.php?action=login" method="POST">
            <div class="form-group">
                <input type="text" name="username" placeholder="Usuario" value="admin" required>
            </div>
            <div class="form-group">
                <input type="password" name="password" placeholder="Contraseña" value="admin123" required>
            </div>
            <button type="submit">Ingresar</button>
        </form>
        
        <div style="margin-top: 20px; font-size: 0.9em; color: #666;">
            <strong>Datos de prueba:</strong><br>
            Usuario: admin<br>
            Contraseña: admin123
        </div>
    </div>
</body>
</html>