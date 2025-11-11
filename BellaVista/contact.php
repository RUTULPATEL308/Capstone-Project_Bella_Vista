<?php include 'includes/header.php'; ?>

<section class="welcome" style="background-image:url('images/contact-hero.jpg')">
  <div class="container welcome-content">
    <h2>Contact Us</h2>
    <p>Questions about reservations, private dining, or anything else? Send us a note — we’ll get back within one business day.</p>
  </div>
</section>

<section class="featured">
  <div class="container">

    <div class="featured-header">
      <h2>We’re Here to Help</h2>
      <p>Call the restaurant during service hours or use the form for general inquiries and event requests.</p>
    </div>

    <div class="reservation-grid">

      <form id="contact-form" class="reservation-form">
        <label for="c-name">Full Name</label>
        <input id="c-name" name="name" required placeholder="First and last name">

        <label for="c-email">Email</label>
        <input id="c-email" name="email" type="email" required placeholder="you@example.com">

        <label for="c-phone">Phone (optional)</label>
        <input id="c-phone" name="phone" type="tel" placeholder="e.g. (555) 123-4567">

        <label for="c-topic">Topic</label>
        <select id="c-topic" name="topic" required>
          <option value="general" selected>General question</option>
          <option value="reservation">Reservation change</option>
          <option value="allergies">Dietary/allergy question</option>
          <option value="events">Private dining / events</option>
          <option value="careers">Careers</option>
          <option value="press">Press</option>
        </select>

        <label for="c-message">Message</label>
        <textarea id="c-message" name="message" rows="6" required placeholder="How can we help?"></textarea>

        <label style="display:flex;gap:8px;align-items:center;">
          <input type="checkbox" id="c-consent" required>
          I agree to be contacted about my inquiry.
        </label>

        <button type="submit" class="primary-btn">Submit</button>
      </form>

      <div class="reservation-info">
        <h3>Visit & Hours</h3>
        <p>123 Culinary Street, Food City</p>
        <p>Kitchen: 5:00pm–10:00pm daily</p>
        <p>Bar from 4:30pm · Last seating 9:30pm</p>

        <h3 style="margin-top:14px;">Contact</h3>
        <p>(555) 123-4567</p>
        <p>hello@bellavista.com</p>

        <h3 style="margin-top:14px;">Follow</h3>
        <p>
          <a href="#" aria-label="Instagram" style="margin-right:10px;"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" aria-label="Facebook" style="margin-right:10px;"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#" aria-label="Twitter"><i class="fa-brands fa-x-twitter"></i></a>
        </p>

        <div style="margin-top:16px;border-radius:12px;overflow:hidden;">
          <iframe
            src="https://maps.google.com/maps?q=123%20Culinary%20Street%20Food%20City&t=&z=15&ie=UTF8&iwloc=&output=embed"
            width="100%" height="260" style="border:0;" loading="lazy" referrerpolicy="no-referrer-when-downgrade"
            title="Map to Bella Vista"></iframe>
        </div>
      </div>

    </div>

    <div id="contact-confirm" class="reservation-confirm" hidden></div>

    <div class="reservation-grid" style="margin-top:16px;">
      <div class="reservation-info">
        <h3>Frequently Asked</h3>
        <details>
          <summary>Dietary and allergy requests</summary>
          <p style="margin-top:8px;">Many dishes are naturally gluten-free or can be adjusted. Let us know in advance and we’ll guide you through safe options.</p>
        </details>
        <details>
          <summary>Parking</summary>
          <p style="margin-top:8px;">Street parking is available after 6pm. A paid lot is across the street; please allow extra time on weekends.</p>
        </details>
        <details>
          <summary>Gift cards</summary>
          <p style="margin-top:8px;">Digital gift cards are available in any amount. Visit in person or email gifts@bellavista.com to purchase.</p>
        </details>
        <details>
          <summary>Accessibility</summary>
          <p style="margin-top:8px;">The dining room, washrooms, and patio are wheelchair accessible. Please note any needs so we can reserve an appropriate table.</p>
        </details>
      </div>

      <div class="reservation-info">
        <h3>Private Dining & Events</h3>
        <p>Our private room seats up to 20 guests with custom menus and wine pairings. For larger groups, full buyouts are available Sunday–Wednesday.</p>
        <p style="margin-top:8px;">Email events@bellavista.com with your preferred date, time, guest count, and any dietary notes.</p>
        <img src="images/contact-private.jpg" alt="Private dining room" style="width:100%; border-radius:12px; margin-top:16px;">
      </div>
    </div>

    <div class="reservation-grid" style="margin-top:16px;">
      <div class="reservation-info">
        <h3>Careers</h3>
        <p>We’re always looking for kind, curious people who love hospitality. Send resumes to careers@bellavista.com.</p>
      </div>
      <div class="reservation-info">
        <h3>Press</h3>
        <p>For media inquiries and asset requests, contact press@bellavista.com.</p>
      </div>
    </div>

  </div>
</section>

<?php include 'includes/footer.php'; ?>
