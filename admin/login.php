<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false,
    'httponly' => true,
]);
session_start();
require_once '../includes/db_conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        header('Location: /FinalProject/index.php?error=empty');
        exit;
    }
    
    try {
        $stmt = $pdo->prepare("SELECT admin_id, username, password, full_name, email FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        
        if ($admin && password_verify($password, $admin['password'])) {
            session_regenerate_id(true);
            
            $_SESSION['admin_id']    = $admin['admin_id'];
            $_SESSION['admin_name']  = $admin['full_name'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['role']        = 'admin';
            $_SESSION['login_time']  = time();

           header('Location: /FinalProject/admin/admin_home.php');
           exit;
            
        } else {
            header('Location: /FinalProject/index.php?error=invalid');
            exit;
        }
        
    } catch (PDOException $e) {
        header('Location: /FinalProject/index.php?error=database');
        exit;
    }
    
} else {
    header('Location: /FinalProject/index.php');
    exit;
}
?>
