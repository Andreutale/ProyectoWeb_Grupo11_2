const buscador = document.getElementById("Input_buscador")//input del buscador
const btn_buscador = document.getElementById("Icono_buscador")
const btn_eliminar = document.querySelectorAll(".boton_papelera")
const botonAbrirModal = document.querySelector('table th div button');
const modal = document.getElementById('modalAñadirUsuario');
const cerrarModal = document.getElementById('cerrarModal');
const formulario = document.getElementById('formularioNuevoUsuario');

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


// Modifica el DOMContentLoaded para incluir la nueva función
document.addEventListener('DOMContentLoaded', () => {
    setupColumnSorting();


    btn_buscador.addEventListener("click", () => {
        var contenido_input = buscador.value;
        if(contenido_input === ""){
            alert("Usuario/s no encontrado")
        }
        alert("Usuarios encontrados")
    })

    btn_eliminar.forEach(elemento => {
        // Agregar el evento de clic a cada elemento
        elemento.addEventListener("click", function() {
            // Código a ejecutar cuando se hace clic en el elemento
            alert("Usuario eliminado")
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {


    // Mostrar el modal
    botonAbrirModal.addEventListener('click', () => {
        modal.classList.remove('hidden');
    });

    // Cerrar el modal
    cerrarModal.addEventListener('click', () => {
        modal.classList.add('hidden');
    });

    // Confirmar envío del formulario
    formulario.addEventListener('submit', function(e) {
        e.preventDefault();
        const nombre = document.getElementById('nombreUsuario').value;
        const rol = document.getElementById('rolUsuario').value;
        const correo = document.getElementById('correoUsuario').value;

        // Aquí podrías hacer una llamada a backend para guardar

        alert('Usuario añadido:\nNombre: ${nombre}\nRol: ${rol}\nCorreo: ${correo}');
        modal.classList.add('hidden');
        formulario.reset();
    });
});