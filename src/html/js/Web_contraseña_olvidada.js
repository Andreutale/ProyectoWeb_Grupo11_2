const correoElectronico = document.getElementById("correoElectronico");
const btn_enviar = document.getElementById("btn_enviar");

btn_enviar.addEventListener("click", () => {
    var contenido = correoElectronico.value.trim();
    //input vacio
    if(contenido === "") {
        alert("Rellena el campo vacío")
        return;
    }
    //input sin @
    if(!contenido.includes("@")) {
        alert("El correo electrónido no es válido")
        return;
    }
    //input sin .com
    if(!contenido.includes(".com")) {
        alert("El correo electrónico no es válido")
        return;
    }
    //alert de confirmacion
    alert("Sigue los pasos del correo que has recibido")
    setTimeout(() => {
        document.location.href = "Web_inicio_sesion.php"
    }, 150)

})