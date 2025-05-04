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

    $possiblePaths = [
        './HTML/login.php',
        '../HTML/login.php',
        '../../HTML/login.php',
    ];
    
    $found = false;
    
    foreach ($possiblePaths as $path) {
        if (file_exists($path)) {
            header("Location: $path?error=not_logged_in");
            $found = true;
            break;
        }
    }
    
    if (!$found) {
        // fallback path if no login.php was found
        echo "Page de login introuvable.";
        exit();
    }

    // Update activity timestamp
    $_SESSION['last_activity'] = time();
}

