<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $imagePath = '';

  if (!empty($_FILES['image']['name'])) {
    $imageName = time() . '_' . basename($_FILES['image']['name']);
    $target = "../img/" . $imageName;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
    $imagePath = "img/" . $imageName;
  }

  if ($name && $imagePath) {
    Database::iud("INSERT INTO categories (name, image) VALUES ('$name', '$imagePath')");
    header("Location: categories.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Add Category</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Add New Category</h1>
    <form method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="text" name="name" placeholder="Category Name" class="w-full border px-4 py-2 rounded" required>
      <input type="file" name="image" class="w-full border px-4 py-2 rounded" required>
      <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Add Category</button>
      <a href="categories.php" class="text-blue-600 hover:underline ml-4">Back to Categories</a>
    </form>
  </div>
</body>
</html>
