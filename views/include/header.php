<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Docentes</title>
    <link rel="stylesheet" href="<?php echo BASE_URL; ?>public/css/style.css">
</head>
<body>
    <header>
        <h1>Instituto API Docentes</h1>
        <nav>
            <a href="<?php echo BASE_URL; ?>views/dashboard.php">Dashboard</a>
            <a href="<?php echo BASE_URL; ?>views/docentes_list.php">Docentes</a>
            
            <!-- Múltiples opciones de logout para asegurar que funcione -->
            <a href="<?php echo BASE_URL; ?>logout.php">Cerrar Sesión</a>
            
            <!-- Alternativa con JavaScript -->
            <a href="#" onclick="logout(); return false;">Logout (JS)</a>
        </nav>
    </header>
    
    <script>
    function logout() {
        if (confirm('¿Estás seguro de que deseas cerrar sesión?')) {
            // Intentar múltiples métodos
            window.location.href = '<?php echo BASE_URL; ?>logout.php';
        }
    }
    </script>