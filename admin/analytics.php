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
    <title>Analytics</title>
    <link rel="stylesheet" href="assets/admin.css">
    <link rel="stylesheet" href="../assets/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
      <div class="topbar-title">Analytics</div>
      <div class="topbar-actions">
        <button class="topbar-btn js-toggle-theme" title="Toggle dark mode">🌓</button>
      </div>
    </div>
    <div class="page-container">
      <div class="featured-header">
        <h2>Analytics</h2>
        <p>Track key KPIs for your business growth.</p>
      </div>
      <div class="widget-row">
        <div class="widget-card">
          <div class="widget-label">Avg. Daily Reservations</div>
          <div class="widget-value">24</div>
        </div>
        <div class="widget-card">
          <div class="widget-label">Returning Customers</div>
          <div class="widget-value">54%</div>
        </div>
        <div class="widget-card">
          <div class="widget-label">Revenue/Guest ($)</div>
          <div class="widget-value">39</div>
        </div>
      </div>
      <div class="card">
        <h3 style="margin-top:0;">Weekly Revenue</h3>
        <canvas id="revenueChart" height="96"></canvas>
      </div>
    </div>
  </main>
</div>
<script>
$(function(){
  const ctx = document.getElementById('revenueChart');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'],
      datasets: [{
        label: 'Revenue ($)',
        data: [220,290,170,315,490,605,440],
        backgroundColor: '#355c7d',
      }]
    },
    options: {
      plugins: { legend: { display: false } },
      responsive: true,
      scales: { y: { beginAtZero: true } }
    }
  });
});
</script>
</body>
</html>
