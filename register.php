<?php
include 'connect.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $first_name = trim($_POST['firstName'] ?? '');
    $last_name = trim($_POST['lastName'] ?? '');
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $connection->prepare("INSERT INTO tbluser (email, password, first_name, last_name, role) VALUES (?, ?, ?, ?, 'student')");
    $stmt->bind_param('ssss', $email, $hashedPassword, $first_name, $last_name);

    if ($stmt->execute()) {
        $user_id = $connection->insert_id;
        echo "<script>alert('Registered! Please login.'); window.location='login.php';</script>";
    } else {
        echo "Error: " . htmlspecialchars($stmt->error);
    }

    $stmt->close();
}
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Register — EduNexus Hybrid</title>
        <link rel="stylesheet" href="styles.css" />
    </head>

    <body>
        <nav class="navbar" id="navbar">
            <div class="container nav-inner">
                <a href="login.php" class="nav-brand">
                    <div class="nav-brand-icon">
                        <img src="images/open-book.png" alt="EduNexus Logo" style="width:18px; height:18px;" />
                    </div>
                    EduNexus Hybrid
                </a>
                <div class="nav-links">
                    <a href="login.php">Login</a>
                    <a href="register.php" class="active">Register</a>
                    <a href="about.html">About Us</a>
                    <a href="contact.html">Contact Us</a>
                </div>
            </div>
        </nav>

        <div class="auth-page">
            <div class="auth-card">
                <h1 class="auth-form-title">Create account</h1>
                <p class="auth-form-sub">Sign up for EduNexus to join classes and start learning.</p>

                <form id="registerForm" method="post">
                    <div class="form-group">
                        <label class="form-label" for="email">Email address</label>
                        <input class="form-control" id="email" name="email" type="email" placeholder="you@university.edu" required />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <div style="position: relative;">
                            <input class="form-control" id="password" name="password" type="password" placeholder="Enter your password" required />
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-500); display: flex; align-items: center; justify-content: center;">
                                <svg class="eye-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <svg class="eye-off-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-4.753 4.753m4.753-4.753L3.596 3.039m10.318 10.318L21.44 21.44"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="confirmPassword">Confirm Password</label>
                        <div style="position: relative;">
                            <input class="form-control" id="confirmPassword" name="confirmPassword" type="password" placeholder="Re-enter your password" required />
                            <button type="button" class="password-toggle" onclick="togglePasswordVisibility('confirmPassword')" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); background: none; border: none; cursor: pointer; color: var(--text-500); display: flex; align-items: center; justify-content: center;">
                                <svg class="eye-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <svg class="eye-off-icon" width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" style="display: none;">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-4.803m5.596-3.856a3.375 3.375 0 11-4.753 4.753m4.753-4.753L3.596 3.039m10.318 10.318L21.44 21.44"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="firstName">First Name</label>
                        <input class="form-control" id="firstName" name="firstName" type="text" placeholder="Juan" required />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="lastName">Last Name</label>
                        <input class="form-control" id="lastName" name="lastName" type="text" placeholder="Dela Cruz" required />
                    </div>

                    <button class="btn btn-primary btn-full" type="submit">Sign up</button>
                </form>

                <p class="auth-switch">Already have an account? <a href="login.php">Sign in</a></p>
            </div>
        </div>

        <script>
            function togglePasswordVisibility(fieldId) {
                const input = document.getElementById(fieldId);
                const button = input.parentElement.querySelector('.password-toggle');
                const eyeIcon = button.querySelector('.eye-icon');
                const eyeOffIcon = button.querySelector('.eye-off-icon');

                if (input.type === 'password') {
                    input.type = 'text';
                    eyeIcon.style.display = 'none';
                    eyeOffIcon.style.display = 'block';
                } else {
                    input.type = 'password';
                    eyeIcon.style.display = 'block';
                    eyeOffIcon.style.display = 'none';
                }
            }

            document.getElementById('registerForm').addEventListener('submit', function(e) {
                const password = document.getElementById('password').value;
                const confirmPassword = document.getElementById('confirmPassword').value;

                if (password !== confirmPassword) {
                    e.preventDefault();
                    alert('Passwords do not match.');
                    return;
                }

                if (password.length < 6) {
                    e.preventDefault();
                    alert('Password must be at least 6 characters long.');
                    return;
                }
            });
        </script>
    </body>
</html>