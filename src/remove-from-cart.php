<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];

    if (isset($_SESSION['cart'])) {
        foreach ($_SESSION['cart'] as $index => $item) {
            if ($item['product_id'] == $product_id) {
                unset($_SESSION['cart'][$index]);
                $_SESSION['cart'] = array_values($_SESSION['cart']); // Re-index array
                break;
            }
        }
    }

    // Redirect back to the referring page
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit;
} else {
    echo "Invalid request";
}
?>
