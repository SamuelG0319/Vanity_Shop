<?php
require_once('dbconn.php');
global $dbnconn;

if (isset($_POST['signin'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $verifyUser = $dbconn->prepare("SELECT user, password FROM user WHERE user = :user 
            UNION 
            SELECT username AS user, password FROM admin WHERE username = :user");
            $verifyUser->execute(['user' => $username]);

            if ($verifyUser->rowCount() > 0) {
                $getData = $verifyUser->fetch(PDO::FETCH_ASSOC);
                if ($username == $getData['user']) {
                    if ($password == $getData['password']) {
                        session_start();
                        $_SESSION['user'] = $username;
                        header("Location: index.php");
                    } else {
                        echo "<script> alert('Contraseña incorrecta'); </script>";
                    }
                }
            } else {
                echo "<script> alert('Usuario no existente'); </script>";
            }
        } else {
            echo "<script> alert('Llene los campos'); </script>";
        }
    }
}
?>
<!DOCTYPE html>

<html lang="es" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login</title>

    <!-- ----- Icons references ----- -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- ----- Fonts references ----- -->
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- ----- CSS Styles ----- -->
    <link rel="stylesheet" href="assets/css/register.css">
</head>

<body>
    <!-- ----- Sing in  Form ----- -->
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="assets/img/sign-up/clothing-login.jpg" alt="sing up image"></figure>
                </div>

                <div class="signin-form">
                    <h2 class="form-title">Sign up</h2>
                    <form method="POST" class="register-form" id="login-form">
                        <!-- ----- Username field ----- -->
                        <div class="form-group">
                            <label for="your_name"><span
                                    class="material-symbols-outlined">alternate_email</span></label>
                            <input type="text" name="username" id="username" placeholder="Usuario" />
                        </div>
                        <!-- ----- Password field ----- -->
                        <div class="form-group">
                            <label for="your_pass"><span class="material-symbols-outlined">password</span></label>
                            <input type="password" name="password" id="password" placeholder="Contraseña" />
                        </div>
                        <!-- ----- Sign up button ----- -->
                        <div class="form-group form-button">
                            <input type="submit" name="signin" id="signin" class="form-submit" value="Iniciar sesión" />
                        </div>
                    </form>
                    <!-- ----- Login in with social network account ----- -->
                    <div class="social-login">
                        <span class="social-label">¿No tienes cuenta?</span>
                        <a href="register.php" class="signup-image-link">Crear una cuenta</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</body>

</html>