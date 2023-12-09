<?php
require_once('dbconn.php');
global $dbconn;

if (isset($_POST['register'])) {
    if (
        isset($_POST['name']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['password'])
        && isset($_POST['phone']) && isset($_POST['email'])) {

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
        <input type="email" placeholder="Correo electrónico" name="email" id="email" required><br><br>
        <input type="password" placeholder="Contraseña" name="password" id="password" required><br><br>
        <input type="text" placeholder="Dirección" name="address" id="address" required><br><br>
        <input type="tel" placeholder="Teléfono" name="phone" id="phone" pattern="[0-9]{4}-[0-9]{4}" required><br>
        <small>Formato: 6123-4567</small><br><br>
        <input name="register" id="register" type="submit">
    </form>
</body>

</html>