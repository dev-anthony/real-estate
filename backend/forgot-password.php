<?php
session_start();
include '../Config/db.php';

$email = $_POST['email'];

//checking admins table
$stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$adminResult = $stmt->get_result();

if($adminResult->num_rows > 0){
    $_SESSION['reset_email'] = $email;
    $_SESSION['reset_type'] = 'admin';
    header('Location: /Authentication/Frontend/php/reset-password-form.php');
    exit();
}

//checking users
$stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$userResult = $stmt->get_result();

if($userResult->num_rows > 0){
    $_SESSION['reset_email'] = $email;
    $_SESSION['reset_type'] = 'user';
    header('Location: /Authentication/Frontend/php/reset-password-form.php');
    exit();
}

?>