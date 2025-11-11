<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header('Content-Type: application/json');
ob_clean();
include 'db_connect.php';

$data = json_decode(file_get_contents("php://input"), true);

if (!$data || !isset($data['items']) || count($data['items']) === 0) {
  echo json_encode(['status' => 'error', 'message' => 'Empty cart']);
  exit;
}

$name = $conn->real_escape_string($data['name']);
$email = $conn->real_escape_string($data['email']);
$phone = $conn->real_escape_string($data['phone']);
$pickup_option = $conn->real_escape_string($data['method']); // pickup or dine-in
$payment_method = $conn->real_escape_string($data['payment']); // card or cash
$notes = $conn->real_escape_string($data['notes']);
$subtotal = floatval($data['subtotal']);
$tax = floatval($data['tax']);
$total = floatval($data['total']);

// Check if customer exists
$customerCheck = $conn->query("SELECT id FROM customers WHERE email='$email'");
if ($customerCheck->num_rows > 0) {
  $customer_id = $customerCheck->fetch_assoc()['id'];
} else {
  $conn->query("INSERT INTO customers (name, email, phone, pickup_option, payment_method, notes)
              VALUES ('$name','$email','$phone','$pickup_option','$payment_method','$notes')");
  $customer_id = $conn->insert_id;
}

// Insert order
$sql = "INSERT INTO orders (customer_id, subtotal, tax, total, pickup_option, payment_method, notes)
        VALUES ($customer_id, $subtotal, $tax, $total, '$pickup_option', '$payment_method', '$notes')";
if ($conn->query($sql)) {
  $order_id = $conn->insert_id;

  // Insert items
  foreach ($data['items'] as $item) {
    $item_name = $conn->real_escape_string($item['name']);
    $item_price = floatval($item['price']);
    $qty = intval($item['qty']);
    $conn->query("INSERT INTO order_items (order_id, item_name, price, qty)
                  VALUES ($order_id, '$item_name', $item_price, $qty)");
  }

  echo json_encode(['status' => 'success', 'order_id' => $order_id, 'total' => $total]);
} else {
  echo json_encode(['status' => 'error', 'message' => 'Order insert failed']);
}
$conn->close();
ob_end_flush();
?>
