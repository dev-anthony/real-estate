<?php
// session_start();
// if (!isset($_SESSION['user_id'])) {
//     http_response_code(401); 
//     echo json_encode(["error" => "Not logged in"]);
//     // header("Location: /Authentication/Frontend/php/index.php");
//     exit;
// }

// include '../Config/db.php';
// $data = json_decode(file_get_contents("php://input"), true);
// $house_id = $data['house_id'];

// $user_id = $_SESSION['user_id'];

// $stmt = $conn->prepare("INSERT INTO applications (house_id, user_id, status) VALUES (?, ?, 'Pending')");
// $stmt->bind_param("ss", $house_id, $user_id);
// $stmt->execute();

// echo 'Application sent. waiting to be approved';


session_start();
include '../Config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo "You must be logged in.";
    exit;
}

$user_id = $_SESSION['user_id'];
$data = json_decode(file_get_contents("php://input"), true);
$house_id = $data['house_id'];

// 1. Check if house already taken
$check = $conn->prepare("SELECT id FROM applications WHERE house_id = ? AND status = 'approved'");
$check->bind_param("i", $house_id);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    echo "This house has already been taken.";
    exit;
}

// 2. Check if user already applied
$check2 = $conn->prepare("SELECT id FROM applications WHERE house_id = ? AND user_id = ?");
$check2->bind_param("ii", $house_id, $user_id);
$check2->execute();
$check2->store_result();

if ($check2->num_rows > 0) {
    echo "You have already applied for this house.";
    exit;
}

// 3. Insert application
$insert = $conn->prepare("INSERT INTO applications (house_id, user_id, status) VALUES (?, ?, 'Pending')");
$insert->bind_param("ii", $house_id, $user_id);
$insert->execute();

// 4. Get landlord ID from house
$getAdmin = $conn->prepare("SELECT admin_id FROM houses WHERE id = ?");
$getAdmin->bind_param("i", $house_id);
$getAdmin->execute();
$result = $getAdmin->get_result();
$house = $result->fetch_assoc();
$admin_id = $house['admin_id'];

// 5. Notify the landlord (admin)
$message = "A new rental application has been submitted for your house.";
$notify = $conn->prepare("INSERT INTO applications (house_id, user_id, status) VALUES (?, ?, 'Pending')");
$conn->query("INSERT INTO notifications (user_id, message, is_read) VALUES ($admin_id, '$message', 0)");

echo "Application successful, wait for admin to approve.";
