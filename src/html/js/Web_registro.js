import { usuariosWeb as usuariosBase } from '../../app/usuariosWeb.js';

let usuariosWeb = [];

const usuariosGuardados = localStorage.getItem("usuariosWeb");
if (usuariosGuardados) {
    usuariosWeb = JSON.parse(usuariosGuardados);
} else {
    usuariosWeb = [...usuariosBase];
}

document.addEventListener("DOMContentLoaded", () => {
    const botonRegistro = document.querySelector(".btn-azul-verdoso");

    if (botonRegistro) {
        botonRegistro.addEventListener("click", () => {
            const nombre = document.getElementById("nombre").value.trim();
            const apellidos = document.getElementById("apellidos").value.trim();
            const correo = document.getElementById("correo").value.trim();
            const telefono = document.getElementById("telefono").value.trim();
            const contrasena = document.getElementById("contraseña").value;
            const confirmarContrasena = document.getElementById("confirmarContraseña").value;

            if (!nombre || !apellidos || !correo || !telefono || !contrasena || !confirmarContrasena) {
                alert("Por favor, completa todos los campos.");
                return;
            }

            if (contrasena !== confirmarContrasena) {
                alert("Las contraseñas no coinciden.");
                return;
            }

            const correoExiste = usuariosWeb.some(usuario => usuario.correo === correo);
            if (correoExiste) {
                alert("Ya existe un usuario con ese correo.");
                return;
            }

            const nuevoUsuario = {
                nombre: nombre,
                apellido: apellidos,
                correo: correo,
                contraseña: contrasena,
                telefono: telefono,
            };

            usuariosWeb.push(nuevoUsuario);
            localStorage.setItem("usuariosWeb", JSON.stringify(usuariosWeb));
            console.log("Usuario registrado:", nuevoUsuario);

            setTimeout(() => {
                window.location.href = "Web_inicio_sesion.html";
            }, 1500);
        });
    }
});
