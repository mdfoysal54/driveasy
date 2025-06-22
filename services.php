<?php
require_once('init.php'); // Include the initialization file for session management and timezone settings
require_once 'db_connect.php';// Include the database connection file
// Set the current page and title for the header
$currentPage = 'services'; // Set the current page for active link highlighting
$pageTitle = 'Our Services'; // Set the page title for the header
// Include the header file for consistent layout
include('includes/header.php'); 

// Fetch services from database
$sql = "SELECT * FROM services";
$result = $conn->query($sql);   // Query to select all services from the database
?>

<section class="features">
    <div class="container">
        <h2 class="section-title">Our Services</h2>
        <div class="feature-grid">
            <?php if ($result->num_rows > 0): ?> <!--Check if there are any services available-->
                <?php while($service = $result->fetch_assoc()): ?> <!--Loop through each service and display it-->
                    <div class="feature">
                        <i><?= $service['icon'] ?></i> <!-- Display the service icon-->
                        <h3><?= $service['title'] ?></h3>
                        <p><?= $service['description'] ?></p>
                    </div>
                <?php endwhile; ?> <!-- End of service loop-->
            <?php else: ?>
                <p>No services available at the moment.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<?php 
$conn->close(); // Close the database connection
// Include the footer file for consistent layout
include('includes/footer.php'); 
?>