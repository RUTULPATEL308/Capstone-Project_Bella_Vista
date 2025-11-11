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

      <!-- STARTERS -->
      <article class="menu-card" data-category="starters">
        <img src="images/menu/starters/bruschetta.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Bruschetta al Pomodoro <span class="diet-tag">V</span></h4>
          <p>Grilled bread, vine tomatoes, basil, olive oil.</p>
          <p class="pairing">Pairs with Pinot Grigio</p>
          <div class="menu-bottom">
            <span class="price">$10</span>
            <button class="add-cart-btn" data-name="Bruschetta al Pomodoro" data-price="10">Add</button>
          </div>
        </div>
      </article>

      <article class="menu-card" data-category="starters">
        <img src="images/menu/starters/calamari.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Crispy Calamari</h4>
          <p>Lightly fried with roasted garlic aioli.</p>
          <p class="pairing">Pairs with Sauvignon Blanc</p>
          <div class="menu-bottom">
            <span class="price">$14</span>
            <button class="add-cart-btn" data-name="Crispy Calamari" data-price="14">Add</button>
          </div>
        </div>
      </article>

      <article class="menu-card" data-category="starters">
        <img src="images/menu/starters/burrata.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Burrata <span class="diet-tag">V</span> <span class="diet-tag">GF</span></h4>
          <p>Cherry tomatoes, arugula, balsamic.</p>
          <p class="pairing">Pairs with Rosé</p>
          <div class="menu-bottom">
            <span class="price">$16</span>
            <button class="add-cart-btn" data-name="Burrata" data-price="16">Add</button>
          </div>
        </div>
      </article>

      <article class="menu-card" data-category="starters">
        <img src="images/menu/starters/garlic-shrimp.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Garlic Shrimp</h4>
          <p>White wine, butter, herbs, grilled lemon.</p>
          <p class="pairing">Pairs with Chardonnay</p>
          <div class="menu-bottom">
            <span class="price">$15</span>
            <button class="add-cart-btn" data-name="Garlic Shrimp" data-price="15">Add</button>
          </div>
        </div>
      </article>

      <!-- PASTA -->
      <article class="menu-card" data-category="pasta">
        <img src="images/menu/pasta/tagliatelle.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Tagliatelle Pomodoro <span class="diet-tag">V</span></h4>
          <p>Handmade tagliatelle with basil and parmesan.</p>
          <p class="pairing">Pairs with Chianti</p>
          <div class="menu-bottom">
            <span class="price">$22</span>
            <button class="add-cart-btn" data-name="Tagliatelle Pomodoro" data-price="22">Add</button>
          </div>
        </div>
      </article>

      <article class="menu-card" data-category="pasta">
        <img src="images/menu/pasta/mushroom-risotto.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Wild Mushroom Risotto <span class="diet-tag">GF</span></h4>
          <p>Arborio rice, mushrooms, parmesan.</p>
          <p class="pairing">Pairs with Pinot Noir</p>
          <div class="menu-bottom">
            <span class="price">$26</span>
            <button class="add-cart-btn" data-name="Wild Mushroom Risotto" data-price="26">Add</button>
          </div>
        </div>
      </article>

      <article class="menu-card" data-category="pasta">
        <img src="images/menu/pasta/lobster-risotto.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Lobster Risotto</h4>
          <p>Saffron broth, buttered lobster, lemon zest.</p>
          <p class="pairing">Pairs with Vermentino</p>
          <div class="menu-bottom">
            <span class="price">$36</span>
            <button class="add-cart-btn" data-name="Lobster Risotto" data-price="36">Add</button>
          </div>
        </div>
      </article>

      <article class="menu-card" data-category="pasta">
        <img src="images/menu/pasta/fettuccine-alfredo.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Fettuccine Alfredo</h4>
          <p>Creamy parmesan sauce, parsley. Add chicken +$4.</p>
          <p class="pairing">Pairs with Chardonnay</p>
          <div class="menu-bottom">
            <span class="price">$21</span>
            <button class="add-cart-btn" data-name="Fettuccine Alfredo" data-price="21">Add</button>
          </div>
        </div>
      </article>

      <!-- MAINS -->
      <article class="menu-card" data-category="mains">
        <img src="images/menu/mains/salmon.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Grilled Salmon <span class="diet-tag">GF</span></h4>
          <p>Lemon butter sauce, roasted vegetables.</p>
          <p class="pairing">Pairs with Pinot Grigio</p>
          <div class="menu-bottom">
            <span class="price">$29</span>
            <button class="add-cart-btn" data-name="Grilled Salmon" data-price="29">Add</button>
          </div>
        </div>
      </article>

      <article class="menu-card" data-category="mains">
        <img src="images/menu/mains/tenderloin.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Beef Tenderloin</h4>
          <p>Rosemary potatoes, red wine jus.</p>
          <p class="pairing">Pairs with Barolo</p>
          <div class="menu-bottom">
            <span class="price">$42</span>
            <button class="add-cart-btn" data-name="Beef Tenderloin" data-price="42">Add</button>
          </div>
        </div>
      </article>

      <article class="menu-card" data-category="mains">
        <img src="images/menu/mains/piccata.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Chicken Piccata</h4>
          <p>Lemon caper sauce, creamy mashed potatoes.</p>
          <p class="pairing">Pairs with Pinot Bianco</p>
          <div class="menu-bottom">
            <span class="price">$26</span>
            <button class="add-cart-btn" data-name="Chicken Piccata" data-price="26">Add</button>
          </div>
        </div>
      </article>

      <article class="menu-card" data-category="mains">
        <img src="images/menu/mains/seafood-stew.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Seafood Stew</h4>
          <p>Mussels, shrimp, cod, tomato broth.</p>
          <p class="pairing">Pairs with Verdicchio</p>
          <div class="menu-bottom">
            <span class="price">$34</span>
            <button class="add-cart-btn" data-name="Seafood Stew" data-price="34">Add</button>
          </div>
        </div>
      </article>

      <!-- DESSERTS -->
      <article class="menu-card" data-category="desserts">
        <img src="images/menu/desserts/tiramisu.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Tiramisu</h4>
          <p>Espresso-soaked sponge, mascarpone.</p>
          <p class="pairing">Pairs with Espresso</p>
          <div class="menu-bottom">
            <span class="price">$9</span>
            <button class="add-cart-btn" data-name="Tiramisu" data-price="9">Add</button>
          </div>
        </div>
      </article>

      <article class="menu-card" data-category="desserts">
        <img src="images/menu/desserts/panna-cotta.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Panna Cotta <span class="diet-tag">GF</span></h4>
          <p>Vanilla custard, berry compote.</p>
          <p class="pairing">Pairs with Moscato</p>
          <div class="menu-bottom">
            <span class="price">$8</span>
            <button class="add-cart-btn" data-name="Panna Cotta" data-price="8">Add</button>
          </div>
        </div>
      </article>

      <article class="menu-card" data-category="desserts">
        <img src="images/menu/desserts/affogato.jpg" class="menu-img lightbox-img" alt="">
        <div class="menu-info">
          <h4>Affogato</h4>
          <p>Vanilla gelato with hot espresso.</p>
          <p class="pairing">Perfect finisher</p>
          <div class="menu-bottom">
            <span class="price">$7</span>
            <button class="add-cart-btn" data-name="Affogato" data-price="7">Add</button>
          </div>
        </div>
      </article>

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


