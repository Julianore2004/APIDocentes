async function buscarDocentes() {
    const search = document.getElementById('search').value;
    const token = document.getElementById('token').value;
    const resultadosDiv = document.getElementById('resultados');

    if (!search.trim()) {
        alert('Ingrese un nombre o apellido para buscar.');
        return;
    }

    resultadosDiv.innerHTML = '<div class="loading"><i class="fas fa-spinner fa-spin"></i> Buscando docentes...</div>';

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
            resultadosDiv.innerHTML = `<div class="error"><i class="fas fa-exclamation-triangle"></i> ${data.msg}</div>`;
            return;
        }

        if (data.data.length === 0) {
            resultadosDiv.innerHTML = '<div class="no-results"><i class="fas fa-info-circle"></i> No se encontraron docentes.</div>';
            return;
        }

        let html = '';
        data.data.forEach(docente => {
            const iniciales = docente.nombres.charAt(0) + docente.apellidos.charAt(0);
            html += `
                <div class="docente-card">
                    <div class="docente-header">
                        <div class="docente-avatar">${iniciales}</div>
                        <h3 class="docente-nombre">${docente.nombres} ${docente.apellidos}</h3>
                    </div>
                    <div class="docente-carrera">${docente.carrera_nombre}</div>
                    <div class="docente-especialidad">${docente.especialidad || 'Sin especialidad'}</div>
                    <div class="docente-info">
                        ${docente.correo ? `<p><i class="fas fa-envelope"></i> ${docente.correo}</p>` : ''}
                        ${docente.telefono ? `<p><i class="fas fa-phone"></i> ${docente.telefono}</p>` : ''}
                    </div>
                </div>
            `;
        });

        resultadosDiv.innerHTML = html;

    } catch (error) {
        console.error('Error:', error);
        resultadosDiv.innerHTML = '<div class="error"><i class="fas fa-exclamation-triangle"></i> Ocurrió un error al buscar los docentes.</div>';
    }
}
