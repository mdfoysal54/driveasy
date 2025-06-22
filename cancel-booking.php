<?php
require_once('init.php');// Initialize session and other settings
include('db_connect.php');// Include the database connection file

// Redirect to login if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}
// Set the current page and title for the header
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['booking_id'])) {
    $booking_id = $_POST['booking_id'];
    $user_id = $_SESSION['user_id'];
    
    // Check if booking belongs to user and is pending
    $stmt = $conn->prepare("SELECT id FROM bookings WHERE id = ? AND user_id = ? AND status = 'pending'");
    $stmt->bind_param("ii", $booking_id, $user_id);// Bind the parameters to prevent SQL injection
    $stmt->execute();// Execute the statement
    $result = $stmt->get_result();// Get the result set from the prepared statement
    
    if ($result->num_rows > 0) {
        // Update booking status to cancelled
        $update_stmt = $conn->prepare("UPDATE bookings SET status = 'cancelled' WHERE id = ?");
        $update_stmt->bind_param("i", $booking_id);
        $update_stmt->execute();// Execute the update statement
        $update_stmt->close();// Close the update statement
        
        $_SESSION['success'] = 'Booking cancelled successfully';
    } else {
        $_SESSION['error'] = 'Unable to cancel booking';
    }
    
    $stmt->close();
}

header('Location: bookings.php');// Redirect back to bookings page after cancellation
exit;
?>