<?php
session_start();
require './database/db_connection.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LuhLuh Spa</title>
  <link rel="stylesheet" href="index.css">
  <link rel="stylesheet" href="shared/common.css">
  <link rel="stylesheet" href="testimonial.css">
  <!-- Google fonts link for icon -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,1,0" />
  <!-- Swiper CSS link -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
</head>

<body class="font-sans bg-orange-100" style="overflow-x: hidden; background: green;">
  <div class="header-container">
    <nav class="navbar">
      <a href="/" class="logo-container">
        <img class="logo-image" src="spa-logo-header.png" alt="LUHLUH's SPA">
        <h1 class="logo-text">LUHLUH's SPA</h1>
      </a>
      <ul class="nav-links">
        <li><a href="index.php" class="nav-link">Home</a></li>
        <li><a href="/CIT17-3H/service-list.php" class="nav-link">Service List</a></li>
        <li><a href="/CIT17-3H/booking.php" class="nav-link">Booking</a></li>
        <li><a href="/CIT17-3H/user-dashboard.php" class="nav-link">User</a></li>
        <li><a href="/CIT17-3H/admin-dashboard.php" class="nav-link">Admin</a></li>
      </ul>
      <div class="user-icon">
        <?php if (isset($_SESSION['user_id'])): ?>
          <?php
          try {
            $stmt = $pdo->prepare("SELECT email FROM Users WHERE user_id = :user_id");
            $stmt->bindParam(':user_id', $_SESSION['user_id'], PDO::PARAM_INT);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $user_email = $user['email'] ?? "User";
          } catch (PDOException $e) {
            $user_email = "User";
          }
          ?>
          <span><?php echo htmlspecialchars($user_email); ?></span>
          <form action="logout.php" method="post" style="display:inline;">
            <button type="submit" class="logout-btn" style="border: none; border-bottom: 2px solid white; background-color: transparent; color: white; padding: 10px 20px; font-size: 16px; cursor: pointer; margin-right: 40px;">Logout</button>
          </form>
        <?php else: ?>
          <a href="./login.php" style="margin-right: 40px;">
            <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
              <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
            </svg>
          </a>
        <?php endif; ?>
      </div>
    </nav>
  </div>
  <div class="main-container" style="background-color:white;">
    <div class="header-section" style="background-color:white;">
      <div class="background-johny flex-center">
        <img src="logo-spa-hero.png" alt="Logo" class="hero-logo">
        <div class="headline">
          <h4 class="title-primary">Pamper yourself to perfection</h4>
          <h4 class="title-secondary">Experience Johny at its Finest</h4>
        </div>
        <div class="button-group" style="position: relative;">
          <div class="border-box"><button class="btn-primary" style="position:relative; z-index: 10; padding: 18px; margin: 10px; background: #047857;">Book Now</button></div>
          <div class="border-box"><button class="btn-primary" style="position:relative; z-index: 10; padding: 0px; background: #047857;">View Services</button></div>

        </div>
      </div>
    </div>

    <div class="services-section" class="nature-services" style="background: url('nature-trip2.jpg') no-repeat center center;   background-size: cover;
  padding: 2rem;
  height: 100vh;
  width: 100vw;
     backdrop-filter: blur(60px); 
  ">
      <h2 class="section-title f-name" style="color: white; font-size: 80px; font-weight: 800;   margin-bottom: 10px;
  color: transparent;
  -webkit-text-stroke: 1px #fff;
  background: url(images/back.png);
  background-clip: text;
  -webkit-background-clip: text;
  background-position: 0 0;
  animation: back 20s linear infinite;">SERVICES</h2>
      <div class="services-container">
        <div class="service-card" style="background: white;  border: 2px solid white;">
          <div class="image-container">
            <img src="back.jpeg" alt="Service item" class="service-image">
          </div>
          <div class="text-content">
            <span class="service-name">Back Spa</span>
            <h3 class="service-description">Durog likod mo</h3>
            <h3 class="service-price">₱ 2500 </h3>
            <h3 class="service-duration">30 minutes</h3>
            <a href="./booking.php" class="book-now">Book Now</a>
          </div>
        </div>
        <div class="service-card" style="background: white;  border: 2px solid white;">
          <div class="image-container">
            <img src="foot-spa.jpg" alt="Service item" class="service-image">
          </div>
          <div class="text-content">
            <span class="service-name">Foot Spa</span>
            <h3 class="service-description">Babango paa mo</h3>
            <h3 class="service-price">₱ 4500</h3>
            <h3 class="service-duration">1 hour</h3>

            <a href="./booking.php" class="book-now">Book Now</a>

          </div>
        </div>
        <div class="service-card" style="background: white;  border: 2px solid white;">
          <div class="image-container">
            <img src="head.jpg" alt="Service item" class="service-image">
          </div>
          <div class="text-content">
            <span class="service-name">Head Spa</span>
            <h3 class="service-description">Mawawala kuto mo</h3>
            <h3 class="service-price">₱ 1500</h3>
            <h3 class="service-duration">20 minutes</h3>
            <a href="./booking.php" class="book-now">Book now</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Testimonialssssssssssssssssssssssssssssssssssssssssssss -->

    <div style=" margin-top: -85px; width: 100vw; height: 100vh;  max-width: 2000px;background: url('nature-trip3.jpg') no-repeat center center;
padding-top: 50px; ">
      <h2 class="section-title f-name" style="color: white; font-size: 80px; font-weight: 800;  
  color: transparent;
  -webkit-text-stroke: 1px #fff;
  background: url(images/back.png);
  background-clip: text;
  -webkit-background-clip: text;
  background-position: 0 0;
  animation: back 20s linear infinite; margin-bottom: -80px;;">TESTIMONIALS</h2>
      <div class="container swiper" style="width: 100vw; height: 100vh; padding:3; margin: 0; max-width: 2000px;">
        <div class="slider-wrapper" style=" margin: 0 auto; margin-top: 130px;">
          <div class="card-list swiper-wrapper">
            <div class="card-item swiper-slide">
              <img src="images/user6.jpg" alt="User Profile" class="user-image" />
              <h3 class="user-name">Ayala Masola</h3>
              <p class="review-text">"Good service, nice ambiance, nice technique and a cozy vibe. Lovely johny!"</p>
              <div class="review-rating">
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
              </div>
            </div>
            <div class="card-item swiper-slide">
              <img src="images/user7.jpeg" alt="User Profile" class="user-image" />
              <h3 class="user-name">Ange Tang</h3>
              <p class="review-text">"Service was friendly, everything went smoothly"</p>
              <div class="review-rating">
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star_half </span>
                <span class="material-symbols-outlined"> star_half </span>
              </div>
            </div>
            <div class="card-item swiper-slide">
              <img src="images/user8.jpeg" alt="User Profile" class="user-image" />
              <h3 class="user-name">Christy Bermonths</h3>
              <p class="review-text">"Authentic and warm service. My schedule was delayed but worth the wait!"</p>
              <div class="review-rating">
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star_half </span>
              </div>
            </div>
            <div class="card-item swiper-slide">
              <img src="images/user9.jpeg" alt="User Profile" class="user-image" />
              <h3 class="user-name">Yany Jurado</h3>
              <p class="review-text">"Good service, beautiful presentation, and friendly staff. Highly recommend!"</p>
              <div class="review-rating">
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
              </div>
            </div>
            <div class="card-item swiper-slide">
              <img src="./awra.jpg" alt="User Profile" class="user-image" />
              <h3 class="user-name">Awra Brigada</h3>
              <p class="review-text">"Casual spot with fantastic massage. Perfect for a quickie!"</p>
              <div class="review-rating">
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star </span>
                <span class="material-symbols-outlined"> star_half </span>
              </div>
            </div>
          </div>

          <div class="swiper-pagination" style="margin-top: -150px; bottom: 220px;"></div>
          <div class="swiper-slider-button swiper-button-prev" style="margin-left: 50px;"></div>
          <div class="swiper-slider-button swiper-button-next" style="margin-right: 50px;"></div>
        </div>
      </div>
    </div>






    <div class="cta-section flex-center" style="background: url('nature-2.jpg') no-repeat center center;   background-size: cover;
  height: 100vh;
  width: 100vw;
     backdrop-filter: blur(60px);  margin-top: -80px; padding-bottom: 60px; padding-top: 1px;">
      <img src="./lana.png" alt="lana" style="height: 50%; border-radius: 80px; background: lightgreen;   box-shadow: 0 0 10px 20px rgba(255, 255, 255, 0.8);
   animation: floatImage 4s ease-in-out infinite; position: relative;" class="lana">
      <h3 class="cta-text" style="  border: none; border-radius: 50px; font-size: 50px; text-transform: uppercase; color: white; font-weight: extrabold;">Don't Wait! Schedule Your first session now!</h3>
      <button class="btn-primary">Book Now</button>
    </div>

    <footer class="footer" style="background-color: #fed7aa;   padding: 0.5rem 0; margin: 0; font-weight: bold;">
      <p class="footer-text">© 2024 LuhLuh Spa. The best you deserved all time.</p>
    </footer>
  </div>
  <!-- Adding swiper js script -->
  <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

  <!-- Adding custom script -->
  <script src="script.js"></script>
</body>

</html>