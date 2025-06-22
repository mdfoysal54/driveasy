<?php
$currentPage = 'about';
$pageTitle = 'About Us';
require_once('init.php');
include('includes/header.php'); 
?>

<section class="features">
    <div class="container">
        <h2 class="section-title">About DriveEasy</h2>
        
        <div class="about-content">
            <div class="about-text">
                <h3>Our Story</h3>
                <p>Founded in 2010, DriveEasy has grown to become one of Bangladesh's leading car rental services. We started with just 3 cars and a dream to make car rental simple and hassle-free.</p>
                
                <h3>Our Mission</h3>
                <p>To provide reliable, affordable, and convenient transportation solutions while delivering exceptional customer service.</p>
                
                <h3>Our Values</h3>
                <ul>
                    <li>Customer Satisfaction Above All</li>
                    <li>Transparency in Pricing</li>
                    <li>Well-Maintained Vehicles</li>
                    <li>Innovative Solutions</li>
                </ul>
            </div>
            
            <div class="about-image" style="background-image: url('https://images.unsplash.com/photo-1580273916550-e323be2ae537')"></div>
        </div>
        
        <div class="feature-grid">
            <div class="feature">
                <h3>15,000+</h3>
                <p>Satisfied Customers</p>
            </div>
            <div class="feature">
                <h3>200+</h3>
                <p>Vehicles in Fleet</p>
            </div>
            <div class="feature">
                <h3>12</h3>
                <p>Locations Nationwide</p>
            </div>
        </div>
    </div>
</section>

<?php include('includes/footer.php'); ?>