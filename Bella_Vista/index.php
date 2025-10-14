<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>Bella Vista Restaurant</title>
  <link rel="stylesheet" href="styles.css" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>
<body>
  <!-- HEADER/NAVIGATION -->
  <header class="site-header">
    <div class="container header-inner">
      <div class="logo-group">
        <img src="images/div.svg" alt="Bella Vista Logo" class="logo-img">
        <span class="logo-text">Bella Vista</span>
      </div>
      <nav class="main-nav">
        <a href="#home" class="nav-link active">Home</a>
        <a href="#about" class="nav-link">About</a>
        <a href="#menu" class="nav-link">Menu</a>
        <a href="#reservations" class="nav-link">Reservations</a>
        <a href="#contact" class="nav-link">Contact</a>
      </nav>
      <div class="header-actions">
        <button class="cart-btn"><i class="fa-solid fa-cart-shopping" style="color: #000000;"></i><span class="cart-badge">3</span></button>
        <button class="reserve-btn">Reserve Table</button>
      </div>
    </div>
  </header>
  <!-- HERO SECTION -->
  <section class="hero" style="background-image:url('images/Main-banner.jpg'); background-size: cover; background-position: center;">
    <div class="container hero-content">
      <h1>Ready to Experience Bella Vista?</h1>
      <p>Join us for an unforgettable culinary journey that celebrates tradition, flavor, and hospitality.</p>
      <div class="hero-actions">
        <button class="primary-btn"><i class="fa-solid fa-cart-shopping" style="color: #f57c00;"></i> Reserve Your Table</button>
        <button class="secondary-btn"><i class="fa-solid fa-utensils"></i> View Our Menu</button>
      </div>
    </div>
  </section>
  <!-- FEATURED DISHES -->
  <section class="featured" id="menu">
    <div class="container">
      <div class="featured-header">
        <h2>Featured Dishes</h2>
        <p>Discover our most popular creations, each crafted with passion and served with excellence.</p>
      </div>
      <div class="dishes-grid">
        <div class="dish-card">
          <img src="images/img.png" alt="Grilled Atlantic Salmon">
          <div class="dish-info">
            <h3>Grilled Atlantic Salmon</h3>
            <p>Fresh salmon fillet with seasonal vegetables and lemon herb butter</p>
            <div class="dish-row">
              <span class="price">$28</span>
              <button class="add-cart-btn">Add to Cart</button>
            </div>
          </div>
        </div>
        <div class="dish-card">
          <img src="images/img-1.png" alt="Prime Beef Tenderloin">
          <div class="dish-info">
            <h3>Prime Beef Tenderloin</h3>
            <p>8oz tenderloin with truffle mashed potatoes and red wine reduction</p>
            <div class="dish-row">
              <span class="price">$42</span>
              <button class="add-cart-btn">Add to Cart</button>
            </div>
          </div>
        </div>
        <div class="dish-card">
          <img src="images/img-2.png" alt="Lobster Risotto">
          <div class="dish-info">
            <h3>Lobster Risotto</h3>
            <p>Creamy arborio rice with fresh lobster and saffron</p>
            <div class="dish-row">
              <span class="price">$36</span>
              <button class="add-cart-btn">Add to Cart</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- OUR STORY -->
  <section class="our-story" id="about">
    <div class="container">
      <div class="story-content">
        <div class="story-text">
          <h2>Our Story</h2>
          <p>Founded in 2015, Savory began as a dream to bring authentic, farm-to-table dining to our community. Our passionate team of chefs sources the finest local ingredients to create memorable culinary experiences.</p>
          <p>Every dish tells a story of tradition, innovation, and our commitment to excellence. We believe that great food brings people together and creates lasting memories.</p>
          <button class="learn-more-btn">Learn More About Us</button>
        </div>
        <div class="story-img">
          <img src="images/img-3.png" alt="Our Story">
        </div>
      </div>
    </div>
  </section>
  <!-- MEET OUR TEAM -->
  <section class="our-team">
    <div class="container">
      <div class="team-header">
        <h2>Meet Our Team</h2>
        <p>The passionate individuals behind every exceptional dish and memorable dining experience.</p>
      </div>
      <div class="team-grid">
        <div class="team-card">
          <img src="images/img-4.png" alt="Chef Marcus Rivera" class="team-photo">
          <h3>Chef Marcus Rivera</h3>
          <p class="team-role">Head Chef</p>
          <p>15 years of culinary excellence with expertise in Mediterranean and contemporary cuisine.</p>
        </div>
        <div class="team-card">
          <img src="images/img-5.png" alt="Chef Isabella Chen" class="team-photo">
          <h3>Chef Isabella Chen</h3>
          <p class="team-role">Sous Chef</p>
          <p>Specialized in Asian fusion techniques with a passion for innovative flavor combinations.</p>
        </div>
        <div class="team-card">
          <img src="images/img-6.png" alt="David Thompson" class="team-photo">
          <h3>David Thompson</h3>
          <p class="team-role">Restaurant Manager</p>
          <p>Dedicated to ensuring every guest has an exceptional dining experience from start to finish.</p>
        </div>
      </div>
    </div>
  </section>
  <!-- FOOTER -->
  <footer class="site-footer">
    <div class="container footer-content">
      <div class="footer-brand">
        <img src="images/div.svg" alt="Bella Vista" class="footer-logo">
        <span>Bella Vista</span>
        <p>Authentic Italian cuisine served with passion and tradition since 1985.</p>
      </div>
      <div class="footer-links">
        <h4>Quick Links</h4>
        <ul>
          <li><a href="#home">Home</a></li>
          <li><a href="#about">About</a></li>
          <li><a href="#menu">Menu</a></li>
          <li><a href="#reservations">Reservations</a></li>
        </ul>
      </div>
      <div class="footer-contact">
        <h4>Contact Info</h4>
        <div><i class="fa-solid fa-location-dot" style="color: #9CA3AF;"></i> 123 Culinary Street, Food City</div>
        <div><i class="fa-solid fa-phone" style="color: #9CA3AF;"></i> (555) 123-4567</div>
        <div><i class="fa-solid fa-envelope" style="color: #9CA3AF;"></i> hello@bellavista.com</div>
        <div class="footer-social">Follow Us: 
          <a href="#"><i class="fa-brands fa-facebook-f" style="color: #FFFFFF; background-color:#374151; border-radius: 50%;"></i></a>
            <a href="#"><i class="fa-brands fa-twitter" style="color: #FFFFFF; background-color:#374151; border-radius: 50%;"></i></a>
            <a href="#"><i class="fa-brands fa-instagram" style="color: #FFFFFF; background-color:#374151; border-radius: 50%;"></i></a>
          </div>
      </div>
    </div>
    <div class="container footer-bottom">
      <span>© 2025 Bella Vista Restaurant. All rights reserved.</span>
    </div>
  </footer>
  <script src="scripts.js"></script>
</body>
</html>
