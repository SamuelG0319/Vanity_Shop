<?php
require_once('dbconn.php');
global $dbconn;

if (isset($_POST['register'])) {
    if (
        isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['username']) && isset($_POST['email']) &&
        isset($_POST['phone']) && isset($_POST['address']) && isset($_POST['password'])
    ) {
        $name = trim($_POST['name']);
        $lastname = trim($_POST['lastname']);
        $username = trim($_POST['username']);
        $email = trim($_POST['email']);
        $address = trim($_POST['address']);
        $phone = trim($_POST['phone']);
        $password = trim($_POST['password']);

        if (
            !empty($name) && !empty($lastname) && !empty($username) && !empty($email) && !empty($address) &&
            !empty($phone) && !empty($password)
        ) {
            $verifyUser = $dbconn->prepare("select user from user where user = :user");
            $verifyUser->execute(['user' => $username]);
            $selectedUser = $verifyUser->fetch(PDO::FETCH_ASSOC);

            if ($username == $selectedUser['user']) {
                '<script> alert("Usuario existente"); </script>';
            } else {
                $insertUser = "insert into user (user, password, name, last_name, email, address, phone) values (:user, :password, :name, :last_name, :email, :address, :phone)";
                $prepareUser = $dbconn->prepare($insertUser);
                $createUser = $prepareUser->execute(array(':user' => $username, ':password' => $password, ':name' => $name,
                    ':last_name' => $lastname, ':email' => $email, ':address' => $address, ':phone' => $phone));

                if ($createUser) {
                    session_start();
                    $_SESSION['user'] = $username;
                    header("Location: indext.html");
                } else {
                    echo 'Llena todos los campos';
                }
            }
        }
    }
}
?>

<!DOCTYPE html>

<html lang="es" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registro</title>
</head>

<body>
    <form method="POST">
        <input type="text" placeholder="Nombre" name="name" id="name" required><br><br>
        <input type="text" placeholder="Apellido" name="lastname" id="lastname" required><br><br>
        <input type="text" placeholder="Username" name="username" id="username" required><br><br>
        <input type="email" placeholder="Correo electrónico" name="email" id="email" required><br><br>
        <input type="text" placeholder="Dirección" name="address" id="address" required><br><br>
        <input type="tel" placeholder="Teléfono" name="phone" id="phone" pattern="[0-9]{4}-[0-9]{4}" required><br>
        <small>Formato: 6123-4567</small><br><br>
        <input type="password" placeholder="Contraseña" name="password" id="password" required><br><br>
        <input name="register" id="register" type="submit">
    </form>
</body>

</html>