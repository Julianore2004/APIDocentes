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
  <style>
    body {
      font-family: Arial, Helvetica, sans-serif;
      background: #f0f2f5;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    /* ===== LOGIN CARD ===== */
    .auth-card {
      background: #fff;
      width: 100%;
      max-width: 380px;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }

    .auth-title {
      text-align: center;
      margin-bottom: 1.5rem;
      font-size: 1.5rem;
      font-weight: bold;
      color: #222;
    }

    /* ALERTAS */
    .alert {
      padding: 12px;
      border-radius: 5px;
      margin-bottom: 1rem;
      font-size: 0.95rem;
    }

    .alert-success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    /* FORM */
    .form-group {
      margin-bottom: 1.2rem;
    }

    .form-input {
      width: 100%;
      padding: 0.8rem;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 1rem;
      transition: border 0.3s;
    }

    .form-input:focus {
      outline: none;
      border-color: #007bff;
      box-shadow: 0 0 0 3px rgba(0,123,255,0.2);
    }

    .btn-submit {
      width: 100%;
      padding: 0.9rem;
      background: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      font-size: 1rem;
      font-weight: bold;
      cursor: pointer;
      transition: background 0.3s;
    }

    .btn-submit:hover {
      background: #0056b3;
    }

    /* INFO TEST DATA */
    .test-info {
      margin-top: 1.5rem;
      font-size: 0.85rem;
      color: #555;
      text-align: center;
      line-height: 1.4;
    }
  </style>
</head>
<body>
  <div class="auth-card">
    <h2 class="auth-title">Iniciar Sesión</h2>

    <!-- Mensajes -->
    <?php if (isset($_GET['logout']) && $_GET['logout'] == 1): ?>
      <div class="alert alert-success">
        ✅ Sesión cerrada exitosamente
      </div>
    <?php endif; ?>

    <?php if (isset($_GET['error']) && $_GET['error'] == 1): ?>
      <div class="alert alert-error">
        ❌ Usuario o contraseña incorrectos
      </div>
    <?php endif; ?>

    <form action="<?php echo BASE_URL; ?>public/index.php?action=login" method="POST">
      <div class="form-group">
        <input type="text" name="username" class="form-input" placeholder="Usuario" value="admin" required>
      </div>
      <div class="form-group">
        <input type="password" name="password" class="form-input" placeholder="Contraseña" value="admin123" required>
      </div>
      <button type="submit" class="btn-submit">Ingresar</button>
    </form>

    <div class="test-info">
      <strong>Datos de prueba:</strong><br>
      Usuario: <code>admin</code><br>
      Contraseña: <code>admin123</code>
    </div>
  </div>
</body>
</html>