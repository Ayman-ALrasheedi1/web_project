<?php
/**
 * signup.php
 * User registration page (With Auto-Login)
 */
session_start();
require 'config.php';

// If already logged in, go to home
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: home.php');
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm  = trim($_POST['confirm_password'] ?? '');

    if (empty($username) || empty($password)) {
        $error = "Please fill in all fields.";
    } elseif ($password !== $confirm) {
        $error = "Passwords do not match.";
    } else {
        // 1. Check if username exists
        $stmt = $pdo->prepare("SELECT id FROM users WHERE username = :username");
        $stmt->execute([':username' => $username]);
        if ($stmt->fetch()) {
            $error = "Username already taken.";
        } else {
            // 2. Create user
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $pdo->prepare("INSERT INTO users (username, password, role) VALUES (:user, :pass, 'user')");
            
            if ($stmt->execute([':user' => $username, ':pass' => $hash])) {
                
                // --- AUTO LOGIN START ---
                // Set session variables immediately so they are logged in
                $_SESSION['logged_in'] = true;
                $_SESSION['username']  = $username;
                $_SESSION['role']      = 'user';
                
                // Redirect to Home Page
                header('Location: home.php');
                exit;
                // --- AUTO LOGIN END ---

            } else {
                $error = "Something went wrong. Please try again.";
            }
        }
    }
}

$pageTitle = "Sign Up | Luxury Garage";
include 'includes/header.php';
?>

<section class="hero login-hero" style="min-height: 80vh; display:flex; align-items:center;">
    <div class="container" style="display:flex; justify-content:center; width:100%;">
        <div class="login-card" style="width:100%; max-width:420px; padding: 2.5rem;">
            
            <div style="text-align:center; margin-bottom:1.5rem;">
                <h1 style="margin:0; font-size:1.8rem;">Create Account</h1>
                <p class="login-subtitle">Join Luxury Garage today</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>

            <form action="signup.php" method="post" class="login-form">
                <label>
                    Username
                    <input type="text" name="username" required placeholder="Choose a username">
                </label>
                
                <label>
                    Password
                    <input type="password" name="password" required placeholder="Create a password">
                </label>
                
                <label>
                    Confirm Password
                    <input type="password" name="confirm_password" required placeholder="Repeat password">
                </label>
                
                <button type="submit" class="btn btn-primary login-btn">Sign Up & Login</button>
            </form>
            
            <div style="margin-top: 1.5rem; text-align: center; border-top: 1px solid #232338; padding-top: 1.5rem;">
                <p style="font-size: 0.95rem;">
                    Already have an account? <a href="index.php" style="color:#ff9100; font-weight:600;">Login here</a>
                </p>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>