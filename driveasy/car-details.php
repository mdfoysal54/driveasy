<?php
require_once('init.php'); // Include the initialization file for session management and timezone settings
include('db_connect.php'); // Include the database connection file
// Set the current page and title for the header
$currentPage = 'cars';
$pageTitle = 'Car Details'; // Set the current page for active link highlighting
include('includes/header.php');// Include the header file for consistent layout

$car_id = $_GET['id'] ?? 0;// Ensure car_id is set and is a valid integer

// Get car details from database
$car = null;
if ($stmt = $conn->prepare("SELECT * FROM cars WHERE id = ?")) { // Prepare statement to prevent SQL injection
    $car_id = (int)$car_id; // Cast to integer for safety
    $stmt->bind_param("i", $car_id); // Bind the parameter
    // Execute the statement and fetch the result
    $stmt->execute();    
    $result = $stmt->get_result();// Get the result set from the prepared statement
    // Fetch the car details
    $car = $result->fetch_assoc();
    $stmt->close();// Close the statement
}

// Redirect if car not found
if (!$car) {
    header('Location: cars.php');
    exit;
}

$errors = [];// Initialize an array to hold error messages
$bookingSuccess = false;// Flag to indicate if booking was successful

// Process booking form
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['user_id'])) {
    $pickup_date = $_POST['pickup_date'];
    $return_date = $_POST['return_date'];
    
    // Validate dates
    $today = date('Y-m-d');// Get today's date
    if (empty($pickup_date)) $errors[] = 'Pickup date is required';// Check if pickup date is provided
    if (empty($return_date)) $errors[] = 'Return date is required';
    if ($pickup_date < $today) $errors[] = 'Pickup date cannot be in the past';
    if ($return_date < $pickup_date) $errors[] = 'Return date must be after pickup date';
    
    if (empty($errors)) {
        // Calculate total price
        $days = (strtotime($return_date) - strtotime($pickup_date)) / (60 * 60 * 24);
        $total_price = $days * $car['price_per_day'];
        
        // Create booking
        $user_id = $_SESSION['user_id'];
        // Prepare statement to prevent SQL injection
        if ($stmt = $conn->prepare("INSERT INTO bookings (user_id, car_id, pickup_date, return_date, total_price) VALUES (?, ?, ?, ?, ?)")) {
            $stmt->bind_param("iissd", $user_id, $car['id'], $pickup_date, $return_date, $total_price);
            $stmt->execute();// Execute the statement
            $stmt->close();// Close the statement
            $bookingSuccess = true;// Set booking success flag
        }
    }
}
?>

<section class="car-detail"><!-- Car detail section to display individual car information -->
    <div class="container">
        <div class="car-detail-content">
            <div class="car-image">
                <?php if (!empty($car['image_url'])): ?><!-- If car image is available, display it -->
                    <img src="assets/images/<?= $car['image_url'] ?>">
                <?php else: ?><!-- If no image is available, show a default image -->
                    <img src="assets/images/default-car.jpg" alt="Default Car Image">
                <?php endif; ?>
            </div>
            <div class="car-info">
                <h2><?= htmlspecialchars($car['make']) ?> <?= htmlspecialchars($car['model']) ?> (<?= htmlspecialchars($car['year']) ?>)</h2>
                <div class="car-meta">Type: <?= htmlspecialchars($car['type']) ?></div>
                <div class="car-price">Price per day: ৳<?= number_format($car['price_per_day'], 2) ?></div>
                
                <?php if ($bookingSuccess): ?><!-- If booking was successful, show confirmation message -->
                    <div class="message-confirmation">
                        <p>Booking successful! Thank you for choosing DriveEasy.</p>
                    </div>
                <?php else: ?>
                    <?php if ($errors): ?>
                        <div class="error-message">
                            <?php foreach ($errors as $error): ?>
                                <p><?= $error ?></p>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (isset($_SESSION['user_id'])): ?> <!-- Check if user is logged in -->
                        <h3>Book This Car</h3>
                        <form method="POST">
                            <div class="form-group">
                                <label>Pickup Date</label>
                                <input type="date" name="pickup_date" required min="<?= date('Y-m-d') ?>">
                            </div>
                            <div class="form-group">
                                <label>Return Date</label>
                                <input type="date" name="return_date" required min="<?= date('Y-m-d') ?>">
                            </div>
                            <button type="submit" class="btn">Confirm Booking</button>
                        </form>
                    <?php else: ?>
                        <p><a href="login.php">Login</a> to book this car</p>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<script>
    // Set min return date based on pickup date
    document.addEventListener('DOMContentLoaded', function() {
        const pickupInput = document.querySelector('input[name="pickup_date"]');// input pickup_data
        const returnInput = document.querySelector('input[name="return_date"]');//inpuut return_ date 
        
        if (pickupInput && returnInput) {
            pickupInput.addEventListener('change', function() {
                returnInput.min = this.value;
            });
        }
    });
</script>

<?php include('includes/footer.php'); ?>