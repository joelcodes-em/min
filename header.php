
 
<!-- 
    - #HEADER
  -->

  <header class="header" data-header>
    <div class="container">

      <a href="home.php" class="logo">
        <img src="./assets/images/frlogo.jpg" width="80" height="30" alt="cafe Home">
      </a>

      <nav class="navbar" data-navbar>

        <button class="close-btn" aria-label="close menu" data-nav-toggler>
          <ion-icon name="close-outline" aria-hidden="true"></ion-icon>
        </button>

        <a href="home.php" class="logo">
          <img src="./assets/images/logo.svg" width="160" height="50" alt="cafe Home">
        </a>
      
        <ul class="navbar-list">
       

          <li class="navbar-item">
            <a href="home.php" class="navbar-link hover-underline ">
              <div class="separator"></div>

              <span class="span">Home</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="menu.php" class="navbar-link hover-underline ">
              <div class="separator"></div>

              <span class="span">Menus</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="#events" class="navbar-link hover-underline ">
              <div class="separator"></div>

              <span class="span">Events</span>
            </a>
          </li>


          <li class="navbar-item">
            <a href="#reservations" class="navbar-link hover-underline ">
              <div class="separator"></div>

              <span class="span">Contact</span>
            </a>
          </li>

          <li class="navbar-item">
            <a href="profile.php" class="navbar-link hover-underline ">
              <div class="separator"></div>

              <span class="span">Profile</span>
            </a>
          </li>
          <?php
                             // Check if the user is logged in
                                  if (isset($_SESSION['user_id'])) {
    // User is logged in, display the cart icon
                             ?>
                                    <li class="navbar-item">
                                       <a href="cart.php" class="navbar-link hover-underline ">
                                       <div class="separator"></div>

                                       <span class="span">Cart</span>
                                         </a>
                                          </li>
                                            <?php
                                                }
                                                    ?>
                                          
          

        

        </ul>

        
        <div class="icons">
      

      <a href="signin.php" class="btn btn-secondary">
        <span class="text text-1">Order Online</span>

        <span class="text text-2" aria-hidden="true">Order Now</span>
      </a>

      <button class="nav-open-btn" aria-label="open menu" data-nav-toggler>
        <span class="line line-1"></span>
        <span class="line line-2"></span>
        <span class="line line-3"></span>
      </button>

      <div class="overlay" data-nav-toggler data-overlay></div>

    </div>
  </header>