<?php
require './database/db_connection.php';
session_start();

$queryServices = "SELECT * FROM Services";
$stmtServices = $pdo->query($queryServices);
$services = $stmtServices->fetchAll(PDO::FETCH_ASSOC);

$filterStatus = isset($_GET['status']) ? $_GET['status'] : 'all';
$queryAppointments = "
    SELECT 
        a.appointment_id, 
        a.appointment_date AS date, 
        a.start_time, 
        a.end_time, 
        a.status AS appointment_status, 
        COALESCE(u.full_name, 'N/A') AS therapist_name,
        COALESCE(u2.full_name, 'N/A') AS customer_name,
        COALESCE(s.service_name, 'N/A') AS service_name
    FROM Appointments a
    LEFT JOIN Users u ON a.therapist_id = u.user_id AND u.user_type = 'therapist'
    LEFT JOIN Users u2 ON a.user_id = u2.user_id AND u2.user_type = 'customer'
    LEFT JOIN Services s ON a.service_id = s.service_id
    WHERE 1=1
    " . ($filterStatus !== 'all' ? "AND a.status = :status" : "") . "
    ORDER BY a.appointment_date DESC";

try {
    $stmtAppointments = $pdo->prepare($queryAppointments);
    if ($filterStatus !== 'all') {
        $stmtAppointments->execute([':status' => $filterStatus]);
    } else {
        $stmtAppointments->execute();
    }
    $appointments = $stmtAppointments->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    error_log("Database error: " . $e->getMessage());
    $message = "An error occurred while fetching appointments.";
    $appointments = [];
}

$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $action = $_POST['action'] ?? null;
  $appointmentId = $_POST['appointment_id'] ?? null;

  if ($action === 'approve') {
    $newStatus = 'confirmed';
  } elseif ($action === 'cancel') {
    $newStatus = 'canceled';
  } elseif ($action === 'complete') {
    $newStatus = 'completed';
  }

  if (isset($newStatus)) {
    try {
      $queryUpdateAppointment = "
                UPDATE Appointments
                SET status = :status
                WHERE appointment_id = :appointment_id
            ";
      $stmtUpdateAppointment = $pdo->prepare($queryUpdateAppointment);
      $stmtUpdateAppointment->execute([':status' => $newStatus, ':appointment_id' => $appointmentId]);

      $message = "Appointment successfully updated.";
    } catch (Exception $e) {
      $message = "Error: " . $e->getMessage();
    }

    $stmtAppointments->execute();
    $appointments = $stmtAppointments->fetchAll(PDO::FETCH_ASSOC);
  }
}

// Handle service actions (add, edit, delete)
$editService = null; // For holding the service being edited

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['add_service']) || isset($_POST['edit_service'])) {
    $errors = [];
    if (empty($_POST['name'])) $errors[] = "Service name is required";
    if (!is_numeric($_POST['price']) || $_POST['price'] < 0) $errors[] = "Invalid price";
    if (!is_numeric($_POST['duration']) || $_POST['duration'] < 0) $errors[] = "Invalid duration";
    
    if (empty($errors)) {
        // Proceed with current logic
    } else {
        $message = "Validation errors: " . implode(", ", $errors);
    }
  } elseif (isset($_POST['delete_service'])) {
    $id = $_POST['service_id'];

    $queryCheck = "SELECT COUNT(*) FROM Appointments WHERE service_id = :id";
    $stmtCheck = $pdo->prepare($queryCheck);
    $stmtCheck->execute([':id' => $id]);
    $referenceCount = $stmtCheck->fetchColumn();

    if ($referenceCount > 0) {
      $message = "Cannot delete service. It is currently used in $referenceCount appointment(s).";
    } else {
      $queryDelete = "DELETE FROM Services WHERE service_id = :id";
      $stmtDelete = $pdo->prepare($queryDelete);
      $stmtDelete->execute([':id' => $id]);

      $message = "Service deleted successfully!";
    }
  }

  $stmtServices = $pdo->query($queryServices);
  $services = $stmtServices->fetchAll(PDO::FETCH_ASSOC);
}

// Fetch service for editing (pre-populate the form)
if (isset($_GET['edit_service_id'])) {
  $editServiceId = $_GET['edit_service_id'];

  $queryGetService = "SELECT * FROM Services WHERE service_id = :id";
  $stmtGetService = $pdo->prepare($queryGetService);
  $stmtGetService->execute([':id' => $editServiceId]);
  $editService = $stmtGetService->fetch(PDO::FETCH_ASSOC);
}

// Fetch payments for reports
$queryPayments = "
    SELECT 
        p.payment_id, 
        p.appointment_id, 
        p.amount, 
        p.payment_status, 
        p.payment_date 
    FROM Payments p
";
$stmtPayments = $pdo->query($queryPayments);
$payments = $stmtPayments->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="./admin-dashboard.css" />
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
  <div class="dashboard" style="margin-top: 90px;">
    <div class="container">
      <h1 class="title">Admin Dashboard</h1>

      <!-- Tabs -->
      <div class="tabs">
        <button class="tab" data-tab="bookings">Manage Bookings</button>
        <button class="tab" data-tab="services"><a href="/CIT17-3H/manage-services.php" style="color:white; text-decoration: none;">Manage Services</a></button>
        <button class="tab" data-tab="schedule">Therapist Schedule</button>
        <button class="tab" data-tab="payments">Payments & Reports</button>
      </div>

      <!-- Booking Management -->
      <div class="section bookings">
        <h2 class="subtitle">Manage Bookings</h2>

        <!-- Filters -->
        <div class="filters">
          <label for="booking-status">Booking Status:</label>
          <select id="booking-status" class="select">
            <option value="all">All</option>
            <option value="pending">Pending</option>
            <option value="confirmed">Confirmed</option>
            <option value="completed">Completed</option>
          </select>
        </div>

        <!-- Booking Table -->
        <table class="table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Customer</th>
              <th>Service</th>
              <th>Therapist</th>
              <th>Date</th>
              <th>Time</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($appointments as $appointment): ?>
              <tr>
                <td><?= $appointment['appointment_id'] ?></td>
                <td><?= htmlspecialchars($appointment['customer_name']) ?></td>
                <td><?= htmlspecialchars($appointment['service_name']) ?></td>
                <td><?= htmlspecialchars($appointment['therapist_name']) ?></td>
                <td><?= htmlspecialchars($appointment['date']) ?></td>
                <td><?= htmlspecialchars($appointment['start_time']) . ' - ' . htmlspecialchars($appointment['end_time']) ?></td>
                <td><?= htmlspecialchars($appointment['appointment_status']) ?></td>
                <td style="display: flex;">
                  <?php if ($appointment['appointment_status'] == 'pending'): ?>
                    <form method="POST" style="display:inline;">
                      <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                      <button type="submit" name="action" value="approve" style="  padding: 10px;
  background-color: lightgreen; border: none; font-weight: bold; border-radius: 20px;">Approve</button>
                    </form>
                    <form method=" POST" style="display:inline;">
                      <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                      <button type="submit" name="action" value="cancel" style="  padding: 10px;
  background-color: #FF474C; border: none; font-weight: bold; border-radius: 20px;">Cancel</button>
                    </form>
                  <?php endif; ?>
                  <?php if ($appointment['appointment_status'] == 'confirmed'): ?>
                    <form method=" POST" style="display:inline;">
                      <input type="hidden" name="appointment_id" value="<?= $appointment['appointment_id'] ?>">
                      <button type="submit" name="action" value="complete" style="padding: 8px; border: none; background-color: lightgreen;  font-size: 16px; border-radius: 8px;">Complete</button>
                    </form>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <!-- Other sections can be added here in the same structure -->

    </div>
  </div>
</body>

</html>