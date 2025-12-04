<?php include 'includes/header.php'; ?>

<section class="menu-hero">
  <h1>Our Menu</h1>
  <p>Explore a seasonal mix of Italian classics, handmade pasta, and house favourites.</p>
</section>

<section class="menu-tabs-section">
  <div class="menu-tabs">
    <button class="tab active" data-category="all">All</button>
    <button class="tab" data-category="starters">Starters</button>
    <button class="tab" data-category="pasta">Fresh Pasta</button>
    <button class="tab" data-category="mains">Mains</button>
    <button class="tab" data-category="desserts">Desserts</button>
  </div>
</section>

<section class="menu-section">
  <div class="menu-page-container">

    <!-- GRID -->
    <div class="menu-grid-container" id="menu-grid">
      <?php
      require_once 'db_connect.php';
      $result = $conn->query("SELECT * FROM menu_items WHERE is_active = 1 ORDER BY category, display_order, name");
      
      if ($result && $result->num_rows > 0) {
        while ($item = $result->fetch_assoc()) {
          $dietTags = !empty($item['diet_tags']) ? explode(',', $item['diet_tags']) : [];
          $dietTagsHtml = '';
          foreach ($dietTags as $tag) {
            $tag = trim($tag);
            if ($tag) {
              $dietTagsHtml .= '<span class="diet-tag">' . htmlspecialchars($tag) . '</span>';
            }
          }
          
          echo '<article class="menu-card" data-category="' . htmlspecialchars($item['category']) . '">';
          if (!empty($item['image'])) {
            echo '<img src="' . htmlspecialchars($item['image']) . '" class="menu-img lightbox-img" alt="' . htmlspecialchars($item['name']) . '">';
          }
          echo '<div class="menu-info">';
          echo '<h4>' . htmlspecialchars($item['name']) . ' ' . $dietTagsHtml . '</h4>';
          if (!empty($item['description'])) {
            echo '<p>' . htmlspecialchars($item['description']) . '</p>';
          }
          if (!empty($item['pairing'])) {
            echo '<p class="pairing">' . htmlspecialchars($item['pairing']) . '</p>';
          }
          echo '<div class="menu-bottom">';
          echo '<span class="price">$' . number_format($item['price'], 2) . '</span>';
          echo '<button class="add-cart-btn" data-name="' . htmlspecialchars($item['name']) . '" data-price="' . htmlspecialchars($item['price']) . '">Add</button>';
          echo '</div>';
          echo '</div>';
          echo '</article>';
        }
      } else {
        echo '<p style="grid-column:1/-1;text-align:center;padding:40px;color:#666;">No menu items available. Please check back later.</p>';
      }
      ?>

    </div>

    <!-- STICKY CART -->
    <aside class="sticky-cart">
      <h3>Your Order</h3>
      <div id="cart-items"></div>
      <div class="cart-total-row">
        <span>Total:</span>
        <span id="cart-total">$0.00</span>
      </div>
      <button id="checkout-btn" class="checkout-btn">Checkout</button>
    </aside>

  </div>
</section>

<?php include 'includes/footer.php'; ?>


