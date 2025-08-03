<?php
session_start();
header('Content-Type: application/json');
include  '../Config/db.php'; 
$user_id = $_GET['user_id'] ?? null;
$admin_id = $_GET['admin_id'] ?? null;

if (!$user_id || !$admin_id) {
    echo json_encode(['error' => 'Missing user_id or admin_id']);
    exit;
}

try {
    // Fetch all messages between user and admin
    $sql = "SELECT id, sender_id, sender_type, receiver_id, receiver_type, message, file_url, timestamp, is_read
            FROM messages
            WHERE 
                (
                    sender_id = ? AND sender_type = 'user' AND receiver_id = ? AND receiver_type = 'admin'
                ) 
                OR 
                (
                    sender_id = ? AND sender_type = 'admin' AND receiver_id = ? AND receiver_type = 'user'
                )
            ORDER BY timestamp ASC";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iiii", $user_id, $admin_id, $admin_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    $messages = [];
    $messageIdsToMarkSeen = [];

    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;

        // If current user is the receiver and hasn't seen this message yet, mark for update
        if (
            ($row['sender_id'] == $user_id && $row['sender_type'] == 'user') ||
            ($row['receiver_id'] == $admin_id && $row['receiver_type'] == 'admin')
        ) {
            if (!$row['is_read']) {
                $messageIdsToMarkSeen[] = $row['id'];
            }
        }
    }

    // Mark unseen messages as seen for the receiver
    if (!empty($messageIdsToMarkSeen)) {
        $idsString = implode(',', array_map('intval', $messageIdsToMarkSeen));
        $updateSql = "UPDATE messages SET is_read = 1 WHERE id IN ($idsString)";
        $conn->query($updateSql);
    }

    echo json_encode($messages);
} catch (Exception $e) {
    echo json_encode(['error' => 'Something went wrong', 'details' => $e->getMessage()]);
}
?>
