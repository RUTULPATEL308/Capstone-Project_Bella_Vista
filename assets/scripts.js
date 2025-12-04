// ====== GLOBAL CART FUNCTIONS ======
function getCart() {
  return JSON.parse(localStorage.getItem('cart')) || [];
}

function saveCart(cart) {
  localStorage.setItem('cart', JSON.stringify(cart));
}

function updateCartBadge() {
  const cart = getCart();
  const count = cart.reduce((sum, i) => sum + (i.qty || 1), 0);
  document.querySelectorAll('.cart-badge').forEach(b => (b.textContent = count));
}

// ====== ADD TO CART BUTTONS ======
document.addEventListener('click', e => {
  if (e.target.classList.contains('add-cart-btn')) {
    const btn = e.target;
    const name = btn.dataset.name;
    const price = parseFloat(btn.dataset.price || 0);

    let cart = getCart();
    const item = cart.find(i => i.name === name);
    if (item) item.qty += 1;
    else cart.push({ name, price, qty: 1 });
    saveCart(cart);
    updateCartBadge();

    // Feedback on button
    btn.innerText = 'Added!';
    btn.disabled = true;
    setTimeout(() => {
      btn.innerText = 'Add';
      btn.disabled = false;
    }, 1000);

    renderStickyCart();
  }
});

// ====== STICKY CART (MENU PAGE) ======
function renderStickyCart() {
  const container = document.getElementById('cart-items');
  const totalEl = document.getElementById('cart-total');
  if (!container || !totalEl) return;

  const cart = getCart();
  container.innerHTML = '';
  let total = 0;

  if (cart.length === 0) {
    container.innerHTML = '<p>Your cart is empty.</p>';
    totalEl.textContent = '$0.00';
    return;
  }

  cart.forEach((item, idx) => {
    const div = document.createElement('div');
    div.className = 'cart-row';
    div.innerHTML = `
      <div class="cart-name">${item.name}</div>
      <div class="cart-qty">
        <button class="qty-btn" data-idx="${idx}" data-action="dec">-</button>
        <span>${item.qty}</span>
        <button class="qty-btn" data-idx="${idx}" data-action="inc">+</button>
      </div>
      <div class="cart-price">$${(item.price * item.qty).toFixed(2)}</div>
      <a href="#" class="remove-item" data-idx="${idx}">Remove</a>
    `;
    container.appendChild(div);
    total += item.price * item.qty;
  });

  totalEl.textContent = `$${total.toFixed(2)}`;
}

document.addEventListener('click', e => {
  const inc = e.target.closest('.qty-btn[data-action="inc"]');
  const dec = e.target.closest('.qty-btn[data-action="dec"]');
  const rem = e.target.closest('.remove-item');

  let cart = getCart();

  if (inc || dec || rem) {
    e.preventDefault();

    if (inc) cart[inc.dataset.idx].qty++;
    if (dec) {
      cart[dec.dataset.idx].qty--;
      if (cart[dec.dataset.idx].qty <= 0) cart.splice(dec.dataset.idx, 1);
    }
    if (rem) cart.splice(rem.dataset.idx, 1);

    saveCart(cart);
    updateCartBadge();
    renderStickyCart();
  }
});

// ====== PAGE INIT ======
document.addEventListener('DOMContentLoaded', () => {
  updateCartBadge();
  renderStickyCart();

  // Cart icon → checkout page
  const cartBtn = document.querySelector('.cart-btn');
  if (cartBtn) {
    cartBtn.addEventListener('click', () => {
      const cart = getCart();
      if (cart.length === 0) {
        alert('Your cart is empty.');
        return;
      }
      window.location.href = 'checkout.php';
    });
  }

  // Sticky cart checkout button
  const checkoutBtn = document.getElementById('checkout-btn');
  if (checkoutBtn) {
    checkoutBtn.addEventListener('click', e => {
      e.preventDefault();
      const cart = getCart();
      if (cart.length === 0) {
        alert('Your cart is empty.');
        return;
      }
      window.location.href = 'checkout.php';
    });
  }
});

// ====== CONTACT FORM ======
document.addEventListener('DOMContentLoaded', () => {
  const contactForm = document.getElementById('contact-form');
  const contactConfirm = document.getElementById('contact-confirm');

  if (contactForm) {
    contactForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      const formData = new FormData(contactForm);

      try {
        const res = await fetch('process_contact.php', {
          method: 'POST',
          body: formData
        });
        const data = await res.json();

        if (data.status === 'success') {
          if (typeof showAlert === 'function') {
            showAlert('Thank you! Your message has been sent successfully.', 'success');
          } else {
            contactConfirm.hidden = false;
            contactConfirm.innerHTML = `<strong>Thank you!</strong> Your message has been sent successfully.`;
          }
          contactForm.reset();
        } else {
          if (typeof showAlert === 'function') {
            showAlert('Error: ' + (data.message || 'Unknown issue.'), 'error');
          } else {
            alert('Error: ' + (data.message || 'Unknown issue.'));
          }
        }
      } catch (err) {
        console.error('Contact form error:', err);
        if (typeof showAlert === 'function') {
          showAlert('Server error — please check your PHP or database connection.', 'error');
        } else {
          alert('Server error — please check your PHP connection.');
        }
      }
    });
  }
});

// ====== MENU FILTER TABS ======
document.addEventListener('DOMContentLoaded', () => {
  const tabs = document.querySelectorAll('.tab');
  const cards = document.querySelectorAll('.menu-card');

  if (!tabs.length || !cards.length) return;

  function show(category) {
    cards.forEach(card => {
      const match = category === 'all' || card.dataset.category === category;
      card.style.display = match ? 'block' : 'none';
    });
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      show(tab.dataset.category);
    });
  });

  // Show all by default
  show('all');
});

// ====== JQUERY ANIMATIONS FOR ALL PAGES ======
$(document).ready(function() {
    // ====== ALERT MESSAGE SYSTEM ======
    window.showAlert = function(message, type = 'info') {
      const alertTypes = {
        'success': { bg: '#e9f7ef', color: '#064e3b', border: '#c7eed8', icon: '✓' },
        'error': { bg: '#ffefeb', color: '#e84c3d', border: '#ffd7cc', icon: '✕' },
        'info': { bg: '#e6f3ff', color: '#0066cc', border: '#b3d9ff', icon: 'ℹ' },
        'warning': { bg: '#fff7e6', color: '#cc6600', border: '#ffd699', icon: '⚠' }
      };
      
      const alertStyle = alertTypes[type] || alertTypes.info;
      const alertId = 'alert-' + Date.now();
      const alertHtml = `
        <div id="${alertId}" class="custom-alert" style="
          background: ${alertStyle.bg};
          color: ${alertStyle.color};
          border: 1px solid ${alertStyle.border};
          padding: 14px 32px 14px 14px;
          border-radius: 8px;
          margin: 8px auto 12px auto;
          max-width: 520px;
          position: relative;
          box-shadow: 0 2px 8px rgba(0,0,0,0.1);
          opacity: 0;
          transform: translateY(-10px);
        ">
          <button class="close-alert" style="
            position: absolute;
            top: 10px;
            right: 10px;
            background: none;
            border: none;
            font-size: 1.5em;
            color: ${alertStyle.color};
            opacity: 0.70;
            line-height: 1;
            cursor: pointer;
            padding: 0;
            width: 24px;
            height: 24px;
          ">&times;</button>
          <strong style="margin-right: 8px;">${alertStyle.icon}</strong>${message}
        </div>
      `;
      
      // Insert at top of page or in a specific container
      const $container = $('.container').first() || $('body');
      $container.prepend(alertHtml);
      
      const $alert = $('#' + alertId);
      $alert.animate({
        opacity: 1,
        marginTop: '+=10'
      }, 300);
      
      // Auto-hide after 5 seconds
      setTimeout(() => {
        $alert.fadeOut(300, function() {
          $(this).remove();
        });
      }, 5000);
      
      return alertId;
    };

    // Smooth close/dismiss for all alerts
    $(document).on('click', '.close-alert, .alert-error .close-alert', function() {
      $(this).closest('.custom-alert, .alert-error').fadeOut(300, function() {
        $(this).remove();
      });
    });

    // ====== SMOOTH DETAILS/SUMMARY TOGGLE ANIMATIONS ======
    function initDetailsToggle() {
      $('details').each(function() {
        const $details = $(this);
        
        // Skip if already initialized
        if ($details.data('toggle-initialized')) return;
        $details.data('toggle-initialized', true);
        
        const summary = this.querySelector('summary');
        if (!summary) return;
        
        // Find all direct children except summary
        let $content = $();
        this.childNodes.forEach(function(node) {
          if (node !== summary && (node.nodeType === 1 || (node.nodeType === 3 && node.textContent.trim()))) {
            $content = $content.add(node);
          }
        });
        
        // Wrap content if not already wrapped
        if ($content.length > 0 && !$details.find('.details-content').length) {
          const $wrapper = $('<div class="details-content"></div>');
          $content.wrapAll($wrapper);
        }
        
        // Initialize: hide if closed
        const $wrapper = $details.find('.details-content');
        if (!this.open && $wrapper.length) {
          $wrapper.hide();
        }
        
        // Listen for native toggle event
        $details.on('toggle', function() {
          const $w = $(this).find('.details-content');
          if (this.open) {
            $w.stop(true, true).slideDown(300);
          } else {
            $w.stop(true, true).slideUp(300);
          }
        });
      });
    }
    
    // Initialize on page load
    initDetailsToggle();

    // ====== RESERVATIONS PAGE ANIMATIONS ======
    if ($('#reservation-form').length) {
      // Form fields fade in on focus
      $('#reservation-form input, #reservation-form select, #reservation-form textarea').on('focus', function() {
        $(this).css('transform', 'scale(1.02)').css('transition', 'transform 0.2s');
      }).on('blur', function() {
        $(this).css('transform', 'scale(1)');
      });

      // Confirmation message animation
      const $confirm = $('#reservation-confirm');
      if ($confirm.length) {
        $confirm.css('opacity', '0').css('transform', 'translateY(-10px)');
        // Show with animation when reservation is successful
        if (!$confirm.attr('hidden')) {
          $confirm.animate({
            opacity: 1,
            marginTop: '+=10'
          }, 400);
        }
      }
    }

    // ====== MENU PAGE ANIMATIONS ======
    if ($('.menu-card').length) {
      // Animate menu cards on page load
      $('.menu-card').each(function(index) {
        $(this).css('opacity', '0').css('transform', 'translateY(20px)');
        setTimeout(() => {
          $(this).animate({
            opacity: 1
          }, 400).css('transform', 'translateY(0)');
        }, index * 50);
      });

      // Smooth tab switching with fade
      $('.tab').on('click', function() {
        const category = $(this).data('category');
        const $cards = $('.menu-card');
        
        $cards.fadeOut(200, function() {
          $cards.each(function() {
            if (category === 'all' || $(this).data('category') === category) {
              $(this).fadeIn(300);
            }
          });
        });
      });

      // Add to cart button animation
      $(document).on('click', '.add-cart-btn', function() {
        $(this).css('transform', 'scale(0.95)');
        setTimeout(() => {
          $(this).css('transform', 'scale(1)');
        }, 150);
      });
    }

    // ====== CONTACT PAGE ANIMATIONS ======
    if ($('#contact-form').length) {
      // Form sections slide in
      $('#contact-form').find('label, input, select, textarea, button').each(function(index) {
        $(this).css('opacity', '0').css('transform', 'translateX(-20px)');
        setTimeout(() => {
          $(this).animate({
            opacity: 1
          }, 300).css('transform', 'translateX(0)');
        }, index * 30);
      });

      // Confirmation message fade in
      const $contactConfirm = $('#contact-confirm');
      if ($contactConfirm.length) {
        $contactConfirm.css('transition', 'all 0.4s ease');
        if (!$contactConfirm.attr('hidden')) {
          $contactConfirm.animate({
            opacity: 1,
            marginTop: '+=10'
          }, 400);
        }
      }
    }

    // ====== ABOUT PAGE ANIMATIONS ======
    if ($('.team-card, .dish-card').length) {
      // Animate cards on scroll
      function animateOnScroll() {
        $('.team-card, .dish-card').each(function() {
          const $card = $(this);
          const cardTop = $card.offset().top;
          const windowBottom = $(window).scrollTop() + $(window).height();
          
          if (cardTop < windowBottom - 100 && !$card.hasClass('animated')) {
            $card.addClass('animated').css('opacity', '0').css('transform', 'translateY(30px)')
              .animate({
                opacity: 1
              }, 500).css('transform', 'translateY(0)');
          }
        });
      }

      $(window).on('scroll', animateOnScroll);
      animateOnScroll(); // Run on load
    }

    // ====== SMOOTH SCROLL TO SECTIONS ======
    $('a[href^="#"]').on('click', function(e) {
      const target = $(this.getAttribute('href'));
      if (target.length) {
        e.preventDefault();
        $('html, body').animate({
          scrollTop: target.offset().top - 80
        }, 600);
      }
    });

    // ====== FADE IN PAGE SECTIONS ======
    $('.featured, .our-story, .menu-section').each(function(index) {
      $(this).css('opacity', '0');
      setTimeout(() => {
        $(this).animate({ opacity: 1 }, 600);
      }, index * 200);
    });

    // ====== TOGGLE INFO PANEL ======
    $('.toggle-info').on('click', function() {
      $('.info-panel').slideToggle(300);
    });
});