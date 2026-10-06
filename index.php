<?php
$page_title = "Home";
require_once __DIR__ . "/includes/header.php";
?>

<section class="hero">
    <h1>Vehicle Services Booking System</h1>
    <p>Book car & bike servicing online — fast, reliable, and hassle-free.</p>
    <a href="services.php" class="btn">View Services</a>
</section>

<section class="section">
    <h2>Why Choose Us?</h2>
    <div class="cards">
        <div class="card">
            <h3>🛠 Expert Technicians</h3>
            <p>Certified mechanics for cars and two-wheelers.</p>
        </div>
        <div class="card">
            <h3>📅 Easy Online Booking</h3>
            <p>Book a slot in under a minute, from anywhere.</p>
        </div>
        <div class="card">
            <h3>💰 Transparent Pricing</h3>
            <p>No hidden charges — see the price before you book.</p>
        </div>
    </div>
</section>

<?php require_once __DIR__ . "/includes/footer.php"; ?>
