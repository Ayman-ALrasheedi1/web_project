<?php
/**
 * builds.php
 * Dynamic Projects Gallery with Admin Controls
 */

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require 'config.php';
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

// --- HANDLE DELETE (Admin Only) ---
if (isset($_POST['delete_id']) && $isAdmin) {
    $deleteId = (int)$_POST['delete_id'];
    $stmt = $pdo->prepare("DELETE FROM builds WHERE id = :id");
    $stmt->execute([':id' => $deleteId]);
    header("Location: builds.php");
    exit;
}

$pageTitle = "Builds | Luxury Garage";
include 'includes/header.php';

// Fetch all builds
$stmt = $pdo->query("SELECT * FROM builds ORDER BY created_at DESC");
$builds = $stmt->fetchAll();
?>

<section class="section">
    <div class="container">
        
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: end; margin-bottom: 2rem;">
            <div>
                <h1 class="section-title" style="margin-bottom: 0.5rem;">Custom Builds & Projects</h1>
                <p class="section-subtitle" style="margin-bottom: 0;">Showcase of cars modified using Luxury Garage parts.</p>
            </div>
            
            <?php if ($isAdmin): ?>
                <a href="add_build.php" class="btn btn-primary" style="padding: 0.7rem 1.5rem;">
                    <span style="margin-right: 8px; font-weight: bold; font-size: 1.2rem;">+</span> Add Project
                </a>
            <?php endif; ?>
        </div>

        <!-- Builds Grid -->
        <div class="card-grid">
            <?php foreach ($builds as $build): ?>
                <article class="card build-card" style="position: relative; border: 1px solid #232338; display: flex; flex-direction: column;">
                    
                    <!-- Admin Delete Button -->
                    <?php if ($isAdmin): ?>
                        <form method="POST" onsubmit="return confirm('Delete this project?');" style="position: absolute; top: 10px; right: 10px; z-index: 10;">
                            <input type="hidden" name="delete_id" value="<?php echo $build['id']; ?>">
                            <button type="submit" style="background: rgba(0,0,0,0.7); color: #ff5252; border: 1px solid #ff5252; border-radius: 50%; width: 32px; height: 32px; cursor: pointer; display: flex; align-items: center; justify-content: center; font-weight:bold;">✕</button>
                        </form>
                    <?php endif; ?>

                    <div class="build-image-placeholder" style="height: 200px; background: #0b0b10; position: relative;">
                         <span style="position: absolute; bottom: 10px; left: 10px; background: #ff9100; color: black; padding: 4px 10px; font-size: 0.7rem; font-weight: bold; border-radius: 4px; text-transform: uppercase;">
                            <?php echo htmlspecialchars($build['car_model']); ?>
                        </span>
                        <span style="opacity: 0.3; letter-spacing: 2px;">PROJECT IMAGE</span>
                    </div>

                    <div style="padding: 1.2rem; flex-grow: 1; display: flex; flex-direction: column;">
                        <h3 style="font-size: 1.3rem; margin: 0 0 0.5rem; color: white;">
                            <?php echo htmlspecialchars($build['title']); ?>
                        </h3>
                        
                        <p style="font-size: 0.9rem; color: #aaa; margin-bottom: 1.5rem; line-height: 1.5;">
                            <?php echo htmlspecialchars($build['description']); ?>
                        </p>

                        <!-- Modifications List -->
                        <div style="background: #1a1a24; padding: 1rem; border-radius: 8px; margin-top: auto;">
                            <h4 style="margin: 0 0 0.5rem; font-size: 0.85rem; color: #ff9100; text-transform: uppercase;">Modifications Installed:</h4>
                            <ul style="margin: 0; padding-left: 1.2rem; color: #ddd; font-size: 0.9rem; line-height: 1.6;">
                                <?php 
                                    // Split the text by new lines to make a list
                                    $mods = explode("\n", $build['mods_list']);
                                    foreach($mods as $mod) {
                                        if(trim($mod)) echo "<li>" . htmlspecialchars($mod) . "</li>";
                                    }
                                ?>
                            </ul>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
        
    </div>
</section>

<?php include 'includes/footer.php'; ?>