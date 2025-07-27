<?php
// admin/login.php
session_start();

if (isset($_SESSION['admin'])) {
  header("Location: dashboard.php");
  exit;
}

include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  $rs = Database::search("SELECT * FROM admins WHERE username = '$username'");
  if ($rs->num_rows == 1) {
    $admin = $rs->fetch_assoc();
    if ( $password === $admin['password']) {
      $_SESSION['admin'] = $admin['admin_id'];
      header("Location: dashboard.php");
      exit;
    } else {
      $error = "Invalid credentials.";
    }
  } else {
    $error = "Admin not found.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-tr from-gray-900 via-gray-800 to-gray-900 h-screen flex items-center justify-center">
  <div class="bg-white rounded-xl shadow-lg p-8 w-full max-w-md">
    <h2 class="text-2xl font-bold mb-6 text-center text-gray-700">Admin Login</h2>
    <?php if (isset($error)): ?>
      <p class="mb-4 text-red-500 text-sm text-center"><?= $error ?></p>
    <?php endif; ?>
    <form method="post" class="space-y-4">
      <input name="username" type="text" required placeholder="Username" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400">
      <input name="password" type="password" required placeholder="Password" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-400">
      <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-500 text-white font-bold py-3 rounded-lg transition">Login</button>
    </form>
  </div>
</body>
</html>
