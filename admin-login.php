<?php
require_once('dbconn.php');
global $dbnconn;

if (isset($_POST['signin'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $verifyAdmin = $dbconn->prepare("SELECT * FROM admin WHERE username = :username");
            $verifyAdmin->execute(['username' => $username]);

            if ($verifyAdmin->rowCount() > 0) {
                $getAdmData = $verifyAdmin->fetch(PDO::FETCH_ASSOC);
                if ($username == $getAdmData['username'] && $password == $getAdmData['password']) {
                    session_start();

                    /* - Getting admin's data - */
                    $adminCod = $getAdmData['cod_admin'];
                    $name = $getAdmData['name'];
                    $last_name = $getAdmData['last_name'];
                    $phone = $getAdmData['phone'];
                    $email = $getAdmData['email'];
                    $position = $getAdmData['position'];

                    /* - Session variables - */
                    $_SESSION['cod_admin'] = $adminCod;
                    $_SESSION['user'] = $username;
                    $_SESSION['password'] = $password;
                    $_SESSION['name'] = $name;
                    $_SESSION['lastname'] = $last_name;
                    $_SESSION['phone'] = $phone;
                    $_SESSION['email'] = $email;
                    $_SESSION['position'] = $position;

                    /* - Success message - */
                    echo json_encode(['status' => 'success', 'message' => 'Bienvenidos administrador']);
                    exit();

                }
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Usuario o Contraseña incorrectos']);
                exit();
            }
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Llena los campos']);
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Admin Login</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- ---------- link references ---------- -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link rel="icon" type="image/png" href="assets/img/sign-up/home.ico" />

    <!-- ---------- CSS References ----------- -->
    <link rel="stylesheet" type="text/css" href="assets/css/util.css">
    <link rel="stylesheet" type="text/css" href="assets/css/admin-login.css">

    <!-- ---------- Fonts References ----------- -->
    <link rel="stylesheet" type="text/css" href="assets/fonts/Linearicons-Free-v1.0.0/icon-font.min.css">

</head>

<body>
    <div class="limiter">
        <div class="container-login100" style="background-image: url('assets/img/sign-up/back.jpeg');">
            <div class="wrap-login100 p-t-30 p-b-50">
                <span class="login100-form-title p-b-41">
                    Bienvenido administrador
                </span>
                <form class="login100-form validate-form p-b-33 p-t-5" id="login-form" name="login-form">

                    <div class="wrap-input100 validate-input" data-validate="Enter username">
                        <input class="input100" type="text" name="username" id="username" placeholder="Usuario">
                        <span class="focus-input100" data-placeholder="&#xe82a;"></span>
                    </div>

                    <div class="wrap-input100 validate-input" data-validate="Enter password">
                        <input class="input100" type="password" name="password" id="password" placeholder="Contraseña">
                        <span class="focus-input100" data-placeholder="&#xe80f;"></span>
                    </div>

                    <div class="container-login100-form-btn m-t-32">
                        <button class="login100-form-btn" id="signin" name="signin">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div id="dropDownSelect1"></div>

    <!-- JavaScript section -->
    <script src="assets/js/admin-login.js"></script>
    <script>
        $(document).ready(function () {
            $("#login-form").submit(function (e) {
                e.preventDefault();

                var username = $("#username").val();
                var password = $("#password").val();

                $.ajax({
                    type: "POST",
                    url: "admin-login.php",
                    data: {
                        signin: true,
                        username: username,
                        password: password
                    },
                    dataType: 'json',
                    success: function (response) {
                        alert(response.message);

                        /* - User found on db - */
                        if (response.status === "success") {
                            window.location.href = "admin-side.php"
                            exit();
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>