<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

include '../connection.php';

$rs = Database::search("SELECT products.*, categories.name AS category_name FROM products INNER JOIN categories ON products.category_id = categories.category_id ORDER BY created_at DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Products - Admin Panel | Kitter</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="flex min-h-screen">
    
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
      <div class="px-6 py-4 text-2xl font-bold border-b border-gray-700">Kitter Admin</div>
      <nav class="flex-1 p-4 space-y-2">
        <a href="dashboard.php" class="block px-4 py-2 rounded hover:bg-gray-800">Dashboard</a>
        <a href="orders.php" class="block px-4 py-2 rounded hover:bg-gray-800">Orders</a>
        <a href="products.php" class="block px-4 py-2 rounded bg-gray-800">Products</a>
        <a href="categories.php" class="block px-4 py-2 rounded hover:bg-gray-800">Categories</a>
        <a href="customers.php" class="block px-4 py-2 rounded hover:bg-gray-800">Customers</a>
        <a href="logout.php" class="block px-4 py-2 rounded bg-red-500 hover:bg-red-600 mt-10 text-center">Logout</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">All Products</h1>
        <a href="add-product.php" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded text-sm">+ Add New</a>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl overflow-hidden">
          <thead class="bg-gray-200 text-gray-600 text-sm">
            <tr>
              <th class="text-left px-4 py-3">Product</th>
              <th class="text-left px-4 py-3">Category</th>
              <th class="text-left px-4 py-3">Price</th>
              <th class="text-left px-4 py-3">Stock</th>
              <th class="text-left px-4 py-3">Actions</th>
            </tr>
          </thead>
          <tbody class="text-sm divide-y divide-gray-100">
            <?php while ($p = $rs->fetch_assoc()): ?>
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-3 font-semibold"><?= htmlspecialchars($p['name']) ?></td>
              <td class="px-4 py-3"><?= htmlspecialchars($p['category_name']) ?></td>
              <td class="px-4 py-3 text-green-600 font-medium">$<?= number_format($p['price'], 2) ?></td>
              <td class="px-4 py-3"><?= $p['stock'] ?></td>
              <td class="px-4 py-3 space-x-2">
                <a href="edit-product.php?id=<?= $p['product_id'] ?>" class="text-blue-600 hover:underline">Edit</a>
                <a href="delete-product.php?id=<?= $p['product_id'] ?>" onclick="return confirm('Are you sure you want to delete this product?');" class="text-red-600 hover:underline">Delete</a>
              </td>
            </tr>
            <?php endwhile; ?>
          </tbody>
        </table>
      </div>
    </main>
  </div>
</body>
</html>
