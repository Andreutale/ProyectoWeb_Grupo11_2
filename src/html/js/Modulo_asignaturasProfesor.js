// Datos iniciales de los criterios
let criteriosEvaluacion = [
    { nombre: "Exámenes", porcentaje: 50 },
    { nombre: "Prácticas", porcentaje: 30 },
    { nombre: "Asistencia", porcentaje: 10 },
    { nombre: "Participación", porcentaje: 10 }
];

// Función para renderizar los criterios en la vista principal
function renderizarCriteriosEnVista() {
    const listaCriterios = document.getElementById('lista-criterios');
    listaCriterios.innerHTML = '';

    criteriosEvaluacion.forEach(criterio => {
        const li = document.createElement('li');
        li.className = 'criterio-item';

        const contenido = document.createElement('div');
        contenido.className = 'criterio-texto';
        contenido.innerHTML = `<strong>${criterio.nombre} —</strong> ${criterio.porcentaje}%`;

        li.appendChild(contenido);
        listaCriterios.appendChild(li);
    });
}

// Función para renderizar los criterios en el modal
function renderizarCriteriosEnModal() {
    const contenedorCriterios = document.getElementById('contenedor-criterios');
    contenedorCriterios.innerHTML = '';

    criteriosEvaluacion.forEach((criterio, index) => {
        const criterioGroup = document.createElement('div');
        criterioGroup.className = 'criterio-form-group';
        criterioGroup.innerHTML = `
            <div class="form-group" style="flex: 1;">
                <label for="criterio-nombre-${index}">Nombre del criterio</label>
                <input type="text" id="criterio-nombre-${index}" 
                       value="${criterio.nombre}" 
                       placeholder="Ej. Examen parcial">
            </div>
            
            <div class="form-group">
                <label for="criterio-porcentaje-${index}">Porcentaje (%)</label>
                <input type="number" id="criterio-porcentaje-${index}" 
                       min="0" max="100" step="5" 
                       value="${criterio.porcentaje}">
            </div>
            
            <button type="button" class="btn-rojo eliminar-criterio" 
                    data-index="${index}">Eliminar</button>
        `;

        contenedorCriterios.appendChild(criterioGroup);
    });

    // Agregar event listeners a los botones de eliminar
    document.querySelectorAll('.eliminar-criterio').forEach(btn => {
        btn.addEventListener('click', function() {
            const index = parseInt(this.getAttribute('data-index'));
            eliminarCriterio(index);
        });
    });
}

// Función para añadir un nuevo criterio
function añadirNuevoCriterio() {
    criteriosEvaluacion.push({ nombre: "Nuevo criterio", porcentaje: 0 });
    renderizarCriteriosEnModal();
}

// Función para eliminar un criterio
function eliminarCriterio(index) {
    if (criteriosEvaluacion.length > 1) {
        criteriosEvaluacion.splice(index, 1);
        renderizarCriteriosEnModal();
    } else {
        alert('Debe haber al menos un criterio de evaluación');
    }
}

// Función para guardar los criterios desde el modal
function guardarCriteriosDesdeModal() {
    const nuevosCriterios = [];

    criteriosEvaluacion.forEach((_, index) => {
        const nombre = document.getElementById(`criterio-nombre-${index}`).value;
        const porcentaje = parseInt(document.getElementById(`criterio-porcentaje-${index}`).value);

        if (nombre && !isNaN(porcentaje)) {
            nuevosCriterios.push({ nombre, porcentaje });
        }
    });

    // Verificar que la suma de porcentajes sea 100%
    const totalPorcentaje = nuevosCriterios.reduce((sum, criterio) => sum + criterio.porcentaje, 0);

    if (totalPorcentaje !== 100) {
        alert(`La suma de los porcentajes debe ser 100%. Actual: ${totalPorcentaje}%`);
        return false;
    }

    criteriosEvaluacion = nuevosCriterios;
    renderizarCriteriosEnVista();
    return true;
}

// JS para abrir/cerrar modal editar guía
const btnEditar = document.getElementById("btnEditarGuia");
const modal = document.getElementById("modalEditarGuia");
const closeBtn = modal.querySelector(".close-modal");

btnEditar.addEventListener("click", () => {
    renderizarCriteriosEnModal();
    modal.style.display = "block";
});

closeBtn.addEventListener("click", () => {
    modal.style.display = "none";
});

window.addEventListener("click", (e) => {
    if (e.target === modal) {
        modal.style.display = "none";
    }
});

// JS para manejar las pestañas
const tabBtns = document.querySelectorAll('.tab-btn');

tabBtns.forEach(btn => {
    btn.addEventListener('click', () => {
        // Quitar clase active de todos los botones
        tabBtns.forEach(b => b.classList.remove('active'));

        // Agregar clase active al botón clickeado
        btn.classList.add('active');

        // Ocultar todos los contenidos de pestañas
        document.querySelectorAll('.tab-content').forEach(content => {
            content.classList.remove('active');
        });

        // Mostrar el contenido de la pestaña correspondiente
        const tabId = btn.getAttribute('data-tab');
        document.getElementById(`tab-${tabId}`).classList.add('active');
    });
});

// JS para manejar el envío del formulario
document.getElementById('formEditarGuia').addEventListener('submit', function(e) {
    e.preventDefault();

    // Guardar criterios solo si están en la pestaña activa
    if (!guardarCriteriosDesdeModal()) {
        return; // Detener el envío si hay error
    }

    alert('Cambios guardados exitosamente');
    modal.style.display = "none";
});

// Evento para añadir nuevo criterio
document.getElementById('btnAnadirCriterio').addEventListener('click', añadirNuevoCriterio);

// Inicializar la vista al cargar la página
document.addEventListener('DOMContentLoaded', renderizarCriteriosEnVista);