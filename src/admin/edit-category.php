<?php
session_start();
if (!isset($_SESSION['admin'])) {
  header("Location: login.php");
  exit();
}
include '../connection.php';

$id = intval($_GET['id']);
$rs = Database::search("SELECT * FROM categories WHERE category_id = $id");
$category = $rs->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $imagePath = $category['image'];

  if (!empty($_FILES['image']['name'])) {
    $imageName = time() . '_' . basename($_FILES['image']['name']);
    $target = "../uploads/" . $imageName;
    move_uploaded_file($_FILES['image']['tmp_name'], $target);
    $imagePath = "uploads/" . $imageName;
  }

  Database::iud("UPDATE categories SET name='$name', image='$imagePath' WHERE category_id=$id");
  header("Location: categories.php");
  exit();
}
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Edit Category</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
  <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Edit Category</h1>
    <form method="POST" enctype="multipart/form-data" class="space-y-4">
      <input type="text" name="name" value="<?= htmlspecialchars($category['name']) ?>" class="w-full border px-4 py-2 rounded" required>
      <div>
        <label class="block text-sm text-gray-700 mb-1">Current Image</label>
        <img src="../<?= $category['image'] ?>" class="w-24 h-24 object-cover rounded mb-2">
        <input type="file" name="image" class="w-full border px-4 py-2 rounded">
      </div>
      <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Update</button>
      <a href="categories.php" class="text-blue-600 hover:underline ml-4">Cancel</a>
    </form>
  </div>
</body>
</html>
