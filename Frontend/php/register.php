<?php
//we want to display the errors in the useraccont.php on the main page (register.php)
//so first we start the session then we check if there are any errors
session_start();
if(isset($_SESSION['errors'])){
    $errors = $_SESSION['errors'];
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="../css/register.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
</head>
<body>
<div class="container">
       
        <form action="/Authentication/backend/useraccount.php" method="POST" id="form">
        <h1 class="form-title">Sign Up</h1>
        <?php
        if(isset($errors['user_exist'])){
            echo '<div class="error-main"> <p>' . $errors['user_exist'] . '</p></div>';
        }
        ?>
        <div class="input_group">
                <i class="fas fa-user"></i>
                <input type="text" name="name" id="name" placeholder="Username" required>

                <?php
                    if(isset($errors['name'])){
                        echo '<div class="error-main"> <p>' . $errors['name'] . '</p></div>';
                    }
                ?>
        </div>
        <div class="input_group">
            <i class="fas fa-envelope"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
            <?php
                if(isset($errors['email'])){
                    echo '<div class="error-main"> <p>' . $errors['email'] . '</p></div>';
            }
        ?>
        </div>
            <div class="input_group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" id="password" placeholder="Password" required>
                <i class="fa fa-eye" id="eye"></i>

                <?php
        if(isset($errors['password'])){
            echo '<div class="error-main"> <p>' . $errors['password'] . '</p></div>';
        }
        ?>
            </div>
            <!-- <div class="input_group">
                <i class="fas fa-lock"></i>
                <input type="password" name="confirm_password" placeholder="Confirm password" required>
                <?php
                // if(isset($errors['confirm_password'])){
                //     echo '<div class="error-main"> <p>' . $errors['confirm_password'] . '</p></div>';
                // }
                ?>
                
            </div> -->
            <!-- <p class="recover">
                <a href="">Recover password</a>
            </p> -->
            <input type="submit" value="Sign Up" name="signup" class="btn">
            <p class="or">
                --------or--------
            </p>
            <!-- <div class="icons">
                <i class="fab fa-google"></i>
                <i class="fab fa-facebook"></i>
            </div> -->
            <div class="links">
                <p>Already have account ? </p>
                <a href="/Authentication/Frontend/php/index.php">Sign-in</a>
            </div>
        </form>
    </div>
    <script src="/Authentication/Frontend/js/script.js"></script>
</body>
</html>

<?php
if(isset($_SESSION['errors'])){
    unset($_SESSION['errors']);
}
?>