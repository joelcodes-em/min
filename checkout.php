<?php
include 'connect.php';
session_start();

require 'assets/vendor/autoload.php';

use Razorpay\Api\Api;

// Redirect user to home page if not logged in
if(!isset($_SESSION['user_id'])) {
    header('location: home.php');
    exit;
}

$user_id = $_SESSION['user_id'];


// Fetch user profile information
$select_profile = $conn->prepare("SELECT * FROM `users` WHERE user_id = ?");
$select_profile->execute([$user_id]);
$fetch_profile = $select_profile->fetch(PDO::FETCH_ASSOC);

if(isset($_POST['submit'])) {
    // Sanitize input data
    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $phone = filter_var($_POST['phone'], FILTER_SANITIZE_STRING);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_STRING);
    $roll = filter_var($_POST['roll'], FILTER_SANITIZE_STRING);
    $method = filter_var($_POST['method'], FILTER_SANITIZE_STRING);
    $total_products = $_POST['total_products'];
    $total_price = $_POST['total_price'];

    $payment_api = new Api($keyId, $keySecret);

    $orderData = [
        'amount'          => ($total_price*100),
        'currency'        => 'INR'
    ];
    
    $razorpayOrder = $payment_api->order->create($orderData);
    $razorpay_id = $razorpayOrder['id'];

    // Check if cart is not empty
    $check_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
    $check_cart->execute([$user_id]);

    if($check_cart->rowCount() > 0) {
        // Check if address is provided
        if(empty($address)) {
            
            // Insert order into database
            $insert_order = $conn->prepare("INSERT INTO `orders`(user_id, name, phone, email, roll, method, total_products, total_price) VALUES(?,?,?,?,?,?,?,?)");
            $insert_order->execute([$user_id, $name, $phone, $email, $roll, $method, $total_products, $total_price]);

            // Clear user's cart
            $delete_cart = $conn->prepare("DELETE FROM `cart` WHERE user_id = ?");
            $delete_cart->execute([$user_id]);

            $message[] = 'Order placed successfully!';
        }
    } else {
        $message[] = 'Your cart is empty';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <!-- Add your head content here -->
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
  <link rel="stylesheet" href="./assets/css/check.css?v=<?php echo time(); ?>">

  <!-- 
    - preload images
  -->
  <link rel="preload" as="image" href="./assets/images/hero-slider-1.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-slider-2.jpg">
  <link rel="preload" as="image" href="./assets/images/hero-slider-3.jpg">

</head>
<body>

   <div class="heading">
      <h3>Checkout</h3>
      <p><a href="home.php">Home</a> <span>/ Checkout</span></p>
   </div>

   <section class="checkout">
      <h1 class="title">Order Summary</h1>
      <form action="" method="post">
         <!-- Cart items section -->
         <div class="cart-items">
            <h3>Cart Items</h3>
            <!-- Display cart items -->
            <?php
            $grand_total = 0;
            if($fetch_profile) {
               $cart_items = [];
               $select_cart = $conn->prepare("SELECT * FROM `cart` WHERE user_id = ?");
               $select_cart->execute([$user_id]);
               if($select_cart->rowCount() > 0) {
                  while($fetch_cart = $select_cart->fetch(PDO::FETCH_ASSOC)) {
                     $cart_items[] = $fetch_cart['name'].' ('.$fetch_cart['price'].' x '. $fetch_cart['quantity'].') - ';
                     $total_products = implode($cart_items);
                     $grand_total += ($fetch_cart['price'] * $fetch_cart['quantity']);
            ?>
                     <p><span class="name"><?= $fetch_cart['name']; ?></span><span class="price">Rs<?= $fetch_cart['price']; ?> x <?= $fetch_cart['quantity']; ?></span></p>
            <?php
                  }
               } else {
                  echo '<p class="empty">Your cart is empty!</p>';
               }
            }
            ?>
            <p class="grand-total"><span class="name">Grand Total :</span><span class="price">Rs<?= $grand_total; ?></span></p>
            <a href="cart.php" class="btn">View Cart</a>
         </div>

         <!-- Hidden input fields for form submission -->
         <input type="hidden" name="total_products" value="<?= $total_products; ?>">
         <input type="hidden" name="total_price" value="<?= $grand_total; ?>">
         <input type="hidden" name="name" value="<?= $fetch_profile['name'] ?>">
         <input type="hidden" name="phone" value="<?= $fetch_profile['phone'] ?>">
         <input type="hidden" name="email" value="<?= $fetch_profile['email'] ?>">
         <input type="hidden" name="roll" value="<?= $fetch_profile['roll'] ?>">
         <input type="hidden" name="method" value="Online Payment">
         

         <!-- User info section -->
         <div class="user-info">
            <h3>Your Info</h3>
            <p><i class="fas fa-user"></i><span><?= $fetch_profile['name'] ?></span></p>
            <p><i class="fas fa-phone"></i><span><?= $fetch_profile['phone'] ?></span></p>
            <p><i class="fas fa-envelope"></i><span><?= $fetch_profile['email'] ?></span></p>
            <a href="update_profile.php" class="btn">Update Info</a>
            <p class="instructions">Please make the payment online and pick up your order from college canteen.</p>
            <!-- Place order button -->
            <input type="submit" value="Place Order" id="pay-btn" class="btn btn-place-order" style="width:100%; background:var(--red); color:var(--white);" name="submit">
         </div>
      </form>
   </section>

   <!-- footer section starts  -->
   
   <!-- footer section ends -->

   <a href="#top" class="back-top-btn active" aria-label="back to top" data-back-top-btn>
      <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
   </a>

   <script src="./assets/js/script.js"></script>
   <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        var options = {
            "key": "<?php echo $keyId; ?>",
            "amount": "<?php echo $grand_total * 100; ?>",
            "currency": "INR",
            "name": "Fr Crce Cafe",
            "description": "Food booking for <?php echo $fetch_profile['name']; ?>",
            "image": "favicon.png",
            "order_id": "<?php echo $razorpay_id; ?>",
            "handler": function(response) {
                $.ajax({
                    type: 'POST',
                    url: 'processing',
                    data: {
                        razorpay_payment_id: response.razorpay_payment_id,
                        razorpay_order_id: response.razorpay_order_id,
                        razorpay_signature: response.razorpay_signature
                    },
                    success: function(data) {
                        console.log('Session variables set successfully.');
                        if (data.trim() === "success") {
                            window.location.href = "/success";
                        } else {
                            window.location.href = "/failed";
                        }
                    }
                });
            },
            "prefill": {
                "name": "<?php echo $fetch_profile['name']; ?>"
            },
            "theme": {
                "color": "#3399cc"
            }
        };
        var rzp = new Razorpay(options);
        rzp.on('payment.failed', function(response) {
            alert("Payment failed!");
            $.ajax({
                type: 'POST',
                url: 'failed',
                data: {
                    error_code: response.error.code,
                    error_description: response.error.description,
                    error_source: response.error.source,
                    error_step: response.error.step,
                    error_reason: response.error.reason,
                    error_metadata_order_id: response.error.metadata.order_id,
                    error_metadata_payment_id: response.error.metadata.payment_id
                },
                success: function(data) {
                    console.log('Failure Recorded Successfully.');;
                }
            });
        });
        document.getElementById('pay-btn').onclick = function(e) {
            rzp.open();
            e.preventDefault();
        }
    </script>

   <!-- Ionicon link -->
   <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
   <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>
