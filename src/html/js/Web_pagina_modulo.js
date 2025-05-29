document.addEventListener('DOMContentLoaded', function() {
    // 1. Tu código existente para el popup (sin cambios)
    const popup = document.getElementById("popup");
    const popupImg = document.getElementById("popup-img");
    const closeBtn = document.querySelector(".close");
    const images = document.querySelectorAll(".contenedor_img img");
    const leftArrow = document.querySelector(".flecha_izquierda");
    const rightArrow = document.querySelector(".flecha_derecha");

    let currentImageIndex = 0;

    function openPopup(index) {
        currentImageIndex = index;
        popup.style.display = "block";
        popupImg.src = images[currentImageIndex].src;
    }

    images.forEach((img, index) => {
        img.addEventListener("click", () => {
            openPopup(index);
        });
    });

    leftArrow.addEventListener("click", (e) => {
        e.stopPropagation();
        currentImageIndex = (currentImageIndex - 1 + images.length) % images.length;
        popupImg.src = images[currentImageIndex].src;
    });

    rightArrow.addEventListener("click", (e) => {
        e.stopPropagation();
        currentImageIndex = (currentImageIndex + 1) % images.length;
        popupImg.src = images[currentImageIndex].src;
    });

    closeBtn.addEventListener("click", () => {
        popup.style.display = "none";
    });

    popup.addEventListener("click", (e) => {
        if (e.target === popup) {
            popup.style.display = "none";
        }
    });

    // 2. Nuevo código para el slider (se activa solo en móviles)
    const sliderContainer = document.querySelector('.slider-container');
    const slider = document.querySelector('.slider');
    const sliderImages = document.querySelectorAll('.slider img');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    const dotsContainer = document.querySelector('.slider-dots');

    // Solo inicializar el slider si existe (en móviles)
    if (slider) {
        let currentSlide = 0;
        const slideCount = sliderImages.length;

        // Crear puntos indicadores
        sliderImages.forEach((_, index) => {
            const dot = document.createElement('span');
            dot.classList.add('dot');
            if (index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => goToSlide(index));
            dotsContainer.appendChild(dot);
        });

        const dots = document.querySelectorAll('.slider-dots .dot');

        // Actualizar posición del slider
        function updateSlider() {
            slider.style.transform = `translateX(-${currentSlide * 100}%)`;

            // Actualizar puntos activos
            dots.forEach((dot, index) => {
                dot.classList.toggle('active', index === currentSlide);
            });
        }

        // Ir a slide específico
        function goToSlide(index) {
            currentSlide = index;
            if (currentSlide >= slideCount) currentSlide = 0;
            if (currentSlide < 0) currentSlide = slideCount - 1;
            updateSlider();
        }

        // Siguiente slide
        function nextSlide() {
            currentSlide++;
            if (currentSlide >= slideCount) currentSlide = 0;
            updateSlider();
        }

        // Slide anterior
        function prevSlide() {
            currentSlide--;
            if (currentSlide < 0) currentSlide = slideCount - 1;
            updateSlider();
        }

        // Event listeners para botones
        nextBtn.addEventListener('click', nextSlide);
        prevBtn.addEventListener('click', prevSlide);

        // Navegación con teclado
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowRight') nextSlide();
            if (e.key === 'ArrowLeft') prevSlide();
        });

        // Event listeners para popup en imágenes del slider
        sliderImages.forEach((img, index) => {
            img.addEventListener('click', () => {
                currentImageIndex = Array.from(images).findIndex(
                    originalImg => originalImg.src === img.src
                );
                openPopup(currentImageIndex >= 0 ? currentImageIndex : 0);
            });
        });
    }
});