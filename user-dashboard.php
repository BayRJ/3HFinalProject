<?php
require './database/db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
  header("Location: login.php");
  exit();
}

$user_id = $_SESSION['user_id'];

try {
  // Fetch user details
  $stmt = $pdo->prepare("SELECT full_name, email, phone_number FROM Users WHERE user_id = ?");
  $stmt->execute([$user_id]);
  $user = $stmt->fetch(PDO::FETCH_ASSOC);


  if (!$user) {
    die("User not found.");
  }

  // Handle appointment cancellation
  if (isset($_POST['cancel_appointment_id'])) {
    $appointment_id = intval($_POST['cancel_appointment_id']);

    // Check if the appointment belongs to the user and is cancellable
    $stmt = $pdo->prepare("
            SELECT appointment_id, status 
            FROM Appointments 
            WHERE appointment_id = ? AND user_id = ? AND status = 'pending'
        ");
    $stmt->execute([$appointment_id, $user_id]);
    $appointment = $stmt->fetch();

    if ($appointment) {
      // Update the appointment status to 'cancelled'
      $updateStmt = $pdo->prepare("UPDATE Appointments SET status = 'cancelled' WHERE appointment_id = ?");
      $updateStmt->execute([$appointment_id]);

      $confirmationMessage = "Your appointment has been successfully cancelled.";
    } else {
      $confirmationMessage = "Unable to cancel the appointment. It may have already been processed.";
    }
  }

  // Fetch user bookings and associated reviews
  $stmtBookings = $pdo->prepare("
        SELECT 
            a.appointment_id,
            a.appointment_date, 
            a.start_time, 
            a.end_time, 
            s.service_name, 
            u.full_name AS therapist_name, 
            a.status,
            r.rating AS review_rating,
            r.comment AS review_comment
        FROM Appointments a
        JOIN Services s ON a.service_id = s.service_id
        JOIN Users u ON a.therapist_id = u.user_id
        LEFT JOIN Reviews r ON a.appointment_id = r.appointment_id
        WHERE a.user_id = ?
        ORDER BY a.appointment_date ASC, a.start_time ASC
    ");
  $stmtBookings->execute([$user_id]);
  $bookings = $stmtBookings->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="user-dashboard.css">
</head>

<body style="background-color: #fed7aa;">
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

        <a href="./login.php" style="margin-right: 40px;">
          <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-person-fill" viewBox="0 0 16 16">
            <path d="M3 14s-1 0-1-1 1-4 6-4 6 3 6 4-1 1-1 1zm5-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
          </svg>
        </a>

      </div>
    </nav>
  </div>
  <div class="dashboard-container">
    <div class="dashboard-content">
      <h1 class="dashboard-title">User Dashboard</h1>

      <!-- Navigation Tabs -->
      <div class="tab-navigation">
        <button id="tab-appointments" class="tab-button">Appointments</button>
        <button id="tab-settings" class="tab-button">Account Settings</button>
        <button id="tab-promotions" class="tab-button">Promotions & Rewards</button>
      </div>

      <!-- Appointments Tab -->
      <div id="appointments-tab" class="tab-content">
        <h2 class="section-title">Upcoming Appointments</h2>
        <div id="upcoming-appointments" class="appointments-list">
          <?php if (!empty($bookings)): ?>
            <?php foreach ($bookings as $booking): ?>
              <div class="appointment-item">
                <div>
                  <strong>Service:</strong> <?php echo htmlspecialchars($booking['service_name']); ?><br>
                  <strong>Therapist:</strong> <?php echo htmlspecialchars($booking['therapist_name']); ?><br>
                  <strong>Date:</strong> <?php echo htmlspecialchars($booking['appointment_date']); ?><br>
                  <strong>Time:</strong> <?php echo htmlspecialchars($booking['start_time']); ?> - <?php echo htmlspecialchars($booking['end_time']); ?><br>
                  <strong>Status:</strong> <?php echo ucfirst(htmlspecialchars($booking['status'])); ?>
                </div>
                <div>
                  <?php if ($booking['status'] === 'pending'): ?>
                    <a href="re-sched.php?appointment_id=<?php echo $booking['appointment_id']; ?>"><button class="reschedule" style="  padding: 10px;
  background-color: #FFFFD5; border: none; font-weight: bold; border-radius: 20px;">Reschedule</button></a>
                    <form method="POST" style="display:inline;">
                      <input type="hidden" name="cancel_appointment_id" value="<?php echo $booking['appointment_id']; ?>">
                      <button type="submit" class="cancel" style="  padding: 10px;
  background-color: #FF474C; border: none; font-weight: bold; border-radius: 20px;">Cancel</button>
                    </form>
                  <?php elseif ($booking['status'] === 'completed'): ?>
                    <?php if ($booking['review_rating']): ?>
                      <div class="review-section styled-review">
                        <div class="review-header">
                          <span class="review-user"><?php echo htmlspecialchars($user['full_name']); ?></span>
                          <span class="review-rating">
                            <?php for ($i = 1; $i <= 5; $i++): ?>
                              <span class="<?php echo $i <= $booking['review_rating'] ? 'filled-star' : 'empty-star'; ?>">★</span>
                            <?php endfor; ?>
                          </span>
                        </div>
                        <p class="review-comment"><?php echo nl2br(htmlspecialchars($booking['review_comment'])); ?></p>
                      </div>
                    <?php else: ?>
                      <a href="review.php?appointment_id=<?php echo $booking['appointment_id']; ?>">
                        <button class="leave" style="padding: 10px;
  background-color:lightgreen; border: none; font-weight: bold; border-radius: 20px;">Leave Review</button>
                      </a>
                    <?php endif; ?>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          <?php else: ?>
            <p>No bookings found.</p>
          <?php endif; ?>
        </div>

        <h2 class="section-title">Past Appointments</h2>
        <div id="past-appointments" class="appointments-list"></div>
      </div>

      <!-- Account Settings Tab -->
      <div id="settings-tab" class="tab-content hidden">
        <h2 class="section-title">Account Settings</h2>


        <div id="profile-display">

          <p><strong>Name:</strong> <?php echo htmlspecialchars($user['full_name']); ?></p>
          <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
          <p><strong>Phone Number:</strong> <?php echo htmlspecialchars($user['phone_number']); ?></p>
          <button id="edit-profile" class="action-button" style="border: none; color: white; background-color:#047857; padding: 15px;">Edit Profile</button>
        </div>


      </div>

      <!-- Promotions Tab -->
      <div id="promotions-tab" class="tab-content hidden">
        <h2 class="section-title">Promotions & Rewards</h2>
        <div id="promotions-list" class="promotions-list"></div>
      </div>
    </div>
  </div>
</body>

</html>