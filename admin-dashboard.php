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
      <div class="auth-links">
        <a href="/userdashboard" class="auth-link">Login</a>
        <a href="/userdashboard" class="auth-link">Register</a>
      </div>
    </nav>
  </div>
  <div class="dashboard">
    <div class="container">
      <h1 class="title">Admin Dashboard</h1>

      <!-- Tabs -->
      <div class="tabs">
        <button class="tab" data-tab="bookings">Manage Bookings</button>
        <button class="tab" data-tab="services">Manage Services</button>
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
              <th>Date & Time</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>1</td>
              <td>John Doe</td>
              <td>Massage</td>
              <td>2024-11-20 at 10:00 AM</td>
              <td>Confirmed</td>
              <td>
                <button class="btn approve">Approve</button>
                <button class="btn cancel">Cancel</button>
                <button class="btn reschedule">Reschedule</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Other sections can be added here in the same structure -->

    </div>
  </div>
</body>

</html>