<?php
header('Content-Type: application/json');
include '../db_connect.php';
if ($conn && !$conn->connect_error) {
    echo json_encode(['status'=>'ok']);
} else {
    echo json_encode(['status'=>'error','message'=>$conn->connect_error]);
}
?>