<nav>
    <ul>
        <li><a href="index.php" <?= ($currentPage == 'home') ? 'class="active"' : '' ?>>Home</a></li> <!-- Home link with active class if current page is home -->
        <li><a href="cars.php" <?= ($currentPage == 'cars') ? 'class="active"' : '' ?>>Cars</a></li> <!-- Cars link with active class if current page is cars -->
        <li><a href="services.php" <?= ($currentPage == 'services') ? 'class="active"' : '' ?>>Services</a></li>
        <li><a href="about.php" <?= ($currentPage == 'about') ? 'class="active"' : '' ?>>About</a></li>
        <li><a href="contact.php" <?= ($currentPage == 'contact') ? 'class="active"' : '' ?>>Contact</a></li>
        <?php if (isset($_SESSION['user_id'])): ?>
            <li><a href="bookings.php">My Bookings</a></li>
            <li><a href="logout.php">Logout</a></li>
        <?php else: ?>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        <?php endif; ?>
    </ul>
</nav>