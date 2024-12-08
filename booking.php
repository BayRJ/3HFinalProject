<?php



require './database/db_connection.php';

session_start();
function getServices($pdo)
{
  $stmt = $pdo->query("SELECT * FROM Services");
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function getTherapists($pdo)
{
  $stmt = $pdo->query("SELECT user_id, full_name FROM Users WHERE role = 'therapist'");
  return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

$services = getServices($pdo);
$specialists = getTherapists($pdo); // Fetch spa specialists
$confirmationMessage = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $service_id = $_POST['service'];
  $specialist_id = $_POST['specialist'];
  $appointment_date = $_POST['appointment_date'];
  $time_slot = $_POST['time_slot'];
  $payment_method = $_POST['payment_method'];
  $promo_code = $_POST['promo_code'] ?? null;

  // Validate therapist exists and has 'therapist' role
  $stmt = $pdo->prepare("SELECT COUNT(*) FROM Users WHERE user_id = :user_id AND role = 'therapist'");
  $stmt->execute([':user_id' => $specialist_id]);
  $therapistExists = $stmt->fetchColumn();

  if (!$therapistExists) {
    $confirmationMessage = "Error: Selected therapist does not exist or is not a valid therapist.";
  } else {
    try {
      // Fetch the price of the selected service
      $stmt = $pdo->prepare("SELECT price, duration FROM Services WHERE service_id = :service_id");
      $stmt->execute([':service_id' => $service_id]);
      $service = $stmt->fetch(PDO::FETCH_ASSOC);

      // Check if service exists
      if (!$service) {
        throw new Exception("Selected service not found.");
      }

      $service_price = $service['price'];
      $duration = $service['duration']; // Duration in minutes

      // Calculate end time (assuming service duration in minutes)
      $end_time = date("H:i", strtotime("+$duration minutes", strtotime($time_slot)));

      // Insert the appointment into the Appointments table
      $stmt = $pdo->prepare("
                INSERT INTO Appointments 
                (user_id, service_id, therapist_id, appointment_date, start_time, end_time, status) 
                VALUES (:user_id, :service_id, :therapist_id, :appointment_date, :start_time, :end_time, 'pending')
            ");
      $stmt->execute([
        ':user_id' => $_SESSION['user_id'], // Get the user ID from session
        ':service_id' => $service_id,
        ':therapist_id' => $specialist_id,
        ':appointment_date' => $appointment_date,
        ':start_time' => $time_slot,
        ':end_time' => $end_time
      ]);

      // Set the confirmation message in session
      $_SESSION['appointment_confirmation'] = "Appointment Confirmed! Your spa appointment has been booked successfully.";

      // Redirect to user page
      header("Location: user-dashboard.php");
      exit();
    } catch (PDOException $e) {
      $confirmationMessage = "Error: " . $e->getMessage();
    } catch (Exception $e) {
      $confirmationMessage = "Error: " . $e->getMessage();
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Spa Booking Page</title>
  <link rel="stylesheet" href="./booking.css">
  <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
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
  <section id="booking-page">
    <div class="container">
      <?php if (!empty($confirmationMessage)): ?>
        <!-- Confirmation Message -->
        <div class="confirmation-message">
          <h1><?= $confirmationMessage ?></h1>
        </div>
      <?php else: ?>
        <form action="" method="POST">
          <!-- Step 1: Select Service and Therapist -->
          <div class="step-section">
            <h2 class="step-title">Step 1: Select Service and Therapist</h2>
            <div class="input-group">
              <label class="label">Select Service</label>
              <select id="service" name="service" class="input">
                <?php foreach ($services as $service): ?>
                  <option value="<?= $service['service_id']; ?>">
                    <?= $service['service_name']; ?> - ₱<?= number_format($service['price'], 2); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="input-group">
              <label class="label">Select Therapist</label>
              <select id="specialist" name="specialist" class="input">
                <?php foreach ($specialists as $specialist): ?>
                  <option value="<?= $specialist['user_id']; ?>">
                    <?= $specialist['full_name']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

          </div>
          <!-- Step 2: Choose Date and Time -->
          <div class="step-section">
            <h2 class="step-title">Step 2: Choose Date and Time</h2>
            <div class="input-group">
              <label class="label">Select Date</label>
              <input type="date" id="appointment-date" name="appointment_date" class="input" style="width:97%;" required>
            </div>
            <div id="time-slots" class="time-slots">
              <label class="label">Available Time Slots</label>
              <select id="time-slot" name="time_slot" class="input">
                <option value="09:00">09:00 AM</option>
                <option value="11:00">11:00 AM</option>
                <option value="14:00">02:00 PM</option>
              </select>
            </div>
          </div>

          <!-- Step 3: Confirmation and Payment -->
          <div class="step-section">
            <h2 class="step-title">Step 3: Confirmation and Payment</h2>

            <div class="input-group">
              <label class="label">Payment Method</label>
              <select id="payment-method" class="input">
                <option value="">--Choose a Payment Method--</option>
                <option value="credit-card">Credit Card</option>
                <option value="paypal">PayPal</option>
                <option value="cash">Cash</option>
              </select>
            </div>
            <div class="input-group">
              <label class="label">Promo Code</label>
              <input id="promo-code" type="text" class="input" placeholder="Enter promo code" style="width:97%;">
            </div>
          </div>
          <button type="submit" class="confirm-btn" style="width: 100%; padding: 15px; ">Confirm Appointment</button>
        </form>
      <?php endif; ?>
    </div>
  </section>

</body>

</html>