<?php
session_start();
header('Content-Type: application/json');
include '../Config/db.php';

// Validate user session
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "User not logged in"]);
    exit;
}


$sender_id = $_POST['sender_id'] ?? null;
$receiver_id = $_POST['receiver_id'] ?? null;
$sender_type = $_POST['sender_type'] ?? null;
$receiver_type = $_POST['receiver_type'] ?? null;
$message = trim($_POST['message'] ?? '');

if (!$sender_id || !$receiver_id || !$sender_type || !$receiver_type) {
    echo json_encode(['error' => 'Missing required fields']);
    exit;
}


if (empty($message) && (!isset($_FILES['file']) || $_FILES['file']['error'] !== 0)) {
    echo json_encode(['error' => 'Message and file cannot both be empty']);
    exit;
}


$file_url = null;
if (isset($_FILES['file']) && $_FILES['file']['error'] === 0) {

    $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Authentication/assets/';

    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $fileName = time() . '_' . basename($_FILES['file']['name']);
    $filePath = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['file']['tmp_name'], $filePath)) {
        $file_url = '/Authentication/assets/' . $fileName; 
    } else {
        echo json_encode(['error' => 'Failed to upload file']);
        exit;
    }
}



$stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, sender_type, receiver_type, message, file_url) VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    echo json_encode(['error' => 'DB prepare failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("iissss", $sender_id, $receiver_id, $sender_type, $receiver_type, $message, $file_url);

if ($stmt->execute()) {
    echo json_encode(['status' => true,
'file_url' => $file_url,
'message_id' => $stmt->insert_id]);
} else {
    echo json_encode(['error' => 'DB insert failed: ' . $stmt->error]);
}
?>
