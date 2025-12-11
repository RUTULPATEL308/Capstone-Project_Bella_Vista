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

// Get message by ID
if ($action === 'get') {
    $id = intval($_GET['id'] ?? 0);
    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid message ID']);
        ob_end_flush();
        exit;
    }
    
    $stmt = $conn->prepare("SELECT * FROM contact_messages WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . $conn->error]);
        ob_end_flush();
        exit;
    }
    
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $message = $result->fetch_assoc();
        echo json_encode(['status' => 'success', 'message' => $message]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Message not found']);
    }
    $stmt->close();
    
// Delete message
} elseif ($action === 'delete') {
    $id = intval($_POST['id'] ?? 0);
    if (!$id) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid message ID']);
        ob_end_flush();
        exit;
    }
    
    $stmt = $conn->prepare("DELETE FROM contact_messages WHERE id = ?");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => 'Database prepare error: ' . $conn->error]);
        ob_end_flush();
        exit;
    }
    
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => 'Message deleted successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete message: ' . $stmt->error]);
    }
    $stmt->close();
    
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
}

$conn->close();
ob_end_flush();
?>

