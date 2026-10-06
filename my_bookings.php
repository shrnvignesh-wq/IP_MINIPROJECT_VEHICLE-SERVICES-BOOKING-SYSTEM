<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$page_title = "My Bookings";
require_once __DIR__ . "/includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$stmt = $conn->prepare(
    "SELECT b.booking_id, s.service_name, b.vehicle_number, b.vehicle_type,
            b.booking_date, b.booking_time, b.status
     FROM bookings b JOIN services s ON b.service_id = s.service_id
     WHERE b.user_id = ? ORDER BY b.booking_date DESC"
);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

require_once __DIR__ . "/includes/header.php";
?>

<section class="section">
    <h2>My Bookings</h2>
    <table>
        <tr>
            <th>#</th><th>Service</th><th>Vehicle</th><th>Date</th><th>Time</th><th>Status</th>
        </tr>
        <?php if ($result->num_rows === 0): ?>
            <tr><td colspan="6" style="text-align:center;">No bookings yet.</td></tr>
        <?php else: while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td>#<?php echo $row['booking_id']; ?></td>
                <td><?php echo htmlspecialchars($row['service_name']); ?></td>
                <td><?php echo htmlspecialchars($row['vehicle_number']) . " (" . $row['vehicle_type'] . ")"; ?></td>
                <td><?php echo $row['booking_date']; ?></td>
                <td><?php echo $row['booking_time']; ?></td>
                <td><span class="status status-<?php echo $row['status']; ?>"><?php echo $row['status']; ?></span></td>
            </tr>
        <?php endwhile; endif; ?>
    </table>
</section>

<?php
$stmt->close();
$conn->close();
require_once __DIR__ . "/includes/footer.php";
?>
