<?php
require 'db_connect.php';
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
  http_response_code(405);
  echo json_encode(["status" => "error", "message" => "Method not allowed"]);
  exit;
}

$name   = trim($_POST['name'] ?? '');
$email  = trim($_POST['email'] ?? '');
$phone  = trim($_POST['phone'] ?? '');
$date   = trim($_POST['date'] ?? '');
$time   = trim($_POST['time'] ?? '');
$guests = intval($_POST['guests'] ?? 0);
$msg    = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $phone === '' || $date === '' || $time === '' || $guests < 1) {
  echo json_encode(["status" => "error", "message" => "Missing required fields"]);
  exit;
}

$stmt = $conn->prepare("INSERT INTO reservations (name, email, phone, date, time, guests, message) VALUES (?,?,?,?,?,?,?)");
$stmt->bind_param("sssssis", $name, $email, $phone, $date, $time, $guests, $msg);

if ($stmt->execute()) {
  echo json_encode(["status" => "success", "reservation_id" => $stmt->insert_id]);
} else {
  echo json_encode(["status" => "error", "message" => $conn->error]);
}
