<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/database.php';

class Usuario {
    private $conexion;

    public function __construct() {
        $this->conexion = conectarDB();
    }

   public function validarUsuario($username, $password) {
    $stmt = $this->conexion->prepare("SELECT * FROM usuarios WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $usuario = $resultado->fetch_assoc();
    
    // Debug temporal
    error_log("Usuario encontrado: " . ($usuario ? 'SÍ' : 'NO'));
    if ($usuario) {
        error_log("Hash en BD: " . $usuario['password']);
        error_log("Password ingresada: " . $password);
        error_log("Verificación: " . (password_verify($password, $usuario['password']) ? 'CORRECTA' : 'INCORRECTA'));
    }
    
    if ($usuario && password_verify($password, $usuario['password'])) {
        return $usuario;
    }
    return false;
}

}
?>
