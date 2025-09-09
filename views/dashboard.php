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
require_once __DIR__ . '/../controllers/DocenteController.php';
$docenteController = new DocenteController();
$totalDocentes = count($docenteController->listarDocentes());
$totalCursos = count($docenteController->obtenerTodosLosCursos());
$totalHorarios = $docenteController->getConexion()->query("SELECT COUNT(*) as total FROM horarios")->fetch_assoc()['total'] ?? 0;
$totalCarreras = count($docenteController->obtenerCarreras());

// Obtener docentes recientes
$docentesRecientes = array_slice($docenteController->listarDocentes(), -5);

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

    .stat-icon {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        color: #667eea;
    }

    .stat-number {
        font-size: 2rem;
        font-weight: bold;
        color: #2d3748;
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

    /* Botones */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
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

    .btn-primary {
        background-color: #667eea;
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

    /* Badges */
    .badge {
        padding: 0.25rem 0.5rem;
        border-radius: 5px;
        font-size: 0.75rem;
        margin: 0.25rem;
        display: inline-block;
    }

    .carrera-badge {
        background: rgba(76, 175, 80, 0.1);
        color: #4caf50;
    }

    .curso-badge {
        background: rgba(33, 150, 243, 0.1);
        color: #2196f3;
    }

    /* Avatar del docente */
    .docente-avatar {
        width: 40px;
        height: 40px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
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
                <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <div class="stat-number"><?php echo $totalDocentes; ?></div>
                <div class="stat-label">Docentes Registrados</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-book"></i></div>
                <div class="stat-number"><?php echo $totalCursos; ?></div>
                <div class="stat-label">Cursos Disponibles</div>
            </div>
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-graduation-cap"></i></div>
                <div class="stat-number"><?php echo $totalCarreras; ?></div>
                <div class="stat-label">Carreras Disponibles</div>
            </div>
               <!-- 
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-clock"></i></div>
                <div class="stat-number"><?php echo $totalHorarios; ?></div>
                <div class="stat-label">Horarios Programados</div>
            </div> Acciones rápidas -->
            <div class="stat-card">
                <div class="stat-icon"><i class="fas fa-calendar-alt"></i></div>
                <div class="stat-number"><?php echo date('Y'); ?></div>
                <div class="stat-label">Año Académico</div>
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="quick-actions">
            <h3><i class="fas fa-rocket"></i> Acciones Rápidas</h3>
            <div class="btn-container">
                <a href="<?php echo BASE_URL; ?>views/docentes_list.php" class="btn btn-primary">
                    <i class="fas fa-users"></i> Ver Todos los Docentes
                </a>
                <a href="<?php echo BASE_URL; ?>views/docente_form.php" class="btn btn-success">
                    <i class="fas fa-user-plus"></i> Agregar Nuevo Docente
                </a>
                       <a href="<?= BASE_URL ?>views/usuarios_list.php" class="btn btn-primary">
            <i class="fas fa-users-cog"></i> Gestionar Usuarios
        </a>

            </div>
        </div>

        <!-- Información del usuario -->
        <div class="session-info">
            <h4><i class="fas fa-info-circle"></i> Información de la Sesión</h4>
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
               
            </div>
        </div>

        <!-- Docentes recientes -->
        <?php if (!empty($docentesRecientes)): ?>
        <div class="recent-docentes">
            <h3><i class="fas fa-user-clock"></i> Docentes Registrados Recientemente</h3>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Nombre Completo</th>
                            <th>Correo</th>
                            <th>Carrera</th>
                            <th>Cursos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (array_reverse($docentesRecientes) as $docente): ?>
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 0.75rem;">
                                    <div class="docente-avatar">
                                        <?php echo strtoupper(substr($docente['nombres'], 0, 1) . substr($docente['apellidos'], 0, 1)); ?>
                                    </div>
                                    <div>
                                        <strong><?php echo htmlspecialchars($docente['nombres'] . ' ' . $docente['apellidos']); ?></strong>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <?php if (!empty($docente['correo'])): ?>
                                    <a href="mailto:<?php echo htmlspecialchars($docente['correo']); ?>"
                                       style="color: #667eea; text-decoration: none;">
                                        <?php echo htmlspecialchars($docente['correo']); ?>
                                    </a>
                                <?php else: ?>
                                    <span style="color: #999;">No especificado</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($docente['id_carrera'])): ?>
                                    <?php
                                    $carreraNombre = '';
                                    $carreras = $docenteController->obtenerCarreras();
                                    foreach ($carreras as $carrera) {
                                        if ($carrera['id_carrera'] == $docente['id_carrera']) {
                                            $carreraNombre = $carrera['nombre'];
                                            break;
                                        }
                                    }
                                    ?>
                                    <span class="badge carrera-badge">
                                        <?php echo htmlspecialchars($carreraNombre); ?>
                                    </span>
                                <?php else: ?>
                                    <span style="color: #999;">Sin carrera asignada</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <?php if (!empty($docente['cursos'])): ?>
                                    <div style="max-width: 250px;">
                                        <?php foreach (array_slice($docente['cursos'], 0, 2) as $curso): ?>
                                            <span class="badge curso-badge">
                                                <?php echo htmlspecialchars($curso['nombre']); ?>
                                            </span>
                                        <?php endforeach; ?>
                                        <?php if (count($docente['cursos']) > 2): ?>
                                            <span style="color: #666; font-size: 0.875rem;">+<?php echo count($docente['cursos']) - 2; ?> más</span>
                                        <?php endif; ?>
                                    </div>
                                <?php else: ?>
                                    <span style="color: #999;">Sin cursos asignados</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <div class="table-actions">
                                    <a href="<?php echo BASE_URL; ?>views/docente_form.php?edit=<?php echo $docente['id_docente']; ?>"
                                       class="btn btn-small btn-warning" title="Editar docente">
                                        <i class="fas fa-edit"></i>
                                    </a>
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
