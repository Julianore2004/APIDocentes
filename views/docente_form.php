<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'views/login.php');
    exit();
}

require_once __DIR__ . '/../controllers/DocenteController.php';
$docenteController = new DocenteController();

// Determinar si es edición o creación
$isEditing = isset($_GET['edit']) && is_numeric($_GET['edit']);
$docente = null;
$pageTitle = $isEditing ? '✏️ Editar Docente' : '➕ Agregar Nuevo Docente';

if ($isEditing) {
    $docente = $docenteController->obtenerDocente($_GET['edit']);
    if (!$docente) {
        header('Location: ' . BASE_URL . 'views/docentes_list.php');
        exit();
    }
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $especialidad = trim($_POST['especialidad']);

    // Validaciones
    $errores = [];

    if (empty($nombres)) {
        $errores[] = "El campo Nombres es obligatorio";
    }

    if (empty($apellidos)) {
        $errores[] = "El campo Apellidos es obligatorio";
    }

    if (!empty($correo) && !filter_var($correo, FILTER_VALIDATE_EMAIL)) {
        $errores[] = "El formato del correo electrónico no es válido";
    }

    if (!empty($telefono) && !preg_match('/^[\d\s\-\+\(\)]+$/', $telefono)) {
        $errores[] = "El formato del teléfono no es válido";
    }

    if (empty($errores)) {
        if ($isEditing) {
            $resultado = $docenteController->editarDocente($_GET['edit'], $nombres, $apellidos, $correo, $telefono, $especialidad);
            if ($resultado) {
                $mensaje = "✅ Docente actualizado exitosamente";
                $tipo_mensaje = "success";
                // Recargar datos del docente
                $docente = $docenteController->obtenerDocente($_GET['edit']);
            } else {
                $mensaje = "❌ Error al actualizar el docente";
                $tipo_mensaje = "error";
            }
        } else {
            $resultado = $docenteController->crearDocente($nombres, $apellidos, $correo, $telefono, $especialidad);
            if ($resultado) {
                header('Location: ' . BASE_URL . 'views/docentes_list.php?created=1');
                exit();
            } else {
                $mensaje = "❌ Error al crear el docente";
                $tipo_mensaje = "error";
            }
        }
    }
}

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

    /* Breadcrumb */
    .breadcrumb {
        margin-bottom: 2rem;
        color: #666;
        font-size: 0.875rem;
    }

    .breadcrumb a {
        color: #667eea;
        text-decoration: none;
    }

    .breadcrumb span {
        margin: 0 0.5rem;
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

    .message.error ul {
        margin: 0.5rem 0 0 1.5rem;
        padding: 0;
        text-align: left;
    }

    /* Contenedor del formulario */
    .form-container {
        background: white;
        border-radius: 10px;
        padding: 2rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
    }

    /* Encabezado del formulario */
    .form-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 2px solid rgba(102, 126, 234, 0.2);
    }

    .form-header h2 {
        color: #2d3748;
        margin: 0;
    }

    /* Vista previa del docente */
    .docente-preview {
        background: linear-gradient(135deg, rgba(102, 126, 234, 0.1), rgba(118, 75, 162, 0.1));
        padding: 1.5rem;
        border-radius: 10px;
        margin-bottom: 2rem;
        border-left: 4px solid #667eea;
    }

    .preview-content {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .docente-avatar {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #667eea, #764ba2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        font-size: 1.5rem;
    }

    .preview-info h4 {
        margin: 0;
        color: #2d3748;
    }

    .preview-info p {
        margin: 0.25rem 0 0 0;
        color: #666;
    }

    /* Secciones del formulario */
    .form-section {
        background: rgba(255, 255, 255, 0.8);
        padding: 1.5rem;
        border-radius: 10px;
        border-left: 4px solid;
        margin-bottom: 1.5rem;
    }

    .form-section.personal {
        background: rgba(72, 187, 120, 0.05);
        border-left-color: #48bb78;
    }

    .form-section.contact {
        background: rgba(66, 153, 225, 0.05);
        border-left-color: #4299e1;
    }

    .form-section.specialty {
        background: rgba(237, 137, 54, 0.05);
        border-left-color: #ed8936;
    }

    .form-section h4 {
        color: #2d3748;
        margin-bottom: 1rem;
    }

    /* Grupos de formulario */
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 500;
        color: #4a5568;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        font-size: 1rem;
        transition: all 0.3s ease;
    }

    .form-control:focus {
        border-color: #667eea;
        box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        outline: none;
    }

    .form-control::placeholder {
        color: #a0aec0;
    }

    /* Especialidades sugeridas */
    .suggested-specialties {
        margin-top: 1rem;
    }

    .suggested-specialties label {
        font-size: 0.875rem;
        color: #666;
        margin-bottom: 0.5rem;
        display: block;
    }

    .specialty-tags {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .specialty-tag {
        background: rgba(102, 126, 234, 0.1);
        border: 1px solid rgba(102, 126, 234, 0.3);
        color: #667eea;
        padding: 0.25rem 0.5rem;
        border-radius: 15px;
        font-size: 0.75rem;
        cursor: pointer;
        transition: all 0.2s;
    }

    .specialty-tag:hover {
        background: rgba(72, 187, 120, 0.2);
        border-color: #48bb78;
        color: #22543d;
    }

    /* Botones de acción */
    .form-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 2rem;
        padding-top: 2rem;
        border-top: 1px solid #e2e8f0;
    }

    .form-actions .required-note {
        color: #666;
        font-size: 0.875rem;
    }

    .action-buttons {
        display: flex;
        gap: 1rem;
    }

    /* Botones */
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

    .btn-danger {
        background-color: #f56565;
        color: white;
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-cancel {
        background-color: #e2e8f0;
        color: #4a5568;
        box-shadow: none;
    }

    .btn-cancel:hover {
        background-color: #cbd5e0;
        transform: none;
    }

    /* Layout del formulario */
    .form-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 2rem;
    }

    /* Loading indicator */
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

    .loading {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(255, 255, 255, 0.3);
        border-radius: 50%;
        border-top-color: white;
        animation: spin 1s ease-in-out infinite;
        margin-right: 0.5rem;
    }
</style>

<div class="container fade-in">
    <!-- Breadcrumb -->
    <div class="breadcrumb">
        <a href="<?php echo BASE_URL; ?>views/dashboard.php">🏠 Dashboard</a>
        <span>></span>
        <a href="<?php echo BASE_URL; ?>views/docentes_list.php">👥 Docentes</a>
        <span>></span>
        <span><?php echo $isEditing ? 'Editar' : 'Nuevo'; ?></span>
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
        <!-- Encabezado del formulario -->
        <div class="form-header">
            <h2><?php echo $pageTitle; ?></h2>
            <a href="<?php echo BASE_URL; ?>views/docentes_list.php" class="btn btn-cancel">
                ← Volver al listado
            </a>
        </div>

        <!-- Vista previa del docente (solo en edición) -->
        <?php if ($isEditing && $docente): ?>
        <div class="docente-preview">
            <div class="preview-content">
                <div class="docente-avatar">
                    <?php echo strtoupper(substr($docente['nombres'], 0, 1) . substr($docente['apellidos'], 0, 1)); ?>
                </div>
                <div class="preview-info">
                    <h4><?php echo htmlspecialchars($docente['nombres'] . ' ' . $docente['apellidos']); ?></h4>
                    <p>ID: <?php echo $docente['id_docente']; ?> •
                       Registrado: <?php echo date('d/m/Y', strtotime($docente['created_at'] ?? 'now')); ?></p>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Formulario -->
        <form method="POST" action="" id="docenteForm">
            <!-- Secciones del formulario -->
            <div class="form-grid">
                <!-- Información Personal -->
                <div class="form-section personal">
                    <h4>👤 Información Personal</h4>

                    <div class="form-group">
                        <label for="nombres">Nombres *</label>
                        <input type="text"
                               id="nombres"
                               name="nombres"
                               class="form-control"
                               value="<?php echo htmlspecialchars($docente['nombres'] ?? ''); ?>"
                               required
                               placeholder="Ej: Juan Carlos">
                    </div>

                    <div class="form-group">
                        <label for="apellidos">Apellidos *</label>
                        <input type="text"
                               id="apellidos"
                               name="apellidos"
                               class="form-control"
                               value="<?php echo htmlspecialchars($docente['apellidos'] ?? ''); ?>"
                               required
                               placeholder="Ej: García López">
                    </div>
                </div>

                <!-- Información de Contacto -->
                <div class="form-section contact">
                    <h4>📧 Información de Contacto</h4>

                    <div class="form-group">
                        <label for="correo">Correo Electrónico</label>
                        <input type="email"
                               id="correo"
                               name="correo"
                               class="form-control"
                               value="<?php echo htmlspecialchars($docente['correo'] ?? ''); ?>"
                               placeholder="Ej: juan.garcia@instituto.edu">
                        <small style="color: #666; font-size: 0.875rem;">
                            📧 Formato: usuario@dominio.com
                        </small>
                    </div>

                    <div class="form-group">
                        <label for="telefono">Teléfono</label>
                        <input type="tel"
                               id="telefono"
                               name="telefono"
                               class="form-control"
                               value="<?php echo htmlspecialchars($docente['telefono'] ?? ''); ?>"
                               placeholder="Ej: +51 987 654 321">
                        <small style="color: #666; font-size: 0.875rem;">
                            📞 Incluye código de país si es necesario
                        </small>
                    </div>
                </div>
            </div>

            <!-- Especialidad -->
            <div class="form-section specialty">
                <h4>🎓 Especialidad Académica</h4>

                <div class="form-group">
                    <label for="especialidad">Especialidades y Materias</label>
                    <textarea id="especialidad"
                              name="especialidad"
                              class="form-control"
                              rows="4"
                              placeholder="Ej: Programación Web, Bases de Datos, Desarrollo de Software, JavaScript, PHP, MySQL..."
                              style="resize: vertical;"><?php echo htmlspecialchars($docente['especialidad'] ?? ''); ?></textarea>
                    <small style="color: #666; font-size: 0.875rem;">
                        💡 Separa múltiples especialidades con comas. Ej: "Programación Web, Bases de Datos, JavaScript"
                    </small>
                </div>

                <!-- Especialidades sugeridas -->
                <div class="suggested-specialties">
                    <label>🏷️ Especialidades sugeridas (haz clic para agregar):</label>
                    <div class="specialty-tags" id="especialidadesSugeridas">
                        <?php
                        $especialidades_sugeridas = [
                            'Programación Web', 'Bases de Datos', 'Desarrollo de Software',
                            'JavaScript', 'PHP', 'Python', 'Java', 'C++', 'HTML/CSS',
                            'React', 'Angular', 'Vue.js', 'Node.js', 'MySQL', 'PostgreSQL',
                            'MongoDB', 'Análisis de Sistemas', 'Arquitectura de Software',
                            'Redes de Computadoras', 'Ciberseguridad', 'Inteligencia Artificial',
                            'Machine Learning', 'Diseño UI/UX', 'Metodologías Ágiles'
                        ];

                        foreach ($especialidades_sugeridas as $esp): ?>
                        <button type="button"
                                class="specialty-tag"
                                onclick="agregarEspecialidad('<?php echo $esp; ?>')">
                            <?php echo $esp; ?>
                        </button>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Botones de acción -->
            <div class="form-actions">
                <div class="required-note">
                    <span style="color: #666; font-size: 0.875rem;">* Campos obligatorios</span>
                </div>

                <div class="action-buttons">
                    <a href="<?php echo BASE_URL; ?>views/docentes_list.php" class="btn btn-cancel">
                        ❌ Cancelar
                    </a>

                    <?php if ($isEditing): ?>
                    <button type="submit" class="btn btn-warning">
                        💾 Actualizar Docente
                    </button>
                    <?php else: ?>
                    <button type="submit" class="btn btn-success">
                        ➕ Crear Docente
                    </button>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    // Agregar especialidad sugerida
    function agregarEspecialidad(especialidad) {
        const textarea = document.getElementById('especialidad');
        const currentValue = textarea.value.trim();

        // Verificar si ya existe
        if (currentValue.toLowerCase().includes(especialidad.toLowerCase())) {
            return;
        }

        // Agregar la especialidad
        if (currentValue === '') {
            textarea.value = especialidad;
        } else {
            textarea.value = currentValue + ', ' + especialidad;
        }

        // Animar el botón
        event.target.style.transform = 'scale(0.95)';
        event.target.style.background = 'rgba(72, 187, 120, 0.2)';
        event.target.style.borderColor = '#48bb78';
        event.target.style.color = '#22543d';

        setTimeout(() => {
            event.target.style.transform = 'scale(1)';
        }, 150);

        // Enfocar textarea
        textarea.focus();
    }

    // Validación en tiempo real
    document.getElementById('nombres').addEventListener('input', function() {
        validateField(this);
    });

    document.getElementById('apellidos').addEventListener('input', function() {
        validateField(this);
    });

    document.getElementById('correo').addEventListener('input', function() {
        validateEmail(this);
    });

    function validateField(field) {
        if (field.value.trim() === '') {
            field.style.borderColor = '#f56565';
            field.style.background = 'rgba(245, 101, 101, 0.05)';
        } else {
            field.style.borderColor = '#48bb78';
            field.style.background = 'rgba(72, 187, 120, 0.05)';
        }
    }

    function validateEmail(field) {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (field.value !== '' && !emailRegex.test(field.value)) {
            field.style.borderColor = '#f56565';
            field.style.background = 'rgba(245, 101, 101, 0.05)';
        } else {
            field.style.borderColor = field.value === '' ? '#e2e8f0' : '#48bb78';
            field.style.background = field.value === '' ? 'rgba(255, 255, 255, 0.8)' : 'rgba(72, 187, 120, 0.05)';
        }
    }

    // Validación del formulario antes de enviar
    document.getElementById('docenteForm').addEventListener('submit', function(e) {
        const nombres = document.getElementById('nombres').value.trim();
        const apellidos = document.getElementById('apellidos').value.trim();

        if (nombres === '' || apellidos === '') {
            e.preventDefault();
            alert('⚠️ Los campos Nombres y Apellidos son obligatorios.');
            return false;
        }

        // Mostrar indicador de carga
        const submitButton = e.target.querySelector('button[type="submit"]');
        const originalText = submitButton.innerHTML;
        submitButton.innerHTML = '<span class="loading"></span> Guardando...';
        submitButton.disabled = true;

        // Si hay error, restaurar botón
        setTimeout(() => {
            submitButton.innerHTML = originalText;
            submitButton.disabled = false;
        }, 5000);
    });

    // Animar entrada del formulario
    document.addEventListener('DOMContentLoaded', function() {
        const formSections = document.querySelectorAll('.form-container > *');
        formSections.forEach((section, index) => {
            section.style.opacity = '0';
            section.style.transform = 'translateY(20px)';
            setTimeout(() => {
                section.style.transition = 'all 0.4s ease';
                section.style.opacity = '1';
                section.style.transform = 'translateY(0)';
            }, index * 100);
        });
    });
</script>

<?php require_once __DIR__ . '/include/footer.php'; ?>
