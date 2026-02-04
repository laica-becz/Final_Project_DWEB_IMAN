<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Community Management System</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 1200px;
        }

        .header {
            text-align: center;
            margin-bottom: 60px;
        }

        .header h1 {
            font-size: 2.5rem;
            color: #1a1a1a;
            margin-bottom: 15px;
            font-weight: 700;
        }

        .header p {
            font-size: 1.1rem;
            color: #666;
        }

        .role-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            max-width: 1000px;
            margin: 0 auto;
        }

        .card {
            background: #fff;
            border-radius: 20px;
            padding: 50px 40px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
            display: block;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
        }

        .icon-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            margin: 0 auto 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card.member .icon-circle {
            background-color: #e3f2fd;
        }

        .card.admin .icon-circle {
            background-color: #ede7f6;
        }

        .icon {
            width: 50px;
            height: 50px;
        }

        .card h2 {
            font-size: 1.75rem;
            color: #1a1a1a;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .card p {
            font-size: 1rem;
            color: #666;
            line-height: 1.6;
        }

        /* Login Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1000;
            align-items: center;
            justify-content: center;
        }

        .modal.active {
            display: flex;
        }

        .modal-content {
            background: #fff;
            border-radius: 20px;
            padding: 40px;
            width: 90%;
            max-width: 450px;
            position: relative;
        }

        .close-btn {
            position: absolute;
            top: 20px;
            right: 25px;
            font-size: 30px;
            cursor: pointer;
            color: #999;
            background: none;
            border: none;
            line-height: 1;
        }

        .close-btn:hover {
            color: #333;
        }

        .modal-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .modal-header h2 {
            font-size: 1.75rem;
            color: #1a1a1a;
            margin-bottom: 10px;
        }

        .modal-header p {
            color: #666;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #333;
            font-weight: 500;
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .form-group input:focus {
            outline: none;
            border-color: #5e35b1;
        }

        .btn-login {
            width: 100%;
            padding: 14px;
            background: #5e35b1;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn-login:hover {
            background: #4527a0;
        }

        @media (max-width: 768px) {
            .header h1 {
                font-size: 2rem;
            }

            .role-cards {
                grid-template-columns: 1fr;
            }

            .card {
                padding: 40px 30px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Community Management System</h1>
            <p>Select your role to continue</p>
        </div>

        <div class="role-cards">
            <!-- Community Member Card -->
            <a href="member-dashboard.html" class="card member">
                <div class="icon-circle">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#2196F3" stroke-width="2">
                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                        <circle cx="9" cy="7" r="4"></circle>
                        <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                    </svg>
                </div>
                <h2>Community Member</h2>
                <p>Access community announcements, trash schedules, guidelines, and submit reports or concerns</p>
            </a>

            <!-- Administrator Card -->
            <div class="card admin" onclick="openLoginModal()">
                <div class="icon-circle">
                    <svg class="icon" viewBox="0 0 24 24" fill="none" stroke="#5e35b1" stroke-width="2">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
                    </svg>
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
