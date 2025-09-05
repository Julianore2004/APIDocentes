<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
require_once __DIR__ . '/../config/database.php';

class Carrera {
    private $conexion;

    public function __construct() {
        $this->conexion = conectarDB();
    }

    public function obtenerTodas() {
        $query = "SELECT * FROM carreras";
        $result = $this->conexion->query($query);

        $carreras = array();
        while ($row = $result->fetch_assoc()) {
            $carreras[] = $row;
        }

        return $carreras;
    }
}
?>

