document.addEventListener("DOMContentLoaded", () => {
  const cartContainer = document.getElementById("checkout-cart");
  if (!cartContainer) {
    console.warn("checkout-cart not found — skipping cart rendering");
    return; // stops script if this page doesn’t have the cart section
  }

  const subtotalEl = document.getElementById("subtotal");
  const taxEl = document.getElementById("tax");
  const totalEl = document.getElementById("grand-total");
  const checkoutForm = document.getElementById("checkout-form");

  let cart = JSON.parse(localStorage.getItem("cart")) || [];

  function updateTotals() {
    const subtotal = cart.reduce((s, i) => s + i.price * i.qty, 0);
    const tax = subtotal * 0.13;
    const total = subtotal + tax;
    if (subtotalEl && taxEl && totalEl) {
      subtotalEl.textContent = `$${subtotal.toFixed(2)}`;
      taxEl.textContent = `$${tax.toFixed(2)}`;
      totalEl.textContent = `$${total.toFixed(2)}`;
    }
    return { subtotal, tax, total };
  }

  function updateCartItem(index, newQty) {
    if (newQty <= 0) {
      cart.splice(index, 1);
    } else {
      cart[index].qty = newQty;
    }
    localStorage.setItem("cart", JSON.stringify(cart));
    renderCart();
    // Update cart badge if function exists
    if (typeof updateCartBadge === 'function') {
      updateCartBadge();
    }
  }

  function renderCart() {
    if (!cartContainer) return;
    if (!cart.length) {
      cartContainer.innerHTML = "<p>Your cart is empty.</p>";
      updateTotals();
      return;
    }

    cartContainer.innerHTML = `
      <div class="cart-header">
        <div class="cart-col name">Item</div>
        <div class="cart-col qty" style="text-align:center;">Quantity</div>
        <div class="cart-col price" style="text-align:right;">Price</div>
        <div class="cart-col action" style="text-align:center;width:30px;"></div>
      </div>
      ${cart.map((item, index) => `
        <div class="cart-row checkout-item-row" data-index="${index}">
          <div class="cart-item-name">${item.name}</div>
          <div class="cart-item-qty">
            <button class="qty-btn-minus" data-index="${index}" type="button" aria-label="Decrease quantity">−</button>
            <span class="qty-value">${item.qty}</span>
            <button class="qty-btn-plus" data-index="${index}" type="button" aria-label="Increase quantity">+</button>
          </div>
          <div class="cart-item-price">$${(item.price * item.qty).toFixed(2)}</div>
          <div class="cart-item-remove">
            <button class="remove-item-btn" data-index="${index}" type="button" aria-label="Remove item" title="Remove">×</button>
          </div>
        </div>
      `).join("")}
    `;
    updateTotals();
    
    // Attach event listeners
    cartContainer.querySelectorAll('.qty-btn-plus').forEach(btn => {
      btn.addEventListener('click', function() {
        const index = parseInt(this.dataset.index);
        updateCartItem(index, cart[index].qty + 1);
      });
    });
    
    cartContainer.querySelectorAll('.qty-btn-minus').forEach(btn => {
      btn.addEventListener('click', function() {
        const index = parseInt(this.dataset.index);
        updateCartItem(index, cart[index].qty - 1);
      });
    });
    
    cartContainer.querySelectorAll('.remove-item-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const index = parseInt(this.dataset.index);
        if (confirm(`Remove ${cart[index].name} from cart?`)) {
          updateCartItem(index, 0);
        }
      });
    });
  }

  renderCart();

  if (checkoutForm) {
    checkoutForm.addEventListener("submit", async e => {
      e.preventDefault();
      if (!cart.length) {
        if (typeof showAlert === 'function') {
          showAlert("Your cart is empty! Please add items before checkout.", 'warning');
        } else {
          alert("Your cart is empty!");
        }
        return;
      }

      const totals = updateTotals();

      const payload = {
        name: checkoutForm.name.value,
        email: checkoutForm.email.value,
        phone: checkoutForm.phone.value,
        method: checkoutForm.pickup.value,
        payment: checkoutForm.payment.value,
        notes: checkoutForm.notes.value,
        items: cart,
        subtotal: totals.subtotal,
        tax: totals.tax,
        total: totals.total
      };

      try {
        const res = await fetch("process_order.php", {
          method: "POST",
          headers: { "Content-Type": "application/json" },
          body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (data.status === "success") {
          localStorage.removeItem("cart");
          cart = [];
          if (typeof showAlert === 'function') {
            showAlert(`Order #${data.order_id} placed successfully! Total: $${data.total.toFixed(2)}`, 'success');
          } else {
            const confirmBox = document.getElementById("order-confirm");
            if (confirmBox) {
              confirmBox.innerHTML =
                `<strong>Thank you!</strong> Order #${data.order_id} placed successfully.<br>Total: $${data.total.toFixed(2)}`;
              confirmBox.hidden = false;
            }
          }
          checkoutForm.reset();
          cartContainer.innerHTML = "<p>Your cart is empty.</p>";
          updateTotals();
          // Update cart badge
          if (typeof updateCartBadge === 'function') {
            updateCartBadge();
          }
        } else {
          if (typeof showAlert === 'function') {
            showAlert("Error: " + (data.message || "Unknown error"), 'error');
          } else {
            alert("Error: " + (data.message || "Unknown error"));
          }
        }
      } catch (err) {
        console.error(err);
        if (typeof showAlert === 'function') {
          showAlert("Server error — check your PHP or database connection.", 'error');
        } else {
          alert("Server error — check your PHP or database connection.");
        }
      }
    });
  }
});
