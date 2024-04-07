<?php
// Starting or resuming the session


// Check if user is logged in
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = ''; // User is not logged in
}

// Include your database connection file
include 'connect.php';

// Code for adding items to cart
// Code for adding items to cart
if(isset($_POST['add_to_cart'])){
  $pid = $_POST['pid'];
  $product_name = $_POST['name'];
  $price = $_POST['price'];
  $image = $_POST['image'];
  $qty = $_POST['qty'];

  // Sanitize input data
  $pid = filter_var($pid, FILTER_SANITIZE_STRING);
  $product_name = filter_var($product_name, FILTER_SANITIZE_STRING);
  $price = filter_var($price, FILTER_SANITIZE_STRING);
  $image = filter_var($image, FILTER_SANITIZE_STRING);
  $qty = filter_var($qty, FILTER_SANITIZE_STRING);

  // Check if item already exists in cart
  $check_cart_numbers = $conn->prepare("SELECT * FROM `cart` WHERE name = ? AND user_id = ?");
  $check_cart_numbers->execute([$product_name, $user_id]);

  if($check_cart_numbers->rowCount() > 0){
      $message[] = 'Item already added to cart!';
  } else {
      try {
          // Insert item into cart
          $insert_cart = $conn->prepare("INSERT INTO `cart` (user_id, pid, name, price, quantity, image) VALUES (?, ?, ?, ?, ?, ?)");
          $insert_cart->execute([$user_id, $pid, $product_name, $price, $qty, $image]);
          $message[] = 'Item added to cart!';
      } catch (PDOException $e) {
          // Handle the error gracefully
          $message[] = 'Error: ' . $e->getMessage();
      }
  }
}
?>