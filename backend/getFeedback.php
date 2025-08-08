<?php
// get_feedback.php

header('Content-Type: application/json');
include'../Config/db.php'; // Adjust path if needed

$sql = "SELECT feedback.id, feedback.message, feedback.created_at, users.name 
        FROM feedback 
        INNER JOIN users ON feedback.user_id = users.id 
        ORDER BY feedback.created_at DESC";

$result = $conn->query($sql);
$feedbacks = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $feedbacks[] = $row;
    }
}

echo json_encode($feedbacks);
$conn->close();
?>

