<?php
session_start();
header('Content-Type: application/json');
include '../Config/db.php';

$data = json_decode(file_get_contents("php://input"), true);

$reader_id = $data['reader_id'];
$reader_type = $data['reader_type'];
$sender_id = $data['sender_id'];
$sender_type = $data['sender_type'];

$stmt = $conn->prepare("UPDATE messages SET is_read = 1 
  WHERE sender_id = ? AND sender_type = ? 
    AND receiver_id = ? AND receiver_type = ?");
$stmt->bind_param("isis", $sender_id, $sender_type, $reader_id, $reader_type);
$stmt->execute();

echo json_encode(['status' => true]);
