<!-- dashboard.php -->
<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
include '../connection.php';

// Fetch real-time stats from DB
$totalSales = 0.00;
$orderCount = 0;
$productCount = 0;
$customerCount = 0;

$salesResult = Database::search("SELECT SUM(total) AS total_sales FROM orders");
if ($row = $salesResult->fetch_assoc()) {
  $totalSales = $row['total_sales'] ?? 0;
}

$orderResult = Database::search("SELECT COUNT(*) AS total_orders FROM orders");
$orderCount = $orderResult->fetch_assoc()['total_orders'] ?? 0;

$productResult = Database::search("SELECT COUNT(*) AS total_products FROM products");
$productCount = $productResult->fetch_assoc()['total_products'] ?? 0;

$customerResult = Database::search("SELECT COUNT(DISTINCT user_id) AS total_customers FROM orders");
$customerCount = $customerResult->fetch_assoc()['total_customers'] ?? 0;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Dashboard | Kitter</title>
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
        <a href="categories.php" class="block px-4 py-2 rounded hover:bg-gray-800">Categories</a>
        <a href="customers.php" class="block px-4 py-2 rounded hover:bg-gray-800">Customers</a>
        <a href="logout.php" class="block px-4 py-2 rounded bg-red-500 hover:bg-red-600 mt-10 text-center">Logout</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">Dashboard</h1>
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white p-6 rounded shadow border-l-4 border-indigo-500">
          <h2 class="text-sm uppercase text-gray-500">Total Sales</h2>
          <p class="text-2xl font-semibold text-gray-700 mt-2">$<?= number_format($totalSales, 2) ?></p>
        </div>
        <div class="bg-white p-6 rounded shadow border-l-4 border-green-500">
          <h2 class="text-sm uppercase text-gray-500">Orders</h2>
          <p class="text-2xl font-semibold text-gray-700 mt-2"><?= $orderCount ?></p>
        </div>
        <div class="bg-white p-6 rounded shadow border-l-4 border-orange-500">
          <h2 class="text-sm uppercase text-gray-500">Products</h2>
          <p class="text-2xl font-semibold text-gray-700 mt-2"><?= $productCount ?></p>
        </div>
        <div class="bg-white p-6 rounded shadow border-l-4 border-pink-500">
          <h2 class="text-sm uppercase text-gray-500">Customers</h2>
          <p class="text-2xl font-semibold text-gray-700 mt-2"><?= $customerCount ?></p>
        </div>
      </div>
    </main>
  </div>
</body>
</html>
