<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit;
}
require_once '../db_connect.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Menu Management</title>
    <link rel="stylesheet" href="assets/admin.css">
    <link rel="stylesheet" href="../assets/styles.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <script src="assets/admin.js"></script>
    <style>
      .modal { display: none; position: fixed; z-index: 1000; left: 0; top: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); overflow-y: auto; }
      .modal-content { background: #fff; margin: 3% auto; padding: 30px; border-radius: 12px; width: 90%; max-width: 650px; max-height: 90vh; overflow-y: auto; position: relative; }
      .form-group { margin-bottom: 16px; }
      .form-group label { display: block; margin-bottom: 6px; font-weight: 600; }
      .form-group input, .form-group select, .form-group textarea { width: 100%; padding: 10px; border: 1.8px solid #d0d7e2; border-radius: 7px; box-sizing: border-box; }
      .btn-group { display: flex; gap: 10px; margin-top: 20px; }
      .image-upload-area { border: 2px dashed #d0d7e2; border-radius: 8px; padding: 20px; text-align: center; background: #f9f9f9; cursor: pointer; transition: all 0.3s; }
      .image-upload-area:hover { border-color: #ff8500; background: #fff7ee; }
      .image-upload-area.has-image { border-style: solid; }
      .image-preview { max-width: 100%; max-height: 200px; margin-top: 10px; border-radius: 8px; display: none; }
      .image-preview.show { display: block; }
      .upload-btn { background: linear-gradient(90deg,#ff8500 0,#ffb066 100%); color: #fff; border: none; padding: 10px 20px; border-radius: 8px; cursor: pointer; font-weight: 600; margin-top: 10px; }
      .upload-btn:hover { background: linear-gradient(90deg,#ffb066 0,#ff8500 100%); }
      .remove-image-btn { background: #e84c3d; color: #fff; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer; font-size: 12px; margin-top: 8px; display: none; }
      .remove-image-btn.show { display: inline-block; }
      #image_file { display: none; }
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
      <a href="profile.php">Profile</a>
      <a class="bottom-link" href="settings.php">Settings</a>
      <a class="bottom-link" href="logout.php">Logout</a>
    </nav>
  </aside>
  <main class="admin-main">
    <div class="admin-topbar">
      <div class="topbar-title">Menu Management</div>
      <div class="topbar-actions">
        <button class="topbar-btn js-toggle-theme" title="Toggle dark mode">🌓</button>
        <button onclick="openAddModal()" style="background: linear-gradient(90deg,#ff8500 0,#ffb066 100%); color: #fff; border: none; padding: 8px 16px; border-radius: 8px; cursor: pointer; font-weight: 600;">+ Add Item</button>
      </div>
    </div>
    <div class="page-container">
      <div class="featured-header">
        <h2>Menu Items</h2>
        <p>Manage your restaurant menu items, prices, and categories.</p>
      </div>
      <div class="card">
        <div style="overflow-x: auto;">
          <table id="menuTable" class="display" style="width:100%">
            <thead>
              <tr><th>ID</th><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Status</th><th>Actions</th></tr>
            </thead>
            <tbody>
              <?php
              $result = $conn->query("SELECT id, name, category, price, image, is_active FROM menu_items ORDER BY category, display_order, name");
              if ($result) {
                while ($row = $result->fetch_assoc()) {
                  echo '<tr>';
                  echo '<td>' . htmlspecialchars($row['id']) . '</td>';
                  echo '<td>';
                  if (!empty($row['image'])) {
                    echo '<img src="../' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['name']) . '" style="width:50px;height:50px;object-fit:cover;border-radius:6px;">';
                  } else {
                    echo '<span style="color:#999;">No image</span>';
                  }
                  echo '</td>';
                  echo '<td>' . htmlspecialchars($row['name']) . '</td>';
                  echo '<td>' . ucfirst(htmlspecialchars($row['category'])) . '</td>';
                  echo '<td>$' . number_format($row['price'], 2) . '</td>';
                  echo '<td>' . ($row['is_active'] ? '<span style="color:green;">Active</span>' : '<span style="color:red;">Inactive</span>') . '</td>';
                  echo '<td>';
                  echo '<button class="edit-menu-btn" data-id="' . $row['id'] . '" style="padding:4px 8px;margin-right:4px;background:#ff8500;color:#fff;border:none;border-radius:4px;cursor:pointer;">Edit</button>';
                  echo '<button class="delete-menu-btn" data-id="' . $row['id'] . '" style="padding:4px 8px;background:#e84c3d;color:#fff;border:none;border-radius:4px;cursor:pointer;">Delete</button>';
                  echo '</td>';
                  echo '</tr>';
                }
              }
              ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </main>
</div>

<!-- Add/Edit Modal -->
<div id="menuModal" class="modal">
  <div class="modal-content">
    <h2 id="modalTitle">Add Menu Item</h2>
    <form id="menuForm" enctype="multipart/form-data">
      <input type="hidden" id="item_id" name="id">
      <div class="form-group">
        <label>Name *</label>
        <input type="text" id="item_name" name="name" required>
      </div>
      <div class="form-group">
        <label>Description</label>
        <textarea id="item_description" name="description" rows="3"></textarea>
      </div>
      <div class="form-group">
        <label>Price *</label>
        <input type="number" id="item_price" name="price" step="0.01" min="0" required>
      </div>
      <div class="form-group">
        <label>Category *</label>
        <select id="item_category" name="category" required>
          <option value="starters">Starters</option>
          <option value="pasta">Fresh Pasta</option>
          <option value="mains">Mains</option>
          <option value="desserts">Desserts</option>
        </select>
      </div>
      <div class="form-group">
        <label>Image</label>
        <div class="image-upload-area" id="imageUploadArea">
          <input type="file" id="image_file" name="image_file" accept="image/*">
          <input type="hidden" id="item_image" name="image">
          <div id="uploadText">
            <p style="margin:0;color:#666;">📷 Click to upload image</p>
            <p style="margin:4px 0 0 0;font-size:12px;color:#999;">or drag and drop</p>
          </div>
          <img id="imagePreview" class="image-preview" alt="Preview">
          <button type="button" class="remove-image-btn" id="removeImageBtn" onclick="removeImage()">Remove Image</button>
        </div>
        <button type="button" class="upload-btn" id="chooseImageBtn">Choose Image</button>
      </div>
      <div class="form-group">
        <label>Wine Pairing</label>
        <input type="text" id="item_pairing" name="pairing" placeholder="e.g., Pairs with Pinot Grigio">
      </div>
      <div class="form-group">
        <label>Diet Tags (comma separated)</label>
        <input type="text" id="item_diet_tags" name="diet_tags" placeholder="e.g., V,GF">
      </div>
      <div class="form-group">
        <label>Display Order</label>
        <input type="number" id="item_display_order" name="display_order" value="0">
      </div>
      <div class="form-group">
        <label><input type="checkbox" id="item_is_active" name="is_active" checked> Active</label>
      </div>
      <div class="btn-group">
        <button type="submit" style="flex:1;background:linear-gradient(90deg,#ff8500 0,#ffb066 100%);color:#fff;border:none;padding:12px;border-radius:8px;font-weight:600;cursor:pointer;">Save</button>
        <button type="button" onclick="closeModal()" style="flex:1;background:#ccc;color:#333;border:none;padding:12px;border-radius:8px;font-weight:600;cursor:pointer;">Cancel</button>
      </div>
    </form>
  </div>
</div>

<script>
let isDragging = false;

$(document).ready(function(){
  // Initialize DataTable
  $('#menuTable').DataTable({ 
    pageLength: 10, 
    lengthChange: false,
    order: [[0, 'desc']]
  });
  
  // Upload button click handler - use document ready to ensure it's attached
  $(document).on('click', '#chooseImageBtn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    $('#image_file').trigger('click');
  });
  
  // Image upload area click handler
  $(document).on('click', '#imageUploadArea', function(e) {
    if (!isDragging && !$(e.target).is('img') && !$(e.target).is('button')) {
      e.preventDefault();
      e.stopPropagation();
      $('#image_file').trigger('click');
    }
  });
  
  // Image file change handler
  $(document).on('change', '#image_file', function(e) {
    const file = e.target.files[0];
    if (file) {
      if (file.size > 5 * 1024 * 1024) {
        alert('Image size must be less than 5MB');
        $(this).val('');
        return;
      }
      if (!file.type.match('image.*')) {
        alert('Please select an image file');
        $(this).val('');
        return;
      }
      const reader = new FileReader();
      reader.onload = function(e) {
        $('#imagePreview').attr('src', e.target.result).addClass('show');
        $('#uploadText').hide();
        $('#imageUploadArea').addClass('has-image');
        $('#removeImageBtn').addClass('show');
      };
      reader.readAsDataURL(file);
    }
  });
  
  // Drag and drop handlers
  $(document).on('dragover', '#imageUploadArea', function(e) {
    e.preventDefault();
    e.stopPropagation();
    isDragging = true;
    $(this).css('border-color', '#ff8500');
  });
  
  $(document).on('dragleave', '#imageUploadArea', function(e) {
    e.preventDefault();
    e.stopPropagation();
    isDragging = false;
    $(this).css('border-color', '#d0d7e2');
  });
  
  $(document).on('drop', '#imageUploadArea', function(e) {
    e.preventDefault();
    e.stopPropagation();
    isDragging = false;
    $(this).css('border-color', '#d0d7e2');
    const file = e.originalEvent.dataTransfer.files[0];
    if (file && file.type.startsWith('image/')) {
      const dataTransfer = new DataTransfer();
      dataTransfer.items.add(file);
      $('#image_file')[0].files = dataTransfer.files;
      $('#image_file').trigger('change');
    }
  });
  
  // Event delegation for edit and delete buttons (works with DataTables)
  $(document).on('click', '.edit-menu-btn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    const id = $(this).data('id');
    if (id) {
      editItem(id);
    }
  });
  
  $(document).on('click', '.delete-menu-btn', function(e) {
    e.preventDefault();
    e.stopPropagation();
    const id = $(this).data('id');
    if (id) {
      deleteItem(id);
    }
  });
  
  // Form submit handler
  $(document).on('submit', '#menuForm', function(e) {
    e.preventDefault();
    e.stopPropagation();
    
    const formData = new FormData(this);
    formData.append('action', $('#item_id').val() ? 'update' : 'create');
    
    // Show loading
    const submitBtn = $(this).find('button[type="submit"]');
    const originalText = submitBtn.text();
    submitBtn.text('Saving...').prop('disabled', true);
    
    $.ajax({
      url: 'process_menu.php',
      method: 'POST',
      data: formData,
      processData: false,
      contentType: false,
      success: function(res) {
        try {
          const data = typeof res === 'string' ? JSON.parse(res) : res;
          if (data.status === 'success') {
            if (typeof showToast === 'function') {
              showToast(data.message, true);
            } else {
              alert(data.message);
            }
            closeModal();
            setTimeout(function() {
              location.reload();
            }, 800);
          } else {
            if (typeof showToast === 'function') {
              showToast(data.message || 'Error occurred', false);
            } else {
              alert(data.message || 'Error occurred');
            }
            submitBtn.text(originalText).prop('disabled', false);
          }
        } catch(err) {
          console.error('Parse error:', err, res);
          alert('Error processing response');
          submitBtn.text(originalText).prop('disabled', false);
        }
      },
      error: function(xhr, status, error) {
        console.error('AJAX error:', status, error);
        if (typeof showToast === 'function') {
          showToast('Error saving menu item: ' + error, false);
        } else {
          alert('Error saving menu item: ' + error);
        }
        submitBtn.text(originalText).prop('disabled', false);
      }
    });
    return false;
  });
});

function openAddModal() {
  $('#modalTitle').text('Add Menu Item');
  $('#menuForm')[0].reset();
  $('#item_id').val('');
  $('#item_is_active').prop('checked', true);
  $('#item_display_order').val(0);
  resetImagePreview();
  // Re-enable submit button
  $('#menuForm button[type="submit"]').prop('disabled', false).text('Save');
  $('#menuModal').show().fadeIn(300);
  $('html, body').css('overflow', 'hidden');
}

function resetImagePreview() {
  $('#imagePreview').removeClass('show').attr('src', '');
  $('#uploadText').show();
  $('#imageUploadArea').removeClass('has-image');
  $('#removeImageBtn').removeClass('show');
  $('#image_file').val('');
  $('#item_image').val('');
}

function removeImage() {
  resetImagePreview();
}

function editItem(id) {
  if (!id) {
    alert('Invalid item ID');
    return;
  }
  
  $.ajax({
    url: 'process_menu.php',
    method: 'GET',
    data: { action: 'get', id: id },
    success: function(res) {
      try {
        const data = typeof res === 'string' ? JSON.parse(res) : res;
        if (data.status === 'success' && data.item) {
          const item = data.item;
          $('#item_id').val(item.id);
          $('#item_name').val(item.name || '');
          $('#item_description').val(item.description || '');
          $('#item_price').val(item.price || 0);
          $('#item_category').val(item.category || 'starters');
          $('#item_image').val(item.image || '');
          $('#item_pairing').val(item.pairing || '');
          $('#item_diet_tags').val(item.diet_tags || '');
          $('#item_display_order').val(item.display_order || 0);
          $('#item_is_active').prop('checked', item.is_active == 1);
          
          // Reset image preview first
          resetImagePreview();
          
          // Show existing image if available
          if (item.image) {
            $('#imagePreview').attr('src', '../' + item.image).addClass('show');
            $('#uploadText').hide();
            $('#imageUploadArea').addClass('has-image');
            $('#removeImageBtn').addClass('show');
          }
          
          // Re-enable submit button
          $('#menuForm button[type="submit"]').prop('disabled', false).text('Save');
          
          $('#modalTitle').text('Edit Menu Item');
          $('#menuModal').fadeIn(300);
          $('html, body').css('overflow', 'hidden');
        } else {
          alert(data.message || 'Failed to load menu item');
        }
      } catch(err) {
        console.error('Parse error:', err, res);
        alert('Error loading menu item');
      }
    },
    error: function(xhr, status, error) {
      console.error('AJAX error:', status, error);
      alert('Error loading menu item: ' + error);
    }
  });
}

function deleteItem(id) {
  if (!id) {
    alert('Invalid item ID');
    return;
  }
  
  if (!confirm('Are you sure you want to delete this menu item?')) return;
  
  $.ajax({
    url: 'process_menu.php',
    method: 'POST',
    data: { action: 'delete', id: id },
    success: function(res) {
      try {
        const data = typeof res === 'string' ? JSON.parse(res) : res;
        if (data.status === 'success') {
          if (typeof showToast === 'function') {
            showToast(data.message, true);
          } else {
            alert(data.message);
          }
          setTimeout(function() {
            location.reload();
          }, 500);
        } else {
          if (typeof showToast === 'function') {
            showToast(data.message || 'Failed to delete', false);
          } else {
            alert(data.message || 'Failed to delete');
          }
        }
      } catch(err) {
        console.error('Parse error:', err, res);
        alert('Error deleting menu item');
      }
    },
    error: function(xhr, status, error) {
      console.error('AJAX error:', status, error);
      alert('Error deleting menu item: ' + error);
    }
  });
}

function closeModal() {
  $('#menuModal').fadeOut(300, function() {
    $(this).hide();
  });
  $('html, body').css('overflow', 'auto');
  resetImagePreview();
  // Reset form and button state
  $('#menuForm')[0].reset();
  $('#menuForm button[type="submit"]').prop('disabled', false).text('Save');
  $('#item_id').val('');
}

// Close modal when clicking outside
$(document).on('click', '#menuModal', function(e) {
  if ($(e.target).is('#menuModal')) {
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

