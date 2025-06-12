const formulario = document.querySelector('.consulta-form');

formulario.addEventListener('submit', e => {
    e.preventDefault(); // Evita que el formulario se envíe

    // Mostrar alerta personalizada
    const alerta = document.getElementById('alerta-personalizada');
    alerta.style.visibility = 'visible';

    // Redirigir después de 2 segundos
    setTimeout(() => {
        window.location.href = '../web/Web_consultas.html';
    }, 1000);
});