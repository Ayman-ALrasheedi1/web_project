<?php
/**
 * products.php
 * Professional Products Page: Admin Edit/Delete + Quick Stock
 */

session_start();
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: index.php');
    exit;
}

require 'config.php';
$isAdmin = (isset($_SESSION['role']) && $_SESSION['role'] === 'admin');

// --- HANDLE ACTIONS ---
if ($isAdmin) {
    // Delete
    if (isset($_POST['delete_id'])) {
        $stmt = $pdo->prepare("DELETE FROM products WHERE id = :id");
        $stmt->execute([':id' => (int)$_POST['delete_id']]);
        header("Location: products.php");
        exit;
    }
    // Increase Stock
    if (isset($_POST['increase_id'])) {
        $stmt = $pdo->prepare("UPDATE products SET stock_quantity = stock_quantity + 1 WHERE id = :id");
        $stmt->execute([':id' => (int)$_POST['increase_id']]);
        header("Location: products.php");
        exit;
    }
    // Decrease Stock
    if (isset($_POST['decrease_id'])) {
        $stmt = $pdo->prepare("UPDATE products SET stock_quantity = GREATEST(0, stock_quantity - 1) WHERE id = :id");
        $stmt->execute([':id' => (int)$_POST['decrease_id']]);
        header("Location: products.php");
        exit;
    }
}

$pageTitle = "Products | Luxury Garage";
include 'includes/header.php';

$stmt = $pdo->query("SELECT * FROM products ORDER BY created_at DESC");
$products = $stmt->fetchAll();
?>

<section class="section">
    <div class="container">
        
        <!-- Header -->
        <div style="display: flex; justify-content: space-between; align-items: end; margin-bottom: 2rem;">
            <div>
                <h1 class="section-title" style="margin-bottom: 0.5rem;">Performance Parts</h1>
                <p class="section-subtitle" style="margin-bottom: 0;">Premium upgrades for your vehicle.</p>
            </div>
            <?php if ($isAdmin): ?>
                <a href="add_product.php" class="btn btn-primary" style="padding: 0.7rem 1.5rem;">
                    <span style="margin-right: 8px; font-weight: bold; font-size: 1.2rem;">+</span> Add New Product
                </a>
            <?php endif; ?>
        </div>

        <!-- Filter Bar (simplified for brevity) -->
        <div class="filters" style="background: #101018; padding: 1.2rem; border-radius: 12px; border: 1px solid #232338; display: flex; gap: 1rem; flex-wrap:wrap; align-items: center;">
            <input type="text" id="searchInput" placeholder="Search products..." style="flex-grow: 1; padding: 0.7rem; background: #050509; border: 1px solid #333; color: white; border-radius: 6px;">
            <button class="btn btn-secondary" id="filterBtn">Filter</button>
        </div>

        <!-- Grid -->
        <div class="card-grid" id="productsGrid" style="margin-top: 2rem;">
            <?php foreach ($products as $product): ?>
                <?php 
                    $stock = isset($product['stock_quantity']) ? (int)$product['stock_quantity'] : 5;
                    $isOutOfStock = ($stock <= 0);
                ?>

                <article class="card product-card" 
                         style="position: relative; border: 1px solid #232338;"
                         data-brand="<?php echo htmlspecialchars($product['brand']); ?>"
                         data-category="<?php echo htmlspecialchars($product['category']); ?>">
                    
                    <!-- ADMIN ICONS (Top Right) -->
                    <?php if ($isAdmin): ?>
                        <div style="position: absolute; top: 10px; right: 10px; z-index: 10; display: flex; gap: 8px;">
                            <!-- Edit Button (Pencil) -->
                            <a href="edit_product.php?id=<?php echo $product['id']; ?>" style="background: rgba(0,0,0,0.7); color: #ff9100; border: 1px solid #ff9100; border-radius: 50%; width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; text-decoration: none;">
                                ✎
                            </a>
                            <!-- Delete Button (X) -->
                            <form method="POST" onsubmit="return confirm('Delete this product?');" style="margin:0;">
                                <input type="hidden" name="delete_id" value="<?php echo $product['id']; ?>">
                                <button type="submit" style="background: rgba(0,0,0,0.7); color: #ff5252; border: 1px solid #ff5252; border-radius: 50%; width: 32px; height: 32px; cursor: pointer; display: flex; align-items: center; justify-content: center;">✕</button>
                            </form>
                        </div>
                    <?php endif; ?>

                    <!-- Image -->
                    <div class="product-image-placeholder" style="position: relative; overflow: hidden; height: 180px; background: #0b0b10;">
                        <?php if ($isOutOfStock): ?>
                            <span style="position: absolute; top: 10px; left: 10px; background: #ff5252; color: white; padding: 4px 10px; font-size: 0.7rem; font-weight: bold; border-radius: 4px;">SOLD OUT</span>
                        <?php else: ?>
                            <span style="position: absolute; top: 10px; left: 10px; background: #00e676; color: black; padding: 4px 10px; font-size: 0.7rem; font-weight: bold; border-radius: 4px;">IN STOCK</span>
                        <?php endif; ?>
                        <span style="opacity: 0.3; letter-spacing: 2px;">PRODUCT IMAGE</span>
                    </div>

                    <div style="padding: 0.5rem;">
                        <div style="font-size: 0.75rem; color: #ff9100; text-transform: uppercase; font-weight: bold;">
                            <?php echo htmlspecialchars($product['brand']); ?>
                        </div>

                        <h3 class="product-name" style="font-size: 1.2rem; margin: 0.5rem 0; height: 2.8rem; overflow: hidden;">
                            <?php echo htmlspecialchars($product['name']); ?>
                        </h3>

                        <p class="product-description" style="font-size: 0.85rem; color: #aaa; margin-bottom: 1rem; height: 2.6rem; overflow: hidden;">
                            <?php echo htmlspecialchars($product['description']); ?>
                        </p>

                        <!-- ADMIN CONTROLS ROW -->
                        <?php if ($isAdmin): ?>
                            <div style="background: #1a1a24; padding: 8px; border-radius: 8px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                <span style="font-size: 0.8rem; color: #aaa;">Quick Stock:</span>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <form method="POST" style="margin:0;">
                                        <input type="hidden" name="decrease_id" value="<?php echo $product['id']; ?>">
                                        <button type="submit" style="background:none; border:none; color:#ff5252; font-weight:bold; cursor:pointer; font-size:1.1rem;">-</button>
                                    </form>
                                    <span style="color:white; font-weight:bold; min-width:20px; text-align:center;"><?php echo $stock; ?></span>
                                    <form method="POST" style="margin:0;">
                                        <input type="hidden" name="increase_id" value="<?php echo $product['id']; ?>">
                                        <button type="submit" style="background:none; border:none; color:#00e676; font-weight:bold; cursor:pointer; font-size:1.1rem;">+</button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- PRICE & DETAILS ROW -->
                        <div style="display: flex; justify-content: space-between; align-items: center;">
                            <span class="product-price" style="font-size: 1.3rem; color: white; margin: 0;">
                                <?php echo number_format($product['price']); ?> <span style="font-size: 0.8rem; color: #888;">SAR</span>
                            </span>

                            <?php if ($isOutOfStock && !$isAdmin): ?>
                                <button class="btn btn-disabled" style="padding: 0.4rem 1rem; font-size: 0.8rem;">No Stock</button>
                            <?php else: ?>
                                <a href="product.php?id=<?php echo $product['id']; ?>" class="btn btn-secondary" style="padding: 0.4rem 1.2rem; font-size: 0.85rem; border-color: #444;">
                                    View Page
                                </a>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php include 'includes/footer.php'; ?>