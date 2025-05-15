export function iniciarMenuHamburguesa() {
    const menuBtn = document.getElementById("menu-btn");
    const menu = document.getElementById("menu");

    if (menuBtn && menu) {
        // Toggle del menú hamburguesa
        menuBtn.addEventListener("click", () => {
            menu.classList.toggle("activo");
        });

        // Cerrar menú al hacer clic en un enlace
        const menuLinks = menu.querySelectorAll("a");
        menuLinks.forEach(link => {
            link.addEventListener("click", () => {
                menu.classList.remove("activo");
            });
        });

        // Cerrar menú si la pantalla se agranda (modo escritorio)
        window.addEventListener("resize", () => {
            if (window.innerWidth > 768) {
                menu.classList.remove("activo");
            }
        });
    }
}
