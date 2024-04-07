<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: signin.php');
    exit; // Stop further execution
}

$user_id = $_SESSION['user_id'];

// Include your database connection file
include 'connect.php';

include 'add_cart.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Add your head content here -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary meta tags -->
    <title>FRCRCE CAFE</title>
    <meta name="title" content="CRCE Caffe">
    <meta name="description" content="cafe">

    <!-- Favicon -->
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

   

    <!-- Custom CSS link -->
    <link rel="stylesheet" href="assets/css/menu.css">
   
   
</head>

<body id="top">
<?php include 'top.php'; ?>

<header class="header">
    <div class="logo">
        <a href="home.php">
            <img src="./assets/images/frlogo.jpg" alt="Logo">
        </a>
    </div>
    <nav class="navigation">
        <ul>
        <li><a href="home.php">Home</a></li>
        <li><a href="menu.php">Menu</a></li>
        <li><a href="profile.php">Profile</a></li>

        </ul>
    </nav>
</header>

<div class="separator gold"></div>
 
   

    <div class="add-cart-container">
        <?php include 'add_cart.php'; ?>
    </div>

    <section class="products">
        <h1 class="title">Menu</h1>
        <div class="box-container">
            <!-- Fetch and display all products -->
            <?php
            $select_products = $conn->prepare("SELECT * FROM `products`");
            $select_products->execute();

            if ($select_products->rowCount() > 0) {
                while ($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)) {
            ?>
                <form action="products.php" method="post" class="box">
    <!-- Your form inputs for adding items to cart -->
    <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
    <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
    <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
    <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
    <!-- Display product details -->
    <img src="./assets/images/<?= $fetch_products['image']; ?>" alt="">
    <div class="name"><?= $fetch_products['name']; ?></div>
    <div class="flex">
        <div class="price"><span>Rs</span><?= $fetch_products['price']; ?></div>
        <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
    </div>
    <!-- Add to cart button -->
    <button type="submit" name="add_to_cart">Add to Cart</button>
</form>

            <?php
                }
            } else {
                echo '<p class="empty">No products found!</p>';
            }
            ?>
        </div>
    </section>

   

   
</body>
</html>
