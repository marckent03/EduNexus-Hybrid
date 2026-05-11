<?php
session_start();
include 'connect.php';
$loginError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $connection->prepare("SELECT user_id, password, role FROM tbluser WHERE email = ?");
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            header('Location: dashboard.php');
            exit;
        }
        $loginError = 'Wrong password';
    } else {
        $loginError = 'Email not found';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Login — EduNexus Hybrid</title>
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
                    <a href="login.php" class="active">Login</a>
                    <a href="register.php">Register</a>
                    <a href="about.html">About Us</a>
                    <a href="contact.html">Contact Us</a>
                </div>
            </div>
        </nav>

        <div class="auth-page">
            <div class="auth-card">
                <h1 class="auth-form-title">Welcome back</h1>
                <p class="auth-form-sub">Sign in to your EduNexus account to continue to your dashboard and classes.</p>

                <form id="loginForm" method="post">
                    <div class="form-group">
                        <label class="form-label" for="email">Email address</label>
                        <input class="form-control" id="email" name="email" type="email" placeholder="you@university.edu" required />
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="password">Password</label>
                        <input class="form-control" id="password" name="password" type="password" placeholder="Enter your password" required />
                    </div>

                    <div class="form-aux" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:20px; font-size:13px; color:var(--text-500);">
                        <label class="form-check" style="margin:0;">
                            <input type="checkbox" id="remember" />
                            Remember me
                        </label>
                        <a href="#" style="color:var(--primary); text-decoration:none;">Forgot password?</a>
                    </div>

                    <button class="btn btn-primary btn-full" type="submit">Log in</button>
                    <?php if (!empty($loginError)): ?>
                        <div class="form-error" style="color: var(--danger); margin-top: 16px; font-size: 14px;">
                            <?php echo htmlspecialchars($loginError); ?>
                        </div>
                    <?php endif; ?>
                </form>

                <p class="auth-switch">Don’t have an account? <a href="register.php">Register</a></p>
            </div>
        </div>
    </body>
</html>

