<?php include 'includes/header.php'; ?>

<section class="welcome" style="background-image:url('images/checkout-hero.jpg')">
  <div class="container welcome-content">
    <h2>Checkout</h2>
    <p>Review your order and enter your details to confirm pickup or dine-in.</p>
  </div>
</section>

<section class="featured">
  <div class="container">

    <div class="featured-header">
      <h2>Your Order</h2>
      <p>Please review your selected dishes before completing the order.</p>
    </div>

    <div class="reservation-grid">

      <!-- ORDER SUMMARY -->
      <div class="reservation-info">
        <h3>Order Summary</h3>
        <div id="checkout-cart" class="cart-panel">
          <!-- Items populated dynamically -->
        </div>

        <div class="cart-total-row">
          <span>Subtotal:</span>
          <span id="subtotal">$0.00</span>
        </div>
        <div class="cart-total-row">
          <span>Tax (13%):</span>
          <span id="tax">$0.00</span>
        </div>
        <div class="cart-total-row" style="font-size:18px;">
          <span>Total:</span>
          <span id="grand-total" style="font-weight:700;">$0.00</span>
        </div>
      </div>

      <!-- CUSTOMER FORM -->
      <form id="checkout-form" class="reservation-form" method="POST">
        <h3>Customer Details</h3>
        <label for="name">Full Name</label>
        <input id="name" name="name" required placeholder="Your name">

        <label for="email">Email</label>
        <input id="email" name="email" type="email" required placeholder="you@example.com">

        <label for="phone">Phone</label>
        <input id="phone" name="phone" type="tel" required placeholder="(555) 123-4567">

        <label for="pickup">Pickup or Dine-In</label>
        <select id="pickup" name="pickup" required>
          <option value="pickup" selected>Pickup</option>
          <option value="dine-in">Dine-In</option>
        </select>

        <label for="notes">Special Instructions (optional)</label>
        <textarea id="notes" name="notes" rows="4" placeholder="e.g., no cheese, extra sauce, allergy notes"></textarea>

        <h3>Payment Method</h3>
        <label style="display:flex;align-items:center;gap:8px;">
          <input type="radio" name="payment" value="card" required> Credit / Debit Card
        </label>
        <label style="display:flex;align-items:center;gap:8px;">
          <input type="radio" name="payment" value="cash"> Pay at Pickup
        </label>

        <button type="submit" class="primary-btn" style="margin-top:10px;">Place Order</button>
      </form>

    </div>

    <div id="order-confirm" class="reservation-confirm" hidden></div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>