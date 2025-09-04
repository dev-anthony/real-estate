<?php
session_start();
include '../Config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT id, message, is_read, created_at 
        FROM notifications 
        WHERE user_id = ? 
        ORDER BY created_at DESC";

$stmt = $conn->prepare($sql);
if($stmt === false){
    die("error fetching:". $conn->error);
}
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];

while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode($notifications);
