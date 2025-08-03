<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    http_response_code(401); 
    echo json_encode(["error" => "Not logged in"]);
    // header("Location: /Authentication/Frontend/php/index.php");
    exit;
}

include '../Config/db.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["error" => "Invalid request"]);
    exit;
}

// Get and validate input
    $title = $_POST['title'];
    $location = $_POST['location'];
    $price = $_POST['price'];
    $description = $_POST['description'];

$admin_id = $_SESSION['admin_id'];

if (!$title || !$location || !$price || !$description || !$admin_id) {
    echo json_encode(["error" => "Missing required fields"]);
    exit;
}

// Set default status
$status = "available";

// Handle image upload
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imageName = uniqid() . '_' . basename($_FILES['image']['name']);
    $targetDir = '../assets/';
    $targetPath = $targetDir . $imageName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
        // Insert into database
        $stmt = $conn->prepare("INSERT INTO houses (title, location, price, description, status, image, admin_id) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdsssi", $title, $location, $price, $description, $status, $imageName, $admin_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true]);
        } else {
            echo json_encode(["error" => $stmt->error]);
        }

    } else {
        echo json_encode(["error" => "Failed to upload image"]);
    }
} else {
    echo json_encode(["error" => "No valid image uploaded"]);
}
?>
