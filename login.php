<?php
require_once('dbconn.php');

class Usuario
{
    private $dbconn;

    public function __construct($dbconn)
    {
        $this->dbconn = $dbconn;
    }

    public function login($username, $password)
    {
        $verifyUser = $this->dbconn->prepare("SELECT * FROM user WHERE user = :user");
        $verifyUser->execute(['user' => $username]);

        if ($verifyUser->rowCount() > 0) {
            $userData = $verifyUser->fetch(PDO::FETCH_ASSOC);
            if ($username == $userData['user'] && $password == $userData['password']) {
                session_start();

                /* - Getting user's data - */
                $userCod = $userData['cod_user'];
                $companyCode = $userData['company_code'];
                $name = $userData['name'];
                $last_name = $userData['last_name'];
                $email = $userData['email'];
                $address = $userData['address'];
                $phone = $userData['phone'];

                /* - Session variables - */
                $_SESSION['cod_user'] = $userCod;
                $_SESSION['company_code'] = $companyCode;
                $_SESSION['user'] = $username;
                $_SESSION['password'] = $password;
                $_SESSION['name'] = $name;
                $_SESSION['lastname'] = $last_name;
                $_SESSION['email'] = $email;
                $_SESSION['address'] = $address;
                $_SESSION['phone'] = $phone;

                /* - Success message - */
                return ['status' => 'success', 'message' => 'Login exitoso'];
            }
        }

        return ['status' => 'error', 'message' => 'Usuario o Contraseña incorrectos'];
    }
}

/* --- Instance of user --- */
$usuario = new Usuario($dbconn);

/* --- Verify if login form was send --- */
if (isset($_POST['signin'])) {
    if (isset($_POST['username']) && isset($_POST['password'])) {
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);

        if (!empty($username) && !empty($password)) {
            $loginResult = $usuario->login($username, $password);

            /* --- Return JSON answer --- */
            echo json_encode($loginResult);
            exit();
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Llena los campos']);
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="assets/img/sign-up/home.ico" />
    <title>Login</title>

    <!-- link references -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>

    <!-- Icons references -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />

    <!-- CSS Styles -->
    <link rel="stylesheet" href="assets/css/register.css">
</head>

<body>
    <!-- ----- Sing in Form ----- -->
    <section class="sign-in">
        <div class="container">
            <div class="signin-content">
                <div class="signin-image">
                    <figure><img src="assets/img/sign-up/clothing-login.jpg" alt="sing up image"></figure>
                </div>

                <div class="signin-form">
                    <h2 class="form-title">Iniciar sesión</h2>
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

    <!-- JavaScript section -->
    <script src="assets/js/user-login.js"></script>
</body>

</html>