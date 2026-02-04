<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrator Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!-- Main container for login page -->
    <div class="container">
        <!-- Back to role selection link -->
        <a href="index.php" class="back-link">
            <!-- Left arrow SVG icon -->
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Back to role selection
        </a>

        <!-- Login form card -->
        <div class="login-card">
            <!-- Icon for administrator -->
            <div class="icon-circle icon-purple">
                <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                </svg>
            </div>

            <!-- Login form title -->
            <h2 class="login-title">Administrator Login</h2>
            <p class="login-subtitle">Enter your credentials to continue</p>

            <!-- PHP form that submits to itself -->
            <form method="POST" action="admin_login.php" class="login-form">
                <!-- Username input field -->
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" placeholder="Enter your username" required>
                </div>

                <!-- Password input field -->
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter your password" required>
                </div>

                <!-- Submit button -->
                <button type="submit" class="btn-primary">Sign In</button>
            </form>

            <!-- Demo credentials information box -->
            <div class="demo-box">
                <p class="demo-title">Demo Credentials:</p>
                <p class="demo-text">Username: admin</p>
                <p class="demo-text">Password: admin123</p>
            </div>
        </div>
    </div>

    <?php
    // PHP code to handle form submission
    // Check if the form was submitted using POST method
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get username and password from form input
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Simple authentication check (in real app, use database and hashed passwords)
        // Check if username is 'admin' AND password is 'admin123'
        if ($username === "admin" && $password === "admin123") {
            // If credentials are correct, redirect to admin portal
            header("Location: admin_portal.php");
            exit(); // Stop script execution after redirect
        } else {
            // If credentials are wrong, show error message using JavaScript
            echo "<script>alert('Invalid username or password. Please try again.');</script>";
        }
    }
    ?>
</body>
</html>