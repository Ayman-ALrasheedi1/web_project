<?php
/**
 * messages.php
 * Admin Inbox to view contact form submissions
 */
session_start();
require 'config.php';

// Security: Only Admins can see this
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: contact.php');
    exit;
}

// Handle Delete
if (isset($_POST['delete_id'])) {
    $stmt = $pdo->prepare("DELETE FROM messages WHERE id = :id");
    $stmt->execute([':id' => (int)$_POST['delete_id']]);
    header("Location: messages.php");
    exit;
}

$pageTitle = "Inbox | Luxury Garage";
include 'includes/header.php';

// Fetch messages
$stmt = $pdo->query("SELECT * FROM messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>

<section class="section">
    <div class="container">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
            <h1 class="section-title" style="margin:0;">Customer Messages</h1>
            <a href="contact.php" class="btn btn-secondary">← Back</a>
        </div>

        <?php if (count($messages) === 0): ?>
            <div style="text-align:center; padding: 4rem; color:#666;">
                <h3>No messages yet.</h3>
            </div>
        <?php else: ?>
            <div style="display:flex; flex-direction:column; gap:1rem;">
                <?php foreach ($messages as $msg): ?>
                    <div class="card" style="padding:1.5rem; border-left: 4px solid #ff9100; display:flex; flex-direction:column; gap:0.5rem;">
                        <div style="display:flex; justify-content:space-between; align-items:start;">
                            <div>
                                <h3 style="margin:0; font-size:1.2rem;"><?php echo htmlspecialchars($msg['full_name']); ?></h3>
                                <span style="font-size:0.85rem; color:#888;"><?php echo htmlspecialchars($msg['email']); ?> • <?php echo htmlspecialchars($msg['phone']); ?></span>
                            </div>
                            <span style="font-size:0.8rem; color:#666;"><?php echo $msg['created_at']; ?></span>
                        </div>

                        <div style="background:#1a1a24; padding:0.8rem; border-radius:6px; margin-top:0.5rem;">
                            <strong style="color:#ff9100; font-size:0.8rem; text-transform:uppercase;">Car:</strong> 
                            <span style="color:#ddd;"><?php echo htmlspecialchars($msg['car_model_year']); ?></span>
                            <hr style="border:0; border-top:1px solid #333; margin:0.5rem 0;">
                            <p style="margin:0; color:#eee;"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></p>
                        </div>

                        <div style="text-align:right; margin-top:0.5rem;">
                            <form method="POST" onsubmit="return confirm('Delete message?');">
                                <input type="hidden" name="delete_id" value="<?php echo $msg['id']; ?>">
                                <button type="submit" style="background:none; border:none; color:#ff5252; cursor:pointer; font-size:0.9rem;">Delete Message</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php include 'includes/footer.php'; ?>