<?php
/**
 * contact.php
 * Professional About & Contact Page
 */

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require 'config.php';
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

$pageTitle = "About & Contact | Luxury Garage";
$successMessage = "";
$errorMessage   = "";

// Handle Form Submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name    = trim($_POST['name'] ?? '');
    $email   = trim($_POST['email'] ?? '');
    $phone   = trim($_POST['phone'] ?? '');
    $car     = trim($_POST['car'] ?? '');
    $message = trim($_POST['message'] ?? '');

    if ($name && $email && $message) {
        $stmt = $pdo->prepare("INSERT INTO messages (full_name, email, phone, car_model_year, message) VALUES (:name, :email, :phone, :car, :message)");
        if ($stmt->execute([':name' => $name, ':email' => $email, ':phone' => $phone, ':car' => $car, ':message' => $message])) {
            $successMessage = "Message sent! We will get back to you shortly.";
        } else {
            $errorMessage = "Database error. Please try again.";
        }
    } else {
        $errorMessage = "Please fill in all required fields.";
    }
}

include 'includes/header.php';
?>

<section class="section">
    <div class="container">
        
        <!-- HEADER WITH ADMIN LINK -->
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 2rem;">
            <div>
                <h1 class="section-title" style="margin-bottom: 0.5rem;">Get in Touch</h1>
                <p class="section-subtitle" style="margin:0;">We are here to help with your build.</p>
            </div>
            
            <?php if ($isAdmin): ?>
                <a href="messages.php" class="btn btn-secondary" style="border-color:#444;">
                    <span style="margin-right:8px;">✉</span> View Inbox
                </a>
            <?php endif; ?>
        </div>

        <!-- TWO COLUMN LAYOUT -->
        <div class="two-columns" style="align-items: flex-start; gap: 4rem;">
            
            <!-- LEFT: INFO & ABOUT -->
            <div class="column">
                <div class="card" style="padding: 2rem; border: 1px solid #232338; background: #101018;">
                    <h2 style="margin-top:0; color:#ff9100;">Who We Are</h2>
                    <p style="color:#ccc; line-height:1.6; margin-bottom:1.5rem;">
                        Luxury Garage specializes in transforming ordinary cars into unique machines. 
                        We source the highest quality rims, body kits, and performance parts for 
                        enthusiasts who demand perfection.
                    </p>

                    <h3 style="font-size:1.1rem; margin-bottom:1rem;">Contact Info</h3>
                    
                    <div style="display:flex; flex-direction:column; gap: 1rem;">
                        <!-- Location -->
                        <div style="display:flex; gap:1rem; align-items:center;">
                            <div style="width:40px; height:40px; background:#1a1a24; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#ff9100;">📍</div>
                            <div>
                                <strong style="display:block; font-size:0.9rem;">Location</strong>
                                <span style="font-size:0.9rem; color:#aaa;">Qassim, Saudi Arabia</span>
                            </div>
                        </div>

                        <!-- WhatsApp -->
                        <div style="display:flex; gap:1rem; align-items:center;">
                            <div style="width:40px; height:40px; background:#1a1a24; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#00e676;">💬</div>
                            <div>
                                <strong style="display:block; font-size:0.9rem;">WhatsApp</strong>
                                <span style="font-size:0.9rem; color:#aaa;">+966 5X XXX XXXX</span>
                            </div>
                        </div>

                        <!-- Instagram -->
                        <div style="display:flex; gap:1rem; align-items:center;">
                            <div style="width:40px; height:40px; background:#1a1a24; border-radius:50%; display:flex; align-items:center; justify-content:center; color:#e1306c;">📸</div>
                            <div>
                                <strong style="display:block; font-size:0.9rem;">Instagram</strong>
                                <span style="font-size:0.9rem; color:#aaa;">@luxury_garage</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- RIGHT: CONTACT FORM -->
            <div class="column">
                <div class="login-card" style="padding: 2rem; border-top: 3px solid #ff9100;">
                    <h2 style="margin-top:0; margin-bottom: 1.5rem;">Send a Message</h2>

                    <?php if ($successMessage): ?>
                        <div class="alert alert-success"><?php echo $successMessage; ?></div>
                    <?php endif; ?>

                    <?php if ($errorMessage): ?>
                        <div class="alert alert-error"><?php echo $errorMessage; ?></div>
                    <?php endif; ?>

                    <form action="contact.php" method="post" class="login-form">
                        
                        <!-- Name & Email Row -->
                        <div class="two-columns" style="gap:1rem; grid-template-columns: 1fr 1fr;">
                            <label>Full Name
                                <input type="text" name="name" required placeholder="Your Name">
                            </label>
                            <label>Email Address
                                <input type="email" name="email" required placeholder="you@example.com">
                            </label>
                        </div>

                        <!-- Phone & Car Row -->
                        <div class="two-columns" style="gap:1rem; grid-template-columns: 1fr 1fr;">
                            <label>Phone Number
                                <input type="text" name="phone" placeholder="05X XXX XXXX">
                            </label>
                            <label>Car Model & Year
                                <input type="text" name="car" placeholder="e.g. Camry 2023">
                            </label>
                        </div>

                        <label>Message / Inquiry
                            <textarea name="message" rows="5" required placeholder="Tell us what parts you are looking for..." style="background:#050509; border:1px solid #333; color:white; padding:0.75rem; border-radius:8px; width:100%;"></textarea>
                        </label>

                        <button type="submit" class="btn btn-primary" style="padding: 0.8rem; font-size:1rem;">Send Message</button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>