<?php

session_start();
include '../Config/db.php';
$errors = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['signin'])) {
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }
    if (empty($password)) {
        $errors['password'] = 'Password cannot be empty';
    }

    if(!empty($errors)){
        $_SESSION['errors']=$errors;
        header('Location: /Authentication/Frontend/php/index.php');
        exit();
        
    }

    // First, check in the admins table
    $stmt = $conn->prepare("SELECT * FROM admins WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $admin_result = $stmt->get_result();

    if ($admin_result->num_rows === 1) {
        // Admin found, verify password
        $admin = $admin_result->fetch_assoc();
        if (password_verify($password, $admin['password'])) {
            $_SESSION['user_email'] = $admin['email'];
            $_SESSION['user_id'] = $admin['id']; //i did this because i have one backend for the chat system and we need to check who is logged in... to determine who is the sender and who is the receiver.
            //i needed a script that retrives the user id and  type based on their session or login or auth token. 
            $_SESSION['admin_id'] = $admin['id']; 
            $_SESSION['user_type'] = 'admin';
            
            header("Location: /Authentication/Frontend/php/admin_dashboard.php");
            exit();
        } else {

            $errors['admin_login'] = 'Invalid email or password';
            $_SESSION['errors']=$errors;
            header('Location: /Authentication/Frontend/php/index.php');
            exit();
        }
    }//else{
    //     $errors['login'] = 'user not found';
    //     $_SESSION['errors']=$errors;
    //     header('Location: index.php');
    //     exit();
    // }

    // Check in the users table if not found in admins table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user_result = $stmt->get_result();

    if ($user_result->num_rows === 1) {
        // User found, verify password
        $user = $user_result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            //store them in sessions....
            $_SESSION['user_email'] = $user['email'];
            $_SESSION['user_id'] = $user['id']; 
            $_SESSION['user_type'] = 'user'; 

            header("Location: /Authentication/Frontend/php/userdashboard.php");
            exit();
        } else {
            //echo 'Wrong password for user';
            $errors['user_login'] = 'Invalid email or password';
            $_SESSION['errors']=$errors;
            header('Location: /Authentication/Frontend/php/index.php');
            exit();
        }
    } else {
        
        $errors['login'] = 'user not found';
        $_SESSION['errors']=$errors;
        header('Location: /Authentication/Frontend/php/index.php');
        exit();
    }
}



// echo password_hash("12345678**", PASSWORD_DEFAULT)
?>


