const slider = document.querySelector('.slider');
const images = Array.from(slider.querySelectorAll('img'));
const totalSlides = images.length;

const prevBtn = document.querySelector('.prev-btn');
const nextBtn = document.querySelector('.next-btn');
const dotsContainer = document.querySelector('.slider-dots');

let currentIndex = 1; // Empezamos en el primer "real"

// Clonar última y primera imagen
const firstClone = images[0].cloneNode(true);
const lastClone = images[images.length - 1].cloneNode(true);
firstClone.classList.add('clone');
lastClone.classList.add('clone');
slider.insertBefore(lastClone, images[0]);
slider.appendChild(firstClone);

const allSlides = slider.querySelectorAll('img');

// Crear los dots
for (let i = 0; i < totalSlides; i++) {
    const dot = document.createElement('span');
    dot.classList.add('dot');
    if (i === 0) dot.classList.add('active');
    dot.addEventListener('click', () => goToSlide(i + 1)); // +1 por el clon
    dotsContainer.appendChild(dot);
}

const updateSliderPosition = (animate = true) => {
    const slideWidth = slider.clientWidth;
    if (!animate) slider.style.transition = 'none';
    else slider.style.transition = 'transform 0.5s ease-in-out';

    slider.style.transform = `translateX(-${currentIndex * slideWidth}px)`;

    // Actualizar dots
    document.querySelectorAll('.dot').forEach((dot, index) => {
        dot.classList.toggle('active', index === currentIndex - 1); // -1 por el clon
    });
};

const goToSlide = (index) => {
    currentIndex = index;
    updateSliderPosition();
};

const nextSlide = () => {
    if (currentIndex >= totalSlides + 1) return;
    currentIndex++;
    updateSliderPosition();
};

const prevSlide = () => {
    if (currentIndex <= 0) return;
    currentIndex--;
    updateSliderPosition();
};

nextBtn.addEventListener('click', nextSlide);
prevBtn.addEventListener('click', prevSlide);

slider.addEventListener('transitionend', () => {
    const slideWidth = slider.clientWidth;

    // Si estás en el clon de la primera, salta al original
    if (currentIndex === totalSlides + 1) {
        currentIndex = 1;
        updateSliderPosition(false);
    }

    // Si estás en el clon de la última, salta al original
    if (currentIndex === 0) {
        currentIndex = totalSlides;
        updateSliderPosition(false);
    }
});

// Redimensionamiento
window.addEventListener('resize', () => updateSliderPosition(false));

// Inicialización
updateSliderPosition(false);

// Extra: soporte para popup
const popup = document.getElementById('popup');
const popupImg = document.getElementById('popup-img');
const closeBtn = document.querySelector('.close');
const flechaIzquierda = document.querySelector('.flecha_izquierda');
const flechaDerecha = document.querySelector('.flecha_derecha');

const realImages = Array.from(slider.querySelectorAll('img:not(.clone)'));

realImages.forEach((img, i) => {
    img.addEventListener('click', () => {
        popup.style.display = 'block';
        popupImg.src = img.src;
        currentIndex = i + 1;
        document.body.style.overflow = 'hidden'; // Ocultar scroll de fondo
    });
});
closeBtn.addEventListener('click', () => {
    popup.style.display = 'none';
    document.body.style.overflow = ''; // Restaurar scroll
});

flechaIzquierda.addEventListener('click', () => {
    currentIndex = (currentIndex - 1 + totalSlides + 2) % (totalSlides + 2); // +2 por clones
    updateSliderPosition();
    popupImg.src = realImages[(currentIndex - 1 + totalSlides) % totalSlides].src;
});

flechaDerecha.addEventListener('click', () => {
    currentIndex = (currentIndex + 1) % (totalSlides + 2);
    updateSliderPosition();
    popupImg.src = realImages[(currentIndex - 1) % totalSlides].src;
});