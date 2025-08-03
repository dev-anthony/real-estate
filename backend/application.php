<?php
session_start();
header('Content-Type: application/json');
include '../Config/db.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if(!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin'){
    echo json_encode(["error" => "unauthorized"]);
    exit;
}
$admin_id = $_SESSION['user_id'];


// if ($_SESSION['role'] !== 'admin') {
//     echo json_encode(["error" => "Unauthorized"]);
//     exit;
// }

$sql = " SELECT 
            applications.id AS application_id,
            users.id AS user_id,
            users.name,
            users.email,
            houses.id AS house_id,
            houses.title,
            applications.status,
            applications.applied_at
        FROM applications
        JOIN users ON applications.user_id = users.id
        JOIN houses ON applications.house_id = houses.id
        WHERE houses.admin_id = ?
        ORDER BY applications.applied_at DESC 
        ";

$stmt = $conn->prepare(trim($sql));
if(!$stmt){
    die("SQL Error: " . $conn->error);
}
$stmt->bind_param("i", $admin_id);
$stmt->execute();

$result = $stmt->get_result();
$notifications = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
}

echo json_encode($notifications);
