<?php
// Ensure session is active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if admin session exists
if (
    !isset($_SESSION['admin_id']) ||
    !isset($_SESSION['role'])     ||
    $_SESSION['role'] !== 'admin'
) {
    // Wipe everything and kick out
    session_unset();
    session_destroy();
    header('Location: ../index.php?error=unauthorized');
    exit;
}

// Optional: auto-logout after 2 hours of inactivity
$timeout = 2 * 60 * 60; // 2 hours
if (isset($_SESSION['login_time']) && (time() - $_SESSION['login_time']) > $timeout) {
    session_unset();
    session_destroy();
    header('Location: ../index.php?error=timeout');
    exit;
}

// Refresh activity timer
$_SESSION['login_time'] = time();
?>
