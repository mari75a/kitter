<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}

include '../connection.php';

if (isset($_GET['id'])) {
  $pid = intval($_GET['id']);
  Database::iud("DELETE FROM products WHERE id = $pid");
}

header("Location: products.php");
exit();
?>
