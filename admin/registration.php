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

$success = '';
$error = '';

// Check if admin is already logged in
if (isset($_SESSION['admin_id'])) {
    header('Location: /FinalProject/admin/admin_home.php');
    exit;
}

// Process registration
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($username) || empty($email) || empty($full_name) || empty($password)) {
        $error = 'All fields are required.';
    } elseif (strlen($username) < 4) {
        $error = 'Username must be at least 4 characters.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Invalid email format.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } elseif ($password !== $confirm_password) {
        $error = 'Passwords do not match.';
    } else {
        // Check if username already exists
        $stmt = $pdo->prepare("SELECT admin_id FROM admins WHERE username = ?");
        $stmt->execute([$username]);
        
        if ($stmt->fetch()) {
            $error = 'Username already taken. Please choose another.';
        } else {
            // Check if email already exists
            $stmt = $pdo->prepare("SELECT admin_id FROM admins WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $error = 'Email already registered. Please use another.';
            } else {
                // Hash password and insert
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                try {
                    $stmt = $pdo->prepare("INSERT INTO admins (username, password, email, full_name) 
                                           VALUES (?, ?, ?, ?)");
                    
                    if ($stmt->execute([$username, $hashed_password, $email, $full_name])) {
                        $success = 'Account created successfully! Redirecting to login...';
                        // Redirect after 2 seconds
                        header("refresh:2;url=../index.php");
                    } else {
                        $error = 'Registration failed. Please try again.';
                    }
                } catch (PDOException $e) {
                    $error = 'Database error: ' . $e->getMessage();
                }
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Registration - Community Management</title>
    <link rel="stylesheet" href="../css/registration.css">
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1>🔐 Admin Registration</h1>
            <p>Create your administrator account</p>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success">
                <?php echo htmlspecialchars($success); ?>
            </div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="alert alert-error">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="" id="registerForm">
            <div class="form-group">
                <label for="full_name">Full Name</label>
                <input type="text" 
                       id="full_name" 
                       name="full_name" 
                       required 
                       value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>"
                       placeholder="Juan Dela Cruz">
            </div>

            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" 
                       id="email" 
                       name="email" 
                       required 
                       value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"
                       placeholder="admin@barangay.gov">
                <small>Used for account recovery and notifications</small>
            </div>

            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" 
                       id="username" 
                       name="username" 
                       required 
                       minlength="4"
                       value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"
                       placeholder="admin123">
                <small>At least 4 characters, used for login</small>
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" 
                       id="password" 
                       name="password" 
                       required 
                       minlength="6"
                       placeholder="••••••••">
                <small>At least 6 characters</small>
                <div id="passwordStrength" class="password-strength"></div>
            </div>

            <div class="form-group">
                <label for="confirm_password">Confirm Password</label>
                <input type="password" 
                       id="confirm_password" 
                       name="confirm_password" 
                       required 
                       minlength="6"
                       placeholder="••••••••">
            </div>

            <button type="submit" class="btn-register">Create Account</button>
        </form>

        <div class="login-link">
            Already have an account? <a href="../index.php">Login here</a>
        </div>
    </div>

    <script>
        // Password strength indicator
        const passwordInput = document.getElementById('password');
        const strengthDiv = document.getElementById('passwordStrength');

        passwordInput.addEventListener('input', function() {
            const password = this.value;
            let strength = '';
            let className = '';

            if (password.length === 0) {
                strengthDiv.textContent = '';
                return;
            }

            if (password.length < 6) {
                strength = 'Too short';
                className = 'strength-weak';
            } else if (password.length < 8) {
                strength = 'Weak';
                className = 'strength-weak';
            } else if (password.length < 12) {
                strength = 'Medium';
                className = 'strength-medium';
            } else {
                strength = 'Strong';
                className = 'strength-strong';
            }

            strengthDiv.textContent = 'Password strength: ' + strength;
            strengthDiv.className = 'password-strength ' + className;
        });

        // Confirm password match
        const confirmPassword = document.getElementById('confirm_password');
        const form = document.getElementById('registerForm');

        form.addEventListener('submit', function(e) {
            if (passwordInput.value !== confirmPassword.value) {
                e.preventDefault();
                alert('Passwords do not match!');
                confirmPassword.focus();
            }
        });
    </script>
</body>
</html>
