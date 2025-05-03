<?php
function requireRole($requiredRole) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Basic checks
    if (!isset($_SESSION['user_id'])) {
        header("Location: ../home.php?error=not_logged_in");
        exit();
    }
    
    // Session security validation
    if ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] ||
        $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
        session_destroy();
        header("Location: ../home.php?error=session_invalid");
        exit();
    }
    
    // Check role
    if ($_SESSION['role'] !== $requiredRole) {
        header("Location: ../unauthorized.php");
        exit();
    }
    
    // Additional admin verification
    if ($requiredRole === 'admin') {
        require_once 'dbh.inc.php';
        global $pdo;
        
        $stmt = $pdo->prepare("SELECT admin_approved FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        $user = $stmt->fetch();
        
        if (!$user || !$user['admin_approved']) {
            session_destroy();
            header("Location: ../home.php?error=admin_not_approved");
            exit();
        }
    }
    
    // Update last activity
    $_SESSION['last_activity'] = time();
}

function isAdminApproved($userId) {
    require_once 'dbh.inc.php';
    global $pdo;
    
    $stmt = $pdo->prepare("SELECT admin_approved FROM users WHERE id = ?");
    $stmt->execute([$userId]);
    $user = $stmt->fetch();
    
    return $user && $user['admin_approved'];
}
