<?php
$currentPage = 'home';// Set the current page for active link highlighting
$pageTitle = 'Home';// Set the page title for the header
require_once('init.php'); // Include the initialization file for session management and other settings
include('includes/header.php'); //include header file
?>

<section class="hero">
    <!-- Slideshow container -->
    <div class="hero-slideshow">
        <div class="slide active" style="background-image: url('https://images.unsplash.com/photo-1502877338535-766e1452684a')"></div>
        <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1542362567-b07e54358753')"></div>
        <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1568605117036-5fe5e7bab0b7')"></div>
        <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1494976388531-d1058494cdd8')"></div>
        <div class="slide" style="background-image: url('https://images.unsplash.com/photo-1511919884226-fd3cad34687c')"></div>
    </div>
    
    <div class="container"><!-- Container to center the content -->
        <div class="hero-content"><!-- Hero content for the main message -->
            <h1>Rent The Perfect Car For Your Journey</h1>
            <p>Choose from our wide selection of vehicles at affordable prices</p>
            <a href="cars.php" class="btn">Browse Cars</a>
        </div>
    </div>
    
    <div class="slideshow-controls">
        <div class="slide-btn active"></div><!-- Slide buttons for navigation -->
        <div class="slide-btn"></div><!-- Each button corresponds to a slide -->
        <div class="slide-btn"></div>
        <div class="slide-btn"></div>
        <div class="slide-btn"></div>
    </div>
</section>


<section class="features"> <!-- Features section highlighting the benefits of using DriveEasy-->
    <div class="container"> <!-- Container to center the content-->
        <h2 class="section-title">Why Choose DriveEasy?🚘</h2>
        <div class="feature-grid">
            <div class="feature">
                <i>🚗</i>
                <h3>Wide Selection</h3>
                <p>From economy cars to luxury vehicles, we have options for every need and budget.</p>
            </div>
            <div class="feature"> <!-- Feature highlighting the wide selection of cars -->
                <i>💰</i>
                <h3>Affordable Rates</h3>
                <p>Competitive pricing with no hidden fees. We guarantee the best value for your money.</p>
            </div>
            <div class="feature"> 
                <i>📱</i>
                <h3>Easy Booking</h3>
                <p>Simple online reservation system. Book your car in just a few clicks.</p>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?> <!-- Include footer file for consistent layout-->