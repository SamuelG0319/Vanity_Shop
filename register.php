<?php
require_once('dbconn.php');

class UserRegistration
{
    private $dbconn;

    public function __construct($dbconn)
    {
        $this->dbconn = $dbconn;
    }

    public function registerUser()
    {
        if (isset($_POST['signup'])) {
            $userData = $this->validateAndGetData();

            if ($userData) {
                if ($this->userExists($userData['username'])) {
                    echo '<script> alert("Usuario existente"); </script>';
                } else {
                    $this->insertUser($userData);
                }
            }
        }
    }

    private function validateAndGetData()
    {
        if (
            isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) &&
            isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['password'])
        ) {
            $username = trim($_POST['username']);
            $password = trim($_POST['password']);
            $name = trim($_POST['name']);
            $lastname = trim($_POST['lastname']);
            $email = trim($_POST['email']);
            $address = trim($_POST['address']);
            $phone = trim($_POST['phone']);

            $code = isset($_POST['code']) ? $_POST['code'] : null;

            if (
                !empty($name) && !empty($lastname) && !empty($username) && !empty($email) && !empty($address) &&
                !empty($phone) && !empty($password)
            ) {
                return [
                    'username' => $username,
                    'password' => $password,
                    'name' => $name,
                    'lastname' => $lastname,
                    'email' => $email,
                    'address' => $address,
                    'phone' => $phone,
                    'code' => $code,
                ];
            }
        }

        return false;
    }

    private function userExists($username)
    {
        $verifyUser = $this->dbconn->prepare("SELECT user FROM user WHERE user = :user");
        $verifyUser->execute(['user' => $username]);
        $selectedUser = $verifyUser->fetch(PDO::FETCH_ASSOC);

        return ($selectedUser && $username == $selectedUser['user']);
    }

    private function insertUser($userData)
    {
        if ($userData['code'] != null) {
            $insertUser = "INSERT INTO user (company_code, user, password, name, last_name, email, address, phone) VALUES (:company_code, :user, :password, :name, :last_name, :email, :address, :phone)";
            $prepareUser = $this->dbconn->prepare($insertUser);
            $createUser = $prepareUser->execute([
                ':company_code' => $userData['code'],
                ':user' => $userData['username'],
                ':password' => $userData['password'],
                ':name' => $userData['name'],
                ':last_name' => $userData['lastname'],
                ':email' => $userData['email'],
                ':address' => $userData['address'],
                ':phone' => $userData['phone'],
            ]);
        } else {
            $insertUser = "INSERT INTO user (user, password, name, last_name, email, address, phone) VALUES (:user, :password, :name, :last_name, :email, :address, :phone)";
            $prepareUser = $this->dbconn->prepare($insertUser);
            $createUser = $prepareUser->execute([
                ':user' => $userData['username'],
                ':password' => $userData['password'],
                ':name' => $userData['name'],
                ':last_name' => $userData['lastname'],
                ':email' => $userData['email'],
                ':address' => $userData['address'],
                ':phone' => $userData['phone'],
            ]);
        }

        if ($createUser) {
            /* --- Get last ID --- */
            $cod_user = $this->dbconn->lastInsertId();

            /* --- Start the session --- */
            session_start();
            $_SESSION['cod_user'] = $cod_user;
            $_SESSION['company_code'] = $userData['code'];
            $_SESSION['user'] = $userData['username'];
            $_SESSION['password'] = $userData['password'];
            $_SESSION['name'] = $userData['name'];
            $_SESSION['lastname'] = $userData['lastname'];
            $_SESSION['email'] = $userData['email'];
            $_SESSION['address'] = $userData['address'];
            $_SESSION['phone'] = $userData['phone'];

            header("Location: index.php");
            exit;
        }
    }
}

$userRegistration = new UserRegistration($dbconn);
$userRegistration->registerUser();
?>

<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <link rel="stylesheet" href="assets/css/core-style.css">
    <link rel="stylesheet" href="assets/css/register.css">
    <link rel="stylesheet" href="assets/style.css">
</head>

<body>
    <section class="signup">
        <div class="container">
            <div class="signup-content">
                <div class="signup-form">
                    <h2 class="form-title">Sign up</h2>
                    <form method="POST" class="register-form" id="register-form">
                        <div class="form-group">
                            <label for="name"><span class="material-symbols-outlined">face</span></i></label>
                            <input type="text" name="name" id="name" placeholder="Nombre" required />
                        </div>
                        <div class="form-group">
                            <label for="lastname"><span class="material-symbols-outlined">face</span></label>
                            <input type="text" name="lastname" id="lastname" placeholder="Apellido" required />
                        </div>
                        <span id="check_username"></span>
                        <div class="form-group">
                            <label for="username"><span class="material-symbols-outlined">alternate_email</span></label>
                            <input type="text" name="username" id="username" placeholder="Usuario" required />
                        </div>
                        <div class="form-group">
                            <label for="email"><span class="material-symbols-outlined">mail</span></label>
                            <input type="email" name="email" id="email" placeholder="Correo electrónico" required />
                        </div>
                        <div class="form-group">
                            <label for="address"><span class="material-symbols-outlined">home</span></label>
                            <input type="text" name="address" id="address" placeholder="Dirección" required />
                        </div>
                        <span>Ej.: 6655-4499</span>
                        <div class="form-group">
                            <label for="phone"><span class="material-symbols-outlined">call</span></label>
                            <input type="text" name="phone" id="phone" pattern="[0-9]{4}-[0-9]{4}"
                                placeholder="Teléfono" required />
                        </div>
                        <div class="form-group">
                            <label for="password"><span class="material-symbols-outlined">password</span></label>
                            <input type="password" name="password" id="password" placeholder="Contraseña" required />
                        </div><br>
                        <div name="company_checkbox" id="company_checkbox" class="checkbox-wrapper-24">
                            <input type="checkbox" id="check-24" name="check-24" value="" />
                            <label for="check-24">
                                <span></span>Marcar si es es representante empresarial
                            </label>
                        </div>
                        <div name="company_code" id="company_code" class="form-group" style="display: none;">
                            <label for="code"><span class="material-symbols-outlined">store</span></label>
                            <input type="text" name="code" id="code" placeholder="Código de empresa" />
                        </div>
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
    <script src="assets/js/register.js"></script>
</body>

</html>