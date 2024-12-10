<?php
session_start();
require './database/db_connection.php';



$typeFilter = $_GET['service_type'] ?? 'all';
$priceFilter = $_GET['price'] ?? 'all';
$durationFilter = $_GET['duration'] ?? 'all';
$sortBy = $_GET['sort'] ?? 'price';


$query = "SELECT * FROM Services WHERE 1=1";
$params = [];


if ($typeFilter !== 'all') {
  $query .= " AND service_type = :service_type";
  $params[':service_type'] = $typeFilter;
}

if ($priceFilter !== 'all') {
  if ($priceFilter === 'low') {
    $query .= " AND price <= 1000";
  } elseif ($priceFilter === 'medium') {
    $query .= " AND price > 1000 AND price <= 2000";
  } elseif ($priceFilter === 'high') {
    $query .= " AND price > 2000";
  }
}

if ($durationFilter !== 'all') {
  if ($durationFilter === 'short') {
    $query .= " AND duration < 60";
  } elseif ($durationFilter === 'medium') {
    $query .= " AND duration >= 60 AND duration < 90";
  } elseif ($durationFilter === 'long') {
    $query .= " AND duration >= 90";
  }
}

if ($sortBy === 'price') {
  $query .= " ORDER BY price ASC";
} elseif ($sortBy === 'duration') {
  $query .= " ORDER BY duration ASC";
}


$stmt = $pdo->prepare($query);
$stmt->execute($params);
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./service-list.css" />
  <link rel="stylesheet" href="/shared/common.css">
</head>

<body>

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
  <div style="display: flex">
    <div class="container" style="width: 20vw;  height: 160vh; padding: 1; margin-right: 3px;">
      <!-- Filters Sidebar -->
      <div class="filters-sidebar" style="width: 20vw; margin-top: 70px;">
        <h2 class=" filters-title">Filters</h2>
        <form method="GET" action="">
          <div class="filter-group">
            <label for="price-filter" class="filter-label">Price Range</label>
            <select id="price-filter" name="price" class="filter-select">
              <option value="all" <?php if ($priceFilter === 'all') echo 'selected'; ?>>All Prices</option>
              <option value="low" <?php if ($priceFilter === 'low') echo 'selected'; ?>>Pesos 0 - 1000</option>
              <option value="medium" <?php if ($priceFilter === 'medium') echo 'selected'; ?>>Pesos 1001 - 2000</option>
              <option value="high" <?php if ($priceFilter === 'high') echo 'selected'; ?>>Pesos 2001+</option>
            </select>
          </div>

          <div class="filter-group">
            <label for="duration-filter" class="filter-label">Duration</label>
            <select id="duration-filter" name="duration" class="filter-select">
              <option value="all" <?php if ($durationFilter === 'all') echo 'selected'; ?>>Any Duration</option>
              <option value="short" <?php if ($durationFilter === 'short') echo 'selected'; ?>>30 minutes</option>
              <option value="medium" <?php if ($durationFilter === 'medium') echo 'selected'; ?>>60 minutes</option>
              <option value="long" <?php if ($durationFilter === 'long') echo 'selected'; ?>>90 minutes</option>
            </select>
          </div>

          <div class="filter-group">
            <label for="sort-by" class="filter-label">Sort by</label>
            <select id="sort-by" name="sort" class="filter-select">
              <option value="popularity" <?php if ($sortBy === 'popularity') echo 'selected'; ?>>Popularity</option>
              <option value="price" <?php if ($sortBy === 'price') echo 'selected'; ?>>Price</option>
              <option value="duration" <?php if ($sortBy === 'duration') echo 'selected'; ?>>Duration</option>
            </select>
          </div>

          <button type="submit" class="filter-submit book-now">Apply Filters</button>
        </form>
      </div>

      <!-- Service List Section -->

    </div>
    <section id="service-cards" class="services-container">
      <?php
      $image_names = ['1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg']; // Assuming image files are in .jpg format
      $index = 0;
      ?>

      <?php
      foreach ($services as $service):
        if ($index >= count($image_names)) {
          $index = 0; // Reset to avoid going out of bounds
        }

        $service_price = isset($service['price']) ? number_format($service['price'], 2) : '0.00';
        $service_duration = isset($service['duration']) ? htmlspecialchars($service['duration']) : 'N/A';
        $service_type = isset($service['service_type']) ? htmlspecialchars($service['service_type']) : 'undefined';
        $service_name = isset($service['service_name']) ? htmlspecialchars($service['service_name']) : 'No Name';
        $service_description = isset($service['description']) ? htmlspecialchars($service['description']) : 'No Description';
      ?>
        <div class="service-card" data-type="<?= $service_type; ?>" data-price="<?= $service_price; ?>" data-duration="<?= $service_duration; ?>" style="height: 450px;">
          <div class="image-container">
            <img src="./servicelist_images/<?= htmlspecialchars($image_names[$index]); ?>" alt="<?= $service_name; ?>" class=" service-image">
          </div>
          <div class="text-content">
            <span class="service-name"><?= $service_name; ?></span>
            <h3 class="service-description"><?= $service_description; ?></h3>
            <h3 class="service-price"><?= $service_price; ?> Pesos</h3>
            <h3 class="service-duration"><?= $service_duration; ?> mins</h3>

            <a href="./booking.php? service_id=<?= htmlspecialchars($service['service_id']); ?>" class="book-now">Book Now</a>

          </div>
        </div>


      <?php
        $index++;
      endforeach;
      ?>
      <div> </div>
    </section>
  </div>



</body>

</html>