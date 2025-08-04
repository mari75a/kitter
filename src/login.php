<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php';
Database::setUpConnection();
$conn = Database::$connection;

$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($email) || empty($password)) {
        $error = "Please enter both email and password.";
    } else {
        $stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $fullname, $hashedPassword);
            $stmt->fetch();

            
                $_SESSION["id"] = $id;
                $_SESSION["name"] = $fullname;
                header("Location: index.php"); 
                exit();
            
        } else {
            $error = "No account found with that email.";
        }

        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Login - PetZone</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-orange-600 mb-6 text-center">Login to PetZone</h2>

    <?php if (!empty($error)): ?>
      <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm text-center">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>

    <form class="space-y-4" method="POST" action="">
      <input name="email" type="email" placeholder="Email" required class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
      <input name="password" type="password" placeholder="Password" required class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
      <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">Login</button>
    </form>

    <p class="text-sm mt-4 text-center">Don't have an account? <a href="register.php" class="text-orange-600 underline">Register</a></p>
  </div>
</body>
</html>
