<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'views/login.php');
    exit();
}

// Obtener estadísticas
require_once __DIR__ . '/../models/Docente.php';
$docenteModel = new Docente();
$totalDocentes = count($docenteModel->obtenerDocentes());

// Conexión para estadísticas adicionales
$conexion = conectarDB();
$totalCursos = $conexion->query("SELECT COUNT(*) as total FROM cursos")->fetch_assoc()['total'] ?? 0;
$totalHorarios = $conexion->query("SELECT COUNT(*) as total FROM horarios")->fetch_assoc()['total'] ?? 0;

require_once __DIR__ . '/include/header.php';
?>

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

    /* Dashboard */
    .dashboard-container {
        background-color: #f8f9fa;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    .dashboard-welcome {
        text-align: center;
        margin-bottom: 2rem;
    }

    .dashboard-welcome h2 {
        color: #2d3748;
        font-size: 2rem;
        margin-bottom: 0.5rem;
    }

    .dashboard-welcome p {
        font-size: 1.1rem;
        color: #666;
        margin-top: 0.5rem;
    }

    /* Estadísticas */
    .dashboard-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background: white;
        border-radius: 10px;
        padding: 1.5rem;
        text-align: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .stat-card:hover {
        transform: translateY(-5px);
    }

    .stat-number {
        font-size: 2.5rem;
        font-weight: bold;
        color: #667eea;
        margin-bottom: 0.5rem;
    }

    .stat-label {
        font-size: 1rem;
        color: #666;
    }

    /* Acciones rápidas */
    .quick-actions {
        text-align: center;
        margin-bottom: 2rem;
    }

    .quick-actions h3 {
        margin-bottom: 1.5rem;
        color: #2d3748;
    }

    .quick-actions .btn-container {
        display: flex;
        gap: 1rem;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        display: inline-block;
        padding: 0.75rem 1.5rem;
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

    .btn-warning {
        background-color: #fbbf24;
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Información de sesión */
    .session-info {
        background: rgba(102, 126, 234, 0.1);
        padding: 1.5rem;
        border-radius: 15px;
        border-left: 4px solid #667eea;
        margin-bottom: 2rem;
    }

    .session-info h4 {
        color: #2d3748;
        margin-bottom: 1rem;
    }

    .session-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 1rem;
    }

    .session-item strong {
        display: block;
        margin-bottom: 0.25rem;
        color: #4a5568;
    }

    .role-badge {
        background: #667eea;
        color: white;
        padding: 0.25rem 0.5rem;
        border-radius: 5px;
        font-size: 0.875rem;
    }

    /* Tabla de docentes recientes */
    .table-container {
        overflow-x: auto;
        margin-top: 1rem;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    .table th, .table td {
        padding: 1rem;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
    }

    .table th {
        background-color: #f7fafc;
        font-weight: 600;
        color: #2d3748;
    }

    .table-actions {
        display: flex;
        gap: 0.5rem;
    }

    .btn-small {
        padding: 0.5rem 1rem;
        font-size: 0.875rem;
    }

    .especialidad-badge {
        background: rgba(102, 126, 234, 0.1);
        padding: 0.25rem 0.5rem;
        border-radius: 5px;
        font-size: 0.875rem;
        display: inline-block;
    }
</style>

<div class="container fade-in">
    <div class="dashboard-container">
        <!-- Bienvenida -->
        <div class="dashboard-welcome">
            <h2>¡Bienvenido, <?php echo htmlspecialchars($_SESSION['nombre_completo'] ?? $_SESSION['username']); ?>!</h2>
            <p>Sistema de Gestión de Docentes - Instituto API</p>
        </div>

        <!-- Estadísticas -->
        <div class="dashboard-stats">
            <div class="stat-card">
                <div class="stat-number"><?php echo $totalDocentes; ?></div>
                <div class="stat-label">👨‍🏫 Docentes Registrados</div>
            </div>

            <div class="stat-card">
                <div class="stat-number"><?php echo $totalCursos; ?></div>
                <div class="stat-label">📚 Cursos Disponibles</div>
            </div>

            <div class="stat-card">
                <div class="stat-number"><?php echo $totalHorarios; ?></div>
                <div class="stat-label">🕒 Horarios Programados</div>
            </div>

            <div class="stat-card">
                <div class="stat-number"><?php echo date('Y'); ?></div>
                <div class="stat-label">📅 Año Académico</div>
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="quick-actions">
            <h3>🚀 Acciones Rápidas</h3>
            <div class="btn-container">
                <a href="<?php echo BASE_URL; ?>views/docentes_list.php" class="btn">
                    👥 Ver Todos los Docentes
                </a>
                <a href="<?php echo BASE_URL; ?>views/docente_form.php" class="btn btn-success">
                    ➕ Agregar Nuevo Docente
                </a>
                <a href="<?php echo BASE_URL; ?>views/reportes.php" class="btn btn-warning">
                    📊 Generar Reportes
                </a>
            </div>
        </div>

        <!-- Información del usuario -->
        <div class="session-info">
            <h4>ℹ️ Información de la Sesión</h4>
            <div class="session-grid">
                <div class="session-item">
                    <strong>ID:</strong> <?php echo $_SESSION['user_id']; ?>
                </div>
                <div class="session-item">
                    <strong>Usuario:</strong> <?php echo htmlspecialchars($_SESSION['username']); ?>
                </div>
                <div class="session-item">
                    <strong>Rol:</strong> <span class="role-badge"><?php echo strtoupper($_SESSION['rol'] ?? 'ADMIN'); ?></span>
                </div>
                <div class="session-item">
                    <strong>Último acceso:</strong> <?php echo date('d/m/Y H:i'); ?>
                </div>
            </div>
        </div>

        <!-- Docentes recientes -->
        <?php
        $docentesRecientes = array_slice($docenteModel->obtenerDocentes(), -5);
        if (!empty($docentesRecientes)):
        ?>
        <div class="recent-docentes">
            <h3>📋 Docentes Registrados Recientemente</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th>Especialidad</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_reverse($docentesRecientes) as $docente): ?>
                        <tr>
                            <td>
                                <strong><?php echo htmlspecialchars($docente['nombres'] . ' ' . $docente['apellidos']); ?></strong>
                            </td>
                            <td><?php echo htmlspecialchars($docente['correo'] ?? 'No especificado'); ?></td>
                            <td>
                                <span class="especialidad-badge">
                                    <?php echo htmlspecialchars(substr($docente['especialidad'] ?? 'Sin especialidad', 0, 30)); ?>...
                                </span>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?php echo BASE_URL; ?>views/docente_form.php?edit=<?php echo $docente['id_docente']; ?>" class="btn btn-small btn-warning">✏️ Editar</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<?php require_once __DIR__ . '/include/footer.php'; ?>
