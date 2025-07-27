<?php
$order_id = $_GET['order_id'] ?? 0;
?>
<!DOCTYPE html>
<html>
<head>
  <title>Order Placed - Kitter</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-green-50 flex flex-col items-center justify-center min-h-screen text-center px-6">
  <div class="bg-white shadow-xl rounded-xl p-8 max-w-md">
    <h1 class="text-3xl font-bold text-green-600 mb-4">Thank you!</h1>
    <p class="text-lg">Your order <span class="font-semibold">#<?= htmlspecialchars($order_id) ?></span> has been placed successfully.</p>
    <a href="index.php" class="mt-6 inline-block bg-green-600 text-white py-2 px-6 rounded hover:bg-green-700">Back to Home</a>
  </div>
</body>
</html>
