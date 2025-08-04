<?php
require_once "../connection.php";

// Total Orders
$totalOrdersResult = Database::search("SELECT COUNT(*) AS count FROM orders");
$totalOrders = $totalOrdersResult->fetch_assoc()['count'];

// Total Products
$totalProductsResult = Database::search("SELECT COUNT(*) AS count FROM products");
$totalProducts = $totalProductsResult->fetch_assoc()['count'];

// Total Customers
$totalCustomersResult = Database::search("SELECT COUNT(*) AS count FROM users  ");
$totalCustomers = $totalCustomersResult->fetch_assoc()['count'];

// Total Revenue
$totalRevenueResult = Database::search("SELECT SUM(total) AS revenue FROM orders");
$totalRevenue = $totalRevenueResult->fetch_assoc()['revenue'] ?? 0;

// Monthly Sales for chart
$monthlySales = [];
$monthlyResult = Database::search("
  SELECT DATE_FORMAT(ordered_at, '%b') AS month, SUM(total) AS total
  FROM orders
  GROUP BY ordered_at
  
");
while ($row = $monthlyResult->fetch_assoc()) {
  $monthlySales[] = ["month" => $row['month'], "total" => $row['total']];
}

// Best Selling Products
$bestProducts = Database::search("
  SELECT p.name, SUM(oi.qty) AS total_sold
  FROM order_items oi
  JOIN products p ON oi.product_id = p.product_id
  GROUP BY oi.product_id
  ORDER BY total_sold DESC
  LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Admin Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 p-6">

  <h1 class="text-3xl font-bold mb-6 text-gray-800">Admin Dashboard</h1>
  <div class="flex min-h-screen">
<?php include 'sidebar.php'; ?>
<main class="flex-1 p-8">
  <!-- Stats Grid -->
  <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-lg font-semibold text-gray-700">Total Orders</h2>
      <p class="text-2xl font-bold text-indigo-600 mt-2"><?= $totalOrders ?></p>
    </div>
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-lg font-semibold text-gray-700">Total Products</h2>
      <p class="text-2xl font-bold text-indigo-600 mt-2"><?= $totalProducts ?></p>
    </div>
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-lg font-semibold text-gray-700">Total Customers</h2>
      <p class="text-2xl font-bold text-indigo-600 mt-2"><?= $totalCustomers ?></p>
    </div>
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-lg font-semibold text-gray-700">Total Revenue</h2>
      <p class="text-2xl font-bold text-indigo-600 mt-2">$<?= number_format($totalRevenue, 2) ?></p>
    </div>
  </div>

  <!-- Chart + Best Sellers -->
  <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-10">
    <!-- Sales Chart -->
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-lg font-semibold text-gray-700 mb-4">Monthly Sales</h2>
      <canvas id="salesChart" height="200"></canvas>
    </div>

    <!-- Best Selling Products -->
    <div class="bg-white p-6 rounded shadow">
      <h2 class="text-lg font-semibold text-gray-700 mb-4">Top 5 Best Sellers</h2>
      <ul class="divide-y divide-gray-200">
        <?php while ($bp = $bestProducts->fetch_assoc()): ?>
          <li class="py-2 flex justify-between">
            <span><?= htmlspecialchars($bp['name']) ?></span>
            <span class="text-indigo-600 font-medium"><?= $bp['total_sold'] ?> sold</span>
          </li>
        <?php endwhile; ?>
      </ul>
    </div>
  </div>
</main>

  </div>
  <!-- Chart Script -->
  <script>
  const ctx = document.getElementById('salesChart').getContext('2d');
  const salesChart = new Chart(ctx, {
    type: 'bar',
    data: {
      labels: <?= json_encode(array_column($monthlySales, 'month')) ?>,
      datasets: [{
        label: 'Sales ($)',
        data: <?= json_encode(array_column($monthlySales, 'total')) ?>,
        backgroundColor: 'rgba(99, 102, 241, 0.7)',
        borderRadius: 8,
      }]
    },
    options: {
      responsive: true,
      scales: {
        y: {
          beginAtZero: true,
          ticks: {
            callback: val => '$' + val
          }
        }
      }
    }
  });
  </script>

</body>
</html>
