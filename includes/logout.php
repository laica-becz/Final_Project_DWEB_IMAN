<?php
session_set_cookie_params([
    'lifetime' => 0,
    'path' => '/',
    'domain' => 'localhost',
    'secure' => false,
    'httponly' => true,
]);
session_start();
session_unset();
session_destroy();
header('Location: /FinalProject/index.php');
exit();
?><?php
session_start();
session_destroy();
header("Location: ../index.php");
exit();
?>
