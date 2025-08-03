
<?php



session_start();
include '../Config/db.php';

$data = json_decode(file_get_contents("php://input"), true);
$application_id = $data['application_id'];
$user_id = $data['user_id'];
$house_id = $data['house_id'];
$admin_id = $_SESSION['admin_id'];

// Approve the application
$stmt = $conn->prepare("UPDATE applications SET status='approved' WHERE id=?");
$stmt->bind_param("i", $application_id);
$stmt->execute();

// Send notification to user
$link = "/Authentication/Frontend/php/house-details.php?id=" . $house_id;
$message = "Your rental application has been approved. Proceed to payment here: <a href='$link'>View House</a>";
$stmt = $conn->prepare("INSERT INTO notifications (user_id, message, is_read) VALUES (?, ?, 0)");
$stmt->bind_param("is", $user_id, $message);
$stmt->execute();

echo "Application approved and user notified.";
?>

