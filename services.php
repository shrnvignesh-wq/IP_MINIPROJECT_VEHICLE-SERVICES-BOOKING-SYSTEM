<?php
$page_title = "Services";
require_once __DIR__ . "/includes/db.php";
require_once __DIR__ . "/includes/header.php";

$result = $conn->query("SELECT * FROM services ORDER BY price ASC");
?>

<section class="section">
    <h2>Our Services</h2>
    <div class="cards">
        <?php while ($row = $result->fetch_assoc()): ?>
            <div class="card">
                <h3><?php echo htmlspecialchars($row['service_name']); ?></h3>
                <p><?php echo htmlspecialchars($row['description']); ?></p>
                <div class="price">Rs. <?php echo number_format($row['price'], 2); ?></div>
                <p><small><?php echo $row['duration_mins']; ?> minutes</small></p>
                <a href="book.php?service=<?php echo $row['service_id']; ?>" class="btn">Book Now</a>
            </div>
        <?php endwhile; ?>
    </div>
</section>

<?php
$conn->close();
require_once __DIR__ . "/includes/footer.php";
?>
