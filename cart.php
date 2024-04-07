<?php
// Starting or resuming the session
session_start();

// Check if user is logged in
if(isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = ''; // User is not logged in
}

// Include your database connection file
include 'connect.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <meta name="title" content="CRCE Caffe">
  <meta name="description" content="cafe">

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="./assets/css/stylecart.css?v=<?php echo time(); ?>">
  <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">

  <!-- 
    - preload images
  -->
  <link rel="preload" as="image" href="./assets/images/hero-slider-1.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-slider-2.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-slider-3.jpg">


</head>
<?php include 'top.php'; ?>




  <?php include 'header.php'; ?>

<body id="top">

 <!-- 
    - #PRELOADER
  -->

  <div class="preload" data-preaload>
    <div class="circle"></div>
    <p class="text">CRCE CAFE</p>
  </div>
    <!-- Your body content here -->
 
    <!-- Your CSS and other meta tags -->
</head>
<body>
    <div class="cart-container">
        <h2>Your Shopping Cart</h2>
        <div class="cart-items">
        
            <?php
            // Fetch cart items for the logged-in user
            $cart_items_query = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
            $cart_items_query->execute([$user_id]);

            // Display cart items
if ($cart_items_query->rowCount() > 0) {
    while ($row = $cart_items_query->fetch(PDO::FETCH_ASSOC)) {
        echo '<div class="cart-item">';
        echo '<img src="' . $row['image'] . '" alt="' . $row['name'] . '" class="item-image">';
        echo '<div class="item-details">';
        echo '<h3 class="item-name">' . $row['name'] . '</h3>';
        echo '<p class="item-price">Price: Rs' . $row['price'] . '</p>';
        echo '<p class="item-quantity">Quantity: ' . $row['quantity'] . '</p>';
        // Add a form for removing the item from the cart
        echo '<form action="remove_cart.php" method="post">';
        echo '<input type="hidden" name="cart_item_id" value="' . $row['id'] . '">';
        echo '<button type="submit" class="remove-button">Remove from Cart</button>';
        echo '</form>';
        echo '</div>'; // Close item-details
        echo '</div>'; // Close cart-item
                }
            } else {
                echo '<p>Your cart is empty.</p>';
            }
            ?>
        </div> <!-- Close cart-items -->
        <a href="checkout.php" class="checkout-button">Proceed to Checkout</a>
    </div> <!-- Close container -->
    <a href="#top" class="back-top-btn active" aria-label="back to top" data-back-top-btn>
    <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
  </a>

  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>
</html>
