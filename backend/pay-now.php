<?php
session_start();
include '../Config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Not logged in."]);
    exit;
}

$data = json_decode(file_get_contents("php://input"), true);
$house_id = $data['house_id'];
$user_id = $_SESSION['user_id'];

// Check if house is already taken
$checkHouse = $conn->prepare("SELECT status FROM houses WHERE id = ?");
$checkHouse->bind_param("i", $house_id);
$checkHouse->execute();
$houseResult = $checkHouse->get_result()->fetch_assoc();

if ($houseResult['status'] === 'taken') {
    echo json_encode(["error" => "House already taken."]);
    exit;
}

// Check if application is approved for this user and house
$checkApp = $conn->prepare("SELECT * FROM applications WHERE house_id = ? AND user_id = ? AND status = 'approved'");
$checkApp->bind_param("ii", $house_id, $user_id);
$checkApp->execute();
$appResult = $checkApp->get_result();

if ($appResult->num_rows === 0) {
    echo json_encode(["error" => "No approved application found."]);
    exit;
}

// Update house status to taken
$updateHouse = $conn->prepare("UPDATE houses SET status = 'taken' WHERE id = ?");
$updateHouse->bind_param("i", $house_id);
$updateHouse->execute();

// Reject other pending applications
$rejectOthers = $conn->prepare("UPDATE applications SET status = 'rejected' WHERE house_id = ? AND user_id != ?");
$rejectOthers->bind_param("ii", $house_id, $user_id);
$rejectOthers->execute();

// Send notification
$message = "Your payment for the house has been confirmed. The house is now reserved for you.";
$notify = $conn->prepare("INSERT INTO notifications (user_id, message, is_read) VALUES (?, ?, 0)");
$notify->bind_param("is", $user_id, $message);
$notify->execute();

echo json_encode(["success" => "Payment confirmed, house reserved."]);
