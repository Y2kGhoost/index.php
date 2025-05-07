<?php
function requireRole($requiredRole) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Check if user is logged in
    if (!isset($_SESSION['user_id'], $_SESSION['role'])) {
        redirectToLogin("not_logged_in");
    }

    // Check if user has the required role
    if ($_SESSION['role'] !== $requiredRole) {
        redirectToLogin("insufficient_permissions");
    }

    // Update activity timestamp
    $_SESSION['last_activity'] = time();
}

function redirectToLogin($errorReason) {
    $possiblePaths = [
        './HTML/login.php',
        '../HTML/login.php',
        '../../HTML/login.php',
    ];

    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            header("Location: $path?error=$errorReason");
            exit();
        }
    }

    echo "Page de login introuvable.";
    exit();
}
