<?php
// admin/update-product.php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit();
}

include '../connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);
    $price = floatval($_POST['price']);
    $stock = intval($_POST['stock']);
    $category_id = intval($_POST['category_id']);

    // Fetch existing product
    $existing_rs = Database::search("SELECT * FROM products WHERE product_id = '$id'");
    if ($existing_rs->num_rows === 0) {
        die("Product not found.");
    }
    $existing = $existing_rs->fetch_assoc();

    // Handle image upload
    $image_path = $existing['image'];
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $allowed = ['jpg', 'jpeg', 'png', 'webp'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

        if (!in_array($file_ext, $allowed)) {
            die("Invalid image format. Only JPG, PNG, and WEBP are allowed.");
        }

        $new_filename = uniqid("product_", true) . "." . $file_ext;
        $upload_path = "../uploads/" . $new_filename;

        if (!move_uploaded_file($file_tmp, $upload_path)) {
            die("Image upload failed.");
        }

        // Delete old image if exists
        if ($image_path && file_exists("../" . $image_path)) {
            unlink("../" . $image_path);
        }

        $image_path = "uploads/" . $new_filename;
    }

    // Update product
    $stmt = Database::iud("
        UPDATE products 
        SET name = '$name', description = '$description', price = $price, stock = $stock, category_id = $category_id, image = '$image_path'
        WHERE product_id = '$id'
        
    ");

    header("Location: products.php?msg=Product updated successfully");
    exit();
}
?>
