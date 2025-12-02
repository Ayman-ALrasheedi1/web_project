<?php
/**
 * add_build.php
 * Admin page to add new projects to the gallery
 */
session_start();
require 'config.php';

// Security Check
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: builds.php');
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);
    $model = trim($_POST['model']);
    $desc  = trim($_POST['description']);
    $mods  = trim($_POST['mods']);

    if ($title && $model) {
        $stmt = $pdo->prepare("INSERT INTO builds (title, car_model, description, mods_list) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$title, $model, $desc, $mods])) {
            header("Location: builds.php");
            exit;
        } else {
            $message = "Error adding build.";
        }
    } else {
        $message = "Please fill in all required fields.";
    }
}

$pageTitle = "Add Project | Luxury Garage";
include 'includes/header.php';
?>

<section class="section">
    <div class="container" style="max-width: 600px;">
        <h1 class="section-title">Add New Project Build</h1>
        
        <?php if($message): ?>
            <div class="alert alert-error"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" class="login-card" style="padding: 2rem;">
            <div class="login-form">
                
                <label>Project Title
                    <input type="text" name="title" required placeholder="e.g. Full Blackout Kit for Camry">
                </label>

                <label>Car Model
                    <input type="text" name="model" required placeholder="e.g. Toyota Camry 2024">
                </label>

                <label>Description
                    <textarea name="description" rows="3" style="background:#050509; border:1px solid #333; color:white; padding:0.75rem; border-radius:8px;" placeholder="Brief summary of the build..."></textarea>
                </label>

                <label>Modifications List (One per line)
                    <textarea name="mods" rows="5" style="background:#050509; border:1px solid #333; color:white; padding:0.75rem; border-radius:8px;" placeholder="20-inch Rims&#10;Carbon Spoiler&#10;Sport Exhaust"></textarea>
                    <small style="color:#666; margin-top:5px;">* Press Enter after each item</small>
                </label>

                <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Add Project</button>
                <a href="builds.php" style="text-align: center; margin-top: 1rem; font-size: 0.9rem; color: #888;">Cancel</a>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>