document.addEventListener("DOMContentLoaded", () => {
    const guiaDocente = document.getElementById("guiaDocente");
    const recursos = document.getElementById("recursos");
    const tareas = document.getElementById("tareas");
    const examenes = document.getElementById("examenes");
    const calificaciones = document.getElementById("calificaciones");
    const anuncios = document.getElementById("anuncios");
    const nombreAsignatura = document.getElementById("nombre_asignatura");

    guiaDocente.addEventListener("click", () => {
        alert("Esta función aún no está implementada")
    })

    recursos.addEventListener("click", () => {
        setTimeout(() => {
            document.location.href = "Modulo_recursos_profesor.html"
        }, 150)
    })

    tareas.addEventListener("click", () => {
        alert("Esta función aún no está implementada")
    })

    examenes.addEventListener("click", () => {
        alert("Esta función aún no está implementada")
    })

    calificaciones.addEventListener("click", () => {
        alert("Esta función aún no está implementada")
    })

    anuncios.addEventListener("click", () => {
        alert("Esta función aún no está implementada")
    })

    nombreAsignatura.addEventListener("click", () => {
        alert("Esta función aún no está implementada")
    })
});