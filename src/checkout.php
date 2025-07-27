<?php
session_start();
include 'connection.php';

// Redirect if cart is empty
if (!isset($_SESSION['cart']) || count($_SESSION['cart']) === 0) {
  header("Location: index.php");
  exit;
}

// Calculate total
$subtotal = 0;
$cart_items = [];

foreach ($_SESSION['cart'] as $item) {
  $rs = Database::search("SELECT * FROM products WHERE product_id = '{$item['product_id']}'");
  if ($rs->num_rows == 1) {
    $product = $rs->fetch_assoc();
    $total = $product['price'] * $item['qty'];
    $subtotal += $total;
    $cart_items[] = [
      'id' => $product['product_id'],
      'name' => $product['name'],
      'price' => $product['price'],
      'qty' => $item['qty'],
      'total' => $total
    ];
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Checkout - Kitter</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<!-- Header -->
<header class="bg-white shadow sticky top-0 z-50">
  <div class="max-w-7xl mx-auto p-4 text-xl font-bold text-orange-600">
    Kitter - Checkout
  </div>
</header>

<!-- Checkout Section -->
<main class="max-w-4xl mx-auto px-4 py-10">
  <h1 class="text-3xl font-semibold mb-6 text-center">Complete Your Order</h1>

  <form method="post" action="place-order.php" class="grid md:grid-cols-2 gap-6">
    <!-- Customer Info -->
    <div class="bg-white p-6 rounded-xl shadow">
      <h2 class="text-xl font-semibold mb-4">Customer Info</h2>
      <label class="block mb-2">Full Name</label>
      <input type="text" name="name" class="w-full p-2 border rounded mb-4" required>
      <label class="block mb-2">Email</label>
      <input type="email" name="email" class="w-full p-2 border rounded mb-4" required>
      <label class="block mb-2">Address</label>
      <textarea name="address" rows="4" class="w-full p-2 border rounded" required></textarea>
    </div>

    <!-- Order Summary -->
    <div class="bg-white p-6 rounded-xl shadow">
      <h2 class="text-xl font-semibold mb-4">Order Summary</h2>
      <ul class="space-y-3">
        <?php foreach ($cart_items as $item): ?>
          <li class="flex justify-between text-sm">
            <div><?= $item['name'] ?> x <?= $item['qty'] ?></div>
            <div>$<?= number_format($item['total'], 2) ?></div>
          </li>
        <?php endforeach; ?>
      </ul>
      <hr class="my-4">
      <div class="flex justify-between font-bold text-lg">
        <span>Total</span>
        <span>$<?= number_format($subtotal, 2) ?></span>
      </div>
      <input type="hidden" name="total" value="<?= $subtotal ?>">
      <button type="submit" class="mt-6 w-full bg-orange-500 hover:bg-orange-600 text-white py-3 rounded-lg shadow">
        Place Order
      </button>
    </div>
  </form>
</main>

</body>
</html>
