<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="assets/admin.css">
    <link rel="stylesheet" href="../assets/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="assets/admin.js"></script>
</head>
<body>
<div class="admin-shell">
  <aside class="admin-sidebar">
    <h1>BellaVista</h1>
    <nav>
      <a href="index.php">Dashboard</a>
      <a href="analytics.php">Analytics</a>
      <a href="users.php">Users</a>
      <a href="reservations.php">Reservations</a>
      <a href="menu.php">Menu</a>
      <a href="contact_messages.php">Contact Messages</a>
      <a href="profile.php">Profile</a>
      <a class="bottom-link" href="settings.php">Settings</a>
      <a class="bottom-link" href="logout.php">Logout</a>
    </nav>
  </aside>
  <main class="admin-main">
    <div class="admin-topbar">
      <div class="topbar-title">Profile</div>
      <div class="topbar-actions">
        <button class="topbar-btn js-toggle-theme" title="Toggle dark mode">🌓</button>
      </div>
    </div>
    <div class="page-container">
      <div class="featured-header">
        <h2>Your Profile</h2>
        <p>View/edit your information and change password.</p>
      </div>
      <div class="card" style="max-width:480px;margin:auto">
        <div style="display:flex;align-items:center;gap:20px;">
          <img src="https://ui-avatars.com/api/?name=Admin&background=355c7d&color=fff&size=78" alt="avatar" style="border-radius:50%">
          <div>
            <div style="font-size:1.05em;font-weight:600">Administrator</div>
            <div style="font-size:0.97em;color:#5975ad">admin@bellavista.local</div>
          </div>
        </div>
        <hr style="margin:22px 0;">
        <form method="post">
          <label>Name</label>
          <input type="text" value="Admin" disabled>
          <label>Email</label>
          <input type="email" value="admin@bellavista.local" disabled>
          <label>New Password</label>
          <input type="password" placeholder="•••••••">
          <button type="button" onclick="showToast('Profile update coming soon!',true)">Update</button>
        </form>
      </div>
    </div>
  </main>
</div>
</body>
</html>
