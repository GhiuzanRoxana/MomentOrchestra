document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('gallery-carousel');
    
    if (!carousel) return;
    
    const images = carousel.querySelectorAll('img');
    
    if (images.length === 0) return;
    
    let currentIndex = 0;
    let interval;
    
    function showImage(index) {
        images.forEach((img, i) => {
            img.style.display = i === index ? 'block' : 'none';
            img.style.opacity = i === index ? '1' : '0';
        });
        
        const caption = images[index].getAttribute('data-caption');
        let captionElement = carousel.querySelector('.carousel-caption');
        
        if (!captionElement) {
            captionElement = document.createElement('div');
            captionElement.className = 'carousel-caption';
            carousel.appendChild(captionElement);
        }
        
        if (caption) {
            captionElement.textContent = caption;
            captionElement.style.display = 'block';
        } else {
            captionElement.style.display = 'none';
        }
    }
    
    function nextImage() {
        currentIndex = (currentIndex + 1) % images.length;
        showImage(currentIndex);
    }
    
    function prevImage() {
        currentIndex = (currentIndex - 1 + images.length) % images.length;
        showImage(currentIndex);
    }
    
    function startCarousel() {
        interval = setInterval(nextImage, 3000);
    }
    
    function stopCarousel() {
        clearInterval(interval);
    }
    
    let prevBtn = carousel.querySelector('.carousel-prev');
    let nextBtn = carousel.querySelector('.carousel-next');
    
    if (!prevBtn) {
        prevBtn = document.createElement('button');
        prevBtn.className = 'carousel-prev';
        prevBtn.innerHTML = '&#10094;';
        carousel.appendChild(prevBtn);
    }
    
    if (!nextBtn) {
        nextBtn = document.createElement('button');
        nextBtn.className = 'carousel-next';
        nextBtn.innerHTML = '&#10095;';
        carousel.appendChild(nextBtn);
    }
    
    prevBtn.addEventListener('click', function() {
        stopCarousel();
        prevImage();
        startCarousel();
    });
    
    nextBtn.addEventListener('click', function() {
        stopCarousel();
        nextImage();
        startCarousel();
    });
    
    carousel.addEventListener('mouseenter', stopCarousel);
    carousel.addEventListener('mouseleave', startCarousel);
    
    showImage(0);
    startCarousel();
});