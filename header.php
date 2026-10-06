<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($page_title) ? $page_title . " - VSBS" : "Vehicle Services Booking System"; ?></title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="navbar">
    <div class="logo">🚗 VSBS</div>
    <nav>
        <a href="index.php">Home</a>
        <a href="services.php">Services</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="book.php">Book Service</a>
            <a href="my_bookings.php">My Bookings</a>
            <a href="logout.php">Logout (<?php echo htmlspecialchars($_SESSION['full_name']); ?>)</a>
        <?php else: ?>
            <a href="login.php">Login</a>
            <a href="register.php">Register</a>
        <?php endif; ?>
    </nav>
</header>
