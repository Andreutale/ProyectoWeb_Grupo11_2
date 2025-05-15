// Selección/deselección de todos los checkboxes
function setupSelectAllCheckbox() {
    const selectAll = document.getElementById('selectAll');
    if (!selectAll) return;

    const updateCheckboxAppearance = (checkbox, isChecked) => {
        const img = checkbox.nextElementSibling;
        if (isChecked) {
            checkbox.style.backgroundColor = 'var(--azul-claro)';
            checkbox.style.borderColor = 'var(--azul-oscuro)';
            img.style.opacity = '1';
        } else {
            checkbox.style.backgroundColor = 'white';
            checkbox.style.borderColor = 'var(--azul-claro)';
            img.style.opacity = '0';
        }
    };

    selectAll.addEventListener('change', function() {
        const checkboxes = document.querySelectorAll('.rowCheckbox');
        const isChecked = this.checked;

        checkboxes.forEach(checkbox => {
            checkbox.checked = isChecked;
            updateCheckboxAppearance(checkbox, isChecked);
        });
    });

    document.querySelectorAll('.rowCheckbox').forEach(checkbox => {
        checkbox.addEventListener('change', function() {
            updateCheckboxAppearance(this, this.checked);

            const allCheckboxes = document.querySelectorAll('.rowCheckbox');
            const allChecked = [...allCheckboxes].every(cb => cb.checked);
            selectAll.checked = allChecked;
            updateCheckboxAppearance(selectAll, allChecked);
        });
    });
}

// Ordenación de columnas
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

            rows.forEach(row => tbody.appendChild(row));

            document.querySelectorAll('[data-sort]').forEach(header => {
                header.classList.remove('asc', 'desc');
            });
            th.classList.add(isAscending ? 'asc' : 'desc');
        });
    });
}

// Menús desplegables de opciones
function setupDropdownMenus() {
    document.querySelectorAll('.opciones').forEach(button => {
        button.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = this.closest('.dropdown-container').querySelector('.dropdown-menu');
            const isVisible = dropdown.style.display === 'block';

            document.querySelectorAll('.dropdown-menu').forEach(menu => {
                if (menu !== dropdown) menu.style.display = 'none';
            });

            dropdown.style.display = isVisible ? 'none' : 'block';
        });
    });

    document.addEventListener('click', () => {
        document.querySelectorAll('.dropdown-menu').forEach(menu => {
            menu.style.display = 'none';
        });
    });
}

// Modal para añadir recurso
function setupResourceModal() {
    const modal = document.getElementById('modalAñadirRecurso');
    if (!modal) return;

    const btnOpen = document.getElementById('btnAñadirRecurso');
    const btnClose = document.querySelector('.close-modal');
    const form = document.getElementById('formAñadirRecurso');

    btnOpen.addEventListener('click', () => {
        modal.style.display = 'block';
    });

    btnClose.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });

    form.addEventListener('submit', function(e) {
        e.preventDefault();
        console.log('Recurso añadido:', {
            nombre: this.nombreRecurso.value,
            tipo: this.tipoRecurso.value,
            archivo: this.archivoRecurso.files[0]?.name
        });
        this.reset();
        modal.style.display = 'none';
    });
}

// Modal para gestionar asignaturas favoritas
function setupAsignaturasModal() {
    const modal = document.getElementById('modalAsignaturasFavoritas');
    if (!modal) return;

    const btnOpen = document.getElementById('img_puntos_suspensivos');
    const btnClose = modal.querySelector('.close-modal');
    const btnGuardar = document.getElementById('btnGuardarAsignaturas');

    btnOpen.addEventListener('click', (e) => {
        e.preventDefault();
        modal.style.display = 'block';
    });

    btnClose.addEventListener('click', () => {
        modal.style.display = 'none';
    });

    btnGuardar.addEventListener('click', () => {
        alert("Asignaturas modificadas");
        modal.style.display = 'none';
    });

    window.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
}

// Desplegable responsive para recursos profesor
function setupResponsiveDropdowns() {
    if (window.innerWidth > 1100) {
        document.querySelectorAll('.responsive-info').forEach(panel => panel.remove());
        return;
    }

    document.querySelectorAll('.btn-desplegable-responsive').forEach(btn => {
        if (btn.hasAttribute('data-responsive-bound')) return;
        btn.setAttribute('data-responsive-bound', 'true');

        btn.addEventListener('click', function(e) {
            e.stopPropagation();
            const row = this.closest('tr');
            const td = this.closest('td');

            let infoPanel = td.querySelector('.responsive-info');

            if (infoPanel) {
                infoPanel.classList.toggle('active');
                this.classList.toggle('active');
                return;
            }

            const autor = row.cells[2].textContent.trim();
            const fecha = row.cells[3].textContent.trim();
            const tipo = row.cells[4].textContent.trim();

            infoPanel = document.createElement('div');
            infoPanel.className = 'responsive-info';
            infoPanel.innerHTML = `
                <div class="responsive-info-content">
                    <div class="responsive-info-item">
                        <span class="responsive-info-label"><p>Autor:</p></span>
                        <span class="responsive-info-value"><p>${autor}</p></span>
                    </div>
                    <div class="responsive-info-item">
                        <span class="responsive-info-label"><p>Fecha:</p></span>
                        <span class="responsive-info-value"><p>${fecha}</p></span>
                    </div>
                    <div class="responsive-info-item">
                        <span class="responsive-info-label"><p>Tipo:</p></span>
                        <span class="responsive-info-value"><p>${tipo}</p></span>
                    </div>
                    <div class="responsive-actions">
                        <button class="btn-azul-claro btn-opciones-responsive">Opciones</button>
                    </div>
                </div>
            `;

            td.appendChild(infoPanel);
            infoPanel.classList.add('active');
            this.classList.add('active');

            const btnOpciones = infoPanel.querySelector('.btn-opciones-responsive');
            btnOpciones.addEventListener('click', function(e) {
                e.stopPropagation();
                row.querySelector('.opciones').click();
            });
        });
    });
}

// Función debounce para mejorar el rendimiento
function debounce(func, wait) {
    let timeout;
    return function() {
        const context = this, args = arguments;
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            func.apply(context, args);
        }, wait);
    };
}

// Inicializar todo cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    setupSelectAllCheckbox();
    setupColumnSorting();
    setupDropdownMenus();
    setupResourceModal();
    setupAsignaturasModal();
    setupResponsiveDropdowns();
});

// Manejar cambios de tamaño de pantalla
window.addEventListener('resize', debounce(() => {
    setupResponsiveDropdowns();
}, 250));