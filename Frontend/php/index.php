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
    <title>Login</title>
    <link rel="stylesheet" href="/Authentication/Frontend/css/index.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- add font awesome link -->
</head>
<body>
    <div class="container">
        
        <form action="/Authentication/backend/login.php" method="post" id="form">
        <h1 class="form-title">Login</h1>

        <?php
            if(isset($errors['admin_login']) ){
                echo '<div class="error-main"> <p>' . $errors['admin_login'] . '</p></div>';
            }elseif(isset($errors['user_login'])){
                echo '<div class="error-main"> <p>' . $errors['user_login'] . '</p></div>';
            }elseif (isset($errors['login'])) {
                echo '<div class="error-main"> <p>' . $errors['login'] . '</p></div>'; # code...
            }
        ?>
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
            <p class="recover">
                <a href="../html/forgot-password.html" id="recover">Recover password</a>
            </p>
            
            <input type="submit" value="sign in" name="signin" class="btn">
            <p class="or">
                --------or--------
            </p>
            <!-- <div class="icons">
                <i class="fab fa-google"></i>
                <i class="fab fa-facebook"></i>
            </div> -->
            <div class="links">
                <p>Dont have account yet? </p>
                <a href="register.php">Sign-up</a>
            </div>
        </form>
    </div>
    <script src="../js/script.js"></script>
</body>
</html>
<?php
if(isset($_SESSION['errors'])){
    unset($_SESSION['errors']);
}
?>