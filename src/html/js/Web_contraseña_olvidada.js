const correoElectronico = document.getElementById("correoElectronico");
const btn_enviar = document.getElementById("btn_enviar");
const alerta = document.getElementById('alerta-personalizada');
const mensaje = document.getElementById('mensaje-alerta');
const mensaje2 = document.getElementById('mensaje-alerta2');

function mostrarAlerta(texto1, texto2 = "", duracion = 2000, redireccion = null) {
    mensaje.textContent = texto1;
    mensaje2.textContent = texto2;
    alerta.style.visibility = 'visible';

    setTimeout(() => {
        alerta.style.visibility = 'hidden';
        if (redireccion) {
            window.location.href = redireccion;
        }
    }, duracion);
}

btn_enviar.addEventListener("click", () => {
    const contenido = correoElectronico.value.trim();

    // Validar campo vacío
    if (contenido === "") {
        mostrarAlerta("Error", "Introduce tu correo electrónico", 2500);
        return;
    }

    // Validar formato básico del correo
    if (!contenido.includes("@") || !contenido.includes(".")) {
        mostrarAlerta("Error", "Correo electrónico no válido", 2500);
        return;
    }

    // Si es válido, mostrar mensaje de éxito y redirigir
    mostrarAlerta("Enviando enlace de recuperación...", contenido, 2500, "Web_inicio_sesion.php");
});
