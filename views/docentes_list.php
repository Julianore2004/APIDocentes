<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
require_once __DIR__ . '/include/header.php';
require_once __DIR__ . '/../controllers/DocenteController.php';

$docenteController = new DocenteController();
$docentes = $docenteController->listarDocentes();
?>
<div class="docentes-container">
    <h2>Lista de Docentes</h2>
    <a href="<?php echo BASE_URL; ?>docente_form.php" class="btn-nuevo">Nuevo Docente</a>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombres</th>
                <th>Apellidos</th>
                <th>Correo</th>
                <th>Teléfono</th>
                <th>Especialidad</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($docentes as $docente): ?>
            <tr>
                <td><?php echo $docente['id_docente']; ?></td>
                <td><?php echo $docente['nombres']; ?></td>
                <td><?php echo $docente['apellidos']; ?></td>
                <td><?php echo $docente['correo']; ?></td>
                <td><?php echo $docente['telefono']; ?></td>
                <td><?php echo $docente['especialidad']; ?></td>
                <td>
                    <a href="<?php echo BASE_URL; ?>docente_form.php?id=<?php echo $docente['id_docente']; ?>">Editar</a>
                    <a href="<?php echo BASE_URL; ?>controllers/DocenteController.php?action=borrar&id=<?php echo $docente['id_docente']; ?>" onclick="return confirm('¿Estás seguro?')">Eliminar</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php
require_once __DIR__ . '/include/footer.php';
?>
