
// Slideshow functionality
document.addEventListener('DOMContentLoaded', function() {
    const heroSection = document.querySelector('.hero');
    
    // Only run on pages with hero section
    if (!heroSection) return;
    
    // Get all slides and buttons
    const slides = document.querySelectorAll('.slide'); 
    const buttons = document.querySelectorAll('.slide-btn');
    let currentSlide = 0;
    let slideInterval;
    
    // Function to show a specific slide
    function showSlide(index) {
        // Remove active class from all slides and buttons
        slides.forEach(slide => slide.classList.remove('active'));
        buttons.forEach(button => button.classList.remove('active'));
        
        // Add active class to current slide and button
        slides[index].classList.add('active');
        buttons[index].classList.add('active');
        currentSlide = index;
    }
    
    // Function to move to next slide
    function nextSlide() {
        const nextIndex = (currentSlide + 1) % slides.length;
        showSlide(nextIndex);
    }
    
    // Start the slideshow
    function startSlideshow() {
        slideInterval = setInterval(nextSlide, 5000); // Change slide every 5 seconds
    }
    
    // Add click events to buttons
    buttons.forEach((button, index) => {
        button.addEventListener('click', () => {
            clearInterval(slideInterval);
            showSlide(index);
            startSlideshow();
        });
    });
    
    // Start the slideshow if there are slides
    if (slides.length > 0) {
        startSlideshow();
    }
});
