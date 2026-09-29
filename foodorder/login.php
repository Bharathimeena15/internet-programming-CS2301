<?php
require_once 'includes/functions.php';
require_once 'includes/db.php';

if (isLoggedIn()) {
    redirect("index.php");
}

$pageTitle = "Login";
$basePath = "";
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($email === '' || $password === '') {
        $errors[] = "Please enter both email and password.";
    } else {
        $stmt = $conn->prepare("SELECT user_id, full_name, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['full_name'] = $user['full_name'];
                $_SESSION['role'] = $user['role'];

                $_SESSION['flash_message'] = "Welcome back, " . $user['full_name'] . "!";
                $_SESSION['flash_type'] = "success";

                redirect($user['role'] === 'admin' ? "admin/dashboard.php" : "index.php");
            } else {
                $errors[] = "Incorrect email or password.";
            }
        } else {
            $errors[] = "Incorrect email or password.";
        }
        $stmt->close();
    }
}

include 'includes/header.php';
?>

<div class="form-card">
    <h2>Login</h2>

    <?php if (!empty($errors)): ?>
        <div class="form-error">
            <?php foreach ($errors as $e) echo "<p>" . clean($e) . "</p>"; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required value="<?php echo isset($_POST['email']) ? clean($_POST['email']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary" style="width:100%;">Login</button>
    </form>
    <p class="form-footer-text">Don't have an account? <a href="register.php">Register here</a></p>
    <p class="form-footer-text" style="font-size:0.8rem;color:#999;">Admin demo: admin@foodorder.com / admin123</p>
</div>

<?php include 'includes/footer.php'; ?>
