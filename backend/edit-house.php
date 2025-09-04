<?php
include '../Config/db.php';


$id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? null;
$price = $_POST['price'] ?? null;
$location = $_POST['location'] ?? null;
$description = $_POST['description'] ?? null;

if (!$id || !$title || !$price || !$location || !$description) {
    echo json_encode(["success" => false, "message" => "Missing fields"]);
    exit;
}

$sql = "UPDATE houses SET title=?, price=?, location=?, description=? WHERE id=?";
$stmt = $conn->prepare($sql);
if($stmt === false){
    die("error:". $conn->error);
}
    

$stmt->bind_param("sissi", $title, $price, $location, $description, $id);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "House updated successfully"]);
} else {
    echo json_encode(["success" => false, "message" => "Update failed"]);
}
?>
