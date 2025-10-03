<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'views/login.php');
    exit();
}

require_once __DIR__ . '/../controllers/TokenApiController.php';
$tokenApiController = new TokenApiController();

// Obtener clientes
$clientes = $tokenApiController->obtenerClientes();

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_client_api = trim($_POST['id_client_api']);

    // Validaciones
    $errores = [];
    if (empty($id_client_api)) {
        $errores[] = "El campo Cliente es obligatorio";
    }

    if (empty($errores)) {
        $resultado = $tokenApiController->crearToken($id_client_api);
        if ($resultado) {
            $tokenGenerado = $tokenApiController->obtenerToken($resultado);
            $mensaje = "✅ Token generado exitosamente";
            $tipo_mensaje = "success";
        } else {
            $mensaje = "❌ Error al generar el token";
            $tipo_mensaje = "error";
        }
    }
}
require_once __DIR__ . '/include/header.php';
?>

<!-- Incluir Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">


<style>
    /* Estilos globales */
    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .fade-in {
        animation: fadeIn 0.5s ease-in-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    /* Mensajes */
    .message {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 5px;
        text-align: center;
        font-weight: 500;
    }

    .message.success {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }

    .message.error {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }

    /* Contenedor del formulario */
    .form-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        padding: 2rem;
    }

    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
    }

    .form-header h2 {
        color: #2d3748;
        margin: 0;
    }

    /* Formulario */
    .form-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }

    .form-section {
        margin-bottom: 1.5rem;
    }

    .form-section h4 {
        color: #2d3748;
        margin-bottom: 1rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #2d3748;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        font-size: 1rem;
    }

    /* Botones */
    .btn {
        display: inline-block;
        padding: 0.5rem 1rem;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
    }

    .btn-success {
        background-color: #48bb78;
        color: white;
    }

    .btn-cancel {
        background-color: #e2e8f0;
        color: #2d3748;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
    }

    .required-note {
        color: #666;
        font-size: 0.875rem;
    }

    /* Token generado */
    .token-display {
        background: #f7fafc;
        padding: 1rem;
        border-radius: 5px;
        margin-top: 1rem;
        font-family: monospace;
        word-break: break-all;
    }
</style>

<div class="container fade-in">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="<?php echo BASE_URL; ?>views/dashboard.php">🏠 Dashboard</a>
        <span>></span>
        <a href="<?php echo BASE_URL; ?>views/tokens_list.php">🔑 Tokens</a>
        <span>></span>
        <span>Nuevo</span>
    </div>

    <!-- Mensajes -->
    <?php if (isset($mensaje)): ?>
    <div class="message <?php echo $tipo_mensaje; ?>">
        <?php echo $mensaje; ?>
    </div>
    <?php endif; ?>

    <?php if (!empty($errores)): ?>
    <div class="message error">
        <strong>❌ Se encontraron los siguientes errores:</strong>
        <ul>
            <?php foreach ($errores as $error): ?>
            <li><?php echo htmlspecialchars($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <div class="form-container">
        <div class="form-header">
            <h2>➕ Generar Nuevo Token</h2>
            <a href="<?php echo BASE_URL; ?>views/tokens_list.php" class="btn btn-cancel">
                ← Volver al listado
            </a>
        </div>

        <form method="POST" action="">
            <div class="form-grid">
                <div class="form-section">
                    <h4>🔑 Información del Token</h4>
                    <div class="form-group">
                        <label for="id_client_api">Cliente *</label>
                        <select id="id_client_api" name="id_client_api" class="form-control" required>
                            <option value="">-- Seleccione un cliente --</option>
                            <?php foreach ($clientes as $cliente): ?>
                                <option value="<?php echo $cliente['id']; ?>">
                                    <?php echo htmlspecialchars($cliente['razon_social']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <div class="required-note">
                    <span style="color: #666; font-size: 0.875rem;">* Campos obligatorios</span>
                </div>
                <div class="action-buttons">
                    <a href="<?php echo BASE_URL; ?>views/tokens_list.php" class="btn btn-cancel">
                        ❌ Cancelar
                    </a>
                    <button type="submit" class="btn btn-success">
                        ➕ Generar Token
                    </button>
                </div>
            </div>
        </form>

        <?php if (isset($tokenGenerado)): ?>
        <div class="form-section">
            <h4>🔐 Token Generado</h4>
            <div class="token-display">
                <?php echo htmlspecialchars($tokenGenerado['token']); ?>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>
