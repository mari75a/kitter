<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
  $name = $_POST['name'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $total = $_POST['total'];

  // Insert order
  Database::iud("INSERT INTO orders (customer_name, email, address, total, ordered_at) VALUES ('$name', '$email', '$address', '$total', NOW())");
  $order_id = Database::$connection->insert_id;

  // Insert order items
  foreach ($_SESSION['cart'] as $item) {
    $pid = $item['product_id'];
    $qty = $item['qty'];
    Database::iud("INSERT INTO order_items (order_id, product_id, qty) VALUES ('$order_id', '$pid', '$qty')");
  }

  // Clear cart
  unset($_SESSION['cart']);

  // Redirect to success
  header("Location: order-success.php?order_id=" . $order_id);
  exit;
}
?>
