<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
include '../db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reservations Management</title>
    <link rel="stylesheet" href="assets/admin.css">
    <link rel="stylesheet" href="../assets/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="assets/admin.js"></script>
    <style>
      .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); overflow-y: auto; }
      .modal-content { background: #fff; margin: 3% auto; padding: 30px; border-radius: 12px; width: 90%; max-width: 700px; max-height: 90vh; overflow-y: auto; position: relative; }
      .form-group { margin-bottom: 16px; }
      .form-group label { display: block; margin-bottom: 6px; font-weight: 600; }
      .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1.8px solid #d0d7e2; border-radius: 7px; box-sizing: border-box; }
      .btn-group { display: flex; gap: 10px; margin-top: 20px; }
      .status-badge { padding: 4px 12px; border-radius: 12px; font-size: 0.85em; font-weight: 600; display: inline-block; }
      .status-pending { background: #fff3cd; color: #856404; }
      .status-confirmed { background: #d4edda; color: #155724; }
      .status-cancelled { background: #f8d7da; color: #721c24; }
      .status-completed { background: #d1ecf1; color: #0c5460; }
      .action-btns { display: flex; gap: 6px; flex-wrap: wrap; }
      .action-btns button { 
        padding: 8px 16px; 
        border: none; 
        border-radius: 6px; 
        cursor: pointer; 
        font-size: 0.9em; 
        font-weight: 600; 
        min-height: 36px;
        min-width: 80px;
        transition: all 0.2s;
      }
      .btn-view { background: #007bff; color: #fff; }
      .btn-edit { background: #ff8500; color: #fff; }
      .btn-delete { background: #e84c3d; color: #fff; }
      .btn-confirm { background: #28a745; color: #fff; }
      .btn-cancel { background: #dc3545; color: #fff; }
      .btn-view:hover { background: #0056b3; }
      .btn-edit:hover { background: #e37400; }
      .btn-delete:hover { background: #c9302c; }
      .btn-confirm:hover { background: #218838; }
      .btn-cancel:hover { background: #c82333; }
      .filter-bar { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
      .filter-bar select, .filter-bar input { padding: 8px 12px; border: 1.8px solid #d0d7e2; border-radius: 6px; }
    </style>
</head>
<body>
<div class="admin-shell">
  <aside class="admin-sidebar">
    <h1>BellaVista</h1>
    <nav>
      <a href="index.php">Dashboard</a>
      <a href="analytics.php">Analytics</a>
      <a href="users.php">Users</a>
      <a href="reservations.php">Reservations</a>
      <a href="menu.php">Menu</a>
      <a href="contact_messages.php">Contact Messages</a>
      <a href="profile.php">Profile</a>
      <a class="bottom-link" href="settings.php">Settings</a>
      <a class="bottom-link" href="logout.php">Logout</a>
    </nav>
  </aside>
  <main class="admin-main">
    <div class="admin-topbar">
      <div class="topbar-title">Reservations Management</div>
      <div class="topbar-actions">
        <button class="topbar-btn js-toggle-theme" title="Toggle dark mode">🌓</button>
      </div>
    </div>
    <div class="page-container">
      <div class="featured-header">
        <h2>Reservations</h2>
        <p>Manage all restaurant reservations, confirm bookings, and track customer requests.</p>
      </div>
      
      <!-- Filter Bar -->
      <div class="filter-bar">
        <select id="filterStatus">
          <option value="">All Statuses</option>
          <option value="pending">Pending</option>
          <option value="confirmed">Confirmed</option>
          <option value="cancelled">Cancelled</option>
          <option value="completed">Completed</option>
        </select>
        <input type="date" id="filterDate" placeholder="Filter by date">
        <input type="text" id="filterSearch" placeholder="Search by name, email, phone...">
        <button onclick="clearFilters()" style="padding: 8px 16px; background: #6c757d; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; min-height: 36px;">Clear Filters</button>
      </div>

      <div class="card">
        <table id="resTable" class="display" style="width:100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Contact</th>
              <th>Date</th>
              <th>Time</th>
              <th>Guests</th>
              <th>Seating</th>
              <th>Status</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $result = $conn->query('SELECT id, name, email, phone, guests, date, time, seating_preference, occasion, notes, created_at FROM reservations ORDER BY date DESC, time DESC LIMIT 200');
            if ($result) { 
              while ($row = $result->fetch_assoc()) {
                // Default status to pending if not set (you can add status column later)
                $status = 'pending';
                if (!empty($row['notes']) && strpos(strtolower($row['notes']), 'confirmed') !== false) $status = 'confirmed';
                if (!empty($row['notes']) && strpos(strtolower($row['notes']), 'cancelled') !== false) $status = 'cancelled';
                if (!empty($row['notes']) && strpos(strtolower($row['notes']), 'completed') !== false) $status = 'completed';
                
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']) . '<br><small>' . htmlspecialchars($row['phone']) . '</small></td>';
                echo '<td>' . date('M j, Y', strtotime($row['date'])) . '</td>';
                echo '<td>' . date('g:i A', strtotime($row['time'])) . '</td>';
                echo '<td>' . htmlspecialchars($row['guests']) . '</td>';
                echo '<td>' . htmlspecialchars(ucfirst($row['seating_preference'])) . '</td>';
                echo '<td><span class="status-badge status-' . $status . '">' . ucfirst($status) . '</span></td>';
                echo '<td class="action-btns">';
                echo '<button class="btn-view" onclick="viewReservation(' . $row['id'] . ')">View</button>';
                echo '<button class="btn-edit" onclick="editReservation(' . $row['id'] . ')">Edit</button>';
                echo '<button class="btn-confirm" onclick="confirmReservation(' . $row['id'] . ')">Confirm</button>';
                echo '<button class="btn-cancel" onclick="cancelReservation(' . $row['id'] . ')">Cancel</button>';
                echo '<button class="btn-delete" onclick="deleteReservation(' . $row['id'] . ')">Delete</button>';
                echo '</td>';
                echo '</tr>';
              }
            } 
            ?>
          </tbody>
        </table>
      </div>
    </div>
  </main>
</div>

<!-- View/Edit Modal -->
<div id="reservationModal" class="modal">
  <div class="modal-content">
    <h2 id="modalTitle">View Reservation</h2>
    <form id="reservationForm">
      <input type="hidden" id="reservation_id" name="id">
      
      <div class="form-group">
        <label>Full Name *</label>
        <input type="text" id="res_name" name="name" required>
      </div>
      
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
        <div class="form-group">
          <label>Email *</label>
          <input type="email" id="res_email" name="email" required>
        </div>
        <div class="form-group">
          <label>Phone *</label>
          <input type="tel" id="res_phone" name="phone" required>
        </div>
      </div>
      
      <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 12px;">
        <div class="form-group">
          <label>Date *</label>
          <input type="date" id="res_date" name="date" required>
        </div>
        <div class="form-group">
          <label>Time *</label>
          <input type="time" id="res_time" name="time" required>
        </div>
        <div class="form-group">
          <label>Guests *</label>
          <input type="number" id="res_guests" name="guests" min="1" max="20" required>
        </div>
      </div>
      
      <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 12px;">
        <div class="form-group">
          <label>Seating Preference</label>
          <select id="res_seating" name="seating_preference">
            <option value="no preference">No Preference</option>
            <option value="dining">Dining</option>
            <option value="bar">Bar</option>
            <option value="patio">Patio</option>
          </select>
        </div>
        <div class="form-group">
          <label>Occasion</label>
          <select id="res_occasion" name="occasion">
            <option value="none">None</option>
            <option value="birthday">Birthday</option>
            <option value="anniversary">Anniversary</option>
            <option value="business">Business</option>
          </select>
        </div>
      </div>
      
      <div class="form-group">
        <label>Notes / Special Requests</label>
        <textarea id="res_notes" name="notes" rows="4"></textarea>
      </div>
      
      <div class="form-group">
        <label>Status</label>
        <select id="res_status" name="status">
          <option value="pending">Pending</option>
          <option value="confirmed">Confirmed</option>
          <option value="cancelled">Cancelled</option>
          <option value="completed">Completed</option>
        </select>
      </div>
      
      <div class="btn-group">
        <button type="submit" style="flex:1;background:linear-gradient(90deg,#ff8500 0,#ffb066 100%);color:#fff;border:none;padding:12px 24px;border-radius:8px;font-weight:600;cursor:pointer;min-height:44px;transition:all 0.2s;">Save Changes</button>
        <button type="button" onclick="closeModal()" style="flex:1;background:#ccc;color:#333;border:none;padding:12px 24px;border-radius:8px;font-weight:600;cursor:pointer;min-height:44px;transition:all 0.2s;">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
let reservationTable;

$(document).ready(function(){
  reservationTable = $('#resTable').DataTable({
    pageLength: 15,
    lengthChange: true,
    order: [[3, 'desc'], [4, 'desc']], // Sort by date, then time
    columnDefs: [
      { orderable: false, targets: [8] } // Disable sorting on Actions column
    ]
  });
  
  // Filter by status
  $('#filterStatus').on('change', function() {
    reservationTable.column(7).search(this.value).draw();
  });
  
  // Filter by date
  $('#filterDate').on('change', function() {
    if (this.value) {
      const filterDate = new Date(this.value).toLocaleDateString('en-US', {year: 'numeric', month: 'short', day: 'numeric'});
      reservationTable.column(3).search(filterDate).draw();
    } else {
      reservationTable.column(3).search('').draw();
    }
  });
  
  // Global search
  $('#filterSearch').on('keyup', function() {
    reservationTable.search(this.value).draw();
  });
  
  // Form submit
  $('#reservationForm').on('submit', function(e) {
    e.preventDefault();
    saveReservation();
  });
});

function clearFilters() {
  $('#filterStatus').val('');
  $('#filterDate').val('');
  $('#filterSearch').val('');
  reservationTable.search('').columns().search('').draw();
}

function viewReservation(id) {
  if (!id) {
    alert('Invalid reservation ID');
    return;
  }
  
  $.ajax({
    url: 'process_reservation.php',
    method: 'GET',
    dataType: 'json',
    data: { action: 'get', id: id },
    success: function(data) {
      // With dataType: 'json', jQuery automatically parses
      if (data.status === 'success' && data.reservation) {
          const r = data.reservation;
          $('#reservation_id').val(r.id);
          $('#res_name').val(r.name || '');
          $('#res_email').val(r.email || '');
          $('#res_phone').val(r.phone || '');
          $('#res_date').val(r.date || '');
          $('#res_time').val(r.time || '');
          $('#res_guests').val(r.guests || 1);
          $('#res_seating').val(r.seating_preference || 'no preference');
          $('#res_occasion').val(r.occasion || 'none');
          $('#res_notes').val(r.notes || '');
          
          // Extract status from notes if exists
          let status = 'pending';
          if (r.notes) {
            if (r.notes.toLowerCase().includes('confirmed')) status = 'confirmed';
            else if (r.notes.toLowerCase().includes('cancelled')) status = 'cancelled';
            else if (r.notes.toLowerCase().includes('completed')) status = 'completed';
          }
          $('#res_status').val(status);
          
          $('#modalTitle').text('View Reservation #' + r.id);
          $('#reservationModal').fadeIn(300);
          $('html, body').css('overflow', 'hidden');
        } else {
          alert(data.message || 'Failed to load reservation');
        }
    },
    error: function(xhr, status, error) {
      console.error('AJAX error:', status, error);
      console.error('Response:', xhr.responseText);
      let errorMsg = 'Error loading reservation. ';
      if (status === 'parsererror') {
        errorMsg += 'Server returned invalid JSON. Please check PHP error logs.';
      } else {
        errorMsg += error || 'Unknown error occurred.';
      }
      alert(errorMsg);
    }
  });
}

function editReservation(id) {
  viewReservation(id);
  $('#modalTitle').text('Edit Reservation #' + id);
}

function saveReservation() {
  const formData = {
    action: 'update',
    id: $('#reservation_id').val(),
    name: $('#res_name').val(),
    email: $('#res_email').val(),
    phone: $('#res_phone').val(),
    date: $('#res_date').val(),
    time: $('#res_time').val(),
    guests: $('#res_guests').val(),
    seating_preference: $('#res_seating').val(),
    occasion: $('#res_occasion').val(),
    notes: $('#res_notes').val(),
    status: $('#res_status').val()
  };
  
  // Add status to notes
  if (formData.status !== 'pending') {
    const statusNote = '[Status: ' + formData.status.toUpperCase() + ']';
    if (!formData.notes.includes(statusNote)) {
      formData.notes = statusNote + ' ' + formData.notes;
    }
  }
  
  $.ajax({
    url: 'process_reservation.php',
    method: 'POST',
    dataType: 'json',
    data: formData,
    success: function(data) {
      // With dataType: 'json', jQuery automatically parses, so data is already an object
      if (data.status === 'success') {
        if (typeof showToast === 'function') {
          showToast(data.message || 'Reservation updated successfully', true);
        } else {
          alert(data.message || 'Reservation updated successfully');
        }
        closeModal();
        setTimeout(function() {
          location.reload();
        }, 800);
      } else {
        alert(data.message || 'Failed to update reservation');
      }
    },
    error: function(xhr, status, error) {
      console.error('AJAX error:', status, error);
      console.error('Response:', xhr.responseText);
      let errorMsg = 'Error updating reservation. ';
      
      if (status === 'parsererror') {
        errorMsg += 'Server returned invalid JSON. This usually means there\'s a PHP error. Please check your PHP error logs.';
      } else if (xhr.responseText) {
        // Try to parse if it's JSON
        try {
          const errorData = JSON.parse(xhr.responseText);
          errorMsg = errorData.message || errorMsg;
        } catch(e) {
          // Not JSON - PHP error was output
          errorMsg += 'PHP error detected. Check server logs for details.';
        }
      } else {
        errorMsg += error || 'Unknown error occurred.';
      }
      alert(errorMsg);
    }
  });
}

function confirmReservation(id) {
  if (!confirm('Confirm this reservation?')) return;
  
  $.ajax({
    url: 'process_reservation.php',
    method: 'POST',
    dataType: 'json',
    data: { action: 'update_status', id: id, status: 'confirmed' },
    success: function(data) {
      if (data.status === 'success') {
        if (typeof showToast === 'function') {
          showToast('Reservation confirmed', true);
        } else {
          alert('Reservation confirmed');
        }
        setTimeout(function() { location.reload(); }, 500);
      } else {
        alert(data.message || 'Failed to confirm reservation');
      }
    },
    error: function(xhr, status, error) {
      console.error('AJAX error:', status, error);
      console.error('Response:', xhr.responseText);
      alert('Error confirming reservation. ' + (status === 'parsererror' ? 'Server error - check PHP logs.' : error));
    }
  });
}

function cancelReservation(id) {
  if (!confirm('Cancel this reservation?')) return;
  
  $.ajax({
    url: 'process_reservation.php',
    method: 'POST',
    dataType: 'json',
    data: { action: 'update_status', id: id, status: 'cancelled' },
    success: function(data) {
      if (data.status === 'success') {
        if (typeof showToast === 'function') {
          showToast('Reservation cancelled', true);
        } else {
          alert('Reservation cancelled');
        }
        setTimeout(function() { location.reload(); }, 500);
      } else {
        alert(data.message || 'Failed to cancel reservation');
      }
    },
    error: function(xhr, status, error) {
      console.error('AJAX error:', status, error);
      console.error('Response:', xhr.responseText);
      alert('Error cancelling reservation. ' + (status === 'parsererror' ? 'Server error - check PHP logs.' : error));
    }
  });
}

function deleteReservation(id) {
  if (!confirm('Are you sure you want to delete this reservation? This action cannot be undone.')) return;
  
  $.ajax({
    url: 'process_reservation.php',
    method: 'POST',
    dataType: 'json',
    data: { action: 'delete', id: id },
    success: function(data) {
      if (data.status === 'success') {
        if (typeof showToast === 'function') {
          showToast('Reservation deleted successfully', true);
        } else {
          alert('Reservation deleted successfully');
        }
        setTimeout(function() { location.reload(); }, 500);
      } else {
        alert(data.message || 'Failed to delete reservation');
      }
    },
    error: function(xhr, status, error) {
      console.error('AJAX error:', status, error);
      console.error('Response:', xhr.responseText);
      alert('Error deleting reservation. ' + (status === 'parsererror' ? 'Server error - check PHP logs.' : error));
    }
  });
}

function closeModal() {
  $('#reservationModal').fadeOut(300, function() {
    $(this).hide();
  });
  $('html, body').css('overflow', 'auto');
  $('#reservationForm')[0].reset();
}

// Close modal when clicking outside
$(document).on('click', '#reservationModal', function(e) {
  if ($(e.target).is('#reservationModal')) {
    closeModal();
  }
});

// Prevent modal close when clicking inside modal content
$(document).on('click', '.modal-content', function(e) {
  e.stopPropagation();
});
</script>
</body>
</html>
