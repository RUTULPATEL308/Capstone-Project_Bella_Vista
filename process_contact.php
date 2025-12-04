<?php
header('Content-Type: application/json');
include 'db_connect.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? null;
$topic = $_POST['topic'] ?? '';
$message = $_POST['message'] ?? '';

if (!$name || !$email || !$topic || !$message) {
  echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields.']);
  exit;
}

$sql = "INSERT INTO contact_messages (name, email, phone, topic, message)
        VALUES (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssss", $name, $email, $phone, $topic, $message);

if ($stmt->execute()) {
  echo json_encode(['status' => 'success', 'message' => 'Message saved successfully.']);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Database error: ' . $conn->error]);
}

$stmt->close();
$conn->close();
?>
