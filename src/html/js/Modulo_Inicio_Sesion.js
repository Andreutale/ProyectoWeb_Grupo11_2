// Código para mostrar/ocultar el popup
const botonInfo = document.querySelector('.menu_info');
const contenedorInfo = document.querySelector('.contenedor_info');
const overlayInfo = document.getElementById('overlayInfo');
const cerrarPopup = document.querySelector('.exit');

// Mostrar popup al hacer clic en Info
botonInfo.addEventListener('click', () => {
    contenedorInfo.style.display = 'block';
    overlayInfo.style.display = 'block';
    document.body.style.overflow = 'hidden'; // Evita el scroll del fondo
});

// Cerrar popup al hacer clic en la X
cerrarPopup.addEventListener('click', () => {
    contenedorInfo.style.display = 'none';
    overlayInfo.style.display = 'none';
    document.body.style.overflow = 'auto'; // Restaura el scroll
});

// Cerrar popup al hacer clic fuera del contenido
overlayInfo.addEventListener('click', (e) => {
    if (e.target === overlayInfo) {
        contenedorInfo.style.display = 'none';
        overlayInfo.style.display = 'none';
        document.body.style.overflow = 'auto'; // Restaura el scroll
    }
});

// Cerrar con tecla Escape
document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && contenedorInfo.style.display === 'block') {
        contenedorInfo.style.display = 'none';
        overlayInfo.style.display = 'none';
        document.body.style.overflow = 'auto'; // Restaura el scroll
    }
});

// Funcionalidad para autocompletar los campos
document.querySelectorAll('.btn-autocompletar').forEach(btn => {
    btn.addEventListener('click', function() {
        // Obtener los datos del botón
        const email = this.getAttribute('data-email');
        const password = this.getAttribute('data-password');

        // Redirección según rol
        mensaje.style.visibility = "hidden";
        switch ((usuario.rol || "").toLowerCase()) {
            case "alumno":
                window.location.href = "Modulo_landing_alumno.html";
                break;
            case "profesor":
                window.location.href = "Modulo_landing_profesor.php";
                break;
            case "pas":
                window.location.href = "Modulo_landing_page_pas.html";
                break;
            default:
                mensaje.style.display = "block";
                mensaje.style.color = "orange";
                mensaje.textContent = "Rol no reconocido.";
                break;
        }
    });
});