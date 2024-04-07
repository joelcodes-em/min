<?php

include 'connect.php';

session_start();

if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    $user_id = '';
    header('location:home.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- 
    - primary meta tags
  -->
    <title>FRCRCE CAFE</title>
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
    <link rel="stylesheet" href="./assets/css/style.css?v=<?php echo time(); ?>">

    <!-- 
    - preload images
  -->
    <link rel="preload" as="image" href="./assets/images/hero-slider-1.jpg">
    <link rel="preload" as="image" href="./assets/images/hero-slider-2.jpg">
    <link rel="preload" as="image" href="./assets/images/hero-slider-3.jpg">

</head>

<body id="top">

    <!-- 
    - #PRELOADER
  -->

    <div class="preload" data-preaload>
        <div class="circle"></div>
        <p class="text">CRCE CAFE</p>
    </div>

    <body>
        <?php include 'top.php'; ?>

        <!-- header section starts  -->
        <?php include 'header.php'; ?>
        <!-- header section ends -->

        <div class="heading">
            <h3>orders</h3>
            <p><a href="home.php">home</a> <span> / orders</span></p>
        </div>

        <section class="orders">

            <h1 class="title">your orders</h1>

            <div class="box-container">

                <?php
                if ($user_id == '') {
                    echo '<p class="empty">please login to see your orders</p>';
                } else {
                    $select_orders = $conn->prepare("SELECT * FROM `orders` WHERE user_id = ? AND payment_status = 'completed'");
                    $select_orders->execute([$user_id]);
                    if ($select_orders->rowCount() > 0) {
                        while ($fetch_orders = $select_orders->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <div class="box">
                    <p>placed on : <span><?= $fetch_orders['placed_on']; ?></span></p>
                    <p>name : <span><?= $fetch_orders['name']; ?></span></p>
                    <p>email : <span><?= $fetch_orders['email']; ?></span></p>
                    <p>number : <span><?= $fetch_orders['phone']; ?></span></p>
                    <p>number : <span><?= $fetch_orders['roll']; ?></span></p>
                    <p>payment method : <span><?= $fetch_orders['method']; ?></span></p>
                    <p>your orders : <span><?= $fetch_orders['total_products']; ?></span></p>
                    <p>total price : <span>$<?= $fetch_orders['total_price']; ?>/-</span></p>
                    <p> payment status : <span style="color:<?php if ($fetch_orders['payment_status'] == 'pending') {
                                                                            echo 'red';
                                                                        } else {
                                                                            echo 'green';
                                                                        }; ?>"><?= $fetch_orders['payment_status']; ?></span>
                    </p>
                </div>
                <?php
                        }
                    } else {
                        echo '<p class="empty">no orders placed yet!</p>';
                    }
                }
                ?>

            </div>

        </section>

        <!-- footer section starts  -->
        <?php include 'footer.php'; ?>
        <!-- footer section ends -->

        <!-- custom js file link  -->
        <script src="js/script.js"></script>

    </body>

</html>
