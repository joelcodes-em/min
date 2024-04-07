<?php
include 'connect.php';

session_start();
$user_data = [];

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
   
   
   $select_user = $conn->prepare("SELECT * FROM `users` WHERE user_id = ?");
   $select_user->execute([$user_id]);
   $user_data = $select_user->fetch(PDO::FETCH_ASSOC);// Assuming $_SESSION['name'] contains user data as an array
} else {
   $user_data = array(); // or set it to null, depending on your logic
   header('location:home.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Your head content here -->
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
 


    

    <section class="user_profile">
    <style>
    .user_profile {
        background-color: #808080; /* Gray background */
        color: #fff; /* White text */
        padding: 20px;
        border-radius: 10px;
        margin-top: 200px; /* Add some space between the header and this section */
    }

    .container_profile {
        display: flex;
        flex-direction: column; /* Display items vertically */
        align-items: center;
    }

    .container_profile img {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        margin-bottom: 20px; /* Add space below the image */
    }

    .container_profile p {
        margin: 0;
        font-size: 16px;
        display: flex;
        align-items: center; /* Align icon and text vertically */
    }

    .container_profile p i {
        margin-right: 10px;
    }

    .container_profile a.btn {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
    }

    .container_profile a.btn:hover {
        background-color: #0056b3;
    }
</style>



        <div class="container_profile">
            <img src="assets/images/user-icon.png" alt="">
            <p><i class="fas fa-user" style="align-items=center"></i><span><span><?= isset($user_data['name']) ? $user_data['name'] : ''; ?></span></span></p>
            <p><i class="fas fa-phone" style="align-items=center"></i><span><?= isset($user_data['phone']) ? $user_data['phone'] : ''; ?></span></p>
            <p><i class="fas fa-envelope" style="align-items=center"></i><span><?= isset($user_data['email']) ? $user_data['email'] : ''; ?></span></p></br>
            <a href="update_profile.php" class="btn">update info</a></br>
            <a href="user_logout.php" class="btn">Logout</a>
        </div>

    
    </section>
    
    <!-- Your script links here -->
       <!-- 
    - #BACK TO TOP
  -->

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
