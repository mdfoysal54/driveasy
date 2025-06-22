<?php
$currentPage = 'cars';// Set the current page for active link highlighting
$pageTitle = 'Our Cars';          // Set the page title for the header
require_once('init.php');  // Include the initialization file for session management and other settings
include('includes/header.php'); // Include the header file for consistent layout
include('db_connect.php');  // Include the database connection file

// Get cars from database
$cars = [];
$query = "SELECT * FROM cars";
$result = $conn->query($query);

if ($result) { // Check if the query was successful
    $cars = $result->fetch_all(MYSQLI_ASSOC); // Fetch all cars as an associative array
    // Check if there are any errors in the query
    $result->free();
}
?>

<section class="cars-listing"> <!-- Cars listing section to display all available cars -->
    <div class="container">
        <h2 class="section-title">Our Fleet</h2> <!-- Section title for the cars listing -->
        <?php if (empty($cars)): ?> <!-- Check if there are no cars available -->
            <p>No cars available at the moment.</p> <!-- Message to display when no cars are found -->
        <?php else: ?>  <!-- If there are cars available, display them in a grid -->
            <div class="cars-grid">
                <?php foreach ($cars as $car): ?> <!-- Loop through each car and display its details -->
                    <div class="car-card">
                        <!-- Make sure this link points to car-detail.php -->
                        <a href="car-details.php?id=<?= $car['id'] ?>"> <!-- Link to the car details page with the car ID -->   
                            <?php if (!empty($car['image_url'])): ?>
                                <div class="car-image" style="background-image: url('assets/images/<?= $car['image_url'] ?>')"></div><!-- Display the car image if available -->
                            <?php else: ?>
                                <div class="car-image" style="background-image: url('assets/images/default-car.jpg')"></div><!-- Default image if no car image is available -->
                            <?php endif; ?>
                            <div class="car-details">
                                <h3><?= htmlspecialchars($car['make']) ?> <?= htmlspecialchars($car['model']) ?></h3><!-- Display the car make and model -->
                                <div class="car-meta">
                                    <?= htmlspecialchars($car['year']) ?> • <?= htmlspecialchars($car['type']) ?><!-- Display the car year and type -->
                                </div>
                                <div class="car-price">
                                    ৳<?= number_format($car['price_per_day'], 2) ?> per day<!-- Display the price per day -->
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?> <!-- End of car loop -->
            </div> <!-- End of cars grid -->
        <?php endif; ?> <!-- End of cars check -->
    </div>
</section>

<?php include('includes/footer.php'); ?> <!-- Include footer file for consistent layout -->