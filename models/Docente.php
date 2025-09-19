<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../config/database.php';

class Docente {
    private $conexion;

    public function __construct() {
        $this->conexion = conectarDB();
    }
public function getConexion() {
        return $this->conexion;
    }
    public function obtenerDocentes() {
        $query = "SELECT * FROM docentes";
        $resultado = $this->conexion->query($query);
        $docentes = [];
        while ($fila = $resultado->fetch_assoc()) {
            $docentes[] = $fila;
        }
        return $docentes;
    }

    public function obtenerDocentePorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM docentes WHERE id_docente = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }

    public function obtenerCursosPorDocente($id_docente) {
        $query = "
            SELECT c.* FROM cursos c
            INNER JOIN docente_curso dc ON c.id_curso = dc.id_curso
            WHERE dc.id_docente = ?
        ";
        $stmt = $this->conexion->prepare($query);
        $stmt->bind_param("i", $id_docente);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $cursos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $cursos[] = $fila;
        }
        return $cursos;
    }

    public function guardarDocente($nombres, $apellidos, $correo, $telefono, $id_carrera) {
        $stmt = $this->conexion->prepare("INSERT INTO docentes (nombres, apellidos, correo, telefono, id_carrera) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssi", $nombres, $apellidos, $correo, $telefono, $id_carrera);
        if ($stmt->execute()) {
            $id_docente = $stmt->insert_id;
            return $id_docente;
        }
        return false;
    }

    public function actualizarDocente($id, $nombres, $apellidos, $correo, $telefono, $id_carrera) {
        $stmt = $this->conexion->prepare("UPDATE docentes SET nombres=?, apellidos=?, correo=?, telefono=?, id_carrera=? WHERE id_docente=?");
        $stmt->bind_param("ssssii", $nombres, $apellidos, $correo, $telefono, $id_carrera, $id);
        return $stmt->execute();
    }

    public function eliminarDocente($id) {
        $stmt = $this->conexion->prepare("DELETE FROM docentes WHERE id_docente=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    public function asignarCursosADocente($id_docente, $cursos) {
    // Eliminar cursos anteriores
    $stmt = $this->conexion->prepare("DELETE FROM docente_curso WHERE id_docente = ?");
    $stmt->bind_param("i", $id_docente);
    $stmt->execute();

    // Asignar nuevos cursos
    if (!empty($cursos)) {
        foreach ($cursos as $id_curso) {
            $stmt = $this->conexion->prepare("INSERT INTO docente_curso (id_docente, id_curso) VALUES (?, ?)");
            $stmt->bind_param("ii", $id_docente, $id_curso);
            $stmt->execute();
        }
    }
    return true;
}

}
