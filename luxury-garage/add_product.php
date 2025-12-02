<?php
/**
 * add_product.php
 * Admin page to create new products
 */

session_start();
require 'config.php';

// Check if user is Admin
if (!isset($_SESSION['logged_in']) || $_SESSION['role'] !== 'admin') {
    header('Location: products.php');
    exit;
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name']);
    $brand = trim($_POST['brand']);
    $category = trim($_POST['category']);
    $price = (float)$_POST['price'];
    $desc = trim($_POST['description']);
    $stock = (int)$_POST['stock'];

    if ($name && $brand && $price) {
        $stmt = $pdo->prepare("INSERT INTO products (name, brand, category, price, description, stock_quantity) VALUES (?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$name, $brand, $category, $price, $desc, $stock])) {
            header("Location: products.php"); // Redirect back to list
            exit;
        } else {
            $message = "Error adding product.";
        }
    } else {
        $message = "Please fill in all fields.";
    }
}

$pageTitle = "Add Product | Luxury Garage";
include 'includes/header.php';
?>

<section class="section">
    <div class="container" style="max-width: 600px;">
        <h1 class="section-title">Add New Product</h1>
        
        <?php if($message): ?>
            <div class="alert alert-error"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="POST" class="login-card" style="padding: 2rem;">
            <div class="login-form">
                <label>Product Name
                    <input type="text" name="name" required placeholder="e.g. Carbon Fiber Hood">
                </label>

                <div class="two-columns" style="gap: 1rem;">
                    <label>Brand
                        <select name="brand" style="background:#050509; border:1px solid #333; color:white; padding:0.75rem; border-radius:8px;">
                            <option value="Toyota">Toyota</option>
                            <option value="BMW">BMW</option>
                            <option value="Mercedes">Mercedes</option>
                            <option value="Nissan">Nissan</option>
                        </select>
                    </label>

                    <label>Category
                        <select name="category" style="background:#050509; border:1px solid #333; color:white; padding:0.75rem; border-radius:8px;">
                            <option value="Rims">Rims</option>
                            <option value="Body Kit">Body Kit</option>
                            <option value="Spoiler">Spoiler</option>
                            <option value="Exhaust">Exhaust</option>
                        </select>
                    </label>
                </div>

                <div class="two-columns" style="gap: 1rem;">
                    <label>Price (SAR)
                        <input type="number" name="price" step="0.01" required placeholder="1500.00">
                    </label>
                    <label>Stock Quantity
                        <input type="number" name="stock" value="5" required>
                    </label>
                </div>

                <label>Description
                    <textarea name="description" rows="4" style="background:#050509; border:1px solid #333; color:white; padding:0.75rem; border-radius:8px;"></textarea>
                </label>

                <button type="submit" class="btn btn-primary" style="margin-top: 1rem;">Add Product</button>
                <a href="products.php" style="text-align: center; margin-top: 1rem; font-size: 0.9rem; color: #888;">Cancel</a>
            </div>
        </form>
    </div>
</section>

<?php include 'includes/footer.php'; ?>