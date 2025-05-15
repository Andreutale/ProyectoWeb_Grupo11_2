import { usuarios } from '../../app/usuarios.js';

document.addEventListener("DOMContentLoaded", () => {
    const mensaje = document.getElementById("mensaje");
    const form = document.getElementById("loginForm");

    form.addEventListener("submit", function (e) {
        e.preventDefault();

        const correo = document.getElementById("loginCorreo").value.trim().toLowerCase();
        const password = document.getElementById("loginPassword").value;

        // Buscar usuario con coincidencia exacta en correo y contraseña
        const usuario = usuarios.find(u => u.correo === correo && u.contraseña === password);

        if (!usuario || !usuario.rol) {
            mensaje.style.visibility = "visible";
            mensaje.textContent = "Datos incorrectos.";
            return;
        }

        // Redirección según rol
        mensaje.style.visibility = "hidden";
        switch ((usuario.rol || "").toLowerCase()) {
            case "alumno":
                window.location.href = "../../modulo_landing_alumno.html";
                break;
            case "profesor":
                window.location.href = "../../modulo_landing_profesor.html";
                break;
            case "pas":
                window.location.href = "../../modulo_landing_pas.html";
                break;
            default:
                mensaje.style.display = "block";
                mensaje.style.color = "orange";
                mensaje.textContent = "Rol no reconocido.";
                break;
        }
    });
});
