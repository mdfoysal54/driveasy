<?php
$currentPage = 'login';// Set the current page for navigation highlighting
$pageTitle = 'Login';// Set the page title for the header
require_once('init.php');// Include the initialization file for session management and other settings
include('includes/header.php');
include('db_connect.php'); // Make sure this contains MySQLi connection

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') { // Check if the form is submitted
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    
    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");// Prepare statement to prevent SQL injection
    $stmt->bind_param("s", $email);// Bind the email parameter
    $stmt->execute();// Execute the statement
    $result = $stmt->get_result();// Get the result set from the prepared statement
    $user = $result->fetch_assoc();  // Fetch the user data if exists
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        header('Location: index.php');
        exit;
    } else {
        $error = 'Invalid email or password';
    }
    
    $stmt->close();
}
?>

<section class="login-form"><!-- Login section for users to access their accounts -->
    <div class="container"><!-- Container for the login form -->
        <h2>Login</h2>
        <?php if ($error): ?><!-- Check if there is an error message to display -->
            <div class="error-message"><!-- Display error message if login fails -->
                <p><?= $error ?></p><!-- Show the error message -->
            </div>
        <?php endif; ?><!-- End of error message display -->
        <form method="POST"><!-- Form method set to POST for secure data submission -->
            <div class="form-group"><!-- Form group for email input -->
                <label>Email</label>
                <input type="email" name="email" required><!-- Input field for email, required for login -->
            </div>
            <div class="form-group"><!-- Form group for password input -->
                <label>Password</label>
                <input type="password" name="password" required><!-- Input field for password, required for login -->
            </div>
            <button type="submit" class="btn">Login</button><!-- Submit button for the login form -->
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p><!-- Link to registration page for new users -->
    </div>
</section>

<?php include('includes/footer.php'); ?><!-- Include footer file for consistent layout -->