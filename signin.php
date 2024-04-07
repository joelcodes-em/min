<?php

include 'connect.php';
session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $password = sha1($_POST['password']);
   $password = filter_var($password, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ?");
   $select_user->execute([$email, $password]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $_SESSION['user_id'] = $row['user_id'];
      header('location: home.php');
   }else{
      $message[] = 'incorrect username or password!';
   }

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

<?php include 'top.php'; ?>
   
<!-- header section starts  -->
<?php include 'header.php'; ?>
<!-- header section ends -->

<section class="reservation">
<?php
  include 'connect.php';
  $message = []; // Initialize $message as an array

  if(isset($message)){
     foreach($message as $msg){
        echo '
        <div class="message">
           <span>'.$msg.'</span>
           <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
     }
  }
  
?>
    <div class="container" style="display: flex; justify-content: center; align-items: center;">

          <div class="form reservation-form bg-black-10" style="display: flex; justify-content: center; align-items: center;">

            <form action="signin.php" method="Post" class="form-left">

              <h2 class="headline-1 text-center">Login</h2>

              <p class="form-text text-center">
                To Order Call <a href="tel:+91 22-6711 4100" class="link">+91 22-6711 4100</a>
                or fill out the order form
              </p>

              <div class="input-wrapper">

                <input type="email" name="email" placeholder="Email" autocomplete="on" class="input-field" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">>

                <input type="password" name="password" placeholder="Password" autocomplete="off" class="input-field" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">>
              </div>
                <button type="submit" class="btn btn-secondary" name="submit" value="login now">
                <span class="text text-1">Submit</span>

                <span class="text text-2" aria-hidden="true">Submit</span>
              </button>
              
              <p style="text-align: center;">Don't have an account? <a href="register.php">Register now</a></p>
            </form>
          </div>
        </div>
</section>


<?php include 'footer.php'; ?>






<!-- custom js file link  -->
<script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>


</body>
</html>