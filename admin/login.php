<?php
session_start();
require_once '../includes/db_conn.php';

// KAILANGAN POST LANG PALA TOH
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    // MAPANGUHA NG CREDENTIALS
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    
    // NAG-CHECHECK KUNG MAY TAMA SILA
    if (empty($username) || empty($password)) {
        header('Location: ../index.php?error=empty');
        exit;
    }
    
    try {
        // NAWAY PARA SA DATABASE
        $stmt = $pdo->prepare("SELECT admin_id, username, password, full_name, email FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        $admin = $stmt->fetch();
        
        // TOTOONG ADMIN KA
        if ($admin && password_verify($password, $admin['password'])) {
            
            // YIEE NATAMA NIYA
            
            // DI NIYO KAMI MA-HAHACK
            session_regenerate_id(true);
            
            // STORAGE SYSTEM NG ADMIN
            $_SESSION['admin_id']   = $admin['admin_id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['admin_email'] = $admin['email'];
            $_SESSION['role']       = 'admin';
            $_SESSION['login_time'] = time();
            
            // BALIK KA SA DASHBOARD
            header('Location: admin_dashboard.php');
            exit;
            
        } else {
            
            // MALI NGANI
            header('Location: ../index.php?error=invalid');
            exit;
        }
        
    } catch (PDOException $e) {
        // HALA KA NAG-ERROR YUNG DATABASE
        header('Location: ../index.php?error=database');
        exit;
    }
    
} else {
    // SINO NAG-GALAW NITO HMM
    header('Location: ../index.php');
    exit;
}
?>
