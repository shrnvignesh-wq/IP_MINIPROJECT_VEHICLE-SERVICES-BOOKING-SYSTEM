<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$page_title = "Login";
require_once __DIR__ . "/includes/db.php";

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT user_id, full_name, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id']   = $user['user_id'];
            $_SESSION['full_name'] = $user['full_name'];
            header("Location: index.php");
            exit();
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "No account found with that email.";
    }
    $stmt->close();
}

require_once __DIR__ . "/includes/header.php";
?>

<div class="form-wrapper">
    <h2>Login</h2>
    <?php if ($error): ?><div class="alert alert-error"><?php echo $error; ?></div><?php endif; ?>

    <form method="POST" action="login.php" onsubmit="return validateLoginForm()">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
            <span class="form-error" id="email_error"></span>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
            <span class="form-error" id="password_error"></span>
        </div>
        <button type="submit" class="btn">Login</button>
    </form>
    <div class="form-footer">New here? <a href="register.php">Create an account</a></div>
</div>

<?php
$conn->close();
require_once __DIR__ . "/includes/footer.php";
?>
