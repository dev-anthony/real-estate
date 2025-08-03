<?php
include '../Config/db.php';
session_start();

//we create an array to store error messages
$errors = [];
// print_r( $errors);
//we then check the he server request mehod was set to post and we check the form that is postiong the data...is it the login or register
if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['signup'])){
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password =password_hash($_POST['password'], PASSWORD_BCRYPT);
    // $confirm_password = $_POST['confirm_password'];
    // $created_at=date('Y-m-d H:i:s');

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalide email format';
        $_SESSION['errors']=$errors;
        header('Location: /Authentication/Frontend/php/register.php');
        exit();
        
    }
    if (empty($name)) {
        $errors['name'] = 'Name is required';
        $_SESSION['errors']=$errors;
        header('Location: /Authentication/Frontend/php/register.php');
        exit();
        
    }
    if (strlen($password) < 6) {
        $errors['password'] = 'Password must be atleast 6 characters long';
        $_SESSION['errors']=$errors;
        header('Location: /Authentication/Frontend/php/register.php');
        exit();
        
    }
    // if ($password !== $confirm_password) {
    //     $errors['confirm_password'] = 'Passwords do not match';
    // }

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $errors['user_exist'] = 'Email already exist';
    } 
    if(!empty($errors)){
        $_SESSION['errors']=$errors;
        header('Location: /Authentication/Frontend/php/register.php');
        exit();
        
    }
    
    $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
         if($conn->query($sql)){

             header("Location: /Authentication/Frontend/php/index.php");
             exit();
         }
}

// include 'db.php';
// session_start();

// // We create an array to store error messages
// $errors = [];

// if ($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['signup'])) {
//     $name = htmlspecialchars($_POST['name']);
//     $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
//     $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
//     $confirm_password = $_POST['confirm_password'];

//     // Validate email
//     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
//         $errors['email'] = 'Invalid email format';
//     }
    
//     // Validate name
//     if (empty($name)) {
//         $errors['name'] = 'Name is required';
//     }
    
//     // Validate password length
//     if (strlen($password) < 6) {
//         $errors['password'] = 'Password must be at least 6 characters long';
//     }
    
//     // Validate password confirmation
//     if ($password !== $confirm_password) {
//         $errors['confirm_password'] = 'Passwords do not match';
//     }

//     // Check if email already exists in the database
//     $sql = "SELECT * FROM users WHERE email = '$email'";
//     $result = $conn->query($sql);

//     if ($result->num_rows > 0) {
//         $errors['user_exist'] = 'Email already exists';
//     }

//     // If there are any errors, redirect back to the registration page
//     if (!empty($errors)) {
//         $_SESSION['errors'] = $errors;
//         header('Location: register.php');
//         exit();  // Important to prevent further execution after the redirect
//     }

//     // Proceed with inserting the user into the database if no errors
//     $sql = "INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')";
    
//     if ($conn->query($sql)) {
//         header("Location: index.php"); // Redirect after successful registration
//         exit();  // Important to stop further script execution
//     } else {
//         // Handle the case where the insertion fails (for example, database error)
//         $errors['database'] = 'An error occurred while registering. Please try again.';
//         $_SESSION['errors'] = $errors;
//         header('Location: register.php');
//         exit();
//     }
// }
