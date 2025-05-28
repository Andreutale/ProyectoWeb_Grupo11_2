document.addEventListener("DOMContentLoaded", () => {
    const btnEditar = document.querySelector(".btn-editar");
    const btnConfirmar = document.getElementById("btn-confirmar");
    const btnCancelar = document.getElementById("btn-cancelar");
    const inputs = document.querySelectorAll(".user-info input");
    const tabla = document.querySelector("table tbody");
    let btnAñadir = null;

    // Guardamos estado inicial
    const estadoInicial = {
        campos: Array.from(inputs).map(input => input.value),
        asignaturas: tabla.innerHTML
    };

    btnEditar.addEventListener("click", () => {
        inputs.forEach(input => input.disabled = false);

        // Mostrar botones de confirmación/cancelación
        btnConfirmar.style.display = "inline-block";
        btnCancelar.style.display = "inline-block";

        // Añadir botón eliminar en cada fila
        tabla.querySelectorAll("tr").forEach(row => {
            if (!row.querySelector("button")) {
                const td = document.createElement("td");
                const btn = document.createElement("button");
                btn.textContent = "Eliminar";
                btn.style.background = "crimson";
                btn.style.color = "white";
                btn.style.border = "none";
                btn.style.padding = "0.3rem 0.7rem";
                btn.style.borderRadius = "5px";
                btn.style.cursor = "pointer";
                btn.onclick = () => row.remove();
                td.appendChild(btn);
                row.appendChild(td);
            }
        });

        // Botón "Añadir asignatura"
        if (!btnAñadir) {
            btnAñadir = document.createElement("button");
            btnAñadir.textContent = "Añadir asignatura";
            btnAñadir.className = "btn-editar";
            btnAñadir.style.margin = "1rem 0";
            btnEditar.insertAdjacentElement("afterend", btnAñadir);

            btnAñadir.onclick = () => {
                document.getElementById("modal-asignaturas").style.display = "block";
            };
        }
    });

    // Confirmar cambios
    btnConfirmar.addEventListener("click", () => {
        inputs.forEach(input => input.disabled = true);
        btnConfirmar.style.display = "none";
        btnCancelar.style.display = "none";

        // Eliminar botones "Eliminar" de cada fila
        tabla.querySelectorAll("tr").forEach(row => {
            const lastCell = row.lastElementChild;
            if (lastCell.querySelector("button")) {
                lastCell.remove(); // elimina la celda entera
            }
        });

        if (btnAñadir) btnAñadir.remove();
        btnAñadir = null;
    });

    // Cancelar cambios
    btnCancelar.addEventListener("click", () => {
        // Revertir inputs
        inputs.forEach((input, i) => {
            input.value = estadoInicial.campos[i];
            input.disabled = true;
        });

        // Revertir asignaturas
        tabla.innerHTML = estadoInicial.asignaturas;

        btnConfirmar.style.display = "none";
        btnCancelar.style.display = "none";

        if (btnAñadir) btnAñadir.remove();
        btnAñadir = null;
    });

    // Añadir asignatura desde modal
    document.querySelectorAll(".btn-add").forEach(btn => {
        btn.addEventListener("click", function () {
            const row = this.closest("tr");
            const nombre = row.children[0].textContent;
            const id = row.children[1].textContent;

            const yaExiste = Array.from(tabla.querySelectorAll("tr")).some(r => r.children[0].textContent === nombre);
            if (yaExiste) return;

            const nuevaFila = document.createElement("tr");
            nuevaFila.innerHTML = `<td><p>${nombre}</p></td><td><p>${id}</p></td>`;
            const btnEliminar = document.createElement("button");
            btnEliminar.textContent = "Eliminar";
            btnEliminar.style.background = "crimson";
            btnEliminar.style.color = "white";
            btnEliminar.style.border = "none";
            btnEliminar.style.padding = "0.3rem 0.7rem";
            btnEliminar.style.borderRadius = "5px";
            btnEliminar.style.cursor = "pointer";
            const tdEliminar = document.createElement("td");
            btnEliminar.onclick = () => nuevaFila.remove();
            tdEliminar.appendChild(btnEliminar);
            nuevaFila.appendChild(tdEliminar);
            tabla.appendChild(nuevaFila);
        });
    });
});