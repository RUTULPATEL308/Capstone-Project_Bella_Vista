<?php
session_start();
header('Content-Type: application/json');
require_once '../db_connect.php';

if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    exit;
}

// Handle image upload
function uploadImage($file, $category) {
    if (!isset($file) || $file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }
    
    $allowedTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];
    $maxSize = 5 * 1024 * 1024; // 5MB
    
    if (!in_array($file['type'], $allowedTypes)) {
        return ['error' => 'Invalid file type. Only JPEG, PNG, GIF, and WebP are allowed.'];
    }
    
    if ($file['size'] > $maxSize) {
        return ['error' => 'File size exceeds 5MB limit.'];
    }
    
    $uploadDir = '../images/menu/' . $category . '/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }
    
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid('menu_', true) . '.' . $extension;
    $filepath = $uploadDir . $filename;
    
    if (move_uploaded_file($file['tmp_name'], $filepath)) {
        return 'images/menu/' . $category . '/' . $filename;
    }
    
    return ['error' => 'Failed to upload image.'];
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

if ($action === 'create') {
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $category = $_POST['category'] ?? '';
    $image = trim($_POST['image'] ?? '');
    $pairing = trim($_POST['pairing'] ?? '');
    $diet_tags = trim($_POST['diet_tags'] ?? '');
    $display_order = intval($_POST['display_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if (!$name || !$price || !$category) {
        echo json_encode(['status' => 'error', 'message' => 'Name, price, and category are required']);
        exit;
    }
    
    // Handle image upload
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['image_file'], $category);
        if (is_array($uploadResult) && isset($uploadResult['error'])) {
            echo json_encode(['status' => 'error', 'message' => $uploadResult['error']]);
            exit;
        } elseif ($uploadResult) {
            $image = $uploadResult;
        }
    }
    
    $stmt = $conn->prepare("INSERT INTO menu_items (name, description, price, category, image, pairing, diet_tags, display_order, is_active) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdssssii", $name, $description, $price, $category, $image, $pairing, $diet_tags, $display_order, $is_active);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Menu item created successfully', 'id' => $stmt->insert_id]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to create menu item: ' . $conn->error]);
    }
    $stmt->close();
    
} elseif ($action === 'update') {
    $id = intval($_POST['id'] ?? 0);
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $price = floatval($_POST['price'] ?? 0);
    $category = $_POST['category'] ?? '';
    $image = trim($_POST['image'] ?? '');
    $pairing = trim($_POST['pairing'] ?? '');
    $diet_tags = trim($_POST['diet_tags'] ?? '');
    $display_order = intval($_POST['display_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;
    
    if (!$id || !$name || !$price || !$category) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
        exit;
    }
    
    // Get current image path before update
    $currentStmt = $conn->prepare("SELECT image FROM menu_items WHERE id=?");
    $currentStmt->bind_param("i", $id);
    $currentStmt->execute();
    $currentResult = $currentStmt->get_result();
    $currentImage = $currentResult->fetch_assoc()['image'] ?? '';
    $currentStmt->close();
    
    // Handle new image upload
    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === UPLOAD_ERR_OK) {
        $uploadResult = uploadImage($_FILES['image_file'], $category);
        if (is_array($uploadResult) && isset($uploadResult['error'])) {
            echo json_encode(['status' => 'error', 'message' => $uploadResult['error']]);
            exit;
        } elseif ($uploadResult) {
            // Delete old image if exists
            if ($currentImage && file_exists('../' . $currentImage)) {
                @unlink('../' . $currentImage);
            }
            $image = $uploadResult;
        }
    } else {
        // Keep existing image if no new upload
        $image = $currentImage;
    }
    
    $stmt = $conn->prepare("UPDATE menu_items SET name=?, description=?, price=?, category=?, image=?, pairing=?, diet_tags=?, display_order=?, is_active=? WHERE id=?");
    $stmt->bind_param("ssdssssiii", $name, $description, $price, $category, $image, $pairing, $diet_tags, $display_order, $is_active, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Menu item updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update menu item: ' . $conn->error]);
    }
    $stmt->close();
    
} elseif ($action === 'get') {
    $id = intval($_GET['id'] ?? 0);
    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        exit;
    }
    
    $stmt = $conn->prepare("SELECT * FROM menu_items WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        echo json_encode(['status' => 'success', 'item' => $row]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Menu item not found']);
    }
    $stmt->close();
    
} elseif ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
        exit;
    }
    
    // Get image path before deleting
    $imgStmt = $conn->prepare("SELECT image FROM menu_items WHERE id=?");
    $imgStmt->bind_param("i", $id);
    $imgStmt->execute();
    $imgResult = $imgStmt->get_result();
    $imagePath = $imgResult->fetch_assoc()['image'] ?? '';
    $imgStmt->close();
    
    $stmt = $conn->prepare("DELETE FROM menu_items WHERE id=?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Delete image file if exists
        if ($imagePath && file_exists('../' . $imagePath)) {
            @unlink('../' . $imagePath);
        }
        echo json_encode(['status' => 'success', 'message' => 'Menu item deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete menu item: ' . $conn->error]);
    }
    $stmt->close();
    
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}

$conn->close();
?>

