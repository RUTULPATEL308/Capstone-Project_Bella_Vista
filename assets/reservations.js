document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("reservation-form");
  const confirmBox = document.getElementById("reservation-confirm");

  if (!form) return;

  form.addEventListener("submit", async e => {
    e.preventDefault();

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
