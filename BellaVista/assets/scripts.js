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
          contactConfirm.hidden = false;
          contactConfirm.innerHTML = `<strong>Thank you!</strong> Your message has been sent successfully.`;
          contactForm.reset();
        } else {
          alert('Error: ' + (data.message || 'Unknown issue.'));
        }
      } catch (err) {
        console.error('Contact form error:', err);
        alert('Server error — please check your PHP connection.');
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
