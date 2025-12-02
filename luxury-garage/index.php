<?php
/**
 * index.php
 * USER Login Page
 */
session_start();
require 'config.php';

// If the user is already logged in, redirect them to the home page
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: home.php');
    exit;
}

$loginError = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    // Check user in database
    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    // Verify password
    if ($user && password_verify($password, $user['password'])) {
        // Success: Set session variables
        $_SESSION['logged_in'] = true;
        $_SESSION['username']  = $user['username'];
        $_SESSION['role']      = $user['role']; // 'user' or 'admin'
        
        header('Location: home.php');
        exit;
    } else {
        // Failure: Show error message
        $loginError = "Invalid username or password.";
    }
}

$pageTitle = "Login | Luxury Garage";
include 'includes/header.php';
?>

<section class="hero login-hero" style="min-height: 80vh; display:flex; align-items:center;">
    <div class="container" style="display:flex; justify-content:center; width:100%;">
        
        <div class="login-card" style="width: 100%; max-width: 420px; padding: 2.5rem;">
            <div style="text-align:center; margin-bottom:1.5rem;">
                <h1 style="margin:0; font-size:1.8rem;">Welcome Back</h1>
                <p class="login-subtitle">Sign in to your account</p>
            </div>

            <?php if ($loginError): ?>
                <div class="alert alert-error">
                    <?php echo htmlspecialchars($loginError); ?>
                </div>
            <?php endif; ?>

            <form action="index.php" method="post" class="login-form">
                <label>
                    Username
                    <input type="text" name="username" required placeholder="Enter your username">
                </label>

                <label>
                    Password
                    <input type="password" name="password" required placeholder="Enter your password">
                </label>

                <button type="submit" class="btn btn-primary login-btn">Sign In</button>
            </form>

            <div style="margin-top: 2rem; text-align: center; border-top: 1px solid #232338; padding-top: 1.5rem;">
                <p style="font-size: 0.95rem; margin-bottom: 1rem;">
                    Don't have an account? 
                    <a href="signup.php" style="color: #ff9100; font-weight: 600; margin-left: 5px;">Sign Up</a>
                </p>
                
                <p style="font-size: 0.8rem;">
                    <a href="admin_login.php" style="color: #666; transition: color 0.2s;">Admin Login</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php
include 'includes/footer.php';
?>