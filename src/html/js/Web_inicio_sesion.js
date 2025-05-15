import { usuariosWeb as usuariosBase } from '../../app/usuariosWeb.js';

let usuariosWeb = [];

// Cargar desde localStorage o usar los de base
const usuariosGuardados = localStorage.getItem("usuariosWeb");
if (usuariosGuardados) {
    usuariosWeb = JSON.parse(usuariosGuardados);
} else {
    usuariosWeb = [...usuariosBase];
}

console.log(usuariosWeb)

document.addEventListener("DOMContentLoaded", () => {
    const botonAcceder = document.querySelector(".btn-azul-verdoso");

    if (botonAcceder) {
        botonAcceder.addEventListener("click", () => {
            const correo = document.getElementById("email").value.trim();
            const contrasena = document.getElementById("password").value;
            const mensajeError = document.getElementById("mensaje-error");

            // Ocultar mensaje anterior
            mensajeError.style.visibility = "hidden";

            // Validación de campos vacíos
            if (!correo || !contrasena) {
                mostrarError("Por favor, completa todos los campos.");
                return;
            }

            // Buscar usuario válido
            const usuarioValido = usuariosWeb.find(usuario =>
                usuario.correo === correo && usuario.contraseña === contrasena
            );

            if (!usuarioValido) {
                mostrarError("Correo o contraseña incorrectos.");
                return;
            }

            // Si usuario válido, redirige después de 1 segundo
            mensajeError.style.color = "green"
            mensajeError.style.visibility = "visible"
            mensajeError.textContent = "Usuario correcto"
            console.log("Acceso correcto:", usuarioValido);

            setTimeout(() => {
                window.location.href = "../../landing-no-registrado-web.html";
            }, 1000);
        });
    }

    // Función para mostrar mensaje de error y ocultarlo después de 2s
    function mostrarError(texto) {
        const mensajeError = document.getElementById("mensaje-error");
        mensajeError.textContent = texto;
        mensajeError.style.visibility = "visible";

        setTimeout(() => {
            mensajeError.style.visibility = "hidden";
        }, 2000);
    }
});
