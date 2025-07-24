<?php
session_start();
include 'connection.php';

if (!isset($_GET['cat_id'])) {
  echo "<h2 class='text-center text-red-600 mt-10'>Category not found!</h2>";
  exit;
}

$cat_id = $_GET['cat_id'];


$cat_rs = Database::search("SELECT name FROM categories WHERE category_id = '$cat_id'");
$cat_data = $cat_rs->fetch_assoc();
$category_name = $cat_data['name'] ?? 'Category';

// Fetch products
$products_rs = Database::search("SELECT * FROM products WHERE category_id = '$cat_id'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?= htmlspecialchars($category_name) ?> - Kitter Petstore</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 text-gray-800">

<!-- Header -->
<?php include 'header.php'; ?>

<!-- Hero -->
<section class="bg-gradient-to-r from-orange-400 to-orange-600 text-white py-16 text-center">
  <h1 class="text-4xl font-bold mb-2"><?= htmlspecialchars($category_name) ?></h1>
  <p class="text-lg">Explore the best of "<?= htmlspecialchars($category_name) ?>"</p>
</section>

<!-- Product Grid -->
<section class="max-w-7xl mx-auto px-4 py-10 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
<?php
if ($products_rs->num_rows > 0) {
  while ($product = $products_rs->fetch_assoc()) {
    echo '<div class="bg-white rounded-xl shadow-md overflow-hidden hover:scale-105 transition">';
    echo '  <img src="' . $product['image'] . '" alt="' . $product['name'] . '" class="w-full h-48 object-cover">';
    echo '  <div class="p-4 text-center">';
    echo '    <h3 class="text-lg font-semibold text-gray-800">' . $product['name'] . '</h3>';
    echo '    <p class="text-sm text-gray-500">' . substr($product['description'], 0, 60) . '...</p>';
    echo '    <p class="text-orange-600 text-lg font-bold mt-2">$' . number_format($product['price'], 2) . '</p>';
    echo '    <form method="post" action="add-to-cart.php">';
    echo '      <input type="hidden" name="product_id" value="' . $product['product_id'] . '">';
    echo '      <button type="submit" class="mt-3 bg-orange-500 text-white px-4 py-2 rounded hover:bg-orange-600 transition">Add to Cart</button>';
    echo '    </form>';
    echo '  </div>';
    echo '</div>';
  }
} else {
  echo '<p class="col-span-full text-center text-lg">No products found in this category.</p>';
}
?>
</section>

<!-- Cart Drawer -->
<div id="cartDrawer" class="fixed inset-0 z-50 hidden">
  <div id="backdrop" class="absolute inset-0 bg-black/50 backdrop-blur-sm transition-opacity"></div>
  <div class="absolute right-0 top-0 h-full w-full sm:max-w-md bg-gray-900/80 backdrop-blur-xl shadow-2xl border-l border-indigo-500/20 transition-transform duration-500 ease-in-out transform translate-x-full" id="drawerPanel">
    <div class="p-6 flex flex-col h-full">
      <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-indigo-400">Your Cart</h2>
        <button id="closeCart" class="text-gray-300 hover:text-red-400 text-xl">✕</button>
      </div>
      <div class="flex-1 overflow-y-auto space-y-6">
        <?php
        $subtotal = 0;
        if (isset($_SESSION['cart']) && count($_SESSION['cart']) > 0) {
          foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['product_id'];
            $qty = $item['qty'];
            $rs = Database::search("SELECT * FROM products WHERE product_id = '$product_id'");
            if ($rs->num_rows == 1) {
              $p = $rs->fetch_assoc();
              $total = $p['price'] * $qty;
              $subtotal += $total;
              echo '<div class="flex items-center gap-4 bg-white/5 p-4 rounded-xl shadow">';
              echo '<img src="' . $p['image'] . '" class="w-20 h-20 object-cover rounded-lg border border-indigo-500/30">';
              echo '<div class="flex-1">';
              echo '<h4 class="font-semibold text-indigo-200">' . $p['name'] . '</h4>';
              echo '<p class="text-gray-400 text-sm">Qty: ' . $qty . '</p>';
              echo '<p class="text-indigo-400 mt-1">$' . number_format($total, 2) . '</p>';
              echo '</div>';
              echo '<form method="post" action="remove-from-cart.php">';
              echo '<input type="hidden" name="product_id" value="' . $product_id . '">';
              echo '<button class="text-sm text-red-400 hover:underline">Remove</button>';
              echo '</form>';
              echo '</div>';
            }
          }
        } else {
          echo '<p class="text-white text-center">Your cart is empty.</p>';
        }
        ?>
      </div>
      <div class="mt-6 border-t border-indigo-500/20 pt-4">
        <div class="flex justify-between mb-4 text-lg">
          <span class="text-white">Subtotal</span>
          <span class="text-indigo-300">$<?= number_format($subtotal, 2) ?></span>
        </div>
        <a href="checkout.php" class="block w-full text-center py-3 bg-indigo-600 hover:bg-indigo-500 text-white font-semibold rounded-lg shadow transition">Proceed to Checkout</a>
      </div>
    </div>
  </div>
</div>

<script>
const openCartBtn = document.getElementById('openCart');
const closeCartBtn = document.getElementById('closeCart');
const cartDrawer = document.getElementById('cartDrawer');
const drawerPanel = document.getElementById('drawerPanel');
const backdrop = document.getElementById('backdrop');
function openCart() {
  cartDrawer.classList.remove('hidden');
  setTimeout(() => drawerPanel.classList.remove('translate-x-full'), 10);
}
function closeDrawer() {
  drawerPanel.classList.add('translate-x-full');
  setTimeout(() => cartDrawer.classList.add('hidden'), 500);
}
openCartBtn.addEventListener('click', openCart);
closeCartBtn.addEventListener('click', closeDrawer);
backdrop.addEventListener('click', closeDrawer);
</script>
</body>
</html>