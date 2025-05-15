document.addEventListener("DOMContentLoaded", () => {
    const botonesInaccesibles = document.querySelectorAll(".btn_inaccesible");

    botonesInaccesibles.forEach(boton => {
        boton.addEventListener("click", (e) => {
            alert("Este apartado está inaccesible en este momento. Prueba con Recursos");
        });
    });
});
