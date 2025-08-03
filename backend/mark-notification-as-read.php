<?php
session_start();
include '../Config/db.php';

$data = json_decode(file_get_contents("php://input"), true);
$notification_id = $data['notification_id'];
$user_id = $_SESSION['user_id'] ?? null;

$stmt = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?");
$stmt->bind_param("ii", $notification_id, $user_id);
$stmt->execute();

echo json_encode(['success' => true]);
?>
