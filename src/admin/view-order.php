<?php
// view-order.php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

include '../connection.php';

if (!isset($_GET['id'])) {
  header("Location: orders.php");
  exit();
}

$order_id = $_GET['id'];
$order_rs = Database::search("SELECT * FROM orders o
  INNER JOIN users u ON o.user_id = u.id
  WHERE o.order_id = '$order_id'");
$order = $order_rs->fetch_assoc();

$items_rs = Database::search("SELECT * FROM order_items oi
  INNER JOIN products p ON oi.product_id = p.product_id
  WHERE oi.order_id = '$order_id'");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['status'])) {
  $status = $_POST['status'];
  Database::iud("UPDATE orders SET status = '$status' WHERE order_id = '$order_id'");
  header("Location: view-order.php?id=$order_id&updated=true");
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>View Order #<?= $order_id ?> | Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">
  <div class="max-w-5xl mx-auto bg-white p-6 rounded-xl shadow-md">
    <h1 class="text-2xl font-bold mb-4">Order #<?= $order_id ?></h1>

    <div class="mb-6">
      <p><strong>Customer:</strong> <?= htmlspecialchars($order['name']) ?></p>
      <p><strong>Email:</strong> <?= htmlspecialchars($order['email']) ?></p>
      <p><strong>Total:</strong> $<?= number_format($order['total'], 2) ?></p>
      <p><strong>Ordered At:</strong> <?= $order['ordered_at'] ?></p>
      <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    </div>

    <form method="post" class="mb-6">
      <label for="status" class="block font-medium mb-2">Change Order Status</label>
      <select name="status" id="status" class="border px-4 py-2 rounded w-1/2">
        <option <?= $order['status'] === 'Pending' ? 'selected' : '' ?>>Pending</option>
        <option <?= $order['status'] === 'Shipped' ? 'selected' : '' ?>>Shipped</option>
        <option <?= $order['status'] === 'Completed' ? 'selected' : '' ?>>Completed</option>
        <option <?= $order['status'] === 'Cancelled' ? 'selected' : '' ?>>Cancelled</option>
      </select>
      <button type="submit" class="ml-4 px-6 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">Update</button>
    </form>

    <h2 class="text-xl font-semibold mb-3">Ordered Items</h2>
    <table class="w-full table-auto text-sm border">
      <thead class="bg-gray-200">
        <tr>
          <th class="px-4 py-2 text-left">Product</th>
          <th class="px-4 py-2 text-left">Quantity</th>
          <th class="px-4 py-2 text-left">Price</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($item = $items_rs->fetch_assoc()): ?>
        <tr class="border-t">
          <td class="px-4 py-2"><?= htmlspecialchars($item['name']) ?></td>
          <td class="px-4 py-2"><?= $item['qty'] ?></td>
          <td class="px-4 py-2">$<?= number_format($item['price'], 2) ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>

    <a href="orders.php" class="inline-block mt-6 text-indigo-600 hover:underline">← Back to Orders</a>
  </div>
</body>
</html>
