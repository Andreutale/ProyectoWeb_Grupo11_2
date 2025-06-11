const buscador = document.getElementById("Input_buscador"); //input del buscador
const btn_buscador = document.getElementById("Icono_buscador");
const botonAbrirModal = document.querySelector('table th div button');
const modal = document.getElementById('modalAñadirUsuario');
const cerrarModal = document.getElementById('cerrarModal');
const formulario = document.getElementById('formularioNuevoUsuario');
const modalConfirmar = document.getElementById('modalConfirmarEliminar');
let usuarioAEliminar = null;

// Función para manejar la eliminación de usuarios
function setupEliminacionUsuarios() {
    document.addEventListener('click', function(e) {
        if (e.target.closest('.boton_papelera')) {
            e.preventDefault();
            const botonPapelera = e.target.closest('.boton_papelera');
            usuarioAEliminar = botonPapelera.getAttribute('data-id');
            modalConfirmar.classList.remove('hidden');
        }
    });

    // Confirmar eliminación
    document.getElementById('confirmarEliminar').addEventListener('click', function() {
        if (usuarioAEliminar) {
            eliminarUsuario(usuarioAEliminar);
        }
    });

    // Cancelar eliminación
    document.getElementById('cancelarEliminar').addEventListener('click', function() {
        modalConfirmar.classList.add('hidden');
        usuarioAEliminar = null;
    });

    // Cerrar modal con la X
    modalConfirmar.querySelector('.cerrar').addEventListener('click', function() {
        modalConfirmar.classList.add('hidden');
        usuarioAEliminar = null;
    });
}

// Función para enviar la solicitud de eliminación al servidor
function eliminarUsuario(idUsuario) {
    fetch('../php/eliminar_usuario.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: `id=${idUsuario}`
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Usuario eliminado correctamente');
                // Recargar la página para ver los cambios
                window.location.reload();
            } else {
                alert('Error al eliminar el usuario: ' + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error al conectar con el servidor');
        })
        .finally(() => {
            modalConfirmar.classList.add('hidden');
            usuarioAEliminar = null;
        });
}

//orden de las flechas
function setupColumnSorting() {
    document.querySelectorAll('.sortable').forEach(header => {
        header.addEventListener('click', function(e) {
            e.preventDefault();
            const th = this.closest('th');
            const table = document.getElementById('tablaRecursos');
            const tbody = table.querySelector('tbody');
            const rows = Array.from(tbody.querySelectorAll('tr'));
            const columnIndex = th.cellIndex;
            const sortKey = th.getAttribute('data-sort');
            const isAscending = !th.classList.contains('asc');

            // Ordenar filas
            rows.sort((rowA, rowB) => {
                const cellA = rowA.cells[columnIndex];
                const cellB = rowB.cells[columnIndex];
                let valueA, valueB;

                if (sortKey === 'fecha') {
                    valueA = cellA.querySelector('h3').getAttribute('data-date');
                    valueB = cellB.querySelector('h3').getAttribute('data-date');
                } else {
                    valueA = cellA.textContent.trim().toLowerCase();
                    valueB = cellB.textContent.trim().toLowerCase();
                }

                return isAscending
                    ? valueA.localeCompare(valueB)
                    : valueB.localeCompare(valueA);
            });

            // Reinsertar filas ordenadas
            rows.forEach(row => tbody.appendChild(row));

            // Actualizar indicadores visuales
            document.querySelectorAll('[data-sort]').forEach(header => {
                header.classList.remove('asc', 'desc');
            });
            th.classList.add(isAscending ? 'asc' : 'desc');
        });
    });
}

// Alerts del input y botones
document.addEventListener('DOMContentLoaded', () => {
    setupColumnSorting();
    setupEliminacionUsuarios();

    // Mostrar el modal de añadir
    botonAbrirModal.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    // Cerrar el modal de añadir
    cerrarModal.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Confirmar envío del formulario
    formulario.addEventListener('submit', function(e) {
        e.preventDefault();

        // Obtener valores del formulario
        const nombre = document.getElementById('nombreUsuario').value.trim();
        const apellidos = document.getElementById('apellidosUsuario').value.trim();
        const dni = document.getElementById('dniUsuario').value.trim();
        const correo = document.getElementById('correoUsuario').value.trim();
        const contraseña = document.getElementById('contraseñaUsuario').value;
        const confirmarContraseña = document.getElementById('confirmarContraseña').value;
        const rol = document.getElementById('rolUsuario').value;
        const mensajeError = document.getElementById('mensajeError');

        // Validación básica en cliente
        mensajeError.textContent = '';

        if (contraseña !== confirmarContraseña) {
            mensajeError.textContent = 'Las contraseñas no coinciden';
            return;
        }

        if (contraseña.length < 6) {
            mensajeError.textContent = 'La contraseña debe tener al menos 6 caracteres';
            return;
        }

        // Enviar datos al servidor
        fetch('../php/agregar_usuario.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({
                nombre,
                apellidos,
                dni,
                correo,
                contraseña,
                confirmar_contraseña: confirmarContraseña,
                rol
            })
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Error en la respuesta del servidor');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    alert(data.message || 'Usuario añadido correctamente');
                    modal.classList.add('hidden');
                    formulario.reset();
                    // Recargar la página para mostrar el nuevo usuario
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    mensajeError.textContent = data.message || 'Error al añadir el usuario';
                }
            })
            .catch(error => {
                console.error('Error:', error);
                mensajeError.textContent = 'Error al conectar con el servidor';
            });
    });
});