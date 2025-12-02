<?php
// header.php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in
$isLoggedIn = isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true;

// Get user info if logged in (for the avatar)
$username = $_SESSION['username'] ?? 'Guest';
$initial  = strtoupper(substr($username, 0, 1));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($pageTitle) ? $pageTitle : 'Luxury Garage'; ?></title>
    <link rel="stylesheet" href="assets/css/style.css" />
    <script defer src="assets/js/main.js"></script>

    <style>
        .header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between; /* Pushes Logo left, Menu right */
        }
        .logo a {
            color: #fff;
            font-size: 1.3rem;
            font-weight: 800;
            letter-spacing: 1px;
            text-decoration: none;
            text-transform: uppercase;
        }
    </style>
</head>
<body>

<header class="site-header">
    <div class="container header-inner">

        <div class="logo">
            <a href="<?php echo $isLoggedIn ? 'home.php' : 'index.php'; ?>">
                Luxury Garage
            </a>
        </div>

        <?php if ($isLoggedIn): ?>
            
            <nav class="main-nav" id="mainNav">
                <a href="home.php">Home</a>
                <a href="products.php">Products</a>
                <a href="builds.php">Builds</a>
                <a href="contact.php">About &amp; Contact</a>
            </nav>

            <div class="header-profile">
                <button class="profile-trigger" id="profileTrigger" type="button">
                    <span class="profile-trigger-avatar"><?php echo $initial; ?></span>
                    <span class="profile-trigger-name"><?php echo htmlspecialchars($username); ?></span>
                    <span class="profile-trigger-caret">▾</span>
                </button>

                <div class="profile-dropdown" id="profileDropdown">
                    <span class="profile-dropdown-label">Signed in as</span>
                    <span class="profile-dropdown-user"><?php echo htmlspecialchars($username); ?></span>
                    <hr>
                    <a href="logout.php">Logout</a>
                </div>
            </div>

            <button class="nav-toggle" id="navToggle" type="button">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 12h18M3 6h18M3 18h18" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </button>

        <?php endif; ?>

    </div>
</header>
<main>