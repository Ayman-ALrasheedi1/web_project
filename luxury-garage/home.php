<?php
/**
 * home.php
 * Professional Home Page
 */

session_start();
// Check if user is logged in
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

$username = $_SESSION['username'] ?? 'User';
$pageTitle = "Home | Luxury Garage";
include 'includes/header.php';
?>

<section class="hero home-hero-bg">
    <div class="container hero-content">
        <div class="hero-text fade-in-up">
            <span class="hero-badge">Premium Auto Tuning</span>
            <h1>Redefine Your Ride</h1>
            <p>
                Transform your vehicle with high-performance parts. 
                We specialize in aggressive stance, aerodynamics, and premium exhaust systems.
            </p>

            <div class="hero-specs">
                <div class="spec-item">
                    <span class="spec-val">500+</span>
                    <span class="spec-label">Builds</span>
                </div>
                <div class="spec-item">
                    <span class="spec-val">100%</span>
                    <span class="spec-label">Quality</span>
                </div>
                <div class="spec-item">
                    <span class="spec-val">24/7</span>
                    <span class="spec-label">Support</span>
                </div>
            </div>

            <div class="hero-buttons">
                <a href="products.php" class="btn btn-primary">Shop Parts</a>
                <a href="builds.php" class="btn btn-secondary">View Gallery</a>
            </div>
        </div>
        </div>
</section>

<div class="brand-strip">
    <div class="container brand-flex">
        <span style="color:#888; font-size:0.8rem;">SPECIALIZING IN:</span>
        <span class="brand-name">BMW</span>
        <span class="brand-name">MERCEDES-BENZ</span>
        <span class="brand-name">TOYOTA</span>
        <span class="brand-name">NISSAN</span>
        <span class="brand-name">PORSCHE</span>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="section-header text-center" style="margin-bottom: 2.5rem;">
            <h2 class="section-title">Upgrade Categories</h2>
            <p class="section-subtitle">Premium parts designed for performance and style.</p>
        </div>

        <div class="card-grid">
            <a href="products.php" class="card category-card">
                <div class="icon-box">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ff9100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="12" r="10"></circle>
                        <circle cx="12" cy="12" r="3"></circle>
                        <path d="M12 2v7M12 15v7M4.93 4.93l4.95 4.95M14.12 14.12l4.95 4.95M2 12h7M15 12h7M4.93 19.07l4.95-4.95M14.12 9.88l4.95-4.95"></path>
                    </svg>
                </div>
                <h3>Sport Rims</h3>
                <p>Forged & Alloy wheels for aggressive stance.</p>
            </a>

            <a href="products.php" class="card category-card">
                <div class="icon-box">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ff9100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18.5 12a2.5 2.5 0 1 1 0 5H5.5a2.5 2.5 0 1 1 0-5h13z"></path>
                        <path d="M4 12V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v5"></path>
                    </svg>
                </div>
                <h3>Body Kits</h3>
                <p>Bumpers, skirts, and widebody lips.</p>
            </a>

            <a href="products.php" class="card category-card">
                <div class="icon-box">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ff9100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M22 13l-1.5-6h-17L2 13"></path>
                        <line x1="6" y1="13" x2="6" y2="18"></line>
                        <line x1="18" y1="13" x2="18" y2="18"></line>
                        <line x1="2" y1="18" x2="22" y2="18"></line>
                    </svg>
                </div>
                <h3>Spoilers</h3>
                <p>Carbon fiber wings for downforce.</p>
            </a>

            <a href="products.php" class="card category-card">
                <div class="icon-box">
                    <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#ff9100" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                       <path d="M4 15s1-1 4-1 5 2 8 2 4-1 4-1V3s-1 1-4 1-5-2-8-2-4 1-4 1z"></path>
                       <line x1="4" y1="22" x2="4" y2="15"></line>
                    </svg>
                </div>
                <h3>Exhausts</h3>
                <p>Titanium systems for deep sound.</p>
            </a>
        </div>
    </div>
</section>

<section class="section section-dark">
    <div class="container">
        <div class="two-columns" style="align-items: center;">
            <div class="column">
                <h2 class="section-title">Why Luxury Garage?</h2>
                <p class="section-subtitle">We are not just a shop. We are car enthusiasts.</p>
                
                <ul class="bullet-list" style="font-size: 1.05rem; line-height: 2.2;">
                    <li><span style="color:#ff9100; margin-right:8px;">✔</span> <strong>Authentic Parts:</strong> We only sell high-grade materials.</li>
                    <li><span style="color:#ff9100; margin-right:8px;">✔</span> <strong>Expert Fitment:</strong> Parts guaranteed to fit your model.</li>
                    <li><span style="color:#ff9100; margin-right:8px;">✔</span> <strong>Fast Shipping:</strong> Delivery across Saudi Arabia.</li>
                    <li><span style="color:#ff9100; margin-right:8px;">✔</span> <strong>Secure Payment:</strong> 100% safe checkout.</li>
                </ul>
            </div>
            
            <div class="column" style="display:flex; justify-content:center;">
                <div class="trust-badge">
                    <span style="font-size: 2.5rem; color: #ff9100; font-weight:800;">100%</span>
                    <span style="font-size: 0.8rem; text-transform: uppercase; letter-spacing:1px; opacity:0.8;">Satisfaction</span>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>