<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
require_once '../db_connect.php';

// Dashboard dynamic metrics
$totalUsers = $conn->query("SELECT COUNT(*) FROM customers")->fetch_row()[0] ?? '--';
$totalRes = $conn->query("SELECT COUNT(*) FROM reservations")->fetch_row()[0] ?? '--';
$revenue = $conn->query("SELECT SUM(total) FROM orders")->fetch_row()[0] ?? 0;
$revenue = $revenue ?: '--';
$tableAvailability = '75%'; // Placeholder -- implement from reservations or seats if you want
// Weekly stats (replace with real queries as needed)
$days = ['Mon','Tue','Wed','Thu','Fri','Sat','Sun'];
$weekRes = [16,21,13,22,27,32,28];
$weekRev = [220,290,170,315,490,605,440];
$resQ = $conn->query("SELECT DAYOFWEEK(date) as d, COUNT(*) as c FROM reservations WHERE WEEK(date)=WEEK(CURDATE()) GROUP BY d ORDER BY d");
if ($resQ && $resQ->num_rows == 7) { $weekRes = []; while($row = $resQ->fetch_assoc()) $weekRes[] = (int)$row['c']; }
$revQ = $conn->query("SELECT DAYOFWEEK(o.created_at) as d, SUM(o.total) as s FROM orders o WHERE WEEK(o.created_at)=WEEK(CURDATE()) GROUP BY d ORDER BY d");
if ($revQ && $revQ->num_rows == 7) { $weekRev = []; while($row = $revQ->fetch_assoc()) $weekRev[] = (float)$row['s']; }
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
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
      <a href="profile.php">Profile</a>
      <a class="bottom-link" href="settings.php">Settings</a>
      <a class="bottom-link" href="logout.php">Logout</a>
    </nav>
  </aside>
  <main class="admin-main">
    <div class="admin-topbar">
      <div class="topbar-title">Dashboard</div>
      <div class="topbar-actions">
        <button class="topbar-btn js-toggle-theme" title="Toggle dark mode">🌓</button>
        <button class="topbar-btn" onclick="showToast('Welcome back, admin!', true)" title="Show toast">🔔</button>
      </div>
    </div>
    <div class="page-container">
      <div class="featured-header">
        <h2>Overview</h2>
        <p>Quick view of stats and trends for your restaurant.</p>
      </div>
      <div class="widget-row">
        <div class="widget-card">
          <div class="widget-label">Total Users</div>
          <div class="widget-value"><?= htmlspecialchars($totalUsers) ?></div>
        </div>
        <div class="widget-card">
          <div class="widget-label">Reservations</div>
          <div class="widget-value"><?= htmlspecialchars($totalRes) ?></div>
        </div>
        <div class="widget-card">
          <div class="widget-label">Revenue ($)</div>
          <div class="widget-value"><?= htmlspecialchars($revenue) ?></div>
        </div>
        <div class="widget-card">
          <div class="widget-label">Table Availability</div>
          <div class="widget-value"><?= htmlspecialchars($tableAvailability) ?></div>
        </div>
      </div>
      <div class="card">
        <canvas id="demoChart" height="88"></canvas>
      </div>
    </div>
  </main>
</div>
<script>
$(function(){
  const resData = <?= json_encode($weekRes) ?>;
  const revData = <?= json_encode($weekRev) ?>;
  const days = <?= json_encode($days) ?>;
  const ctx = document.getElementById('demoChart');
  new Chart(ctx, {
    type: 'bar',
    data: {
      labels: days,
      datasets: [
        { label: 'Reservations',
          data: resData,
          backgroundColor: '#ff8500',
          borderRadius: 6,
          barPercentage: 0.6 },
        { label: 'Revenue ($)',
          data: revData,
          type: 'line',
          fill: false,
          borderColor: '#e9571d',
          backgroundColor: '#e9571d',
          tension: 0.3,
          yAxisID: 'revenue',
          pointRadius: 4 }
      ]
    },
    options: {
      responsive: true,
      plugins: { legend: { display: true } },
      scales: {
        y: { title: {display: true, text: 'Reservations'} },
        revenue: { position: 'right', grid: { drawOnChartArea: false }, title: {display: true, text: 'Revenue ($)'} }
      }
    }
  });
});
</script>
</body>
</html>
