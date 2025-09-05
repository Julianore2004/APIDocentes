<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
session_start();
require_once __DIR__ . '/../config/database.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'views/login.php');
    exit();
}

// Manejar eliminación
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    require_once __DIR__ . '/../controllers/DocenteController.php';
    $docenteController = new DocenteController();
    if ($docenteController->borrarDocente($_GET['delete'])) {
        $mensaje = "✅ Docente eliminado exitosamente";
        $tipo_mensaje = "success";
    } else {
        $mensaje = "❌ Error al eliminar el docente";
        $tipo_mensaje = "error";
    }
}

// Obtener lista de docentes
require_once __DIR__ . '/../controllers/DocenteController.php';
$docenteController = new DocenteController();
$docentes = $docenteController->listarDocentes();

// Obtener lista de carreras
require_once __DIR__ . '/../models/Carrera.php';
$carreraModel = new Carrera();
$carreras = $carreraModel->obtenerTodas();

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
    /* Contenedor de la tabla */
    .table-container {
        background: white;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }
    /* Encabezado de la tabla */
    .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: rgba(102, 126, 234, 0.05);
        border-bottom: 1px solid #e2e8f0;
    }
    .table-header h3 {
        color: #2d3748;
        margin: 0;
    }
    /* Barra de búsqueda y filtros */
    .search-filter-container {
        padding: 1.5rem;
        background: rgba(102, 126, 234, 0.05);
        border-bottom: 1px solid #e2e8f0;
    }
    .search-filter {
        display: flex;
        gap: 1rem;
        align-items: center;
        flex-wrap: wrap;
    }
    .form-control {
        padding: 0.75rem;
        border: 1px solid #e2e8f0;
        border-radius: 5px;
        font-size: 1rem;
        flex: 1;
        min-width: 200px;
    }
    /* Tabla */
    .table {
        width: 100%;
        border-collapse: collapse;
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
        cursor: pointer;
    }
    .sort-indicator {
        margin-left: 0.5rem;
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
    /* Especialidades */
    .especialidad-badge {
        background: rgba(102, 126, 234, 0.1);
        color: #667eea;
        padding: 0.25rem 0.5rem;
        border-radius: 5px;
        font-size: 0.75rem;
        margin: 0.25rem;
        display: inline-block;
    }
    /* Carrera */
    .carrera-badge {
        background: rgba(76, 175, 80, 0.1);
        color: #4caf50;
        padding: 0.25rem 0.5rem;
        border-radius: 5px;
        font-size: 0.75rem;
        margin: 0.25rem;
        display: inline-block;
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
    .btn-small {
        padding: 0.375rem 0.75rem;
        font-size: 0.875rem;
    }
    .table-actions {
        display: flex;
        gap: 0.5rem;
    }
    /* Estado vacío */
    .empty-state {
        padding: 3rem;
        text-align: center;
        color: #666;
    }
    .empty-state-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
    }
    /* Estadísticas del listado */
    .table-stats {
        padding: 1rem 2rem;
        background: rgba(102, 126, 234, 0.05);
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }
</style>

<div class="container fade-in">
    <!-- Mensajes -->
    <?php if (isset($mensaje)): ?>
    <div class="message <?php echo $tipo_mensaje; ?>">
        <?php echo $mensaje; ?>
    </div>
    <?php endif; ?>
    <div class="table-container">
        <div class="table-header">
            <h3>👥 Gestión de Docentes</h3>
            <a href="<?php echo BASE_URL; ?>views/docente_form.php" class="btn btn-success">
                ➕ Agregar Nuevo Docente
            </a>
        </div>
        <?php if (empty($docentes)): ?>
        <div class="empty-state">
            <div class="empty-state-icon">👨‍🏫</div>
            <h3>No hay docentes registrados</h3>
            <p>Comienza agregando tu primer docente al sistema.</p>
            <a href="<?php echo BASE_URL; ?>views/docente_form.php" class="btn" style="margin-top: 1rem;">
                ➕ Agregar Primer Docente
            </a>
        </div>
        <?php else: ?>
        <!-- Barra de búsqueda y filtros -->
        <div class="search-filter-container">
            <div class="search-filter">
                <input type="text" id="searchDocente" placeholder="🔍 Buscar por nombre, correo o especialidad..."
                       class="form-control">
                <select id="filterEspecialidad" class="form-control" style="width: 200px;">
                    <option value="">📚 Todas las especialidades</option>
                </select>
                <select id="filterCarrera" class="form-control" style="width: 200px;">
                    <option value="">🎓 Todas las carreras</option>
                    <?php foreach ($carreras as $carrera): ?>
                        <option value="<?php echo $carrera['id_carrera']; ?>">
                            <?php echo htmlspecialchars($carrera['nombre']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <button onclick="clearFilters()" class="btn btn-small">🔄 Limpiar filtros</button>
            </div>
        </div>
        <div style="overflow-x: auto;">
            <table class="table" id="docentesTable">
                <thead>
                    <tr>
                        <th onclick="sortTable(0)">
                            👤 Nombre Completo <span class="sort-indicator">↕️</span>
                        </th>
                        <th onclick="sortTable(1)">
                            📧 Correo <span class="sort-indicator">↕️</span>
                        </th>
                        <th onclick="sortTable(2)">
                            📞 Teléfono <span class="sort-indicator">↕️</span>
                        </th>
                        <th onclick="sortTable(3)">
                            🎓 Especialidad <span class="sort-indicator">↕️</span>
                        </th>
                        <th onclick="sortTable(4)">
                            🏫 Carrera <span class="sort-indicator">↕️</span>
                        </th>
                        <th style="width: 150px;">⚡ Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($docentes as $docente): ?>
                    <tr data-docente='<?php echo json_encode($docente); ?>'>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <div class="docente-avatar">
                                    <?php echo strtoupper(substr($docente['nombres'], 0, 1) . substr($docente['apellidos'], 0, 1)); ?>
                                </div>
                                <div>
                                    <strong><?php echo htmlspecialchars($docente['nombres'] . ' ' . $docente['apellidos']); ?></strong>
                                    <br>
                                    <small style="color: #666;">ID: <?php echo $docente['id_docente']; ?></small>
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
                            <?php if (!empty($docente['telefono'])): ?>
                                <a href="tel:<?php echo htmlspecialchars($docente['telefono']); ?>"
                                   style="color: #667eea; text-decoration: none;">
                                    <?php echo htmlspecialchars($docente['telefono']); ?>
                                </a>
                            <?php else: ?>
                                <span style="color: #999;">No especificado</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($docente['especialidad'])): ?>
                                <div style="max-width: 300px;">
                                    <?php
                                    $especialidades = explode(',', $docente['especialidad']);
                                    foreach (array_slice($especialidades, 0, 2) as $esp):
                                    ?>
                                    <span class="especialidad-badge">
                                        <?php echo htmlspecialchars(trim($esp)); ?>
                                    </span>
                                    <?php endforeach; ?>
                                    <?php if (count($especialidades) > 2): ?>
                                    <span style="color: #666; font-size: 0.875rem;">+<?php echo count($especialidades) - 2; ?> más</span>
                                    <?php endif; ?>
                                </div>
                            <?php else: ?>
                                <span style="color: #999;">Sin especialidad</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($docente['id_carrera'])): ?>
                                <?php
                                $carreraNombre = '';
                                foreach ($carreras as $carrera) {
                                    if ($carrera['id_carrera'] == $docente['id_carrera']) {
                                        $carreraNombre = $carrera['nombre'];
                                        break;
                                    }
                                }
                                ?>
                                <span class="carrera-badge">
                                    <?php echo htmlspecialchars($carreraNombre); ?>
                                </span>
                            <?php else: ?>
                                <span style="color: #999;">Sin carrera asignada</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <div class="table-actions">
                                <a href="<?php echo BASE_URL; ?>views/docente_form.php?edit=<?php echo $docente['id_docente']; ?>"
                                   class="btn btn-small btn-warning" title="Editar docente">
                                    ✏️
                                </a>
                                <button onclick="confirmarEliminacion(<?php echo $docente['id_docente']; ?>, '<?php echo addslashes($docente['nombres'] . ' ' . $docente['apellidos']); ?>')"
                                        class="btn btn-small btn-danger" title="Eliminar docente">
                                    🗑️
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        <!-- Estadísticas del listado -->
        <div class="table-stats">
            <div>
                📊 <strong>Total: <?php echo count($docentes); ?> docentes</strong>
            </div>
            <div>
                <span id="filteredCount" style="color: #667eea;"></span>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<script>
    // Variables globales
    let docentesData = <?php echo json_encode($docentes); ?>;
    let carrerasData = <?php echo json_encode($carreras); ?>;
    let currentSort = { column: -1, direction: 'asc' };

    // Búsqueda en tiempo real
    document.getElementById('searchDocente').addEventListener('input', filterTable);
    document.getElementById('filterEspecialidad').addEventListener('change', filterTable);
    document.getElementById('filterCarrera').addEventListener('change', filterTable);

    // Poblar filtro de especialidades
    function populateEspecialidadFilter() {
        const especialidadSelect = document.getElementById('filterEspecialidad');
        const especialidades = new Set();

        docentesData.forEach(docente => {
            if (docente.especialidad) {
                docente.especialidad.split(',').forEach(esp => {
                    especialidades.add(esp.trim());
                });
            }
        });

        Array.from(especialidades).sort().forEach(esp => {
            const option = document.createElement('option');
            option.value = esp;
            option.textContent = esp;
            especialidadSelect.appendChild(option);
        });
    }

    // Filtrar tabla
    function filterTable() {
        const searchTerm = document.getElementById('searchDocente').value.toLowerCase();
        const especialidadFilter = document.getElementById('filterEspecialidad').value.toLowerCase();
        const carreraFilter = document.getElementById('filterCarrera').value;
        const rows = document.querySelectorAll('#docentesTable tbody tr');
        let visibleCount = 0;

        rows.forEach(row => {
            const docenteData = JSON.parse(row.getAttribute('data-docente'));
            const nombreCompleto = (docenteData.nombres + ' ' + docenteData.apellidos).toLowerCase();
            const correo = (docenteData.correo || '').toLowerCase();
            const telefono = (docenteData.telefono || '').toLowerCase();
            const especialidad = (docenteData.especialidad || '').toLowerCase();
            const idCarrera = docenteData.id_carrera ? docenteData.id_carrera.toString() : '';

            const matchesSearch = searchTerm === '' ||
                nombreCompleto.includes(searchTerm) ||
                correo.includes(searchTerm) ||
                telefono.includes(searchTerm) ||
                especialidad.includes(searchTerm);

            const matchesEspecialidad = especialidadFilter === '' ||
                especialidad.includes(especialidadFilter);

            const matchesCarrera = carreraFilter === '' ||
                idCarrera === carreraFilter;

            if (matchesSearch && matchesEspecialidad && matchesCarrera) {
                row.style.display = '';
                visibleCount++;
            } else {
                row.style.display = 'none';
            }
        });

        document.getElementById('filteredCount').textContent =
            visibleCount < docentesData.length ? `Mostrando ${visibleCount} de ${docentesData.length}` : '';
    }

    // Limpiar filtros
    function clearFilters() {
        document.getElementById('searchDocente').value = '';
        document.getElementById('filterEspecialidad').value = '';
        document.getElementById('filterCarrera').value = '';
        filterTable();
    }

    // Ordenar tabla
    function sortTable(columnIndex) {
        const table = document.getElementById('docentesTable');
        const tbody = table.tBodies[0];
        const rows = Array.from(tbody.querySelectorAll('tr'));

        // Determinar dirección de ordenamiento
        if (currentSort.column === columnIndex) {
            currentSort.direction = currentSort.direction === 'asc' ? 'desc' : 'asc';
        } else {
            currentSort.column = columnIndex;
            currentSort.direction = 'asc';
        }

        // Ordenar filas
        rows.sort((a, b) => {
            const aData = JSON.parse(a.getAttribute('data-docente'));
            const bData = JSON.parse(b.getAttribute('data-docente'));

            let aValue, bValue;

            switch(columnIndex) {
                case 0: // Nombre
                    aValue = aData.nombres + ' ' + aData.apellidos;
                    bValue = bData.nombres + ' ' + bData.apellidos;
                    break;
                case 1: // Correo
                    aValue = aData.correo || '';
                    bValue = bData.correo || '';
                    break;
                case 2: // Teléfono
                    aValue = aData.telefono || '';
                    bValue = bData.telefono || '';
                    break;
                case 3: // Especialidad
                    aValue = aData.especialidad || '';
                    bValue = bData.especialidad || '';
                    break;
                case 4: // Carrera
                    const carreraA = carrerasData.find(c => c.id_carrera == aData.id_carrera);
                    const carreraB = carrerasData.find(c => c.id_carrera == bData.id_carrera);
                    aValue = carreraA ? carreraA.nombre : '';
                    bValue = carreraB ? carreraB.nombre : '';
                    break;
            }

            const comparison = aValue.localeCompare(bValue);
            return currentSort.direction === 'asc' ? comparison : -comparison;
        });

        // Actualizar indicadores de ordenamiento
        document.querySelectorAll('.sort-indicator').forEach((indicator, index) => {
            if (index === columnIndex) {
                indicator.textContent = currentSort.direction === 'asc' ? '↑' : '↓';
            } else {
                indicator.textContent = '↕️';
            }
        });

        // Reordenar DOM
        rows.forEach(row => tbody.appendChild(row));
    }

    // Confirmar eliminación
    function confirmarEliminacion(id, nombre) {
        if (confirm(`¿Estás seguro de que deseas eliminar al docente "${nombre}"?\n\nEsta acción no se puede deshacer.`)) {
            window.location.href = `<?php echo BASE_URL; ?>views/docentes_list.php?delete=${id}`;
        }
    }

    // Inicializar al cargar
    document.addEventListener('DOMContentLoaded', function() {
        populateEspecialidadFilter();

        // Animar entrada de filas
        const rows = document.querySelectorAll('#docentesTable tbody tr');
        rows.forEach((row, index) => {
            row.style.opacity = '0';
            row.style.transform = 'translateY(20px)';
            setTimeout(() => {
                row.style.transition = 'all 0.3s ease';
                row.style.opacity = '1';
                row.style.transform = 'translateY(0)';
            }, index * 50);
        });
    });
</script>

<?php require_once __DIR__ . '/include/footer.php'; ?>
