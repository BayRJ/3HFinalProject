<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>LuhLuh Spa</title>
  <link rel="stylesheet" href="index.css">
</head>

<body class="font-sans bg-orange-100">
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
        <li><a href="/userdashboard" class="nav-link">User</a></li>
        <li><a href="/admindashboard" class="nav-link">Admin</a></li>
      </ul>
      <div class="auth-links">
        <a href="/userdashboard" class="auth-link">Login</a>
        <a href="/userdashboard" class="auth-link">Register</a>
      </div>
    </nav>
  </div>
  <div class="main-container">
    <div class="header-section">
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
    <div class="divider"></div>
    <div class="services-section">
      <h2 class="section-title">Services Offered</h2>
      <div class="services-container">
        <div class="service-card">
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
        <div class="service-card">
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
        <div class="service-card">
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
    <div class="divider"></div>
    <div class="testimonials-section">
      <h2 class="section-title">Testimonials</h2>
      <div class="services-container">
        <div class="service-card">
          <div class="image-container">
            <img src="awra.jpg" alt="Service item" class="service-image">
          </div>
          <div class="text-content">
            <h3 class="service-price">Best spa! ever.</h3>

            <div class="cta-container">
              <img src="star-rating.jpg" alt="star-rating" class="" style="height: 200px; width: 200px;" />
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
    <div class="divider"></div>
    <div class="cta-section flex-center">
      <h2 class="cta-text">Don't Wait Schedule Your first session now!</h2>
      <button class="btn-primary">Book Now</button>
    </div>
    <div class="divider"></div>
    <footer class="footer">
      <p class="footer-text">© 2024 LuhLuh Spa. The best you deserved all time.</p>
    </footer>
  </div>
</body>

</html>