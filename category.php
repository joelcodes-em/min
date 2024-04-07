<?php
include 'connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
} else {
   $user_id = '';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content here -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Primary meta tags -->
    <title>FRCRCE CAFE</title>
    <meta name="title" content="CRCE Caffe">
    <meta name="description" content="cafe">

    <!-- Favicon -->
    <link rel="shortcut icon" href="./favicon.svg" type="image/svg+xml">

    <!-- Google font link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&family=Forum&display=swap" rel="stylesheet">

    <!-- Custom CSS link -->
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">

    <!-- Preload images -->
    <link rel="preload" as="image" href="./assets/images/hero-slider-1.jpg">
    <link rel="preload" as="image" href="./assets/images/hero-slider-2.jpg">
    <link rel="preload" as="image" href="./assets/images/hero-slider-3.jpg">
</head>

<body>
    <?php include 'top.php'; ?>
    <?php include 'header.php'; ?>

    <div class="add-cart-container">
        <?php include 'add_cart.php'; ?>
    </div>

    <section class="products">
        <h1 class="title">Food Category</h1>
        <div class="box-container">
            <?php
            // Check if 'category' parameter is set in the URL
            if(isset($_GET['category'])) {
                $category = $_GET['category'];
                $select_products = $conn->prepare("SELECT * FROM `products` WHERE category = ?");
                $select_products->execute([$category]);
                if($select_products->rowCount() > 0){
                    while($fetch_products = $select_products->fetch(PDO::FETCH_ASSOC)){
            ?>
            <form action="" method="post" class="box">
                <input type="hidden" name="pid" value="<?= $fetch_products['id']; ?>">
                <input type="hidden" name="name" value="<?= $fetch_products['name']; ?>">
                <input type="hidden" name="price" value="<?= $fetch_products['price']; ?>">
                <input type="hidden" name="image" value="<?= $fetch_products['image']; ?>">
                <a href="quick_view.php?pid=<?= $fetch_products['id']; ?>" class="fas fa-eye"></a>
                <button type="submit" class="fas fa-shopping-cart" name="add_to_cart"></button>
                <img src="./assets/images/<?= $fetch_products['image']; ?>" alt="">
                <div class="name"><?= $fetch_products['name']; ?></div>
                <div class="flex">
                    <div class="price"><span>$</span><?= $fetch_products['price']; ?></div>
                    <input type="number" name="qty" class="qty" min="1" max="99" value="1" maxlength="2">
                </div>
            </form>
            <?php
                    }
                } else {
                    echo '<p class="empty">No products added yet!</p>';
                }
            } else {
                echo '<p class="empty">No category selected!</p>';
            }
            ?>
        </div>
    </section>
    

    <?php include 'footer.php'; ?>

    <!-- Custom JavaScript file link -->
    <script src="./assets/js/script.js"></script>

    <!-- Ionicon link -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
