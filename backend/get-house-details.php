<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    http_response_code(401); 
    echo json_encode(["error" => "Not logged in"]);
    // header("Location: /Authentication/Frontend/php/index.php");
    exit;
}
header('Content-Type: application/json');
include '../Config/db.php';

if(!isset($_GET['id'])){
    echo json_encode(['error' => 'no house id provided']);
}

// $houseId = $_GET['id'] ?? null;
// if (!$houseId) {
//     echo json_encode(['error' => 'Missing house ID']);
//     exit;
// }

// Sanitize input to prevent SQL injection
$id = intval($_GET['id']);

$sql = "SELECT 
            houses.*, 
            admins.name AS admin_name
        FROM 
            houses 
        JOIN 
            admins
        ON 
            houses.admin_id = admins.id 
        WHERE 
            houses.id = ?";
// $sql = "SELECT * FROM houses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
 $result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode(['error' => 'House not found']);
   
}
$house = $result->fetch_assoc();
echo json_encode($house);
?>
