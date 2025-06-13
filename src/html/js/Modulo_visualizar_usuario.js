const btnEditar = document.getElementById('btn-editar');
const btnCancelar = document.getElementById('cancelar-edicion');
const botonesEdicion = document.getElementById('botones-edicion');
const cruzSalir = document.querySelector('.cruz_salir');

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

    // Mostrar y habilitar checkboxes
    const asignaturasContainer = document.getElementById('asignaturas-container');
    asignaturasContainer.style.display = 'block';
    asignaturasContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.disabled = false);
});

btnCancelar.addEventListener('click', () => {
    inputs.forEach(input => {
        input.value = valoresOriginales[input.id];
        input.disabled = true;
    });
    botonesEdicion.style.display = 'none';
    btnEditar.style.display = 'inline-block';

    // Ocultar y resetear checkboxes
    const asignaturasContainer = document.getElementById('asignaturas-container');
    asignaturasContainer.style.display = 'none';
    asignaturasContainer.querySelectorAll('input[type="checkbox"]').forEach(cb => {
        cb.disabled = true;
        cb.checked = cb.defaultChecked;
    });
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


// Volver a la página anterior al pulsar la cruz
cruzSalir.addEventListener('click', () => {
    history.back();
});

// Confirmar antes de enviar los cambios (asignaturas eliminadas)
const formUsuario = document.getElementById('form-usuario');

formUsuario.addEventListener('submit', (e) => {
    const cambios = [...document.querySelectorAll('#asignaturas-container input[type="checkbox"]')].some(cb => cb.defaultChecked !== cb.checked);
    if (cambios) {
        const confirmar = confirm("¿Estás seguro de que deseas modificar las asignaturas?\nSe eliminarán las actuales y se aplicarán las nuevas.");
        if (!confirmar) {
            e.preventDefault();
        }
    }
});
