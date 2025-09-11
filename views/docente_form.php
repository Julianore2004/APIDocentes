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

// Obtener carreras
$carreras = $docenteController->obtenerCarreras();

// Determinar si es edición o creación
$isEditing = isset($_GET['edit']) && is_numeric($_GET['edit']);
$docente = null;
$pageTitle = $isEditing ? '✏️ Editar Docente' : '➕ Agregar Nuevo Docente';
$cursosAsignados = [];

if ($isEditing) {
    $docente = $docenteController->obtenerDocente($_GET['edit']);
    if (!$docente) {
        header('Location: ' . BASE_URL . 'views/docentes_list.php');
        exit();
    }
    $cursosAsignados = $docenteController->obtenerCursosPorDocente($_GET['edit']);
    $cursosAsignados = array_column($cursosAsignados, 'id_curso');
}

// Procesar formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombres = trim($_POST['nombres']);
    $apellidos = trim($_POST['apellidos']);
    $correo = trim($_POST['correo']);
    $telefono = trim($_POST['telefono']);
    $id_carrera = isset($_POST['id_carrera']) ? trim($_POST['id_carrera']) : null;
    $cursos = isset($_POST['cursos']) ? $_POST['cursos'] : [];

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
    if (empty($id_carrera)) {
        $errores[] = "Debe seleccionar una carrera";
    }

    if (empty($errores)) {
        if ($isEditing) {
            $resultado = $docenteController->editarDocente($_GET['edit'], $nombres, $apellidos, $correo, $telefono, $id_carrera, $cursos);
            if ($resultado) {
                $mensaje = "✅ Docente actualizado exitosamente";
                $tipo_mensaje = "success";
                $docente = $docenteController->obtenerDocente($_GET['edit']);
            } else {
                $mensaje = "❌ Error al actualizar el docente";
                $tipo_mensaje = "error";
            }
        } else {
            $resultado = $docenteController->crearDocente($nombres, $apellidos, $correo, $telefono, $id_carrera, $cursos);
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

    .form-section.career {
        background: rgba(139, 69, 19, 0.05);
        border-left-color: #8b4513;
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

    /* Estilos para la selección de cursos */
    .cursos-container {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .curso-item {
        background-color: #f7fafc;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        padding: 0.75rem;
        cursor: pointer;
        transition: all 0.2s ease;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        min-width: 120px;
    }

    .curso-item:hover {
        background-color: #ebf8ff;
        border-color: #667eea;
    }

    .curso-item.selected {
        background-color: #667eea;
        color: white;
        border-color: #667eea;
    }

    .curso-item i {
        font-size: 0.875rem;
    }

    .curso-info {
        flex: 1;
    }

    .curso-name {
        font-weight: 500;
        font-size: 0.875rem;
    }

    .curso-type {
        font-size: 0.75rem;
        opacity: 0.8;
    }

    .curso-checkbox {
        display: none;
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

            <!-- Carrera -->
            <div class="form-section career">
                <h4>🎓 Carrera</h4>
                <div class="form-group">
                    <label for="id_carrera">Seleccione una carrera *</label>
                    <select id="id_carrera" name="id_carrera" class="form-control" required>
                        <option value="">-- Seleccione una carrera --</option>
                        <?php foreach ($carreras as $carrera): ?>
                            <option value="<?php echo $carrera['id_carrera']; ?>"
                                <?php echo (isset($docente['id_carrera']) && $docente['id_carrera'] == $carrera['id_carrera']) ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($carrera['nombre']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Cursos -->
            <div class="form-section career">
                <h4>📚 Cursos</h4>
                <div class="form-group">
                    <label>Seleccione los cursos que dictará el docente</label>
                    <div class="cursos-container" id="cursosContainer">
                        <?php
                        if ($isEditing && !empty($docente['id_carrera'])) {
                            $cursos = $docenteController->obtenerCursosPorCarrera($docente['id_carrera']);
                            foreach ($cursos as $curso): ?>
                                <div class="curso-item <?php echo in_array($curso['id_curso'], $cursosAsignados) ? 'selected' : ''; ?>"
                                     onclick="toggleCurso(this, '<?php echo $curso['id_curso']; ?>')">
                                    <input type="checkbox"
                                           class="curso-checkbox"
                                           name="cursos[]"
                                           value="<?php echo $curso['id_curso']; ?>"
                                           <?php echo in_array($curso['id_curso'], $cursosAsignados) ? 'checked' : ''; ?>>
                                    <i class="<?php echo in_array($curso['id_curso'], $cursosAsignados) ? 'fas fa-check-circle' : 'far fa-circle'; ?>"></i>
                                    <div class="curso-info">
                                        <div class="curso-name"><?php echo htmlspecialchars($curso['nombre']); ?></div>
                                        <div class="curso-type"><?php echo htmlspecialchars($curso['tipo']); ?></div>
                                    </div>
                                </div>
                        <?php endforeach;
                        } ?>
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
        </form>
    </div>
</div>

<script>
    // Función para alternar la selección de un curso
    function toggleCurso(element, id_curso) {
        const checkbox = element.querySelector('.curso-checkbox');
        const isChecked = checkbox.checked;

        if (isChecked) {
            checkbox.checked = false;
            element.classList.remove('selected');
            element.querySelector('i').className = 'far fa-circle';
        } else {
            checkbox.checked = true;
            element.classList.add('selected');
            element.querySelector('i').className = 'fas fa-check-circle';
        }
    }

    // Cargar cursos según la carrera seleccionada
    document.getElementById('id_carrera').addEventListener('change', function() {
        const id_carrera = this.value;
        const cursosContainer = document.getElementById('cursosContainer');

        if (id_carrera) {
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '<?php echo BASE_URL; ?>controllers/DocenteController.php?action=obtenerCursosPorCarrera&id_carrera=' + id_carrera, true);
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const cursos = JSON.parse(xhr.responseText);
                    cursosContainer.innerHTML = '';
                    cursos.forEach(curso => {
                        const div = document.createElement('div');
                        div.className = 'curso-item';
                        div.onclick = function() { toggleCurso(this, curso.id_curso); };
                        div.innerHTML = `
                            <input type="checkbox" class="curso-checkbox" name="cursos[]" value="${curso.id_curso}">
                            <i class="far fa-circle"></i>
                            <div class="curso-info">
                                <div class="curso-name">${curso.nombre}</div>
                                <div class="curso-type">${curso.tipo}</div>
                            </div>
                        `;
                        cursosContainer.appendChild(div);
                    });
                }
            };
            xhr.send();
        } else {
            cursosContainer.innerHTML = '';
        }
    });

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
        const id_carrera = document.getElementById('id_carrera').value;

        if (nombres === '' || apellidos === '' || id_carrera === '') {
            e.preventDefault();
            alert('⚠️ Los campos Nombres, Apellidos y Carrera son obligatorios.');
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

        // Cargar cursos si hay una carrera seleccionada al cargar la página (para edición)
        const carreraSeleccionada = document.getElementById('id_carrera').value;
        if (carreraSeleccionada) {
            const event = new Event('change');
            document.getElementById('id_carrera').dispatchEvent(event);
        }
    });
</script>

<?php require_once __DIR__ . '/include/footer.php'; ?>
                