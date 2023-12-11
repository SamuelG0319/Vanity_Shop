<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once('dbconn.php');
    session_start();
    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION['user'])) {
        // Si ha iniciado sesión, solicita los datos de las variables de sesión
        $username = $_SESSION['user'];
        $password = $_SESSION['password'];
        $name = $_SESSION['name'];
        $last_name = $_SESSION['lastname'];
        $phone = $_SESSION['phone'];
        $email = $_SESSION['email'];
    }
    ?>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <!-- Title  -->
    <title>Vanity - Admin Side</title>
    <!-- Favicon  -->
    <link rel="icon" href="assets/img/core-img/logo.png">
    <!-- Core Style CSS -->
    <link rel="stylesheet" href="assets/css/core-style.css">
    <link rel="stylesheet" href="assets/style.css">
    <link rel="stylesheet" href="assets/Mstyle.css">
</head>

<body>
    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="index.php"><img src="assets/img/core-img/logo.png" alt="" height="100px"
                        width="100px"></a>
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <!-- Nav Start -->
                    <div class="classynav">
                        <ul>
                            <li><a href="admin-side.php">Admin Side</a></li>
                            <li><a href="crud-clientes.php">CRUD Clientes</a></li>
                            <li><a href="crud-admin.php">CRUD Administradores</a></li>
                            <li><a href="pedidos.php">Pedidos</a></li>
                            <li><a href="index.php">Ir a web</a></li>
                            <li><a href="logout-admin.php">Logout</a></li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>
            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">

                <!-- User Login Info -->
                <div class="user-login-info" id="userLoginInfo">
                    <a href="#"><img src="assets/img/core-img/user.svg" alt=""></a>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->
    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img" style="background-image: url(assets/img/bg-img/breadcumb.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Update Clientes/Usuarios</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Create User Form Area Start ##### -->
    <div class="checkout_area section-padding-80">
        <div class="container">
            <div class="text">
                <div class="checkout_details_area mt-50 clearfix">
                    <div class="cart-page-heading mb-30">
                        <h5>Enter Data for Update</h5>
                    </div>
                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-12 mb-3">
                                <label for="street_address">User Code</label>
                                <input type="text" class="form-control mb-3" name="user_code" id="user_code" value="">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="first_name">Username</label>
                                <input type="text" class="form-control" name="user_name" id="user_name" value=""
                                    required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name">Password </label>
                                <input type="text" class="form-control" name="password" id="password" value="" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="first_name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" value="" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name">Last Name</label>
                                <input type="text" class="form-control" name="lastname" id="lastname" value="" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="first_name">Email</label>
                                <input type="text" class="form-control" name="email" id="email" value="" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="last_name">Phone</label>
                                <input type="text" class="form-control" name="phone" id="phone" value="" required>
                            </div>
                            <div class="col-12 mb-3">
                                <label for="street_address">Address </label>
                                <input type="text" class="form-control mb-3" name="address" id="address" value="">
                            </div>
                            <div class="col-12 mb-3">
                                <label for="country">Company Code </label>
                                <select class="w-100" id="country">
                                    <option value="null">Null</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                </select>
                            </div>
                            <div class="container">
                                <input class="btn btn-primary container" name="btnsubmit" id="btnsubmit"
                                    type="submit">Update</input>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Create User Form Area End ##### -->
</body>

</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userCode = $_POST['user_code'];
    $user = $_POST['user_name'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    global $dbconn;

    $sql = "UPDATE user SET user='$user', password='$password', name='$name', last_name='$lastname', email='$email', address='$address', phone='$phone' WHERE cod_user=$userCode";
    $result = $dbconn->query($sql);
}
?>