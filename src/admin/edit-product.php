<?php
// admin/edit-product.php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

include '../connection.php';

if (!isset($_GET['id'])) {
  header("Location: products.php");
  exit();
}

$product_id = $_GET['id'];

// Fetch product
$product_rs = Database::search("SELECT * FROM products WHERE    product_id = '$product_id'");
if ($product_rs->num_rows === 0) {
  echo "Product not found.";
  exit();
}
$product = $product_rs->fetch_assoc();

// Fetch categories
$categories_rs = Database::search("SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Product - Admin Panel | Kitter</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
  <div class="max-w-3xl mx-auto bg-white shadow rounded p-6">
    <h1 class="text-2xl font-bold mb-4">Edit Product</h1>

    <form action="update-product.php" method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="hidden" name="id" value="<?= $product['product_id'] ?>">

      <div>
        <label class="block mb-1 font-medium">Product Name</label>
        <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required class="w-full px-3 py-2 border rounded">
      </div>

      <div>
        <label class="block mb-1 font-medium">Description</label>
        <textarea name="description" required class="w-full px-3 py-2 border rounded"><?= htmlspecialchars($product['description']) ?></textarea>
      </div>

      <div class="grid grid-cols-2 gap-4">
        <div>
          <label class="block mb-1 font-medium">Price ($)</label>
          <input type="number" name="price" value="<?= $product['price'] ?>" step="0.01" required class="w-full px-3 py-2 border rounded">
        </div>

        <div>
          <label class="block mb-1 font-medium">Stock</label>
          <input type="number" name="stock" value="<?= $product['stock'] ?>" required class="w-full px-3 py-2 border rounded">
        </div>
      </div>

      <div>
        <label class="block mb-1 font-medium">Category</label>
        <select name="category_id" required class="w-full px-3 py-2 border rounded">
          <?php while ($category = $categories_rs->fetch_assoc()): ?>
            <option value="<?= $category['category_id'] ?>" <?= $category['category_id'] == $product['category_id'] ? 'selected' : '' ?>>
              <?= htmlspecialchars($category['name']) ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>

      <div>
        <label class="block mb-1 font-medium">Product Image</label>
        <input type="file" name="image" class="w-full">
        <p class="text-xs text-gray-500 mt-1">Leave blank to keep current image.</p>
      </div>

      <div class="pt-4">
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded">Update Product</button>
        <a href="products.php" class="ml-4 text-gray-600 hover:underline">Cancel</a>
      </div>
    </form>
  </div>
</body>
</html>
