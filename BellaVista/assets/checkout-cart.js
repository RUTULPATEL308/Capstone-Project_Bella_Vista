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
        <div class="cart-col qty" style="text-align:center;">Qty</div>
        <div class="cart-col price" style="text-align:right;">Price</div>
      </div>
      ${cart.map(i => `
        <div class="cart-row" style="display:grid;grid-template-columns:2fr 1fr 1fr;">
          <div>${i.name}</div>
          <div style="text-align:center;">${i.qty}</div>
          <div style="text-align:right;">$${(i.price * i.qty).toFixed(2)}</div>
        </div>`).join("")}
    `;
    updateTotals();
  }

  renderCart();

  if (checkoutForm) {
    checkoutForm.addEventListener("submit", async e => {
      e.preventDefault();
      if (!cart.length) {
        alert("Your cart is empty!");
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
          const confirmBox = document.getElementById("order-confirm");
          if (confirmBox) {
            confirmBox.innerHTML =
              `<strong>Thank you!</strong> Order #${data.order_id} placed successfully.<br>Total: $${data.total.toFixed(2)}`;
            confirmBox.hidden = false;
          }
          checkoutForm.reset();
          cartContainer.innerHTML = "<p>Your cart is empty.</p>";
          updateTotals();
        } else {
          alert("Error: " + (data.message || "Unknown error"));
        }
      } catch (err) {
        console.error(err);
        alert("Server error — check your PHP or database connection.");
      }
    });
  }
});
