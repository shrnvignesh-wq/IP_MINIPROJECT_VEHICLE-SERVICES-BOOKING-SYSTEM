<?php
$page_title = "Register";
require_once __DIR__ . "/includes/db.php";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST['full_name']);
    $email     = trim($_POST['email']);
    $phone     = trim($_POST['phone']);
    $password  = $_POST['password'];

    if ($full_name === "" || $email === "" || $phone === "" || $password === "") {
        $error = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (strlen($password) < 6) {
        $error = "Password must be at least 6 characters.";
    } else {
        // Check for duplicate email
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "An account with this email already exists.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert = $conn->prepare(
                "INSERT INTO users (full_name, email, phone, password) VALUES (?, ?, ?, ?)"
            );
            $insert->bind_param("ssss", $full_name, $email, $phone, $hashed_password);

            if ($insert->execute()) {
                $success = "Registration successful! You can now log in.";
            } else {
                $error = "Something went wrong. Please try again.";
            }
            $insert->close();
        }
        $stmt->close();
    }
}

require_once __DIR__ . "/includes/header.php";
?>

<div class="form-wrapper">
    <h2>Create an Account</h2>

    <?php if ($success): ?><div class="alert alert-success"><?php echo $success; ?></div><?php endif; ?>
    <?php if ($error): ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>

    <form method="POST" action="register.php" onsubmit="return validateRegisterForm()">
        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" required>
            <span class="form-error" id="full_name_error"></span>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <span class="form-error" id="email_error"></span>
        </div>
        <div class="form-group">
            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" maxlength="10" required>
            <span class="form-error" id="phone_error"></span>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <span class="form-error" id="password_error"></span>
        </div>
        <button type="submit" class="btn">Register</button>
    </form>
    <div class="form-footer">Already have an account? <a href="login.php">Login here</a></div>
</div>

<?php
$conn->close();
require_once __DIR__ . "/includes/footer.php";
?>
