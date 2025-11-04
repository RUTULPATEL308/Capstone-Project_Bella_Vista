let cartCount = 0;
function updateCartBadges() {
  document.querySelectorAll('.cart-badge').forEach(b => b.innerText = cartCount);
}
document.addEventListener('click', function(e) {
  if (e.target && e.target.classList.contains('add-cart-btn')) {
    const btn = e.target;
    const price = parseFloat(btn.dataset.price || 0);
    const name = btn.dataset.name || 'Item';
    cartCount++;
    updateCartBadges();
    btn.outerHTML = `
  <div class="added-controls" style="display:inline-flex;align-items:center;gap:8px;">
    <button class="add-cart-btn added" disabled>Added</button>
    <a href="#" class="remove-item" data-name="${name}" style="font-size:14px;color:#d32f2f;text-decoration:underline;">Remove</a>
  </div>
`;
    if (document.body.contains(document.getElementById('cart-items'))) {
      addToCartPanel(name, price);
    }
  }
});

document.addEventListener('click', e => {
  if (e.target && e.target.classList.contains('remove-item')) {
    e.preventDefault();
    const name = e.target.dataset.name;
    let cart = JSON.parse(localStorage.getItem('cart')) || [];
    cart = cart.filter(i => i.name !== name);
    localStorage.setItem('cart', JSON.stringify(cart));

    // Restore button appearance
    const wrapper = e.target.closest('.added-controls');
    if (wrapper) {
      wrapper.outerHTML = `<button class="add-cart-btn" data-name="${name}" data-price="${0}">Add to Cart</button>`;
    }

    renderSavedCart();
  }
});

function addToCartPanel(name, price) {
  const list = document.getElementById('cart-items');
  let cart = JSON.parse(localStorage.getItem('cart')) || [];

  const existing = cart.find(item => item.name === name);
  if (existing) {
    existing.qty++;
  } else {
    cart.push({ name, price, qty: 1 });
  }

  localStorage.setItem('cart', JSON.stringify(cart));

  // Re-render
  list.innerHTML = '';
  let total = 0;

  cart.forEach(item => {
    const row = document.createElement('div');
    row.className = 'cart-row';
    row.innerHTML = `
      <div class="cart-name">${item.name}</div>
      <div class="cart-qty">
        <button class="qty-btn decrease" data-name="${item.name}">-</button>
        <span class="qty-value">${item.qty}</span>
        <button class="qty-btn increase" data-name="${item.name}">+</button>
      </div>
      <div class="cart-price">$${(item.price * item.qty).toFixed(2)}</div>
      <a href="#" class="remove-item" data-name="${item.name}">Remove</a>
    `;
    list.appendChild(row);
    total += item.price * item.qty;
  });

  document.getElementById('cart-total').innerText = total.toFixed(2);
  cartCount = cart.reduce((sum, i) => sum + i.qty, 0);
  updateCartBadges();
}


function renderSavedCart() {
  const cart = JSON.parse(localStorage.getItem('cart')) || [];
  const list = document.getElementById('cart-items');
  if (!list) return;
  list.innerHTML = '';

  let total = 0;

  cart.forEach(item => {
    const row = document.createElement('div');
    row.className = 'cart-row';
    row.innerHTML = `
      <div class="cart-name">${item.name}</div>
      <div class="cart-qty">
        <button class="qty-btn decrease" data-name="${item.name}">-</button>
        <span class="qty-value">${item.qty}</span>
        <button class="qty-btn increase" data-name="${item.name}">+</button>
      </div>
      <div class="cart-price">$${(item.price * item.qty).toFixed(2)}</div>
      <a href="#" class="remove-item" data-name="${item.name}">Remove</a>
    `;
    list.appendChild(row);
    total += item.price * item.qty;
  });

  document.getElementById('cart-total').innerText = total.toFixed(2);
  cartCount = cart.reduce((sum, i) => sum + i.qty, 0);
  updateCartBadges();
}

document.addEventListener('click', e => {
  let cart = JSON.parse(localStorage.getItem('cart')) || [];

  // Increase quantity
  if (e.target.classList.contains('increase')) {
    const name = e.target.dataset.name;
    const item = cart.find(i => i.name === name);
    if (item) item.qty++;
    localStorage.setItem('cart', JSON.stringify(cart));
    renderSavedCart();
  }

  // Decrease quantity
  if (e.target.classList.contains('decrease')) {
    const name = e.target.dataset.name;
    const item = cart.find(i => i.name === name);
    if (item) {
      item.qty = Math.max(1, item.qty - 1);
    }
    localStorage.setItem('cart', JSON.stringify(cart));
    renderSavedCart();
  }

  // Remove item
  if (e.target.classList.contains('remove-item')) {
    e.preventDefault();
    const name = e.target.dataset.name;
    cart = cart.filter(i => i.name !== name);
    localStorage.setItem('cart', JSON.stringify(cart));
    renderSavedCart();
  }
});

function calculateCartTotal() {
  const rows = document.querySelectorAll('#cart-items .cart-row');
  let total = 0;
  rows.forEach(r => {
    const text = r.innerText.trim();
    const parts = text.split('$');
    const value = parseFloat(parts[parts.length-1]) || 0;
    total += value;
  });
  return total;
}

document.addEventListener('DOMContentLoaded', function() {
  const path = window.location.pathname.split('/').pop() || 'index.html';
  document.querySelectorAll('.nav-link').forEach(link => {
    const href = link.getAttribute('href');
    if (href === path || (path === '' && href === 'index.html')) {
      link.classList.add('active');
    } else {
      link.classList.remove('active');
    }
  });

  updateCartBadges();
  renderSavedCart();

  const reservationForm = document.getElementById('reservation-form');
  if (reservationForm) {
    reservationForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const name = document.getElementById('name').value.trim();
      const date = document.getElementById('date').value;
      const time = document.getElementById('time').value;
      const guests = document.getElementById('guests').value;
      const confirm = document.getElementById('reservation-confirm');
      confirm.hidden = false;
      confirm.innerHTML = `<strong>Reservation requested</strong><div>Thanks ${name}. We requested a table for ${guests} on ${date} at ${time}. We will call or email to confirm availability.</div>`;
      reservationForm.reset();
    });
  }

  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    contactForm.addEventListener('submit', function(e) {
      e.preventDefault();
      const name = document.getElementById('c-name').value.trim();
      const confirm = document.getElementById('contact-confirm');
      confirm.hidden = false;
      confirm.innerHTML = `<strong>Message sent</strong><div>Thanks ${name}. We will get back to you within one business day.</div>`;
      contactForm.reset();
    });
  }
});


// FILTER TABS
const tabs = document.querySelectorAll('.tab');
const cards = document.querySelectorAll('.menu-card');

tabs.forEach(tab => {
  tab.addEventListener('click', () => {
    tabs.forEach(t => t.classList.remove('active'));
    tab.classList.add('active');

    const category = tab.dataset.category;

    cards.forEach(card => {
      if (category === "all" || card.dataset.category === category) {
        card.style.display = "block";
      } else {
        card.style.display = "none";
      }
    });
  });
});

// LIGHTBOX
const lightbox = document.getElementById("lightbox");
const lightboxImg = document.getElementById("lightbox-img");

document.querySelectorAll(".lightbox-img").forEach(img => {
  img.addEventListener("click", () => {
    lightbox.style.display = "flex";
    lightboxImg.src = img.src;
  });
});

lightbox.addEventListener("click", () => {
  lightbox.style.display = "none";
});

// SIMPLE CART
let total = 0;
const cartTotal = document.getElementById("cart-total");
const cartItems = document.getElementById("cart-items");

document.querySelectorAll(".add-cart-btn").forEach(btn => {
  btn.addEventListener("click", e => {
    const card = e.target.closest(".menu-card");
    const name = card.querySelector("h4").innerText;
    const price = parseFloat(card.querySelector(".price").innerText.replace("$",""));

    const item = document.createElement("div");
    item.classList.add("cart-row");
    item.innerHTML = `<p>${name}</p><span>$${price.toFixed(2)}</span>`;
    cartItems.appendChild(item);

    total += price;
    cartTotal.innerText = `$${total.toFixed(2)}`;
  });
});

window.addEventListener("DOMContentLoaded", () => {
  const cartButton = document.querySelector(".cart-btn");
  const checkoutButtons = document.querySelectorAll(".checkout-btn");

  function goToCheckout() {
    const cart = JSON.parse(localStorage.getItem("cart")) || [];
    if (cart.length === 0) {
      console.warn("Cart is empty or not found, redirecting anyway");
    } else {
      console.log("Cart found:", cart);
    }
    window.location.href = "checkout.html";
  }

  if (cartButton) {
    cartButton.addEventListener("click", goToCheckout);
  }

  checkoutButtons.forEach(btn => {
    btn.addEventListener("click", goToCheckout);
  });

  // Restore cart badge count from localStorage when the page loads
  const savedCart = JSON.parse(localStorage.getItem("cart")) || [];
  cartCount = savedCart.reduce((sum, i) => sum + (i.qty || 1), 0);
  updateCartBadges();
});
