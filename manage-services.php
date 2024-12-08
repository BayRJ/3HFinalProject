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
    LEFT JOIN Users u ON a.therapist_id = u.user_id
    LEFT JOIN Users u2 ON a.user_id = u2.user_id
    LEFT JOIN Services s ON a.service_id = s.service_id
";

if ($filterStatus !== 'all') {
  $queryAppointments .= " WHERE a.status = :status";
}

$queryAppointments .= " ORDER BY a.appointment_date DESC";

$stmtAppointments = $pdo->prepare($queryAppointments);

if ($filterStatus !== 'all') {
  $stmtAppointments->execute([':status' => $filterStatus]);
} else {
  $stmtAppointments->execute();
}
$appointments = $stmtAppointments->fetchAll(PDO::FETCH_ASSOC);

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

  if (isset($_POST['add_service'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    $queryAdd = "INSERT INTO Services (service_name, description, price, duration) VALUES (:name, :description, :price, :duration)";
    $stmtAdd = $pdo->prepare($queryAdd);
    $stmtAdd->execute([':name' => $name, ':description' => $description, ':price' => $price, ':duration' => $duration]);

    $message = "Service added successfully!";
  } elseif (isset($_POST['edit_service'])) {
    $id = $_POST['service_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $duration = $_POST['duration'];

    $queryEdit = "UPDATE Services SET service_name = :name, description = :description, price = :price, duration = :duration WHERE service_id = :id";
    $stmtEdit = $pdo->prepare($queryEdit);
    $stmtEdit->execute([':name' => $name, ':description' => $description, ':price' => $price, ':duration' => $duration, ':id' => $id]);

    $message = "Service updated successfully!";

    // Redirect to reset the form after successful edit
    header("Location: " . $_SERVER['PHP_SELF'] . "#manage-services");
    exit;  // Stop further script execution after redirection
  } elseif (isset($_POST['delete_service'])) {
    $id = $_POST['service_id'];

    $queryCheck = "SELECT COUNT(*) FROM Appointments WHERE service_id = :id";
    $stmtCheck = $pdo->prepare($queryCheck);
    $stmtCheck->execute([':id' => $id]);
    $referenceCount = $stmtCheck->fetchColumn();

    if ($referenceCount > 0) {
      $message = "Cannot perform action. Service still have $referenceCount appointment(s).";
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
  <link rel="stylesheet" href="manage-service.css" />
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

  <div class="dashboard">
    <div class="container">
      <h1 class="title">Admin Dashboard</h1>

      <!-- Tabs -->
      <div class="tabs">
        <button class="tab" data-tab="bookings"><a href="/CIT17-3H/admin-dashboard.php" style="color: white;">Manage Bookings</a></button>
        <button class="tab" data-tab="services"><a href="/CIT17-3H/manage-services.php" style="color: white;">Manage Services</a></button>
        <button class="tab" data-tab="schedule">Therapist Schedule</button>
        <button class="tab" data-tab="payments">Payments & Reports</button>
      </div>

      <!-- Booking Management -->
      <section id="manage-services">
        <h2>Manage Services</h2>
        <?php if (!empty($message)): ?>
          <p style="color: green;"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
        <table>
          <thead>
            <tr>
              <th>Service ID</th>
              <th>Service Name</th>
              <th>Description</th>
              <th>Price</th>
              <th>Duration</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($services as $service): ?>
              <tr>
                <td><?= $service['service_id'] ?></td>
                <td><?= htmlspecialchars($service['service_name']) ?></td>
                <td><?= htmlspecialchars($service['description']) ?></td>
                <td>$<?= htmlspecialchars($service['price']) ?></td>
                <td><?= htmlspecialchars($service['duration']) ?> mins</td>
                <td style="display: flex; margin-bottom: 15px;">
                  <form method="GET" action="#manage-services" style="display:inline;">
                    <input type="hidden" name="edit_service_id" value="<?= $service['service_id'] ?>">
                    <button type="submit" style="  padding: 10px;
  background-color: #FFFFD5; border: none; font-weight: bold; border-radius: 20px;">Edit</button>
                  </form>
                  <form method="POST" action="#manage-services" style="display:inline;">
                    <input type="hidden" name="service_id" value="<?= $service['service_id'] ?>">
                    <button name="delete_service" onclick="return confirm('Are you sure you want to delete this service?');" style="  padding: 10px;
  background-color: #FF474C; border: none; font-weight: bold; border-radius: 20px;">Delete</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>



        <form method="POST" action="#manage-services">
          <h3><?= $editService ? 'Edit' : 'Add' ?> Service</h3>
          <?php if ($editService): ?>
            <input type="hidden" name="service_id" value="<?= $editService['service_id'] ?>">
          <?php endif; ?>
          <label>Service Name</label>
          <input type="text" name="name" placeholder="Service Name" value="<?= $editService['service_name'] ?? '' ?>" style="width: 97%; padding: 10px;border-radius: 10px; border: none; margin-bottom: 10px;" required>
          <label>Description</label>
          <textarea name="description" placeholder="Description" style="width: 97%; padding: 10px;border-radius: 10px; border: none; margin-bottom: 10px;"><?= $editService['description'] ?? '' ?></textarea>
          <label>Price</label>
          <input type="number" name="price" placeholder="Price" value="<?= $editService['price'] ?? '' ?>" style="width: 97%; padding: 10px;border-radius: 10px; border: none; margin-bottom: 10px;" required>
          <label>Druation</label>
          <input type="number" name="duration" placeholder="Duration (mins)" value="<?= $editService['duration'] ?? '' ?>" style="width: 97%; padding: 10px;border-radius: 10px; border: none; margin-bottom: 10px;" required>
          <button name="<?= $editService ? 'edit_service' : 'add_service' ?>" style="width: 99%; padding: 10px;border-radius: 10px; border: none; background-color: #065f46; margin-top: 10px; color: white; font-weight: bold;">
            <?= $editService ? 'Update' : 'Add' ?>
          </button>
        </form>
      </section>

      <!-- Other sections can be added here in the same structure -->

    </div>
  </div>



</body>

</html>