<?php
include '../Config/db.php';
session_start();

//we create an array to store error messages
$errors = [];
// print_r( $errors);
//we then check the he server request mehod was set to post and we check the form that is postiong the data...is it the login or register
if($_SERVER["REQUEST_METHOD"] === 'POST' && isset($_POST['addadmin'])){
    $name = htmlspecialchars($_POST['name']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password =password_hash($_POST['password'], PASSWORD_DEFAULT);


    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalide email format';
        $_SESSION['errors']=$errors;
        header('Location: /Authentication/Frontend/php/add-admin.php');
        exit();
        
    }
    if (empty($name)) {
        $errors['name'] = 'Name is required';
        $_SESSION['errors']=$errors;
        header('Location: /Authentication/Frontend/php/add-admin.php');
        exit();
        
    }
    if (strlen($password) < 6) {
        $errors['password'] = 'Password must be atleast 6 characters long';
        $_SESSION['errors']=$errors;
        header('Location: /Authentication/Frontend/php/add-admin.php');
        exit();
        
    }

    $sql = "SELECT * FROM admins WHERE email = '$email'";
    $result = $conn->query($sql);
    if($result->num_rows > 0){
        $errors['user_exist'] = 'Email already exist';
    } 
    if(!empty($errors)){
        $_SESSION['errors']=$errors;
        header('Location: /Authentication/Frontend/php/add-admin.php');
        exit();
        
    }
    
    $sql = "INSERT INTO admins (name, email, password) VALUES ('$name', '$email', '$password')";
         if($conn->query($sql)){

             header("Location: /Authentication/Frontend/php/index.php ");
             exit();
         }
}
