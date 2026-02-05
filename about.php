<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Management System</title>
    <link rel="stylesheet" href="index.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Community Management System</h1>
            <p>Select your role to continue</p>
        </div>

        <div class="role-cards">
            <!-- Community Member Card -->
            <a href="member_portal.php" class="card member">
                <div class="icon-circle">
                    <img src="img/member.png" alt="Community Icon" class="card-icon">
                </div>
                <h2>Community Member</h2>
                <p>Access community announcements, trash schedules, guidelines, and submit reports or concerns</p>
            </a>

            <!-- Administrator Card -->
            <div class="card admin" onclick="openLoginModal()">
                <a href="admin_portal.php"></a>
                <div class="icon-circle">
                    <img src="img/admin.png" alt="Community Icon" class="card-icon">
                </div>
                <h2>Administrator</h2>
                <p>Manage announcements, respond to reports, update schedules, and oversee community operations</p>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div class="modal" id="loginModal">
        <div class="modal-content">
            <button class="close-btn" onclick="closeLoginModal()">&times;</button>
            <div class="modal-header">
                <h2>Administrator Login</h2>
                <p>Please enter your credentials</p>
            </div>
            <form id="loginForm" action="admin-login.php" method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <button type="submit" class="btn-login">Login</button>
            </form>
        </div>
    </div>

    <script>
        function openLoginModal() {
            document.getElementById('loginModal').classList.add('active');
        }

        function closeLoginModal() {
            document.getElementById('loginModal').classList.remove('active');
        }

        // Close modal when clicking outside
        window.onclick = function(event) {
            const modal = document.getElementById('loginModal');
            if (event.target === modal) {
                closeLoginModal();
            }
        }

        // For now, prevent form submission (remove this when adding PHP)
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Login functionality will be added with PHP. For now, this is just the front-end.');
            // When you add PHP, remove the e.preventDefault() and alert
        });
    </script>
</body>
</html>
