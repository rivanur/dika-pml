// Menjaga urutan slide
let slideIndex = 0;
let isAnimating = false;
showSlides(slideIndex);

function changeSlide(n) {
    if (isAnimating) return; // Prevent multiple clicks during animation
    isAnimating = true;
    
    const slides = document.getElementsByClassName('slide');
    const currentSlide = slides[slideIndex];
    
    // Calculate next slide index
    let nextIndex = slideIndex + n;
    if (nextIndex >= slides.length) nextIndex = 0;
    if (nextIndex < 0) nextIndex = slides.length - 1;
    
    // Add sliding out animation to current slide
    currentSlide.classList.add('sliding-out');
    
    // Immediately show and animate in next slide
    slides[nextIndex].classList.add('active');
    slideIndex = nextIndex;
    
    // Remove classes after animation completes
    setTimeout(() => {
        currentSlide.classList.remove('sliding-out', 'active');
        isAnimating = false;
    }, 500);
}

function showSlides(n) {
    const slides = document.getElementsByClassName('slide');
    
    // Handle slide index bounds
    if (n >= slides.length) { slideIndex = 0 }
    if (n < 0) { slideIndex = slides.length - 1 }
    
    // Remove active class from all slides
    for (let i = 0; i < slides.length; i++) {
        slides[i].classList.remove('active');
    }
    
    // Add active class to current slide
    slides[slideIndex].classList.add('active');
}

// Auto slide setiap 10 detik
setInterval(() => {
    if (!isAnimating) {
        changeSlide(1);
    }
}, 10000);
