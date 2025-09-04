<?php
session_start();
header('Content-Type: application/json');
include '../Config/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Not authenticated']);
    exit;
}

$logged_in_id = $_SESSION['user_id'];
$logged_in_type = $_SESSION['user_type'];

$sql = "
    SELECT m1.*
    FROM messages m1
    JOIN (
        SELECT
            CASE
                WHEN sender_type = 'user' THEN sender_id
                ELSE receiver_id
            END AS user_id,
            CASE
                WHEN sender_type = 'admin' THEN sender_id
                ELSE receiver_id
            END AS admin_id,
            MAX(timestamp) AS latest_time
        FROM messages
        WHERE 
            (sender_id = ? AND sender_type = ?)
            OR
            (receiver_id = ? AND receiver_type = ?)
        GROUP BY user_id, admin_id
    ) AS latest_msg
    ON (
        (
            (m1.sender_type = 'user' AND m1.sender_id = latest_msg.user_id AND m1.receiver_type = 'admin' AND m1.receiver_id = latest_msg.admin_id)
            OR
            (m1.sender_type = 'admin' AND m1.sender_id = latest_msg.admin_id AND m1.receiver_type = 'user' AND m1.receiver_id = latest_msg.user_id)
        )
        AND m1.timestamp = latest_msg.latest_time
    )
    ORDER BY m1.timestamp DESC
";

$stmt = $conn->prepare($sql);
if($stmt === false){
    die("error fetching:". $conn->error);
}
$stmt->bind_param("isis", $logged_in_id, $logged_in_type, $logged_in_id, $logged_in_type);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];
while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
