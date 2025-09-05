<?php
session_start();
include '../Config/db.php';
if(isset($_SESSION['user_id']) && isset($_SESSION['user_type'])){
    echo json_encode([
        'user_id' => $_SESSION['user_id'],
        'user_type' => $_SESSION['user_type'],
        'user_email' => $_SESSION['user_email'],
        'user_name' => $_SESSION['user_name']
    ]);
}else{
    echo json_encode(['error' => 'User not logged in']);
}


?>