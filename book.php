<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$page_title = "Book a Service";
require_once __DIR__ . "/includes/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id        = $_SESSION['user_id'];
    $service_id     = intval($_POST['service_id']);
    $vehicle_number = trim($_POST['vehicle_number']);
    $vehicle_type   = trim($_POST['vehicle_type']);
    $booking_date   = $_POST['booking_date'];
    $booking_time   = $_POST['booking_time'];

    if ($vehicle_number === "" || $booking_date === "" || $booking_time === "") {
        $error = "Please fill in all required fields.";
    } elseif ($booking_date < date("Y-m-d")) {
        $error = "Booking date cannot be in the past.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO bookings (user_id, service_id, vehicle_number, vehicle_type, booking_date, booking_time)
             VALUES (?, ?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("iissss", $user_id, $service_id, $vehicle_number, $vehicle_type, $booking_date, $booking_time);

        if ($stmt->execute()) {
            $success = "Your service has been booked successfully!";
        } else {
            $error = "Booking failed. Please try again.";
        }
        $stmt->close();
    }
}

$services = $conn->query("SELECT * FROM services ORDER BY service_name ASC");
$preselect = isset($_GET['service']) ? intval($_GET['service']) : 0;

require_once __DIR__ . "/includes/header.php";
?>

<div class="form-wrapper" style="max-width:520px;">
    <h2>Book a Vehicle Service</h2>

    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>

    <form method="POST" action="book.php" onsubmit="return validateBookingForm()">
        <div class="form-group">
            <label for="service_id">Select Service</label>
            <select id="service_id" name="service_id" required>
                <option value="">-- Choose a service --</option>
                <?php while ($s = $services->fetch_assoc()): ?>
                    <option value="<?php echo $s['service_id']; ?>"
                        data-price="<?php echo $s['price']; ?>"
                        data-duration="<?php echo $s['duration_mins']; ?>"
                        <?php echo ($preselect == $s['service_id']) ? 'selected' : ''; ?>>
                        <?php echo htmlspecialchars($s['service_name']); ?>
                    </option>
                <?php endwhile; ?>
            </select>
            <div id="service_preview" style="display:none;margin-top:8px;color:#0d2b4e;font-size:.9rem;"></div>
        </div>

        <div class="form-group">
            <label for="vehicle_type">Vehicle Type</label>
            <select id="vehicle_type" name="vehicle_type" required>
                <option value="Car">Car</option>
                <option value="Bike">Bike / Two-Wheeler</option>
            </select>
        </div>

        <div class="form-group">
            <label for="vehicle_number">Vehicle Number</label>
            <input type="text" id="vehicle_number" name="vehicle_number" placeholder="e.g. TN-59-AB-1234" required>
            <span class="form-error" id="vehicle_number_error"></span>
        </div>

        <div class="form-group">
            <label for="booking_date">Preferred Date</label>
            <input type="date" id="booking_date" name="booking_date" required>
            <span class="form-error" id="booking_date_error"></span>
        </div>

        <div class="form-group">
            <label for="booking_time">Preferred Time</label>
            <input type="time" id="booking_time" name="booking_time" required>
        </div>

        <button type="submit" class="btn">Confirm Booking</button>
    </form>
</div>

<script>document.addEventListener("DOMContentLoaded", updateServicePreview);</script>

<?php
$conn->close();
require_once __DIR__ . "/includes/footer.php";
?>
