<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../config/database.php';

class Carrera {
    private $conexion;

    public function __construct() {
        $this->conexion = conectarDB();
    }
public function getConexion() {
        return $this->conexion;
    }
    public function obtenerTodas() {
        $query = "SELECT * FROM carreras";
        $resultado = $this->conexion->query($query);
        $carreras = [];
        while ($fila = $resultado->fetch_assoc()) {
            $carreras[] = $fila;
        }
        return $carreras;
    }

    public function obtenerCarreraPorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM carreras WHERE id_carrera = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        return $resultado->fetch_assoc();
    }
}


