<?php
require_once __DIR__ . '/../models/Docente.php';

class DocenteController {
    private $docenteModel;

    public function __construct() {
        $this->docenteModel = new Docente();
    }

    public function listarDocentes() {
        return $this->docenteModel->obtenerDocentes();
    }

    public function obtenerDocente($id) {
        return $this->docenteModel->obtenerDocentePorId($id);
    }

    public function crearDocente($nombres, $apellidos, $correo, $telefono, $especialidad) {
        return $this->docenteModel->guardarDocente($nombres, $apellidos, $correo, $telefono, $especialidad);
    }

    public function editarDocente($id, $nombres, $apellidos, $correo, $telefono, $especialidad) {
        return $this->docenteModel->actualizarDocente($id, $nombres, $apellidos, $correo, $telefono, $especialidad);
    }

    public function borrarDocente($id) {
        return $this->docenteModel->eliminarDocente($id);
    }
    
}
?>
