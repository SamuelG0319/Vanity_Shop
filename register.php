<?php
require_once('dbconn.php');
global $dbconn;

if (isset($_POST['signup'])) {
    if (
        isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) &&
        isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['password'])
    ) {
        //Removing blank spaces.
        $name = trim($_POST['name']);
        $lastname = trim($_POST['lastname']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $phone = trim($_POST['phone']);
        $password = trim($_POST['password']);

        //Checking if 'code' has a value or is null.
        $code = isset($_POST['code']) ? $_POST['code'] : null;

        if (
            !empty($name) && !empty($lastname) && !empty($username) && !empty($email) && !empty($address) &&
            !empty($phone) && !empty($password)
        ) {
            $verifyUser = $dbconn->prepare("select user from user where user = :user");
            $verifyUser->execute(['user' => $username]);
            $selectedUser = $verifyUser->fetch(PDO::FETCH_ASSOC);

            if ($username == $selectedUser['user']) {
                echo '<script> alert("Usuario existente"); </script>';
            } else {
                if ($code != null) {
                    $insertUser = "insert into user (company_code, user, password, name, last_name, email, address, phone) values (:company_code, :user, :password, :name, :last_name, :email, :address, :phone)";
                    $prepareUser = $dbconn->prepare($insertUser);
                    $createUser = $prepareUser->execute(array(':company_code' => $code, ':user' => $username, ':password' => $password, ':name' => $name,
                        ':last_name' => $lastname, ':email' => $email, ':address' => $address, ':phone' => $phone));

                    if ($createUser) {
                        session_start();
                        $_SESSION['user'] = $username;
                        header("Location: index.php");
                    }
                } else {
                    $insertUser = "insert into user (user, password, name, last_name, email, address, phone) values (:user, :password, :name, :last_name, :email, :address, :phone)";
                    $prepareUser = $dbconn->prepare($insertUser);
                    $createUser = $prepareUser->execute(array(':user' => $username, ':password' => $password, ':name' => $name,
                        ':last_name' => $lastname, ':email' => $email, ':address' => $address, ':phone' => $phone));

                    if ($createUser) {
                        session_start();
                        $_SESSION['user'] = $username;
                        header("Location: index.php");
                    }
                }
            }
        }
    }
}

?>

<!-- --------------- HTML section --------------- -->
<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>

    <!-- link references -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- css references -->
    <link rel="stylesheet" href="assets/css/core-style.css">
    <link rel="stylesheet" href="assets/css/register.css">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <!-- ---------- Header Area Start ---------- -->

    <!-- ---------- Sign up form ---------- -->
    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Sign up</h2>
                    <form method="POST" class="register-form" id="register-form">
                        <!-- user name -->
                        <div class="form-group">
                            <label for="name"><span class="material-symbols-outlined">face</span></i></label>
                            <input type="text" name="name" id="name" placeholder="Nombre" required />
                        </div>
                        <!-- user lastname -->
                        <div class="form-group">
                            <label for="lastname"><span class="material-symbols-outlined">face</span></label>
                            <input type="text" name="lastname" id="lastname" placeholder="Apellido" required />
                        </div>
                        <!-- username -->
                        <span id="check_username"></span>
                        <div class="form-group">
                            <label for="username"><span class="material-symbols-outlined">alternate_email</span></label>
                            <input type="text" name="username" id="username" placeholder="Usuario" required />
                        </div>
                        <!-- user email -->
                        <div class="form-group">
                            <label for="email"><span class="material-symbols-outlined">mail</span></label>
                            <input type="email" name="email" id="email" placeholder="Correo electrónico" required />
                        </div>
                        <!-- user address -->
                        <div class="form-group">
                            <label for="address"><span class="material-symbols-outlined">home</span></label>
                            <input type="text" name="address" id="address" placeholder="Dirección" required />
                        </div>
                        <!-- user phone number -->
                        <div class="form-group">
                            <label for="phone"><span class="material-symbols-outlined">call</span></label>
                            <input type="text" name="phone" id="phone" pattern="[0-9]{4}-[0-9]{4}"
                                placeholder="Teléfono" required />
                        </div>
                        <!-- user password -->
                        <div class="form-group">
                            <label for="password"><span class="material-symbols-outlined">password</span></label>
                            <input type="password" name="password" id="password" placeholder="Contraseña" required />
                        </div><br>
                        <!-- Checkbox para indicar si es enviado por una empresa -->
                        <div name="company_checkbox" id="company_checkbox" class="checkbox-wrapper-24">
                            <input type="checkbox" id="check-24" name="check-24" value="" />
                            <label for="check-24">
                                <span></span>Marcar si es es representante empresarial
                            </label>
                        </div>
                        <!-- Campo para el código de empresa (inicialmente oculto) -->
                        <div name="company_code" id="company_code" class="form-group" style="display: none;">
                            <label for="code"><span class="material-symbols-outlined">store</span></label>
                            <input type="text" name="code" id="code" placeholder="Código de empresa" />
                        </div>
                        <!-- Register button -->
                        <div class="form-group form-button">
                            <input type="submit" name="signup" id="signup" class="form-submit" value="Registrar" />
                        </div>
                    </form>
                </div>
                <div class="signup-image">
                    <figure><img src="assets/img/sign-up/clothing-sign.jpg" alt="sing up image"></figure>
                    <a href="login.php" class="signup-image-link">Ya soy miembro</a>
                </div>
            </div>
        </div>
    </section>

    <!-- JavaScript section -->
    <script src="assets/js/register.js"></script>
</body>

</html>