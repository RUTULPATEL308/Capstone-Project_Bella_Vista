<?php
// Turn off error display but keep error logging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);

// Start output buffering to catch any unwanted output
ob_start();

session_start();
header('Content-Type: application/json');

// Clear any output that might have been generated before
ob_clean();

require_once '../db_connect.php';

// Check if there was any output from db_connect.php and clear it
if (ob_get_length() > 0) {
    ob_clean();
}

if (!isset($_SESSION['admin_logged_in'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    ob_end_flush();
    exit;
}

if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => 'Database connection failed']);
    ob_end_flush();
    exit;
}

$action = $_POST['action'] ?? $_GET['action'] ?? '';

// Get reservation by ID
if ($action === 'get') {
    $id = intval($_GET['id'] ?? 0);
    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid reservation ID']);
        ob_end_flush();
        exit;
    }
    
    $stmt = $conn->prepare("SELECT * FROM reservations WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . $conn->error]);
        ob_end_flush();
        exit;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $reservation = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'reservation' => $reservation]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Reservation not found']);
    }
    $stmt->close();
    
// Update reservation
} elseif ($action === 'update') {
    $id = intval($_POST['id'] ?? 0);
    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid reservation ID']);
        ob_end_flush();
        exit;
    }
    
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $guests = intval($_POST['guests'] ?? 1);
    $seating_preference = $_POST['seating_preference'] ?? 'no preference';
    $occasion = $_POST['occasion'] ?? 'none';
    $notes = trim($_POST['notes'] ?? '');
    
    if (!$name || !$email || !$phone || !$date || !$time) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
        ob_end_flush();
        exit;
    }
    
    $stmt = $conn->prepare("UPDATE reservations SET name = ?, email = ?, phone = ?, date = ?, time = ?, guests = ?, seating_preference = ?, occasion = ?, notes = ? WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . $conn->error]);
        ob_end_flush();
        exit;
    }
    
    // Fix: guests is integer (i), not string (s) - corrected bind_param string
    $stmt->bind_param("sssssisssi", $name, $email, $phone, $date, $time, $guests, $seating_preference, $occasion, $notes, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Reservation updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update reservation: ' . $stmt->error]);
    }
    $stmt->close();
    
// Update status only
} elseif ($action === 'update_status') {
    $id = intval($_POST['id'] ?? 0);
    $status = trim($_POST['status'] ?? 'pending');
    
    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid reservation ID']);
        ob_end_flush();
        exit;
    }
    
    // Get current notes
    $stmt = $conn->prepare("SELECT notes FROM reservations WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . $conn->error]);
        ob_end_flush();
        exit;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $current = $result->fetch_assoc();
    $currentNotes = $current['notes'] ?? '';
    
    $stmt->close();
    
    // Remove old status tags and add new one
    $notes = preg_replace('/\[Status:\s*(PENDING|CONFIRMED|CANCELLED|COMPLETED)\]\s*/i', '', $currentNotes);
    $notes = trim($notes);
    $statusTag = '[Status: ' . strtoupper($status) . ']';
    $newNotes = $statusTag . ($notes ? ' ' . $notes : '');
    
    $stmt = $conn->prepare("UPDATE reservations SET notes = ? WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . $conn->error]);
        ob_end_flush();
        exit;
    }
    
    $stmt->bind_param("si", $newNotes, $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Reservation status updated']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update status: ' . $stmt->error]);
    }
    $stmt->close();
    
// Delete reservation
} elseif ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid reservation ID']);
        ob_end_flush();
        exit;
    }
    
    $stmt = $conn->prepare("DELETE FROM reservations WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . $conn->error]);
        ob_end_flush();
        exit;
    }
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Reservation deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete reservation: ' . $stmt->error]);
    }
    $stmt->close();
    
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}

$conn->close();
ob_end_flush();
?>
