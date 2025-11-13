 <?php
header('Content-Type: application/json');
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/controllers/TokenApiController.php';
require_once __DIR__ . '/controllers/DocenteController.php';

// Obtener el token y la acción
$token = $_POST['token'] ?? '';
$action = $_GET['action'] ?? '';

// Validar que el token no esté vacío
if (empty($token)) {
    echo json_encode([
        'status' => false,
        'type' => 'error',
        'msg' => 'Token no proporcionado.'
    ]);
    exit();
}

// Validar el token en la base de datos de APIDOCENTES
$tokenController = new TokenApiController();
$tokenData = $tokenController->obtenerTokenPorToken($token);

if (!$tokenData) {
    echo json_encode([
        'status' => false,
        'type' => 'error',
        'msg' => 'Token no encontrado en la base de datos de APIDOCENTES.'
    ]);
    exit();
}

if ($tokenData['estado'] != 1) {
    echo json_encode([
        'status' => false,
        'type' => 'warning',
        'msg' => 'Token inactivo en la base de datos de APIDOCENTES.'
    ]);
    exit();
}

// Procesar la acción
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
