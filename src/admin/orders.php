<?php
// admin/orders.php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

include '../connection.php';
$rs = Database::search("SELECT * FROM orders ORDER BY created_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Orders - Admin Panel | Kitter</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-gray-900 text-white flex flex-col">
      <div class="px-6 py-4 text-2xl font-bold border-b border-gray-700">Kitter Admin</div>
      <nav class="flex-1 p-4 space-y-2">
        <a href="dashboard.php" class="block px-4 py-2 rounded hover:bg-gray-800">Dashboard</a>
        <a href="orders.php" class="block px-4 py-2 rounded bg-gray-800">Orders</a>
        <a href="products.php" class="block px-4 py-2 rounded hover:bg-gray-800">Products</a>
        <a href="categories.php" class="block px-4 py-2 rounded hover:bg-gray-800">Categories</a>
        <a href="customers.php" class="block px-4 py-2 rounded hover:bg-gray-800">Customers</a>
        <a href="logout.php" class="block px-4 py-2 rounded bg-red-500 hover:bg-red-600 mt-10 text-center">Logout</a>
      </nav>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
      <h1 class="text-3xl font-bold text-gray-800 mb-6">All Orders</h1>

      <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl overflow-hidden">
          <thead class="bg-gray-200 text-gray-600 text-sm">
            <tr>
              <th class="text-left px-4 py-3">Order ID</th>
              <th class="text-left px-4 py-3">Customer</th>
              <th class="text-left px-4 py-3">Email</th>
              <th class="text-left px-4 py-3">Total</th>
              <th class="text-left px-4 py-3">Date</th>
              <th class="text-left px-4 py-3">Actions</th>
            </tr>
          </thead>
          <tbody class="text-sm divide-y divide-gray-100">
            <?php while ($order = $rs->fetch_assoc()): ?>
            <tr class="hover:bg-gray-50">
              <td class="px-4 py-3 font-semibold">#<?= $order['order_id'] ?></td>
              <td class="px-4 py-3"><?= htmlspecialchars($order['customer_name']) ?></td>
              <td class="px-4 py-3"><?= htmlspecialchars($order['email']) ?></td>
              <td class="px-4 py-3 text-green-600 font-medium">$<?= number_format($order['total'], 2) ?></td>
              <td class="px-4 py-3 text-gray-500"><?= date('Y-m-d', strtotime($order['ordered_at'])) ?></td>
              <td class="px-4 py-3">
                <a href="view-order.php?id=<?= $order['order_id'] ?>" class="text-indigo-600 hover:underline text-sm">View</a>
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
