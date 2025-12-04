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
    <title>Settings</title>
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
      <a href="profile.php">Profile</a>
      <a class="bottom-link" href="settings.php">Settings</a>
      <a class="bottom-link" href="logout.php">Logout</a>
    </nav>
  </aside>
  <main class="admin-main">
    <div class="admin-topbar">
      <div class="topbar-title">Settings</div>
      <div class="topbar-actions">
        <button class="topbar-btn js-toggle-theme" title="Toggle dark mode">🌓</button>
      </div>
    </div>
    <div class="page-container">
      <div class="featured-header">
        <h2>Settings</h2>
        <p>Customize your admin panel preferences</p>
      </div>
      <div class="card" style="max-width:480px;margin:auto">
        <form>
          <label style="display:flex;gap:10px;align-items:center;font-weight:500">
            <input type="checkbox" checked> Email notifications about new reservations
          </label>
          <label style="display:flex;gap:10px;align-items:center;font-weight:500">
            <input type="checkbox" checked> Enable system dark mode
          </label>
          <label style="font-weight:500;margin:16px 0 6px 0;">Theme Color</label>
          <select><option>Classic Blue</option><option>Green</option><option>Pink</option></select>
          <button type="button" onclick="showToast('Preferences saved (demo)!',true)">Save Preferences</button>
        </form>
      </div>
    </div>
  </main>
</div>
</body>
</html>
