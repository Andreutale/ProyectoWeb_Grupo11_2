document.addEventListener("DOMContentLoaded", () => {
    const correoElectronico = document.getElementById("correoElectronico");
    const btn_enviar = document.getElementById("btn_enviar");

    btn_enviar.addEventListener("click", () => {
        var contenido = correoElectronico.value.trim();

        if(contenido === "") {
            alert("Rellena el campo vacío")
            return;
        }

        if(!contenido.includes("@")) {
            alert("El correo electrónido no es válido")
            return;
        }

        if(!contenido.includes(".com")) {
            alert("El correo electrónico no es válido")
            return;
        }

        alert("Sigue los pasos del correo que has recibido")
        setTimeout(() => {
            document.location.href = "Web_inicio_sesion.html"
        }, 150)

    })
});