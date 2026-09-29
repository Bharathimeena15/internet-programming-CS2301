<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';

if (isLoggedIn()) {
    redirect("index.php");
}

$pageTitle = "Register";
$basePath = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $address = trim($_POST['address'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // ---- Server-side validation ----
    if ($full_name === '' || $email === '' || $phone === '' || $password === '') {
        $errors[] = "Please fill in all required fields.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Please enter a valid email address.";
    }
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        $errors[] = "Phone number must be exactly 10 digits.";
    }
    if (strlen($password) < 6) {
        $errors[] = "Password must be at least 6 characters long.";
    }
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match.";
    }

    // ---- Check for duplicate email ----
    if (empty($errors)) {
        $stmt = $conn->prepare("SELECT user_id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $errors[] = "An account with this email already exists.";
        }
        $stmt->close();
    }

    // ---- Insert new user ----
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (full_name, email, phone, password, address, role) VALUES (?, ?, ?, ?, ?, 'customer')");
        $stmt->bind_param("sssss", $full_name, $email, $phone, $hashedPassword, $address);

        if ($stmt->execute()) {
            $_SESSION['flash_message'] = "Registration successful! Please log in.";
            $_SESSION['flash_type'] = "success";
            redirect("login.php");
        } else {
            $errors[] = "Something went wrong. Please try again.";
        }
        $stmt->close();
    }
}

include 'includes/header.php';
?>

<div class="form-card">
    <h2>Create an Account</h2>

    <?php if (!empty($errors)): ?>
        <div class="form-error">
            <?php foreach ($errors as $e) echo "<p>" . clean($e) . "</p>"; ?>
        </div>
    <?php endif; ?>

    <form id="registerForm" method="POST" action="register.php" novalidate>
        <div class="form-group">
            <label for="full_name">Full Name</label>
            <input type="text" id="full_name" name="full_name" required value="<?php echo isset($_POST['full_name']) ? clean($_POST['full_name']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? clean($_POST['email']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="phone">Phone (10 digits)</label>
            <input type="text" id="phone" name="phone" maxlength="10" required value="<?php echo isset($_POST['phone']) ? clean($_POST['phone']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="address">Delivery Address</label>
            <textarea id="address" name="address" rows="2"><?php echo isset($_POST['address']) ? clean($_POST['address']) : ''; ?></textarea>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
        </div>
        <p class="form-error" id="registerError"></p>
        <button type="submit" class="btn btn-primary" style="width:100%;">Register</button>
    </form>
    <p class="form-footer-text">Already have an account? <a href="login.php">Login here</a></p>
</div>

<?php include 'includes/footer.php'; ?>
