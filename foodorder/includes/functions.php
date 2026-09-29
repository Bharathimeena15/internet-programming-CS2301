<?php
session_start();

// Redirect helper
function redirect($url) {
    header("Location: " . $url);
    exit();
}

// Check if a user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Check if the logged-in user is an admin
function isAdmin() {
    return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

// Require login, otherwise send to login page
function requireLogin() {
    if (!isLoggedIn()) {
        redirect("login.php");
    }
}

// Require admin, otherwise send home
function requireAdmin() {
    if (!isAdmin()) {
        redirect("../index.php");
    }
}

// Basic sanitisation for output
function clean($value) {
    return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
}

// Get cart item count for the badge in the navbar
function cartCount() {
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        return 0;
    }
    $count = 0;
    foreach ($_SESSION['cart'] as $item) {
        $count += $item['quantity'];
    }
    return $count;
}
?>
