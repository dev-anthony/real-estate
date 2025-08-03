<?php
session_start();


if(!isset($_SESSION['reset_email']) || !isset(($_SESSION['reset_type']))){
    echo 'Unauthorized access';
    exit();
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>password reset</title>
</head>
<body>
    <form action="/Authentication/backend/reset-password.php" method="POST">
    <div class="input_group">
        <i class="fas fa-lock"></i>
        <input type="password" name="new_password" id="password" placeholder="New password" required>
        <i class="fa fa-eye" id="eye"></i>

        <!-- 
            // if(isset($errors['password'])){
            //     echo '<div class="error-main"> <p>' . $errors['password'] . '</p></div>';
            // }
        ?> -->
    </div>
    <button type="submit">Change Password</button>
    </form>
</body>
</html>