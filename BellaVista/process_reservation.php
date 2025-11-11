<?php
header('Content-Type: application/json');
include 'db_connect.php';

$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$phone = $_POST['phone'] ?? '';
$guests = $_POST['guests'] ?? 1;
$date = $_POST['date'] ?? '';
$time = $_POST['time'] ?? '';
$seating = $_POST['seating_preference'] ?? 'no preference';
$occasion = $_POST['occasion'] ?? 'none';
$notes = $_POST['notes'] ?? '';

if (!$name || !$email || !$phone || !$date || !$time) {
  echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
  exit;
}

$sql = "INSERT INTO reservations (name, email, phone, guests, date, time, seating_preference, occasion, notes)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssisssss", $name, $email, $phone, $guests, $date, $time, $seating, $occasion, $notes);

if ($stmt->execute()) {
  echo json_encode([
    'status' => 'success',
    'reservation_id' => $stmt->insert_id
  ]);
} else {
  echo json_encode([
    'status' => 'error',
    'message' => 'Database insert failed'  . $conn->error
  ]);
}

$stmt->close();
$conn->close();
?>
