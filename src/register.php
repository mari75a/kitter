
<?php
session_start();


error_reporting(E_ALL);
ini_set('display_errors', 1);

include 'connection.php';


Database::setUpConnection();
$conn = Database::$connection;

//  Create table if not exists
$tableQuery = "
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    fullname VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($tableQuery);


$error = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullname = trim($_POST["fullname"]);
    $email = trim($_POST["email"]);
    $password = trim($_POST["password"]);

    if (empty($fullname) || empty($email) || empty($password)) {
        $error = "All fields are required.";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $stmt = $conn->prepare("INSERT INTO users (fullname, email, password) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $fullname, $email, $hashedPassword);

            if ($stmt->execute()) {
                header("Location: login.php");
                exit();
            } else {
                $error = "Registration failed: " . $stmt->error;
            }
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
  <title>Register - PetZone</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-orange-50 flex items-center justify-center h-screen">
  <div class="bg-white p-8 rounded shadow-md w-full max-w-md">
    <h2 class="text-2xl font-bold text-orange-600 mb-6 text-center">Create an Account</h2>

    <?php if (!empty($error)): ?>
      <div class="bg-red-100 text-red-700 p-2 rounded mb-4 text-sm text-center">
        <?php echo htmlspecialchars($error); ?>
      </div>
    <?php endif; ?>

    <form class="space-y-4" method="POST" action="">
      <input name="fullname" type="text" placeholder="Full Name" required class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
      <input name="email" type="email" placeholder="Email" required class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
      <input name="password" type="password" placeholder="Password" required class="w-full border px-4 py-2 rounded focus:outline-none focus:ring-2 focus:ring-orange-400">
      <button type="submit" class="w-full bg-orange-500 text-white py-2 rounded hover:bg-orange-600">Register</button>
    </form>

    <p class="text-sm mt-4 text-center">Already have an account? <a href="login.php" class="text-orange-600 underline">Login</a></p>
  </div>
</body>
</html>
