<?php
$current = basename($_SERVER['PHP_SELF']);
function active($file) { global $current; return $current === $file ? 'active' : ''; }
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Bella Vista Restaurant</title>
  <link rel="stylesheet" href="assets/styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>

<header class="site-header">
  <div class="container header-inner">
    <a href="index.php" class="logo-group">
      <img src="images/logo.svg" class="logo-img" alt="Bella Vista">
      <span class="logo-text">Bella Vista</span>
    </a>

    <nav class="main-nav">
      <a href="index.php" class="nav-link <?=active('index.php')?>">Home</a>
      <a href="about.php" class="nav-link <?=active('about.php')?>">About</a>
      <a href="menu.php" class="nav-link <?=active('menu.php')?>">Menu</a>
      <a href="reservations.php" class="nav-link <?=active('reservations.php')?>">Reservations</a>
      <a href="contact.php" class="nav-link <?=active('contact.php')?>">Contact</a>
    </nav>

    <div class="header-actions">
      <button class="cart-btn"><i class="fa-solid fa-cart-shopping"></i><span class="cart-badge">0</span></button>
      <a href="reservations.php" class="reserve-btn">Reserve Table</a>
    </div>
  </div>
</header>
