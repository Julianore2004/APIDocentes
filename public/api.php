<?php
header('Content-Type: application/json');
require_once __DIR__ . '/../controllers/ApiDocenteController.php';

$action = $_GET['action'] ?? '';
$token = $_GET['token'] ?? '';
$search = $_GET['search'] ?? '';

if ($action === 'buscar_docentes' && !empty($token) && !empty($search)) {
    $apiController = new ApiDocenteController();
    $response = $apiController->buscarDocentesPorTokenYNombre($token, $search);
    echo json_encode($response);
} else {
    echo json_encode(['status' => false, 'msg' => 'Parámetros inválidos.']);
}
?>
