<?php
session_start();
include '../Config/db.php';

$data = json_decode(file_get_contents("php://input"), true);
$application_id = $data['application_id'];
$user_id = $data['user_id'];

// Reject the application
$stmt = $conn->prepare("UPDATE applications SET status='rejected' WHERE id=?");
$stmt->bind_param("i", $application_id);
$stmt->execute();

// Notify user
$message = "Your application for the house has been rejected.";
$stmt = $conn->prepare("INSERT INTO notifications (user_id, message, is_read) VALUES (?, ?, 0)");
$stmt->bind_param("is", $user_id, $message);
$stmt->execute();

echo "Application rejected and user notified.";
?>
