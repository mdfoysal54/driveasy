<?php
require_once('init.php');
require_once 'db_connect.php';  // Include the database connection file
$currentPage = 'contact';       // Set the current page for active link highlighting
$pageTitle = 'Contact Us';      // Set the page title for the header
$success = false;

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];         // Get the name from the form
    $email = $_POST['email'];       // Get the email from the form
    $phone = $_POST['phone'];       // Get the phone number from the form
    $message = $_POST['message'];   // Get the message from the form
    
    $stmt = $conn->prepare("INSERT INTO messages (name, email, phone, message) VALUES (?, ?, ?, ?)");// Prepare the SQL statement to prevent SQL injection
    $stmt->bind_param("ssss", $name, $email, $phone, $message);// Bind the parameters to the SQL query
    
    if ($stmt->execute()) { // Execute the prepared statement
        // If the execution is successful, set success to true
        $success = true;// Set success flag to true
    }
    
    $stmt->close(); // Close the prepared statement
}

include('includes/header.php'); // Include header file for consistent layout
?>

<section class="features">      <!-- Contact section for users to reach out -->
    <div class="container">
        <h2 class="section-title">Contact Us</h2>
        
        <?php if ($success): ?>
            <div class="message-confirmation">
                <p>Thank you for your message! We'll get back to you soon.</p>
            </div>
        <?php endif; ?>
        
        <div class="contact-form"> <!-- Contact form for users to fill out -->
            <form method="POST">    <!--Form method set to POST for secure data submission -->
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" required>
                </div>
                
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required>
                </div>
                
                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone">
                </div>
                
                <div class="form-group">
                    <label for="message">Message</label>
                    <textarea id="message" name="message" required></textarea>
                </div>
                
                <button type="submit" class="submit-btn">Send Message</button>
            </form>
        </div>
    </div>
</section>

<?php 
$conn->close();     // Close the database connection
// Include footer file for consistent layout
include('includes/footer.php'); 
?>