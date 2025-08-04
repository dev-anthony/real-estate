<?php
session_start();
header('Content-Type: application/json');

// Check if the user is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized. Please log in."]);
    exit;
}

include '../Config/db.php'; // adjust path as needed

$user_id = $_SESSION['user_id'];

// Get the JSON body
$data = json_decode(file_get_contents("php://input"), true);
$message = trim($data['message'] ?? '');

if (empty($message)) {
    http_response_code(400);
    echo json_encode(["error" => "Feedback message is required."]);
    exit;
}

$stmt = $conn->prepare("INSERT INTO feedback (user_id, message) VALUES (?, ?)");
$stmt->bind_param("is", $user_id, $message);

if ($stmt->execute()) {
    echo json_encode(["success" => true]);
} else {
    http_response_code(500);
    echo json_encode(["error" => "Failed to save feedback."]);
}

$stmt->close();
$conn->close();
?>
