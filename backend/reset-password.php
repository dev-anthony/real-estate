<?php
include '../Config/db.php';
session_start();
if(!isset($_SESSION['reset_email']) || !isset(($_SESSION['reset_type']))){
    echo 'Unauthorized access';
    exit();
}

$newPassword = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
$email = $_SESSION['reset_email'];
$type = $_SESSION['reset_type'];

if($type === 'admin') {
    $stmt = $conn->prepare("UPDATE admins SET password = ? WHERE email = ?");
}else{
    $stmt = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
}
$stmt->bind_param("ss", $newPassword, $email);
if($stmt->execute()){
    session_unset();
    session_destroy();
    header("location: /Authentication/Frontend/php/index.php");
}else{
    echo ' failed to update password';
}
?>