<?php
// views/dashboard.php - Versión corregida
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Iniciar sesión ANTES que cualquier output
session_start();

// Incluir configuración para BASE_URL
require_once __DIR__ . '/../config/database.php';

// Debug temporal
error_log("Dashboard accessed");
error_log("Session data: " . print_r($_SESSION, true));

// Verificar autenticación
if (!isset($_SESSION['user_id'])) {
    error_log("No user_id in session - redirecting to login");
    header('Location: ' . BASE_URL . 'views/login.php');
    exit();
}

// Si llegamos aquí, el usuario está autenticado
error_log("User authenticated: " . $_SESSION['username']);

// Incluir header
require_once __DIR__ . '/include/header.php';
?>

        <div class="dashboard-container">
            <h2>¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_completo'] ?? $_SESSION['username'] ?? 'Usuario'); ?>!</h2>
            <p>Has iniciado sesión exitosamente en el sistema.</p>
            
            <div class="dashboard-stats">
                <h3>Información de la sesión:</h3>
                <ul>
                    <li><strong>ID:</strong> <?php echo $_SESSION['user_id']; ?></li>
                    <li><strong>Usuario:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?></li>
                    <li><strong>Nombre:</strong> <?php echo htmlspecialchars($_SESSION['nombre_completo'] ?? 'No definido'); ?></li>
                    <li><strong>Rol:</strong> <?php echo htmlspecialchars($_SESSION['rol'] ?? 'No definido'); ?></li>
                </ul>
            </div>
            
            <div class="dashboard-actions">
                <h3>Acciones disponibles:</h3>
                <a href="<?php echo BASE_URL; ?>views/docentes_list.php" class="btn">Ver Docentes</a>
                <a href="<?php echo BASE_URL; ?>controllers/AuthController.php?action=logout" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
    </div>
    
    <script>
        console.log('Dashboard cargado exitosamente');
        console.log('Usuario:', '<?php echo $_SESSION['username']; ?>');
    </script>
</body>
</html>