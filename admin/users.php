<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
include '../db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Users</title>
    <link rel="stylesheet" href="assets/admin.css">
    <link rel="stylesheet" href="../assets/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
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
      <div class="topbar-title">Users</div>
      <div class="topbar-actions">
        <button class="topbar-btn js-toggle-theme" title="Toggle dark mode">🌓</button>
      </div>
    </div>
    <div class="page-container">
      <div class="featured-header">
        <h2>Users</h2>
        <p>All registered customers for your restaurant.</p>
      </div>
      <div class="card">
        <table id="usersTable" class="display" style="width:100%">
          <thead>
            <tr><th>ID</th><th>Name</th><th>Email</th><th>Phone</th><th>Created</th></tr>
          </thead>
          <tbody>
            <?php $result = $conn->query('SELECT id, name, email, phone, created_at FROM customers ORDER BY created_at DESC LIMIT 100');
            if ($result) { while ($row = $result->fetch_assoc()) {
              echo '<tr>';
              foreach ($row as $col) echo '<td>' . htmlspecialchars($col) . '</td>';
              echo '</tr>';
            }} ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>
<script>
$(function(){
  $('#usersTable').DataTable({
    "pageLength": 10,
    "lengthChange": false
  });
});
</script>
</body>
</html>
