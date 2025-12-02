<?php
/**
 * product.php
 * Product details + tips page
 */

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require 'config.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
if ($id <= 0) {
    die("Invalid product ID.");
}

// Fetch product info including the new stock_quantity column
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}

// Logic to check if Out of Stock
// We use (int) to make sure it's treated as a number. Default to 0 if null.
$stock = isset($product['stock_quantity']) ? (int)$product['stock_quantity'] : 0;
$isOutOfStock = ($stock <= 0);

$pageTitle = $product['name'] . " | Luxury Garage";
include 'includes/header.php';
?>

<section class="section">
    <div class="container">
        
        <!-- Stock Status Badge (Top of page) -->
        <div style="margin-bottom: 0.5rem;">
             <?php if ($isOutOfStock): ?>
                <span class="stock-tag text-danger" style="font-size: 1rem;">● Out of Stock</span>
            <?php else: ?>
                <span class="stock-tag text-success" style="font-size: 1rem;">● In Stock (<?php echo $stock; ?> available)</span>
            <?php endif; ?>
        </div>

        <h1 class="section-title" style="margin-top:0;"><?php echo htmlspecialchars($product['name']); ?></h1>
        <p class="section-subtitle">
            Detailed information about this part and tips to help you choose the right one.
        </p>

        <div class="two-columns">
            <!-- Left Column: Image & Details -->
            <div class="column">
                <div class="product-image-placeholder product-details-image">
                    <span>Product Image</span>
                </div>

                <h2>Product Details</h2>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($product['category']); ?></p>
                <p><strong>Brand:</strong> <?php echo htmlspecialchars($product['brand']); ?></p>
                <p><strong>Price:</strong> <span style="font-size:1.2rem; font-weight:bold;"><?php echo number_format($product['price'], 2); ?> SAR</span></p>

                <p style="margin-top: 10px; line-height: 1.6;">
                    <?php echo nl2br(htmlspecialchars($product['description'])); ?>
                </p>

                <div style="margin-top: 25px;">
                    <?php if ($isOutOfStock): ?>
                        <!-- Disabled Button if Sold Out -->
                        <button class="btn btn-disabled" disabled>Currently Unavailable</button>
                    <?php else: ?>
                        <!-- Active Button if In Stock -->
                        <a href="contact.php?subject=<?php echo urlencode('Inquiry about ' . $product['name']); ?>" class="btn btn-primary">Contact to Buy</a>
                    <?php endif; ?>
                    
                    <a href="products.php" class="btn btn-secondary" style="margin-left: 10px;">Back to Products</a>
                </div>
            </div>

            <!-- Right Column: Tips (Slightly improved styling) -->
            <div class="column">
                <div style="background: #101018; padding: 1.5rem; border-radius: 12px; border: 1px solid #232338;">
                    <h2 style="margin-top:0;">Tips: How to Choose</h2>
                    <hr style="border: 0; border-top: 1px solid #333; margin-bottom: 1rem;">

                    <?php
                    // Robust check for category keywords (e.g., 'Rims', 'rims', 'Alloy Rims')
                    $category = strtolower($product['category']);

                    if (strpos($category, 'rim') !== false) : ?>
                        <h3>How to choose the right rims</h3>
                        <ul class="bullet-list">
                            <li><strong>Check the size:</strong> Match diameter and width with your car specs.</li>
                            <li><strong>Bolt pattern:</strong> Must be compatible with your car hub.</li>
                            <li><strong>Offset:</strong> Wrong offset can affect handling and rub the fenders.</li>
                            <li><strong>Material:</strong> Alloy rims are lighter and look better.</li>
                            <li><strong>Use:</strong> Daily driving vs. track use may change your choice.</li>
                        </ul>
                    <?php elseif (strpos($category, 'body') !== false) : ?>
                        <h3>How to choose a body kit</h3>
                        <ul class="bullet-list">
                            <li><strong>Fitment:</strong> Make sure it is designed for your model and year.</li>
                            <li><strong>Material:</strong> Polyurethane / ABS are more flexible than fiberglass.</li>
                            <li><strong>Height:</strong> Too low kits will hit speed bumps easily.</li>
                            <li><strong>Painting:</strong> Count painting + installation in your budget.</li>
                        </ul>
                    <?php elseif (strpos($category, 'spoiler') !== false) : ?>
                        <h3>How to choose a spoiler</h3>
                        <ul class="bullet-list">
                            <li><strong>Style:</strong> Match the shape of your car.</li>
                            <li><strong>Function:</strong> Decide if you want just style or real downforce.</li>
                            <li><strong>Install:</strong> Check if it needs drilling or uses factory holes.</li>
                            <li><strong>Material:</strong> ABS or carbon fiber are great options.</li>
                        </ul>
                    <?php elseif (strpos($category, 'exhaust') !== false) : ?>
                        <h3>How to choose a sport exhaust</h3>
                        <ul class="bullet-list">
                            <li><strong>Sound:</strong> Choose a sound level you can live with every day.</li>
                            <li><strong>Diameter:</strong> Too big pipes can reduce performance.</li>
                            <li><strong>Material:</strong> Stainless steel lasts longer.</li>
                            <li><strong>Legal:</strong> Check local rules about loud exhausts.</li>
                        </ul>
                    <?php else : ?>
                        <h3>General tips for choosing car parts</h3>
                        <ul class="bullet-list">
                            <li><strong>Compatibility:</strong> Make sure the part fits your car model and year.</li>
                            <li><strong>Reviews:</strong> Read feedback from other users.</li>
                            <li><strong>Budget:</strong> Very cheap parts often have low quality.</li>
                            <li><strong>Ask a specialist:</strong> Talk to a mechanic or tuning shop if unsure.</li>
                        </ul>
                    <?php endif; ?>

                    <p style="margin-top: 15px; font-size: 0.9rem; opacity: 0.8;">
                        Choosing the right part is not only about the look, but also about safety and performance.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
include 'includes/footer.php';
?>