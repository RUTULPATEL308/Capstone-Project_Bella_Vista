<?php include 'includes/header.php'; ?>

<section class="hero" style="background-image:url('images/hero.jpg');">
  <div class="container hero-content">
    <h1>Modern Italian made with good ingredients</h1>
    <p>Fresh pasta, simple grilled mains, and seasonal flavours inspired by everyday Italian cooking.</p>
    <div class="hero-actions">
      <a href="reservations.php" class="primary-btn">Reserve Table</a>
      <a href="menu.php" class="secondary-btn">View Menu</a>
    </div>
  </div>
</section>

<section class="featured">
  <div class="container">
    <div class="featured-header">
      <h2>Guest Favourites</h2>
      <p>Dishes that remain on the menu year-round because people keep coming back for them.</p>
    </div>

    <div class="dishes-grid">
      <div class="dish-card">
        <img src="images/dish1.jpg" alt="">
        <div class="dish-info">
          <h3>Garlic & Herb Salmon</h3>
          <p>Seared salmon, roasted tomatoes, olive oil, fresh herbs.</p>
          <div class="dish-row">
            <span class="price">$28</span>
            <button class="add-cart-btn" data-name="Garlic & Herb Salmon" data-price="28">Add</button>
          </div>
        </div>
      </div>

      <div class="dish-card">
        <img src="images/dish2.jpg" alt="">
        <div class="dish-info">
          <h3>Beef Tenderloin</h3>
          <p>Served with rosemary potatoes and house jus.</p>
          <div class="dish-row">
            <span class="price">$42</span>
            <button class="add-cart-btn" data-name="Beef Tenderloin" data-price="42">Add</button>
          </div>
        </div>
      </div>

      <div class="dish-card">
        <img src="images/dish3.jpg" alt="">
        <div class="dish-info">
          <h3>Lobster Risotto</h3>
          <p>Classic risotto with saffron, parmesan, and buttered lobster.</p>
          <div class="dish-row">
            <span class="price">$36</span>
            <button class="add-cart-btn" data-name="Lobster Risotto" data-price="36">Add</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="our-story">
  <div class="container">
    <div class="story-content">
      <div class="story-text">
        <h2>How We Approach Food</h2>
        <p>We cook with simple methods and ingredients that speak for themselves. Our menu changes throughout the year depending on what’s fresh and in season.</p>
        <p>Most of what we make is inspired by everyday Italian home meals — clean flavours, warm dishes, and thoughtful portions.</p>
        <a href="about.php" class="learn-more-btn">Learn More</a>
      </div>
      <div class="story-img">
        <img src="images/restaurant-interior.jpg" alt="">
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
