<?php
// Starting or resuming the session
session_start();

// Check if user is logged in
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // If user is not logged in, redirect to login page
    header('Location: signin.php');
    exit; // Stop further execution
}

// Include your database connection file
include 'connect.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if the cart_item_id is set and not empty
    if (isset($_POST['cart_item_id']) && !empty($_POST['cart_item_id'])) {
        // Sanitize the cart_item_id to prevent SQL injection
        $cart_item_id = filter_var($_POST['cart_item_id'], FILTER_SANITIZE_NUMBER_INT);

        // Prepare and execute the SQL query to delete the cart item
        $delete_query = $conn->prepare("DELETE FROM `cart` WHERE id = ? AND user_id = ?");
        $delete_query->execute([$cart_item_id, $user_id]);

        // Redirect back to the cart page after removing the item
        header('Location: cart.php');
        exit; // Stop further execution
    } else {
        // If cart_item_id is not set or empty, redirect back to the cart page
        header('Location: cart.php');
        exit; // Stop further execution
    }
} else {
    // If the form is not submitted, redirect back to the cart page
    header('Location: cart.php');
    exit; // Stop further execution
}
?>
