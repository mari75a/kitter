<?php
// categories.php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
include '../connection.php';

$result = Database::search("SELECT * FROM categories ORDER BY category_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Categories | Kitter</title>
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
        <a href="products.php" class="block px-4 py-2 rounded hover:bg-gray-800">Products</a>
        <a href="categories.php" class="block px-4 py-2 rounded bg-gray-800">Categories</a>
        <a href="customers.php" class="block px-4 py-2 rounded hover:bg-gray-800">Customers</a>
        <a href="logout.php" class="block px-4 py-2 rounded bg-red-500 hover:bg-red-600 mt-10 text-center">Logout</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
      <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">Manage Categories</h1>
        <a href="add-category.php" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-500">+ Add Category</a>
      </div>

      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-lg shadow">
          <thead class="bg-gray-200">
            <tr>
              <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">ID</th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Name</th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Image</th>
              <th class="py-3 px-6 text-left text-sm font-semibold text-gray-600">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php while ($cat = $result->fetch_assoc()): ?>
              <tr class="border-b hover:bg-gray-100">
                <td class="py-3 px-6 text-sm text-gray-700">#<?= $cat['category_id'] ?></td>
                <td class="py-3 px-6 text-sm font-medium text-gray-800"><?= $cat['name'] ?></td>
                <td class="py-3 px-6">
                  <img src="../<?= $cat['image'] ?>" class="w-16 h-16 object-cover rounded" alt="<?= $cat['name'] ?>">
                </td>
                <td class="py-3 px-6">
                  <a href="edit-category.php?id=<?= $category['id'] ?>" class="text-blue-600 hover:underline text-sm mr-3">Edit</a>
<a href="delete-category.php?id=<?= $category['id'] ?>" onclick="return confirm('Are you sure you want to delete this category?');" class="text-red-600 hover:underline text-sm">Delete</a>

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
