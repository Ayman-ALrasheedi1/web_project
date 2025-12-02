<?php
/**
 * edit_product.php
 * Edit existing product details
 */
session_start();
require 'config.php';

// Security Check
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: products.php');
    exit;
}

$id = $_GET['id'] ?? 0;
$message = "";
$error = "";

// 1. Fetch current data
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
$stmt->execute([':id' => $id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found.");
}

// 2. Handle Update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $brand = trim($_POST['brand']);
    $category = trim($_POST['category']);
    $price = (float)$_POST['price'];
    $desc = trim($_POST['description']);
    $stock = (int)$_POST['stock'];

    if ($name && $brand) {
        $sql = "UPDATE products SET name=?, brand=?, category=?, price=?, description=?, stock_quantity=? WHERE id=?";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$name, $brand, $category, $price, $desc, $stock, $id])) {
            $message = "Product updated successfully!";
            // Refresh data
            $stmt = $pdo->prepare("SELECT * FROM products WHERE id = :id");
            $stmt->execute([':id' => $id]);
            $product = $stmt->fetch();
        } else {
            $error = "Failed to update product.";
        }
    }
}

$pageTitle = "Edit Product | Luxury Garage";
include 'includes/header.php';
?>

<section class="section">
    <div class="container" style="max-width: 600px;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:1rem;">
            <h1 class="section-title" style="margin:0;">Edit Product</h1>
            <a href="products.php" class="btn btn-secondary">← Back</a>
        </div>
        
        <?php if($message): ?>
            <div class="alert alert-success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if($error): ?>
            <div class="alert alert-error"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" class="login-card" style="padding: 2rem;">
            <div class="login-form">
                
                <label>Product Name
                    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
                </label>

                <div class="two-columns" style="gap: 1rem;">
                    <label>Brand
                        <select name="brand" style="background:#050509; border:1px solid #333; color:white; padding:0.75rem; border-radius:8px;">
                            <option value="Toyota" <?php echo $product['brand']=='Toyota'?'selected':''; ?>>Toyota</option>
                            <option value="BMW" <?php echo $product['brand']=='BMW'?'selected':''; ?>>BMW</option>
                            <option value="Mercedes" <?php echo $product['brand']=='Mercedes'?'selected':''; ?>>Mercedes</option>
                            <option value="Nissan" <?php echo $product['brand']=='Nissan'?'selected':''; ?>>Nissan</option>
                        </select>
                    </label>

                    <label>Category
                        <select name="category" style="background:#050509; border:1px solid #333; color:white; padding:0.75rem; border-radius:8px;">
                            <option value="Rims" <?php echo $product['category']=='Rims'?'selected':''; ?>>Rims</option>
                            <option value="Body Kit" <?php echo $product['category']=='Body Kit'?'selected':''; ?>>Body Kit</option>
                            <option value="Spoiler" <?php echo $product['category']=='Spoiler'?'selected':''; ?>>Spoiler</option>
                            <option value="Exhaust" <?php echo $product['category']=='Exhaust'?'selected':''; ?>>Exhaust</option>
                        </select>
                    </label>
                </div>

                <div class="two-columns" style="gap: 1rem;">
                    <label>Price (SAR)
                        <input type="number" name="price" step="0.01" value="<?php echo $product['price']; ?>" required>
                    </label>
                    <label>Stock Quantity
                        <input type="number" name="stock" value="<?php echo $product['stock_quantity']; ?>" required>
                    </label>
                </div>

                <label>Description
                    <textarea name="description" rows="5" style="background:#050509; border:1px solid #333; color:white; padding:0.75rem; border-radius:8px;"><?php echo htmlspecialchars($product['description']); ?></textarea>
                </label>

                <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Save Changes</button>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>