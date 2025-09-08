<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../config/database.php';

class Curso {
    private $conexion;

    public function __construct() {
        $this->conexion = conectarDB();
    }

    public function getConexion() {
        return $this->conexion;
    }

    public function obtenerCursosPorCarrera($id_carrera) {
        $stmt = $this->conexion->prepare("SELECT * FROM cursos WHERE id_carrera = ?");
        $stmt->bind_param("i", $id_carrera);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $cursos = [];
        while ($fila = $resultado->fetch_assoc()) {
            $cursos[] = $fila;
        }
        return $cursos;
    }
}
?>
