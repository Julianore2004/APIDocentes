<?php
require_once __DIR__ . '/../../controllers/TokenApiController.php';
$tokenController = new TokenApiController();
$tokens = $tokenController->listarTokens();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API Docentes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .card-docente {
            border-left: 4px solid #667eea;
            margin-bottom: 1rem;
        }
        .card-docente .card-header {
            background-color: #f8f9fa;
            font-weight: bold;
        }
        .carrera-badge {
            background-color: #e3f2fd;
            color: #1976d2;
            padding: 0.25rem 0.5rem;
            border-radius: 0.25rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2>API de Docentes</h2>
        <div class="card mt-4">
            <div class="card-header">
                <h5>Configuración</h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="tokenInput" class="form-label">Token:</label>
                    <input type="text" class="form-control" id="tokenInput" value="589e4cf1e5c2024e8d74d482b4bad2df-20251003-02" readonly>
                    <small class="text-muted">Cambia este valor en el código si es necesario.</small>
                </div>
                <div class="mb-3">
                    <label for="searchInput" class="form-label">Buscar por nombre o apellidos:</label>
                    <input type="text" class="form-control" id="searchInput" placeholder="Ej: Juan Pérez">
                </div>
                <button class="btn btn-primary" onclick="buscarDocentes()">Buscar</button>
            </div>
        </div>
        <div class="mt-4" id="resultadosContainer"></div>
    </div>
    <script>
        // Token oculto en el código (puedes cambiarlo aquí)
        const TOKEN_API = "589e4cf1e5c2024e8d74d482b4bad2df-20251003-02";

        async function buscarDocentes() {
            const searchTerm = document.getElementById('searchInput').value.trim();
            if (!searchTerm) {
                alert('Ingresa un nombre o apellido para buscar.');
                return;
            }

            try {
                const response = await fetch(
                    `../../public/api.php?action=buscar_docentes&token=${TOKEN_API}&search=${encodeURIComponent(searchTerm)}`
                );
                const data = await response.json();

                if (!data.status) {
                    alert(data.msg);
                    return;
                }

                mostrarResultados(data.docentes);
            } catch (error) {
                console.error('Error:', error);
                alert('Ocurrió un error al buscar.');
            }
        }

        function mostrarResultados(docentes) {
            const container = document.getElementById('resultadosContainer');
            if (docentes.length === 0) {
                container.innerHTML = '<div class="alert alert-info">No se encontraron docentes.</div>';
                return;
            }

            let html = '<h4>Resultados:</h4><div class="row">';
            docentes.forEach(docente => {
                html += `
                    <div class="col-md-6">
                        <div class="card card-docente">
                            <div class="card-header">
                                ${docente.nombres} ${docente.apellidos}
                            </div>
                            <div class="card-body">
                                <p><strong>Especialidad:</strong> ${docente.especialidad}</p>
                                <p><strong>Carrera:</strong> <span class="carrera-badge">${docente.carrera_nombre}</span></p>
                            </div>
                        </div>
                    </div>
                `;
            });
            html += '</div>';
            container.innerHTML = html;
        }
    </script>
</body>
</html>
