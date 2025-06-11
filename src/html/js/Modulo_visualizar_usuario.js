document.addEventListener('DOMContentLoaded', () => {
    const btnEditar = document.getElementById('btn-editar');
    const btnCancelar = document.getElementById('cancelar-edicion');
    const botonesEdicion = document.getElementById('botones-edicion');

    const inputs = ['nombre', 'apellidos', 'correo', 'dni'].map(id => document.getElementById(id));
    const valoresOriginales = {};

    // Guardamos los valores originales al iniciar
    inputs.forEach(input => {
        valoresOriginales[input.id] = input.value;
    });

    btnEditar.addEventListener('click', () => {
        inputs.forEach(input => input.disabled = false);
        btnEditar.style.display = 'none';
        botonesEdicion.style.display = 'block';
        // Activar los checkboxes de asignaturas
        document.querySelectorAll('#asignaturas-container input[type="checkbox"]').forEach(cb => cb.disabled = false);

    });

    btnCancelar.addEventListener('click', () => {
        inputs.forEach(input => {
            input.value = valoresOriginales[input.id];
            input.disabled = true;
        });
        botonesEdicion.style.display = 'none';
        btnEditar.style.display = 'inline-block';
        document.querySelectorAll('#asignaturas-container input[type="checkbox"]').forEach(cb => {
            cb.disabled = true;
            cb.checked = cb.defaultChecked;
        });
    });
});
