// Obtener elementos
const popup = document.getElementById("popup");
const popupImg = document.getElementById("popup-img");
const closeBtn = document.querySelector(".close");
const images = document.querySelectorAll(".contenedor_img img");

images.forEach(img => {
    img.addEventListener("click", () => {
        popup.style.display = "block";
        popupImg.src = img.src;
    });
});

closeBtn.addEventListener("click", () => {
    popup.style.display = "none";
});

// Cierra el popup si haces clic fuera de la imagen
popup.addEventListener("click", (e) => {
    if (e.target === popup) {
        popup.style.display = "none";
    }
});