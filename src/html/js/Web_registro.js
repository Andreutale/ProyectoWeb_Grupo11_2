document.addEventListener("DOMContentLoaded", () => {
    const formulario = document.querySelector("form");
    const botonRegistro = document.querySelector(".btn-azul-verdoso");

    if (formulario && botonRegistro) {
        formulario.addEventListener("submit", (e) => {
            const nombre = document.getElementById("nombre").value.trim();
            const apellidos = document.getElementById("apellidos").value.trim();
            const correo = document.getElementById("correo").value.trim();
            const telefono = document.getElementById("telefono").value.trim();
            const contrasena = document.getElementById("contraseña").value;
            const confirmarContrasena = document.getElementById("confirmarContraseña").value;

            if (!nombre || !apellidos || !correo || !telefono || !contrasena || !confirmarContrasena) {
                e.preventDefault();
                alert("Por favor, completa todos los campos.");
                return;
            }

            if (contrasena !== confirmarContrasena) {
                e.preventDefault();
                alert("Las contraseñas no coinciden.");
                return;
            }
        });
    }
});
