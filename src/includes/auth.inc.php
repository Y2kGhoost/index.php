<?php
function requireRole($requiredRole) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Only check if user is logged in and has the correct role
    if (!isset($_SESSION['user_id'], $_SESSION['role'])) {
        header("Location: ../login.php?error=not_logged_in");
        exit();
    }

    if ($_SESSION['role'] !== $requiredRole) {
        header("Location: ../unauthorized.php");
        exit();
    }

    // Update activity timestamp
    $_SESSION['last_activity'] = time();
}

function requireAdmin() {
    requireRole('admin');
}
