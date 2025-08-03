<?php
session_start();
include '../Config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'Not logged in']);
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
$house_id = $data['house_id'];

// Check if the house is already taken (approved by any user)
$checkApproved = $conn->prepare("SELECT user_id FROM applications WHERE house_id = ? AND status = 'approved'");
$checkApproved->bind_param("i", $house_id);
$checkApproved->execute();
$result = $checkApproved->get_result();

$houseTaken = false;
$approvedUserId = null;

if ($row = $result->fetch_assoc()) {
    $houseTaken = true;
    $approvedUserId = $row['user_id'];
}

// Check if current user applied
$checkUser = $conn->prepare("SELECT status FROM applications WHERE house_id = ? AND user_id = ?");
$checkUser->bind_param("ii", $house_id, $user_id);
$checkUser->execute();
$userResult = $checkUser->get_result();

$userApplied = false;
$userApproved = false;

if ($userRow = $userResult->fetch_assoc()) {
    $userApplied = true;
    if ($userRow['status'] === 'approved') {
        $userApproved = true;
    }
}

// Final response
echo json_encode([
    'taken' => $houseTaken,
    'applied' => $userApplied,
    'approved' => $userApproved,
    'is_owner' => $approvedUserId == $user_id
]);
