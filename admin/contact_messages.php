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
    <title>Contact Messages</title>
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
      .message-content { background: #f9f9f9; padding: 15px; border-radius: 8px; border-left: 4px solid #ff8500; margin-top: 10px; white-space: pre-wrap; word-wrap: break-word; }
      .message-info { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 16px; }
      .info-item { background: #f0f0f0; padding: 10px; border-radius: 6px; }
      .info-item strong { display: block; color: #666; font-size: 0.85em; margin-bottom: 4px; }
      .info-item span { color: #333; font-weight: 500; }
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
      .btn-delete { background: #e84c3d; color: #fff; }
      .btn-view:hover { background: #0056b3; }
      .btn-delete:hover { background: #c9302c; }
      .filter-bar { display: flex; gap: 12px; margin-bottom: 20px; flex-wrap: wrap; align-items: center; }
      .filter-bar select, .filter-bar input { padding: 8px 12px; border: 1.8px solid #d0d7e2; border-radius: 6px; }
      .topic-badge { padding: 4px 10px; border-radius: 12px; font-size: 0.85em; font-weight: 600; display: inline-block; background: #e3f2fd; color: #1976d2; }
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
      <div class="topbar-title">Contact Messages</div>
      <div class="topbar-actions">
        <button class="topbar-btn js-toggle-theme" title="Toggle dark mode">🌓</button>
      </div>
    </div>
    <div class="page-container">
      <div class="featured-header">
        <h2>Contact Messages</h2>
        <p>View and manage customer inquiries and messages.</p>
      </div>
      
      <!-- Filter Bar -->
      <div class="filter-bar">
        <select id="filterTopic">
          <option value="">All Topics</option>
          <option value="general">General</option>
          <option value="reservation">Reservation</option>
          <option value="allergies">Allergies</option>
          <option value="events">Events</option>
          <option value="careers">Careers</option>
          <option value="press">Press</option>
        </select>
        <input type="text" id="filterSearch" placeholder="Search by name, email, phone...">
        <button onclick="clearFilters()" style="padding: 8px 16px; background: #6c757d; color: #fff; border: none; border-radius: 6px; cursor: pointer; font-weight: 600; min-height: 36px;">Clear Filters</button>
      </div>

      <div class="card">
        <table id="messagesTable" class="display" style="width:100%">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Contact</th>
              <th>Topic</th>
              <th>Message Preview</th>
              <th>Date</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $result = $conn->query('SELECT id, name, email, phone, topic, subject, message, created_at FROM contact_messages ORDER BY created_at DESC LIMIT 200');
            if ($result) { 
              while ($row = $result->fetch_assoc()) {
                $messagePreview = mb_substr($row['message'], 0, 60);
                if (strlen($row['message']) > 60) $messagePreview .= '...';
                
                echo '<tr>';
                echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                echo '<td>' . htmlspecialchars($row['email']);
                if (!empty($row['phone'])) {
                  echo '<br><small>' . htmlspecialchars($row['phone']) . '</small>';
                }
                echo '</td>';
                echo '<td><span class="topic-badge">' . htmlspecialchars(ucfirst($row['topic'] ?? 'general')) . '</span></td>';
                echo '<td>' . htmlspecialchars($messagePreview) . '</td>';
                echo '<td>' . date('M j, Y g:i A', strtotime($row['created_at'])) . '</td>';
                echo '<td class="action-btns">';
                echo '<button class="btn-view" onclick="viewMessage(' . $row['id'] . ')">View</button>';
                echo '<button class="btn-delete" onclick="deleteMessage(' . $row['id'] . ')">Delete</button>';
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

<!-- View Message Modal -->
<div id="messageModal" class="modal">
  <div class="modal-content">
    <h2 id="modalTitle">View Contact Message</h2>
    <div id="messageDetails">
      <!-- Message details will be loaded here -->
    </div>
    <div style="margin-top: 20px;">
      <button onclick="closeModal()" style="padding: 12px 24px; background: #ccc; color: #333; border: none; border-radius: 8px; font-weight: 600; cursor: pointer; min-height: 44px; transition: all 0.2s;">Close</button>
    </div>
  </div>
</div>

<script>
let messagesTable;

$(document).ready(function(){
  messagesTable = $('#messagesTable').DataTable({
    pageLength: 15,
    lengthChange: true,
    order: [[5, 'desc']], // Sort by date
    columnDefs: [
      { orderable: false, targets: [6] } // Disable sorting on Actions column
    ]
  });
  
  // Filter by topic
  $('#filterTopic').on('change', function() {
    messagesTable.column(3).search(this.value).draw();
  });
  
  // Global search
  $('#filterSearch').on('keyup', function() {
    messagesTable.search(this.value).draw();
  });
});

function clearFilters() {
  $('#filterTopic').val('');
  $('#filterSearch').val('');
  messagesTable.search('').columns().search('').draw();
}

function viewMessage(id) {
  if (!id) {
    alert('Invalid message ID');
    return;
  }
  
  $.ajax({
    url: 'process_contact.php',
    method: 'GET',
    dataType: 'json',
    data: { action: 'get', id: id },
    success: function(data) {
      if (data.status === 'success' && data.message) {
        const msg = data.message;
        
        let html = '<div class="message-info">';
        html += '<div class="info-item"><strong>Name</strong><span>' + escapeHtml(msg.name) + '</span></div>';
        html += '<div class="info-item"><strong>Email</strong><span>' + escapeHtml(msg.email) + '</span></div>';
        if (msg.phone) {
          html += '<div class="info-item"><strong>Phone</strong><span>' + escapeHtml(msg.phone) + '</span></div>';
        }
        html += '<div class="info-item"><strong>Topic</strong><span>' + escapeHtml(ucfirst(msg.topic || 'general')) + '</span></div>';
        if (msg.subject) {
          html += '<div class="info-item" style="grid-column: 1 / -1;"><strong>Subject</strong><span>' + escapeHtml(msg.subject) + '</span></div>';
        }
        html += '<div class="info-item" style="grid-column: 1 / -1;"><strong>Date</strong><span>' + new Date(msg.created_at).toLocaleString() + '</span></div>';
        html += '</div>';
        
        html += '<div class="form-group">';
        html += '<label>Message</label>';
        html += '<div class="message-content">' + escapeHtml(msg.message) + '</div>';
        html += '</div>';
        
        $('#messageDetails').html(html);
        $('#modalTitle').text('Contact Message #' + msg.id);
        $('#messageModal').fadeIn(300);
        $('html, body').css('overflow', 'hidden');
      } else {
        alert(data.message || 'Failed to load message');
      }
    },
    error: function(xhr, status, error) {
      console.error('AJAX error:', status, error);
      console.error('Response:', xhr.responseText);
      alert('Error loading message. ' + (status === 'parsererror' ? 'Server error - check PHP logs.' : error));
    }
  });
}

function deleteMessage(id) {
  if (!confirm('Are you sure you want to delete this contact message? This action cannot be undone.')) return;
  
  $.ajax({
    url: 'process_contact.php',
    method: 'POST',
    dataType: 'json',
    data: { action: 'delete', id: id },
    success: function(data) {
      if (data.status === 'success') {
        if (typeof showToast === 'function') {
          showToast('Message deleted successfully', true);
        } else {
          alert('Message deleted successfully');
        }
        setTimeout(function() { location.reload(); }, 500);
      } else {
        alert(data.message || 'Failed to delete message');
      }
    },
    error: function(xhr, status, error) {
      console.error('AJAX error:', status, error);
      console.error('Response:', xhr.responseText);
      alert('Error deleting message. ' + (status === 'parsererror' ? 'Server error - check PHP logs.' : error));
    }
  });
}

function closeModal() {
  $('#messageModal').fadeOut(300, function() {
    $(this).hide();
  });
  $('html, body').css('overflow', 'auto');
  $('#messageDetails').html('');
}

function escapeHtml(text) {
  const map = {
    '&': '&amp;',
    '<': '&lt;',
    '>': '&gt;',
    '"': '&quot;',
    "'": '&#039;'
  };
  return String(text).replace(/[&<>"']/g, m => map[m]);
}

function ucfirst(str) {
  return str.charAt(0).toUpperCase() + str.slice(1);
}

// Close modal when clicking outside
$(document).on('click', '#messageModal', function(e) {
  if ($(e.target).is('#messageModal')) {
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

