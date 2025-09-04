<?php
include '../Config/db.php';

if (!isset($_GET['id'])) {
    echo json_encode(["success" => false, "message" => "No ID provided"]);
    exit;
}

$id = intval($_GET['id']);
$sql = "DELETE FROM houses WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "House deleted successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Failed to delete"]);
}
?>
