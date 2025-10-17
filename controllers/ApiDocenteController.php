<?php
require_once __DIR__ . '/../models/TokenApi.php';
require_once __DIR__ . '/../models/Docente.php';
require_once __DIR__ . '/../models/ClientApi.php';
require_once __DIR__ . '/../models/Carrera.php';

class ApiDocenteController
{
    private $tokenApiModel;
    private $docenteModel;
    private $clientApiModel;
    private $carreraModel;

    public function __construct()
    {
        $this->tokenApiModel = new TokenApi();
        $this->docenteModel = new Docente();
        $this->clientApiModel = new ClientApi();
        $this->carreraModel = new Carrera();
    }

    public function buscarDocentesPorTokenYNombre($token, $searchTerm)
    {
        // 1. Validar el token
        $token_arr = explode("-", $token);
        if (count($token_arr) < 3) {
            return ['status' => false, 'msg' => 'Token inválido.'];
        }

        // 2. Verificar que el token exista y esté activo
        $stmt = $this->tokenApiModel->getConexion()->prepare("
            SELECT t.*, c.estado as cliente_estado
            FROM tokens_api t
            JOIN client_api c ON t.id_client_api = c.id
            WHERE t.token = ? AND t.estado = 1 AND c.estado = 1
        ");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $token_data = $resultado->fetch_assoc();

        if (!$token_data) {
            return ['status' => false, 'msg' => 'Token no válido o cliente inactivo.'];
        }

        // 3. Buscar docentes por nombre o apellidos
        $searchTerm = "%" . $searchTerm . "%";
        $query = "
            SELECT d.*, c.nombre as carrera_nombre
            FROM docentes d
            LEFT JOIN carreras c ON d.id_carrera = c.id_carrera
            WHERE (d.nombres LIKE ? OR d.apellidos LIKE ?)
        ";
        $stmt = $this->docenteModel->getConexion()->prepare($query);
        $stmt->bind_param("ss", $searchTerm, $searchTerm);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $docentes = [];
        while ($fila = $resultado->fetch_assoc()) {
            // No incluir correo ni teléfono en la respuesta
            unset($fila['correo'], $fila['telefono']);
            $docentes[] = $fila;
        }

        // 4. Formatear la respuesta
        return [
            'status' => true,
            'msg' => 'Búsqueda completada.',
            'cliente' => $token_data['id_client_api'],
            'docentes' => $docentes
        ];
    }
}
?>
