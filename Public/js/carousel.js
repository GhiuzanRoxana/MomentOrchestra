class ImageCarousel {
    constructor(containerId, options = {}) {
        this.container = document.getElementById(containerId);
        if (!this.container) {
            console.error(`Container ${containerId} not found!`);
            return;
        }
        
        this.images = [];
        this.currentIndex = 0;
        this.autoPlayInterval = null;
        
        this.options = {
            autoPlay: options.autoPlay !== undefined ? options.autoPlay : true,
            autoPlayDelay: options.autoPlayDelay || 3000,
            showIndicators: options.showIndicators !== undefined ? options.showIndicators : true,
            showControls: options.showControls !== undefined ? options.showControls : true,
            loop: options.loop !== undefined ? options.loop : true
        };
        
        this.init();
    }
    
    init() {
        this.createCarouselStructure();
        this.loadImages();
        this.attachEventListeners();
        
        if (this.options.autoPlay) {
            this.startAutoPlay();
        }
    }
    
    createCarouselStructure() {
        this.container.innerHTML = `
            <div class="carousel-wrapper">
                <div class="carousel-slides"></div>
                ${this.options.showControls ? `
                    <button class="carousel-control prev" aria-label="Previous">
                        <span>❮</span>
                    </button>
                    <button class="carousel-control next" aria-label="Next">
                        <span>❯</span>
                    </button>
                ` : ''}
                ${this.options.showIndicators ? `
                    <div class="carousel-indicators"></div>
                ` : ''}
            </div>
        `;
        
        this.slidesContainer = this.container.querySelector('.carousel-slides');
        this.indicatorsContainer = this.container.querySelector('.carousel-indicators');
    }
    
    loadImages() {
        const imageElements = this.container.querySelectorAll('img, [data-carousel-image]');
        
        imageElements.forEach((img, index) => {
            const src = img.src || img.getAttribute('data-carousel-image');
            const alt = img.alt || `Slide ${index + 1}`;
            const caption = img.getAttribute('data-caption') || '';
            
            this.images.push({ src, alt, caption });
        });
        
        if (this.images.length === 0) {
            this.images = [
                { src: 'Images/gallery/img1.jpg', alt: 'Concert 1', caption: 'Concert Simfonic' },
                { src: 'Images/gallery/img2.jpg', alt: 'Concert 2', caption: 'Recital de Pian' },
                { src: 'Images/gallery/img3.jpg', alt: 'Concert 3', caption: 'Orchestra de Cameră' }
            ];
        }
        
        this.renderSlides();
        this.renderIndicators();
        this.showSlide(0);
    }
    
    renderSlides() {
        this.slidesContainer.innerHTML = '';
        
        this.images.forEach((image, index) => {
            const slide = document.createElement('div');
            slide.className = 'carousel-slide';
            slide.innerHTML = `
                <img src="${image.src}" alt="${image.alt}" loading="lazy">
                ${image.caption ? `<div class="carousel-caption">${image.caption}</div>` : ''}
            `;
            this.slidesContainer.appendChild(slide);
        });
    }
    
    renderIndicators() {
        if (!this.options.showIndicators || !this.indicatorsContainer) return;
        
        this.indicatorsContainer.innerHTML = '';
        
        this.images.forEach((_, index) => {
            const indicator = document.createElement('button');
            indicator.className = 'carousel-indicator';
            indicator.setAttribute('aria-label', `Slide ${index + 1}`);
            indicator.addEventListener('click', () => this.goToSlide(index));
            this.indicatorsContainer.appendChild(indicator);
        });
    }
    
    showSlide(index) {
        const slides = this.slidesContainer.querySelectorAll('.carousel-slide');
        const indicators = this.indicatorsContainer?.querySelectorAll('.carousel-indicator');
        
        slides.forEach(slide => slide.classList.remove('active'));
        indicators?.forEach(indicator => indicator.classList.remove('active'));
        
        if (slides[index]) {
            slides[index].classList.add('active');
        }
        
        if (indicators && indicators[index]) {
            indicators[index].classList.add('active');
        }
        
        this.currentIndex = index;
    }
    
    nextSlide() {
        let nextIndex = this.currentIndex + 1;
        
        if (nextIndex >= this.images.length) {
            nextIndex = this.options.loop ? 0 : this.currentIndex;
        }
        
        this.goToSlide(nextIndex);
    }
    
    prevSlide() {
        let prevIndex = this.currentIndex - 1;
        
        if (prevIndex < 0) {
            prevIndex = this.options.loop ? this.images.length - 1 : 0;
        }
        
        this.goToSlide(prevIndex);
    }
    
    goToSlide(index) {
        if (index >= 0 && index < this.images.length) {
            this.showSlide(index);
            this.resetAutoPlay();
        }
    }
    
    startAutoPlay() {
        this.autoPlayInterval = setInterval(() => {
            this.nextSlide();
        }, this.options.autoPlayDelay);
    }
    
    stopAutoPlay() {
        if (this.autoPlayInterval) {
            clearInterval(this.autoPlayInterval);
            this.autoPlayInterval = null;
        }
    }
    
    resetAutoPlay() {
        if (this.options.autoPlay) {
            this.stopAutoPlay();
            this.startAutoPlay();
        }
    }
    
    attachEventListeners() {
        const prevBtn = this.container.querySelector('.carousel-control.prev');
        const nextBtn = this.container.querySelector('.carousel-control.next');
        
        if (prevBtn) {
            prevBtn.addEventListener('click', () => this.prevSlide());
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', () => this.nextSlide());
        }
        
        document.addEventListener('keydown', (e) => {
            if (e.key === 'ArrowLeft') {
                this.prevSlide();
            } else if (e.key === 'ArrowRight') {
                this.nextSlide();
            }
        });
        
        this.container.addEventListener('mouseenter', () => {
            this.stopAutoPlay();
        });
        
        this.container.addEventListener('mouseleave', () => {
            if (this.options.autoPlay) {
                this.startAutoPlay();
            }
        });
        
        this.addTouchSupport();
    }
    
    addTouchSupport() {
        let touchStartX = 0;
        let touchEndX = 0;
        
        this.container.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
        });
        
        this.container.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe(touchStartX, touchEndX);
        });
    }
    
    handleSwipe(startX, endX) {
        const swipeThreshold = 50;
        const diff = startX - endX;
        
        if (Math.abs(diff) > swipeThreshold) {
            if (diff > 0) {
                this.nextSlide();
            } else {
                this.prevSlide();
            }
        }
    }
}

document.addEventListener('DOMContentLoaded', () => {
    const galleryCarousel = document.getElementById('gallery-carousel');
    
    if (galleryCarousel) {
        new ImageCarousel('gallery-carousel', {
            autoPlay: true,
            autoPlayDelay: 4000,
            showIndicators: true,
            showControls: true,
            loop: true
        });
    }
});