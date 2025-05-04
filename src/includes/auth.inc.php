<?php
function requireRole($requiredRole) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    // Ensure required session variables are set
    if (!isset($_SESSION['user_id'], $_SESSION['role'], $_SESSION['ip_address'], $_SESSION['user_agent'])) {
        header("Location: ../login.php?error=not_logged_in");
        exit();
    }

    // Validate session integrity
    if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] ||
        $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        session_destroy();
        header("Location: ../login.php?error=session_invalid");
        exit();
    }

    // Role-based access check
    if ($_SESSION['role'] !== $requiredRole) {
        header("Location: ../unauthorized.php");
        exit();
    }

    // Admin-specific verification
    if ($requiredRole === 'admin') {
        require_once 'dbh.inc.php';
        global $pdo;

        $stmt = $pdo->prepare("SELECT is_verified, admin_approved FROM users WHERE id = ? AND role = 'admin'");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();

        if (!$user || !$user['is_verified'] || !$user['admin_approved']) {
            session_destroy();
            header("Location: ../login.php?error=admin_not_verified");
            exit();
        }
    }

    // Activity timestamp update
    $_SESSION['last_activity'] = time();
}

function requireAdmin() {
    requireRole('admin');
}

function isAdminVerified($userId) {
    require_once 'dbh.inc.php';
    global $pdo;

    $stmt = $pdo->prepare("SELECT is_verified FROM users WHERE id = ? AND role = 'admin'");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();

    return $user && $user['is_verified'];
}
