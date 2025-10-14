// Bella Vista scripts
// Smooth scroll for nav links
const navLinks = document.querySelectorAll('.nav-link');
navLinks.forEach(link => {
  link.addEventListener('click', function(e) {
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      e.preventDefault();
      target.scrollIntoView({ behavior: 'smooth' });
    }
  });
});
// Cart badge updating (demo)
let cartCount = 3;
document.querySelectorAll('.add-cart-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    cartCount++;
    document.querySelector('.cart-badge').innerText = cartCount;
    btn.innerText = 'Added!';
    setTimeout(() => {
      btn.innerText = 'Add to Cart';
    }, 1200);
  });
});
// Hero and Reserve buttons demo actions
document.querySelectorAll('.primary-btn, .reserve-btn, .menu-btn, .learn-more-btn, .secondary-btn').forEach(btn => {
  btn.addEventListener('click', function() {
    btn.blur();
  });
});
