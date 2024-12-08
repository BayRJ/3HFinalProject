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
</head>

<body class="font-sans bg-orange-100" style="overflow-x: hidden;">
  <div class="header-container">
    <nav class="navbar">
      <a href="/" class="logo-container">
        <img class="logo-image" src="spa-logo-header.png" alt="LUHLUH's SPA">
        <h1 class="logo-text">LUHLUH's SPA</h1>
      </a>
      <ul class="nav-links">
        <li><a href="/CIT17-3H" class="nav-link">Home</a></li>
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
          <h2 class="title-primary">Pamper yourself to perfection</h2>
          <h2 class="title-secondary">Experience Johny at its Finest</h2>
        </div>
        <div class="button-group">
          <button class="btn-primary">Book Now</button>
          <button class="btn-primary">View Services</button>
        </div>
      </div>
    </div>

    <div class="services-section" class="nature-services" style="background: url('nature.jpg') no-repeat center center;   background-size: cover;
  padding: 2rem;
  height: 100vh;
  width: 100vw;
     backdrop-filter: blur(60px); 
  ">
      <h2 class="section-title" style="color: white;">Services Offered</h2>
      <div class="services-container">
        <div class="service-card" style="background: #fed7aa;  border: 2px solid white;">
          <div class="image-container">
            <img src="back.jpeg" alt="Service item" class="service-image">
          </div>
          <div class="text-content">
            <span class="service-name">Back Spa</span>
            <h3 class="service-description">Durog likod mo</h3>
            <h3 class="service-price">2500 Pesos</h3>
            <h3 class="service-duration">30 minutes</h3>
            <a href="./booking.php" class="book-now">Book Now</a>
          </div>
        </div>
        <div class="service-card" style="background: #fed7aa;  border: 2px solid white;">
          <div class="image-container">
            <img src="foot-spa.jpg" alt="Service item" class="service-image">
          </div>
          <div class="text-content">
            <span class="service-name">Foot Spa</span>
            <h3 class="service-description">Babango paa mo</h3>
            <h3 class="service-price">4500 Pesos</h3>
            <h3 class="service-duration">1 hour</h3>

            <a href="./booking.php" class="book-now">Book Now</a>

          </div>
        </div>
        <div class="service-card" style="background: #fed7aa;  border: 2px solid white;">
          <div class="image-container">
            <img src="head.jpg" alt="Service item" class="service-image">
          </div>
          <div class="text-content">
            <span class="service-name">Head Spa</span>
            <h3 class="service-description">Mawawala kuto mo</h3>
            <h3 class="service-price">1500 Pesos</h3>
            <h3 class="service-duration">20 minutes</h3>
            <a href="./booking.php" class="book-now">Book now</a>
          </div>
        </div>
      </div>
    </div>
    <!-- Testimonialssssssssssssssssssssssssssssssssssssssssssss -->

    <div class="testimonials-section" style="background: url('nature-2.jpg') no-repeat center center;   background-size: cover;
  height: 100vh;
  width: 100vw;
     backdrop-filter: blur(60px);  margin-top: -80px; padding-bottom: 60px; padding-top: 1px;">
      <h2 class="section-title" style="margin-top: 40px; ">Testimonials</h2>
      <div class="services-container">
        <div class="service-card">
          <div class="image-container">
            <img src="awra.jpg" alt="Service item" class="service-image">
          </div>
          <div class="text-content">
            <h3 class="service-price">Best spa! ever.</h3>

            <div class="cta-container">
              <img src="star-rating.jpg" alt="star-rating" class="" style="height: 200px; width: 200px; margin-top: 50px;" />
            </div>
          </div>
        </div>
        <div class="service-card">
          <div class="image-container">
            <img src="queen-dura.jpg" alt="Service item" class="service-image">
          </div>
          <div class="text-content">

            <h3 class="service-price">Very relaxing </h3>
            <h3 class="service-price">Will come again!</h3>

            <div class="cta-container">
              <img src="star-rating.jpg" alt="star-rating" class="" style="height: 200px; width: 200px;" />
            </div>
          </div>
        </div>
        <div class="service-card">
          <div class="image-container">
            <img src="arman.jpg" alt="Service item" class="service-image">
          </div>
          <div class="text-content">

            <h3 class="service-price">Very nice ambiance and </h3>
            <h3 class="service-price">quality massage</h3>

            <div class="cta-container">
              <img src="star-rating.jpg" alt="star-rating" class="" style="height: 200px; width: 200px;" />
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="cta-section flex-center" style="background: url('eimi.jpg') no-repeat center center;   background-size: cover;
  height: 100vh;
  width: 100vw;
     backdrop-filter: blur(60px);  margin-top: -80px; padding-bottom: 60px; padding-top: 1px;">
      <h2 class="cta-text" style="width: 60%;  background-color: #fed7aa; border: none; border-radius: 50px; padding: 20px;">
        "Relax, rejuvenate, and treat yourself to the ultimate spa experience you deserve. Book your appointment today and let our specialists help you unwind and recharge!"</h2>
      <h2 class="cta-text" style="width: 60%;  background-color: #fed7aa; border: none; border-radius: 50px; padding: 20px;">Don't Wait Schedule Your first session now!</h2>
      <button class="btn-primary">Book Now</button>
    </div>

    <footer class="footer" style="background-color: #fed7aa;   padding: 0.5rem 0; margin: 0; font-weight: bold;">
      <p class="footer-text">© 2024 LuhLuh Spa. The best you deserved all time.</p>
    </footer>
  </div>
</body>

</html>