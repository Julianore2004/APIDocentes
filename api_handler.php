<?php
// api_handler.php (APIDOCENTES)
header('Content-Type: application/json');
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/TokenApiController.php';

// Obtener el token y la acción
$token = $_POST['token'] ?? '';
$action = $_GET['action'] ?? '';

// Validar el token en APIDOCENTES
if ($action === 'validarToken') {
    $tokenController = new TokenApiController();
    $tokenData = $tokenController->obtenerTokenPorToken($token);

    if (!$tokenData) {
        echo json_encode([
            'status' => false,
            'type' => 'error',
            'msg' => 'Token no encontrado en APIDOCENTES.'
        ]);
        exit();
    }

    if ($tokenData['estado'] != 1) {
        echo json_encode([
            'status' => false,
            'type' => 'warning',
            'msg' => 'Token inactivo en APIDOCENTES.'
        ]);
        exit();
    }

    echo json_encode([
        'status' => true,
        'type' => 'success',
        'msg' => 'Token válido en APIDOCENTES.'
    ]);
    exit();
}

// Procesar otras acciones (buscarDocentes, etc.)
$tokenController = new TokenApiController();
$tokenData = $tokenController->obtenerTokenPorToken($token);

if (!$tokenData) {
    echo json_encode([
        'status' => false,
        'type' => 'error',
        'msg' => 'Token no encontrado en APIDOCENTES.'
    ]);
    exit();
}

if ($tokenData['estado'] != 1) {
    echo json_encode([
        'status' => false,
        'type' => 'warning',
        'msg' => 'Token inactivo en APIDOCENTES.'
    ]);
    exit();
}

// Procesar la acción (ej: buscarDocentes)
switch ($action) {
    case 'buscarDocentes':
        require_once __DIR__ . '/controllers/DocenteController.php';
        $docenteController = new DocenteController();
        $search = $_POST['search'] ?? '';
        $docentes = $docenteController->buscarDocentesPorNombreApellido($search);
        foreach ($docentes as &$docente) {
            $carrera = $docenteController->obtenerCarreraPorId($docente['id_carrera']);
            $docente['carrera_nombre'] = $carrera['nombre'] ?? 'Sin carrera';
            unset($docente['correo'], $docente['telefono']);
        }
        echo json_encode([
            'status' => true,
            'type' => 'success',
            'data' => $docentes
        ]);
        break;
    default:
        echo json_encode([
            'status' => false,
            'type' => 'error',
            'msg' => 'Acción no válida.'
        ]);
}
?>
