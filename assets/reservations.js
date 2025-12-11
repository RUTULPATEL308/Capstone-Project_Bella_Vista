document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("reservation-form");
  const confirmBox = document.getElementById("reservation-confirm");

  if (!form) return;

  // Add error message containers if missing
  ["name","phone","email","date","time","guests","seating_preference","occasion","consent"].forEach(field => {
    const input = form.querySelector(`[name="${field}"]`) || document.getElementById(field);
    if (input) {
      let errorElem = document.createElement("div");
      errorElem.className = "form-error";
      errorElem.id = `${field}-error`;
      input.insertAdjacentElement("afterend", errorElem);
    }
  });

  form.addEventListener("submit", async e => {
    e.preventDefault();
    let valid = true;
    // Remove all active errors
    form.querySelectorAll('.form-error').forEach(el => el.classList.remove('active'));
    function invalidate(field, msg) {
      let err = document.getElementById(`${field}-error`);
      if (err) { err.textContent = msg; err.classList.add('active'); }
      valid = false;
    }
    if (!form.name.value.trim()) invalidate('name','Name is required.');
    if (!form.phone.value.trim()) invalidate('phone','Phone required.');
    if (form.phone.value && !/^[- +()0-9]{8,}$/.test(form.phone.value)) invalidate('phone','Phone looks invalid.');
    const emailValue = form.email.value.trim();
    if (!emailValue) invalidate('email','Email is required.');
    else if (!/^\S+@\S+\.\S+$/.test(emailValue)) invalidate('email','Enter a valid email.');
    if (!form.date.value) invalidate('date','Date required.');
    if (!form.time.value) invalidate('time','Time required.');
    if (!form.guests.value) invalidate('guests','Please select guests.');
    if (!form.seating_preference.value) invalidate('seating_preference','Please choose seating.');
    if (!form.occasion.value) invalidate('occasion','Choose occasion.');
    if (!form['consent'].checked) invalidate('consent','You must agree to reservation policy.');
    if (!valid) return;

    const formData = new FormData(form);

    try {
      const res = await fetch("process_reservation.php", {
        method: "POST",
        body: formData
      });

      const data = await res.json();
      if (data.status === "success") {
        if (typeof showAlert === 'function') {
          showAlert(`Reservation Confirmed! Your reservation ID: ${data.reservation_id}`, 'success');
        } else {
          confirmBox.hidden = false;
          confirmBox.innerHTML = `
            <strong>Reservation Confirmed!</strong><br>
            Your reservation ID: ${data.reservation_id}
          `;
        }
        form.reset();
      } else {
        if (typeof showAlert === 'function') {
          showAlert("Error: " + (data.message || "Reservation failed."), 'error');
        } else {
          alert("Error: " + (data.message || "Reservation failed."));
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
});
