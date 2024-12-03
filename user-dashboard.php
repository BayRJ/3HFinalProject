<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Dashboard</title>
  <link rel="stylesheet" href="user-dashboard.css">
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
        <div id="upcoming-appointments" class="appointments-list"></div>

        <h2 class="section-title">Past Appointments</h2>
        <div id="past-appointments" class="appointments-list"></div>
      </div>

      <!-- Account Settings Tab -->
      <div id="settings-tab" class="tab-content hidden">
        <h2 class="section-title">Account Settings</h2>
        <form id="profile-form" class="form hidden">
          <label class="form-label">Name</label>
          <input type="text" id="profile-name" class="form-input">
          <label class="form-label">Email</label>
          <input type="email" id="profile-email" class="form-input">
          <label class="form-label">Phone Number</label>
          <input type="tel" id="profile-phone" class="form-input">
          <button type="submit" class="form-button">Update Profile</button>
        </form>

        <div id="profile-display">
          <p id="profile-display-name"></p>
          <p id="profile-display-email"></p>
          <p id="profile-display-phone"></p>
          <button id="edit-profile" class="action-button">Edit Profile</button>
        </div>

        <h2 class="section-title">Change Password</h2>
        <form id="password-form" class="form">
          <label class="form-label">New Password</label>
          <input type="password" id="new-password" class="form-input">
          <button type="submit" class="form-button">Change Password</button>
        </form>
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