<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: ' . BASE_URL . 'login.php');
    exit();
}
require_once __DIR__ . '/include/header.php';
require_once __DIR__ . '/../controllers/DocenteController.php';

$docenteController = new DocenteController();
$docente = null;
if (isset($_GET['id'])) {
    $docente = $docenteController->obtenerDocente($_GET['id']);
}
?>
<div class="form-container">
    <h2><?php echo $docente ? 'Editar Docente' : 'Nuevo Docente'; ?></h2>
    <form action="<?php echo BASE_URL; ?>controllers/DocenteController.php?action=<?php echo $docente ? 'editar' : 'crear'; ?>" method="POST">
        <?php if ($docente): ?>
            <input type="hidden" name="id" value="<?php echo $docente['id_docente']; ?>">
        <?php endif; ?>
        <input type="text" name="nombres" placeholder="Nombres" value="<?php echo $docente ? $docente['nombres'] : ''; ?>" required>
        <input type="text" name="apellidos" placeholder="Apellidos" value="<?php echo $docente ? $docente['apellidos'] : ''; ?>" required>
        <input type="email" name="correo" placeholder="Correo" value="<?php echo $docente ? $docente['correo'] : ''; ?>">
        <input type="text" name="telefono" placeholder="Teléfono" value="<?php echo $docente ? $docente['telefono'] : ''; ?>">
        <input type="text" name="especialidad" placeholder="Especialidad" value="<?php echo $docente ? $docente['especialidad'] : ''; ?>" required>
        <button type="submit">Guardar</button>
    </form>
</div>
<?php
require_once __DIR__ . '/include/footer.php';
?>
