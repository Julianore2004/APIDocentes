<?php
require_once __DIR__ . '/../models/Docente.php';
require_once __DIR__ . '/../models/Carrera.php';
require_once __DIR__ . '/../models/Curso.php';

class DocenteController {
    private $docenteModel;
    private $carreraModel;
    private $cursoModel;

    public function __construct() {
        $this->docenteModel = new Docente();
        $this->carreraModel = new Carrera();
        $this->cursoModel = new Curso();
    }
 public function getConexion() {
        return $this->docenteModel->getConexion();
    }

    public function listarDocentes() {
        $docentes = $this->docenteModel->obtenerDocentes();
        foreach ($docentes as &$docente) {
            $docente['cursos'] = $this->docenteModel->obtenerCursosPorDocente($docente['id_docente']);
        }
        return $docentes;
    }

    public function obtenerDocente($id) {
        return $this->docenteModel->obtenerDocentePorId($id);
    }

    public function crearDocente($nombres, $apellidos, $correo, $telefono, $id_carrera, $cursos) {
    $id_docente = $this->docenteModel->guardarDocente($nombres, $apellidos, $correo, $telefono, $id_carrera);
    if ($id_docente) {
        $this->docenteModel->asignarCursosADocente($id_docente, $cursos);
        return $id_docente;
    }
    return false;
}

public function editarDocente($id, $nombres, $apellidos, $correo, $telefono, $id_carrera, $cursos) {
    $resultado = $this->docenteModel->actualizarDocente($id, $nombres, $apellidos, $correo, $telefono, $id_carrera);
    if ($resultado) {
        $this->docenteModel->asignarCursosADocente($id, $cursos);
        return true;
    }
    return false;
}


    public function borrarDocente($id) {
        return $this->docenteModel->eliminarDocente($id);
    }

    public function obtenerCarreras() {
        return $this->carreraModel->obtenerTodas();
    }

    public function obtenerCursosPorCarrera($id_carrera) {
        return $this->cursoModel->obtenerCursosPorCarrera($id_carrera);
    }

    public function obtenerCursosPorDocente($id_docente) {
        return $this->docenteModel->obtenerCursosPorDocente($id_docente);
    }

    public function obtenerTodosLosCursos() {
        $query = "SELECT * FROM cursos";
        $resultado = $this->cursoModel->getConexion()->query($query);
        $cursos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $cursos[] = $fila;
        }
        return $cursos;
    }
   public function buscarDocentesPorNombreApellido($search)
{
    $search = "%" . $this->getConexion()->real_escape_string($search) . "%";
    $query = "
        SELECT d.*
        FROM docentes d
        WHERE d.nombres LIKE ? OR d.apellidos LIKE ?
    ";
    $stmt = $this->docenteModel->getConexion()->prepare($query);
    $stmt->bind_param("ss", $search, $search);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $docentes = [];
    while ($fila = $resultado->fetch_assoc()) {
        $docentes[] = $fila;
    }
    return $docentes;
}

public function obtenerCarreraPorId($id_carrera)
{
    require_once __DIR__ . '/../models/Carrera.php';
    $carreraModel = new Carrera();
    return $carreraModel->obtenerCarreraPorId($id_carrera);
}


}
?>
<?php
// Agrega esto al final del archivo DocenteController.php
if (isset($_GET['action']) && $_GET['action'] == 'obtenerCursosPorCarrera' && isset($_GET['id_carrera'])) {
    header('Content-Type: application/json');
    $controller = new DocenteController();
    $cursos = $controller->obtenerCursosPorCarrera($_GET['id_carrera']);
    echo json_encode($cursos);
    exit();
}
?>
