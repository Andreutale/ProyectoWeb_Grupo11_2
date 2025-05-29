class ImageSlider {
    constructor() {
        this.currentIndex = 0;
        this.currentPopupIndex = 0;
        this.slides = [];
        this.intervalTime = 5000;
        this.slideInterval = null;
        this.isPopupOpen = false;

        // Bindear métodos
        this.nextSlide = this.nextSlide.bind(this);
        this.prevSlide = this.prevSlide.bind(this);
        this.goToSlide = this.goToSlide.bind(this);
        this.openPopup = this.openPopup.bind(this);
        this.closePopup = this.closePopup.bind(this);
        this.navigatePopup = this.navigatePopup.bind(this);
        this.handleKeyDown = this.handleKeyDown.bind(this);
        this.startInterval = this.startInterval.bind(this);
        this.resetInterval = this.resetInterval.bind(this);
    }

    init(sliderContainer) {
        if (!sliderContainer) return;

        // Obtener elementos
        this.slider = sliderContainer.querySelector('.slider');
        this.slides = sliderContainer.querySelectorAll('.slider img');
        this.prevBtn = sliderContainer.querySelector('.prev-btn');
        this.nextBtn = sliderContainer.querySelector('.next-btn');
        this.dotsContainer = sliderContainer.querySelector('.slider-dots');
        this.popup = document.getElementById('popup');
        this.popupImg = document.getElementById('popup-img');
        this.closeBtn = this.popup?.querySelector('.close');
        this.leftArrow = this.popup?.querySelector('.flecha_izquierda');
        this.rightArrow = this.popup?.querySelector('.flecha_derecha');
        this.arrow = document.querySelector('.floating-bouncing-arrow');

        // Configuración inicial
        this.slideCount = this.slides.length;
        this.createDots();
        this.setupEventListeners();
        this.startInterval();
        this.updateSlider();
    }

    createDots() {
        if (!this.dotsContainer) return;

        this.dotsContainer.innerHTML = '';

        this.slides.forEach((_, index) => {
            const dot = document.createElement('span');
            dot.classList.add('dot');
            if (index === 0) dot.classList.add('active');
            dot.addEventListener('click', () => this.goToSlide(index));
            this.dotsContainer.appendChild(dot);
        });
    }

    updateSlider() {
        if (!this.slider) return;

        this.slider.style.transform = `translateX(-${this.currentIndex * 100}%)`;

        // Actualizar dots
        const dots = this.dotsContainer?.querySelectorAll('.dot');
        dots?.forEach((dot, index) => {
            dot.classList.toggle('active', index === this.currentIndex);
        });
    }

    goToSlide(index) {
        this.currentIndex = index;

        // Circular navigation
        if (this.currentIndex >= this.slideCount) this.currentIndex = 0;
        if (this.currentIndex < 0) this.currentIndex = this.slideCount - 1;

        this.updateSlider();
        this.resetInterval();
    }

    nextSlide() {
        this.goToSlide(this.currentIndex + 1);
    }

    prevSlide() {
        this.goToSlide(this.currentIndex - 1);
    }

    startInterval() {
        this.stopInterval();
        this.slideInterval = setInterval(this.nextSlide, this.intervalTime);
    }

    stopInterval() {
        if (this.slideInterval) {
            clearInterval(this.slideInterval);
            this.slideInterval = null;
        }
    }

    resetInterval() {
        this.stopInterval();
        this.startInterval();
    }

    openPopup(index) {
        if (!this.popup || !this.popupImg) return;

        this.currentPopupIndex = index;
        this.popupImg.src = this.slides[this.currentPopupIndex].src;
        this.popup.style.display = 'block';
        this.isPopupOpen = true;
        document.body.style.overflow = 'hidden';
        this.stopInterval();
    }

    closePopup() {
        if (!this.popup) return;

        this.popup.style.display = 'none';
        this.isPopupOpen = false;
        document.body.style.overflow = 'auto';
        this.startInterval();
    }

    navigatePopup(direction) {
        this.currentPopupIndex = (this.currentPopupIndex + direction + this.slideCount) % this.slideCount;
        this.popupImg.src = this.slides[this.currentPopupIndex].src;
    }

    handleKeyDown(e) {
        if (this.isPopupOpen) {
            switch(e.key) {
                case 'ArrowRight':
                    this.navigatePopup(1);
                    break;
                case 'ArrowLeft':
                    this.navigatePopup(-1);
                    break;
                case 'Escape':
                    this.closePopup();
                    break;
            }
        } else {
            switch(e.key) {
                case 'ArrowRight':
                    this.nextSlide();
                    break;
                case 'ArrowLeft':
                    this.prevSlide();
                    break;
            }
        }
    }

    setupEventListeners() {
        // Botones de navegación
        this.prevBtn?.addEventListener('click', this.prevSlide);
        this.nextBtn?.addEventListener('click', this.nextSlide);

        // Eventos de teclado
        document.addEventListener('keydown', this.handleKeyDown);

        // Popup
        this.closeBtn?.addEventListener('click', this.closePopup);
        this.leftArrow?.addEventListener('click', (e) => {
            e.stopPropagation();
            this.navigatePopup(-1);
        });
        this.rightArrow?.addEventListener('click', (e) => {
            e.stopPropagation();
            this.navigatePopup(1);
        });
        this.popup?.addEventListener('click', (e) => {
            if (e.target === this.popup) this.closePopup();
        });

        // Imágenes del slider
        this.slides.forEach((img, index) => {
            img.addEventListener('click', () => this.openPopup(index));
        });

        // Flecha flotante
        if (this.arrow) {
            const descripcionSection = document.getElementById('descripcion');

            window.addEventListener('scroll', () => {
                if (!descripcionSection) return;

                const descripcionPosition = descripcionSection.getBoundingClientRect().top;
                const windowHeight = window.innerHeight;

                if (descripcionPosition < windowHeight - 100) {
                    this.arrow.classList.add('hide-arrow');
                } else {
                    this.arrow.classList.remove('hide-arrow');
                }
            });
        }

        // Pausar slider al interactuar
        this.slider?.addEventListener('mouseenter', this.stopInterval);
        this.slider?.addEventListener('mouseleave', this.startInterval);
    }
}

// Inicialización cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', () => {
    const sliderContainer = document.querySelector('.slider-container');
    const imageSlider = new ImageSlider();
    imageSlider.init(sliderContainer);
});