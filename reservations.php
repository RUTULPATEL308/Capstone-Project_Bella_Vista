<?php include 'includes/header.php'; ?>

<section class="welcome" style="background-image:url('images/reservations-hero.jpg')">
  <div class="container welcome-content">
    <h2>Reserve a Table</h2>
    <p>Book a spot for dinner. We hold a few tables for walk-ins nightly.</p>
  </div>
</section>

<section class="featured">
  <div class="container">

    <div class="featured-header">
      <h2>Booking Details</h2>
      <p>Open daily 5:00pm–10:00pm. For parties of 8+, private dining, or same-day changes, please call us.</p>
    </div>

    <div class="reservation-grid">

      <form id="reservation-form" class="reservation-form">
        <label for="name">Full Name</label>
        <input id="name" name="name" required placeholder="First and last name">

        <label for="phone">Phone</label>
        <input id="phone" name="phone" type="tel" required placeholder="e.g. (555) 123-4567">

        <label for="email">Email</label>
        <input id="email" name="email" type="email" required placeholder="you@example.com">

        <label for="date">Date</label>
        <input id="date" name="date" type="date" required>

        <label for="time">Time</label>
        <input id="time" name="time" type="time" required>

        <label for="guests">Guests</label>
        <select id="guests" name="guests" required>
          <option value="2">2</option>
          <option value="3">3</option>
          <option value="4" selected>4</option>
          <option value="5">5</option>
          <option value="6">6</option>
          <option value="7">7</option>
          <option value="8">8</option>
        </select>

        <label for="seating_preference">Seating Preference</label>
        <select id="seating_preference" name="seating_preference" required>
          <option value="no preference" selected>No Preference</option>
          <option value="dining">Dining</option>
          <option value="bar">Bar</option>
          <option value="patio">Patio</option>
        </select>

        <label for="occasion">Occasion</label>
        <select id="occasion" name="occasion" required>
          <option value="none" selected>None</option>
          <option value="birthday">Birthday</option>
          <option value="anniversary">Anniversary</option>
          <option value="business">Business</option>
        </select>

        <label for="notes">Notes (dietary requests, high chair, accessibility)</label>
        <textarea id="notes" name="notes" rows="4" placeholder="Tell us anything we should know"></textarea>

        <label style="display:flex;gap:8px;align-items:center;margin-top:4px;">
          <input type="checkbox" id="consent" required>
          I agree to the reservation policy below.
        </label>

        <button type="submit" class="primary-btn">Submit</button>
      </form>

      <div class="reservation-info">
        <h3>Hours & Booking</h3>
        <p>Kitchen: 5:00pm–10:00pm daily.</p>
        <p>Bar: from 4:30pm. Last seating at 9:30pm.</p>

        <h3 style="margin-top:14px;">Reservation Policy</h3>
        <ul style="margin-left:18px;">
          <li>15-minute grace period. Please call if you’re running late.</li>
          <li>Tables are held for 1 hour 45 minutes for parties up to 4, and 2 hours for 5–8.</li>
          <li>Patio seating is weather dependent; we’ll do our best to honour requests.</li>
          <li>For groups of 8+ or private dining, email events@bellavista.com.</li>
        </ul>

        <h3 style="margin-top:14px;">Contact</h3>
        <p>(555) 123-4567</p>
        <p>hello@bellavista.com</p>

        <img src="images/map.jpg" alt="Map to Bella Vista" style="width:100%; border-radius:12px; margin-top:16px;">
      </div>

    </div>

    <div id="reservation-confirm" class="reservation-confirm" hidden></div>

    <div class="reservation-grid" style="margin-top:10px;">
      <div class="reservation-info">
        <h3>Frequently Asked</h3>
        <details>
          <summary>Can I bring my own cake?</summary>
          <p style="margin-top:8px;">Yes. We charge a $3 per person plating fee. Please note any allergies in your reservation notes.</p>
        </details>
        <details>
          <summary>Do you accommodate allergies?</summary>
          <p style="margin-top:8px;">Absolutely. Many dishes are gluten-free or can be adjusted. Let us know in advance so we can prepare.</p>
        </details>
        <details>
          <summary>Is there parking?</summary>
          <p style="margin-top:8px;">Street parking is available after 6pm; a paid lot is across the street.</p>
        </details>
      </div>

      <div class="reservation-info">
        <h3>Private Dining</h3>
        <p>For celebrations and business dinners, our private room seats up to 20 guests with custom menus and wine pairings. Contact our events team at events@bellavista.com.</p>
        <img src="images/private-dining.jpg" alt="Private dining room" style="width:100%; border-radius:12px; margin-top:16px;">
      </div>
    </div>

  </div>
</section>

<?php include 'includes/footer.php'; ?>
