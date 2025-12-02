<?php
/**
 * admin_login.php
 * Separate Login for Admins
 */
session_start();
require 'config.php';

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    header('Location: home.php');
    exit;
}

$loginError = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username AND role = 'admin'");
    $stmt->execute([':username' => $username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username']  = $user['username'];
        $_SESSION['role']      = 'admin';
        header('Location: home.php');
        exit;
    } else {
        $loginError = "Invalid admin credentials.";
    }
}

$pageTitle = "Admin Login | Luxury Garage";
include 'includes/header.php';
?>

<section class="hero login-hero" style="min-height: 80vh; display:flex; align-items:center;">
    <div class="container" style="display:flex; justify-content:center; width:100%;">
        <div class="login-card" style="width: 100%; max-width: 420px; border-color: #ff1744;">
            <div style="text-align:center; margin-bottom:1.5rem;">
                <h1 style="margin:0; font-size:1.8rem; color:#ff1744;">Admin Access</h1>
                <p class="login-subtitle">Restricted Area</p>
            </div>

            <?php if ($loginError): ?>
                <div class="alert alert-error"><?php echo htmlspecialchars($loginError); ?></div>
            <?php endif; ?>

            <form action="admin_login.php" method="post" class="login-form">
                <label>Username <input type="text" name="username" required></label>
                <label>Password <input type="password" name="password" required></label>
                <button type="submit" class="btn btn-primary login-btn" style="background: #b71c1c;">Admin Login</button>
            </form>

            <div style="margin-top: 1.5rem; text-align: center; font-size: 0.9rem;">
                <a href="index.php" style="color: #aaa;">← Back to User Login</a>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>