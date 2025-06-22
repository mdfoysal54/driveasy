<?php
$currentPage = 'register';// Set the current page for active link highlighting
$pageTitle = 'Register';// Set the page title for the header
require_once('init.php');// Include the initialization file for session management and other settings
include('includes/header.php');// Include the header file for consistent layout
include('db_connect.php'); // Make sure this contains MySQLi connection

$errors = [];// Initialize an array to hold error messages
$name = $email = $phone = '';// Initialize variables to hold form input values

if ($_SERVER['REQUEST_METHOD'] == 'POST') {// Check if the form is submitted
    $name = trim($_POST['name']);// Get the name from the form input
    $email = trim($_POST['email']);// Get the email from the form input
    $phone = trim($_POST['phone']);// Get the phone number from the form input
    $password = $_POST['password'];//   Get the password from the form input
    $confirm_password = $_POST['confirm_password'];// Get the confirm password from the form input

    // Validation
    if (empty($name)) $errors[] = 'Name is required';// Check if name is provided
    if (empty($email)) $errors[] = 'Email is required';// Check if email is provided
    if (empty($password)) $errors[] = 'Password is required';// Check if password is provided
    if ($password !== $confirm_password) $errors[] = 'Passwords do not match';// Check if passwords match

    // Check if email exists
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");// Prepare statement to prevent SQL injection
        $stmt->bind_param("s", $email);// Bind the email parameter
        $stmt->execute();// Execute the statement
        $result = $stmt->get_result();// Get the result set from the prepared statement
        
        if ($result->num_rows > 0) {// Check if any rows are returned
            $errors[] = 'Email already exists';// If email exists, add error message
        }
        $stmt->close();// Close the statement
    }

    if (empty($errors)) {// If there are no errors, proceed with registration
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);      // Hash the password for security
        $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)");// Prepare statement to prevent SQL injection
        $stmt->bind_param("ssss", $name, $email, $phone, $hashed_password);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = 'Registration successful! Please login';
            header('Location: login.php');
            exit;
        } else {
            $errors[] = 'Registration failed: ' . $stmt->error;
        }
        
        $stmt->close();
    }
}
?>

<section class="register-form">
    <div class="container">
        <h2>Create Account</h2>
        <?php if ($errors): ?>
            <div class="error-message">
                <?php foreach ($errors as $error): ?>
                    <p><?= $error ?></p>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
        <form method="POST">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" required value="<?= htmlspecialchars($name) ?>">
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" required value="<?= htmlspecialchars($email) ?>">
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="tel" name="phone" value="<?= htmlspecialchars($phone) ?>">
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" required>
            </div>
            <button type="submit" class="btn">Register</button>
        </form>
        <p>Already have an account? <a href="login.php">Login here</a></p>
    </div>
</section>

<?php include('includes/footer.php'); ?>