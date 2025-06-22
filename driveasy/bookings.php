<?php
require_once('init.php');// Initialize session and other settings
include('db_connect.php');// Include the database connection file

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$currentPage = 'bookings';// Set the current page for active link highlighting
$pageTitle = 'My Bookings';// Set the page title for the header
include('includes/header.php');// Include the header file for consistent layout

// Get user bookings from database
$bookings = [];
$user_id = $_SESSION['user_id'];// Get the user ID from session

$query = "
    SELECT b.id, b.pickup_date, b.return_date, b.total_price, b.status, b.created_at,
           c.make, c.model, c.year, c.type, c.image_url
    FROM bookings b
    JOIN cars c ON b.car_id = c.id
    WHERE b.user_id = ?
    ORDER BY b.pickup_date DESC
";

if ($stmt = $conn->prepare($query)) {// Prepare the SQL statement to prevent SQL injection
    $stmt->bind_param("i", $user_id);// Bind the user ID parameter
    $stmt->execute();// Execute the statement
    // Get the result set from the prepared statement
    $result = $stmt->get_result();
    $bookings = $result->fetch_all(MYSQLI_ASSOC);// Fetch all bookings as an associative array
    $stmt->close();// Close the statement
}
?>

<section class="my-bookings">
    <div class="container">
        <h2 class="section-title">My Bookings</h2>
        
        <?php if (empty($bookings)): ?><!-- Check if there are no bookings -->
            <div class="no-bookings"><!-- Display message when no bookings are found -->
                <p>You haven't made any bookings yet.</p><!-- Message to inform user -->
                <a href="cars.php" class="btn">Browse Cars</a><!-- Link to browse available cars -->
            </div>
        <?php else: ?>
            <div class="bookings-list">
                <?php foreach ($bookings as $booking): ?>
                    <div class="booking-card">
                        <div class="booking-header">
                            <!-- Display car make, model, and year -->
                            <h3><?= htmlspecialchars($booking['make']) ?> <?= htmlspecialchars($booking['model']) ?> (<?= htmlspecialchars($booking['year']) ?>)</h3>
                            <!-- Display booking status -->
                            <span class="booking-status <?= $booking['status'] ?>">
                                <?= ucfirst($booking['status']) ?><!---- Capitalize the status for better readability -->
                            </span>
                        </div>
                        
                        <div class="booking-details">
                            <?php if ($booking['image_url']): ?>
                                <div class="booking-image">
                                    <img src="assets/images/<?= $booking['image_url'] ?>" alt="<?= htmlspecialchars($booking['make']) ?>">
                                </div>
                            <?php endif; ?>
                            
                            <div class="booking-info">
                                <div class="booking-dates"><!-- Display booking dates -->
                                    <p><strong>Pickup Date:</strong> <?= date('M d, Y', strtotime($booking['pickup_date'])) ?></p>
                                    <p><strong>Return Date:</strong> <?= date('M d, Y', strtotime($booking['return_date'])) ?></p>
                                    <p><strong>Booking Date:</strong> <?= date('M d, Y', strtotime($booking['created_at'])) ?></p>
                                    </div>
                                        <?php if ($booking['status'] == 'pending'): ?><!-- If booking is pending, show cancel option -->
                                            <div class="booking-actions">
                                                <form action="cancel-booking.php" method="POST"><!-- Form to cancel booking -->
                                                    <input type="hidden" name="booking_id" value="<?= $booking['id'] ?>">
                                                    <button type="submit" class="btn btn-cancel">Cancel Booking</button>
                                                </form>
                                            </div>
                                        <?php endif; ?><!-- End of booking actions -->
                                <div class="booking-price"><!-- Display total price -->
                                    <p><strong>Total Price:</strong> ৳<?= number_format($booking['total_price'], 2) ?></p>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include('includes/footer.php'); ?><!-- Include footer file for consistent layout -->