<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';

class Docente {
    private $conexion;

    public function __construct() {
        $this->conexion = conectarDB();
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

    public function guardarDocente($nombres, $apellidos, $correo, $telefono, $especialidad) {
        $stmt = $this->conexion->prepare("INSERT INTO docentes (nombres, apellidos, correo, telefono, especialidad) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $nombres, $apellidos, $correo, $telefono, $especialidad);
        return $stmt->execute();
    }

    public function actualizarDocente($id, $nombres, $apellidos, $correo, $telefono, $especialidad) {
        $stmt = $this->conexion->prepare("UPDATE docentes SET nombres=?, apellidos=?, correo=?, telefono=?, especialidad=? WHERE id_docente=?");
        $stmt->bind_param("sssssi", $nombres, $apellidos, $correo, $telefono, $especialidad, $id);
        return $stmt->execute();
    }

    public function eliminarDocente($id) {
        $stmt = $this->conexion->prepare("DELETE FROM docentes WHERE id_docente=?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>
