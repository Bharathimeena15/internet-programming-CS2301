<?php
// ============================================================
// ONE-TIME SCRIPT: run this once in your browser to set a working
// password hash for the demo admin account, then delete this file.
// URL: http://localhost/foodorder/reset_admin_password.php
// ============================================================
require_once 'includes/db.php';

$newPassword = 'admin123';
$hash = password_hash($newPassword, PASSWORD_DEFAULT);

$stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = 'admin@foodorder.com'");
$stmt->bind_param("s", $hash);

if ($stmt->execute()) {
    echo "Admin password has been reset successfully.<br>";
    echo "Login with: admin@foodorder.com / admin123<br>";
    echo "<strong>Please delete this file (reset_admin_password.php) now.</strong>";
} else {
    echo "Something went wrong: " . $conn->error;
}
$stmt->close();
?>
