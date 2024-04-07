<?php

include 'connect.php';

session_start();

if(isset($_SESSION['user_id'])){
   $user_id = $_SESSION['user_id'];
}else{
   $user_id = '';
};

if(isset($_POST['submit'])){

   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_EMAIL);
   $roll = $_POST['roll'];
   $roll = filter_var($roll, FILTER_SANITIZE_STRING);
   $phone = $_POST['phone'];
   $phone = filter_var($phone, FILTER_SANITIZE_STRING);
   $password = sha1($_POST['password']);
   $password = filter_var($password, FILTER_SANITIZE_STRING);
   $cpassword = sha1($_POST['cpassword']);
   $cpassword = filter_var($cpassword, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? OR phone = ?");
   $select_user->execute([$email, $phone]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);

   if($select_user->rowCount() > 0){
      $message[] = 'email or phone already exists!';
   }else{
      if($password != $cpassword){
         $message[] = 'confirm password not matched!';
      }else{
         $insert_user = $conn->prepare("INSERT INTO `users`(name, email, roll, phone, password) VALUES(?,?,?,?,?)");
         $insert_user->execute([$name, $email, $roll, $phone, $cpassword]);
         $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? AND roll = ?");
         $select_user->execute([$email, $password, $roll]);
         $row = $select_user->fetch(PDO::FETCH_ASSOC);
         if($select_user->rowCount() > 0){
            $_SESSION['user_id'] = $row['id'];
            header('location:home.php');
         }
      }
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


  <?php include 'header.php'; ?>


     <!-- 
        - #RESERVATION
      -->

      <section class="reservation">
        <div class="container">

          <div class="form reservation-form bg-black-10">

            <form action="register.php" method="Post" class="form-left">

              <h2 class="headline-1 text-center">Register</h2>

              <p class="form-text text-center">
                To Order Call <a href="tel:+91 22-6711 4100" class="link">+91 22-6711 4100</a>
                or fill out the order form
              </p>

              <div class="input-wrapper">
                <input type="text" name="name" placeholder="Your Name" autocomplete="on" class="input-field" maxlength="50">

                <input type="tel" name="phone" placeholder="Phone Number" autocomplete="on" class="input-field" min="0" max="9999999999" maxlength="10">

                <input type="tel" name="roll" placeholder="Roll Number" autocomplete="off" class="input-field">

                <input type="email" name="email" placeholder="Email" autocomplete="on" class="input-field" maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">

                <input type="password" name="password" placeholder="Password" autocomplete="off" class="input-field"  maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">

                <input type="password" name="cpassword" placeholder="Confirm Password" autocomplete="off" class="input-field"  maxlength="50" oninput="this.value = this.value.replace(/\s/g, '')">

              </div>


              <div class="input-wrapper">

                <div class="icon-wrapper">
                  <ion-icon name="person-outline" aria-hidden="true"></ion-icon>

                  <select name="person" class="input-field">
                    <option value="1-person">1st Year</option>
                    <option value="2-person">2nd Year</option>
                    <option value="3-person">3rd Year</option>
                    <option value="4-person">4th Year</option>
                  </select>

                  <ion-icon name="chevron-down" aria-hidden="true"></ion-icon>
                </div>

              </div>


              <button type="submit" name ="submit" class="btn btn-secondary">
                <span class="text text-1">Submit</span>

                <span class="text text-2" aria-hidden="true">Submit</span>

              </button>
              <div class="tex" style="text-align:center;">
              <p>Already have an account? <a href="signin.php">Login?</a></p>
    </div>

              
             
            </form>


            <div class="form-right text-center" style="background-image: url('./assets/images/form-pattern.png')">

              <h2 class="headline-1 text-center">Contact Us</h2>

              <p class="contact-label">Order Request</p>

              <a href="tel:+91 22-6711 4100" class="body-1 contact-number hover-underline">+91 22-6711 4100</a>

              <div class="separator"></div>

              <p class="contact-label">Location</p>

              <address class="body-4">
                Fr. Agnel Ashram, Bandstand, <br>
                Bandra (W), Mumbai
              </address>



            </div>

          </div>

        </div>
      </section>

      

      <!-- 
    - #BACK TO TOP
  -->

  <a href="#top" class="back-top-btn active" aria-label="back to top" data-back-top-btn>
    <ion-icon name="chevron-up" aria-hidden="true"></ion-icon>
  </a>





  <!-- 
    - custom js link
  -->
  <script src="./assets/js/script.js"></script>

  <!-- 
    - ionicon link
  -->
  <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
  <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

</body>

</html>