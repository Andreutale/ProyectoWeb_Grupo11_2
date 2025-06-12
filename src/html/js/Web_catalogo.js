const botonesInaccesibles = document.querySelectorAll(".btn_inaccesible");

botonesInaccesibles.forEach(boton => {
    boton.addEventListener("click", (e) => {
        e.preventDefault(); // Evita que el formulario se envíe

        // Mostrar alerta personalizada
        const alerta = document.getElementById('alerta-personalizada');
        alerta.style.visibility = 'visible';

        // Redirigir después de 2 segundos
        setTimeout(() => {
            window.location.href = '../web/Web_catalogo.html';
        }, 1000);
    });
});