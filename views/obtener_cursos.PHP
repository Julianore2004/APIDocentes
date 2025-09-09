<?php
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../controllers/DocenteController.php';


$docenteController = new DocenteController();
$id_carrera = isset($_GET['id_carrera']) ? intval($_GET['id_carrera']) : 0;

if ($id_carrera > 0) {
    $cursos = $docenteController->obtenerCursosPorCarrera($id_carrera);
    header('Content-Type: application/json');
    echo json_encode($cursos);
} else {
    header('Content-Type: application/json');
    echo json_encode([]);
}
?>
