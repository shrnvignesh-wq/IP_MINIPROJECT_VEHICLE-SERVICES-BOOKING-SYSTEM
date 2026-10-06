<?php
require_once __DIR__ . "/../includes/db.php";
$page_title = "Admin Dashboard";

// Handle status update (data management feature)
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['booking_id'], $_POST['status'])) {
    $stmt = $conn->prepare("UPDATE bookings SET status = ? WHERE booking_id = ?");
    $stmt->bind_param("si", $_POST['status'], $_POST['booking_id']);
    $stmt->execute();
    $stmt->close();
}

$result = $conn->query(
    "SELECT b.booking_id, u.full_name, u.phone, s.service_name, b.vehicle_number,
            b.vehicle_type, b.booking_date, b.booking_time, b.status
     FROM bookings b
     JOIN users u ON b.user_id = u.user_id
     JOIN services s ON b.service_id = s.service_id
     ORDER BY b.booking_date DESC, b.booking_time DESC"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Dashboard - VSBS</title>
<link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header class="navbar">
    <div class="logo">🚗 VSBS Admin</div>
    <nav><a href="../index.php">Back to Site</a></nav>
</header>

<section class="section">
    <h2>All Service Bookings</h2>
    <table>
        <tr>
            <th>#</th><th>Customer</th><th>Phone</th><th>Service</th>
            <th>Vehicle</th><th>Date</th><th>Time</th><th>Status</th><th>Update</th>
        </tr>
        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td>#<?php echo $row['booking_id']; ?></td>
            <td><?php echo htmlspecialchars($row['full_name']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo htmlspecialchars($row['service_name']); ?></td>
            <td><?php echo htmlspecialchars($row['vehicle_number']) . " (" . $row['vehicle_type'] . ")"; ?></td>
            <td><?php echo $row['booking_date']; ?></td>
            <td><?php echo $row['booking_time']; ?></td>
            <td><span class="status status-<?php echo $row['status']; ?>"><?php echo $row['status']; ?></span></td>
            <td>
                <form method="POST" style="display:flex;gap:6px;">
                    <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                    <select name="status" onchange="this.form.submit()">
                        <?php foreach (['Pending','Confirmed','Completed','Cancelled'] as $s): ?>
                            <option value="<?php echo $s; ?>" <?php echo $row['status']==$s?'selected':''; ?>><?php echo $s; ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</section>

<footer>&copy; <?php echo date("Y"); ?> Vehicle Services Booking System - Admin Panel</footer>
</body>
</html>
<?php $conn->close(); ?>
