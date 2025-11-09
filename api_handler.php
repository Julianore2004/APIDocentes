<?php
header('Content-Type: application/json');
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/TokenApiController.php';
require_once __DIR__ . '/controllers/DocenteController.php';

// Validar token
$token = $_POST['token'] ?? '';
$action = $_GET['action'] ?? '';

if (empty($token)) {
    echo json_encode(['status' => false, 'msg' => 'Token no proporcionado.']);
    exit();
}

// Validar token en la base de datos
$tokenController = new TokenApiController();
$tokenData = $tokenController->obtenerTokenPorToken($token);

if (!$tokenData || $tokenData['estado'] != 1) {
    echo json_encode(['status' => false, 'msg' => 'Token inválido o inactivo.']);
    exit();
}

// Procesar acción
$docenteController = new DocenteController();
switch ($action) {
    case 'buscarDocentes':
        $search = $_POST['search'] ?? '';
        $docentes = $docenteController->buscarDocentesPorNombreApellido($search);
        foreach ($docentes as &$docente) {
            $carrera = $docenteController->obtenerCarreraPorId($docente['id_carrera']);
            $docente['carrera_nombre'] = $carrera['nombre'] ?? 'Sin carrera';
            unset($docente['correo'], $docente['telefono']); // Ocultar información sensible
        }
        echo json_encode(['status' => true, 'data' => $docentes]);
        break;
    default:
        echo json_encode(['status' => false, 'msg' => 'Acción no válida.']);
}
?>
