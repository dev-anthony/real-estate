<?php
session_start();
include '../Config/db.php';
if(isset($_SESSION['user_id']) && isset($_SESSION['user_type'])){
    echo json_encode([
        'user_id' => $_SESSION['user_id'],
        'user_type' => $_SESSION['user_type'],
        'user_email' => $_SESSION['user_email']
    ]);
}else{
    echo json_encode(['error' => 'User not logged in']);
}


?>