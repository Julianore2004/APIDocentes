async function buscarDocentes() {
    const search = document.getElementById('search').value;
    const token = document.getElementById('token').value;
    const resultadosDiv = document.getElementById('resultados');

    if (!search.trim()) {
        alert('Ingrese un nombre o apellido para buscar.');
        return;
    }

    resultadosDiv.innerHTML = `
        <div class="loading">
            <i class="fas fa-spinner fa-spin"></i> Buscando docentes...
        </div>
    `;

    try {
        const formData = new FormData();
        formData.append('token', token);
        formData.append('search', search);

        const response = await fetch('api_handler.php?action=buscarDocentes', {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (!data.status) {
            resultadosDiv.innerHTML = `
                <div class="error">
                    <i class="fas fa-exclamation-triangle"></i> ${data.msg}
                </div>
            `;
            return;
        }

        if (data.data.length === 0) {
            resultadosDiv.innerHTML = `
                <div class="no-results">
                    <i class="fas fa-search"></i> No se encontraron docentes con ese criterio.
                </div>
            `;
            return;
        }

        let html = '';
        data.data.forEach(docente => {
            html += `
                <div class="docente-card">
                    <h3>
                        <i class="fas fa-chalkboard-teacher"></i>
                        ${docente.nombres} ${docente.apellidos}
                    </h3>
                    <div class="carrera">
                        <i class="fas fa-graduation-cap"></i> ${docente.carrera_nombre}
                    </div>
                    <div class="especialidad">
                        <i class="fas fa-book"></i> ${docente.especialidad || 'Sin especialidad asignada'}
                    </div>
                </div>
            `;
        });

        resultadosDiv.innerHTML = html;

    } catch (error) {
        console.error('Error:', error);
        resultadosDiv.innerHTML = `
            <div class="error">
                <i class="fas fa-times-circle"></i> Error al conectar con el servidor.
            </div>
        `;
    }
}
