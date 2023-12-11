<!DOCTYPE html>
<html lang="es">

<head>

    <?php
    require_once('dbconn.php');

    session_start();

    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION['admin'])) {
        // Si ha iniciado sesión, solicita los datos de las variables de sesión
        $adminCod = $_SESSION['cod_admin'];
        $username = $_SESSION['user'];
        $password = $_SESSION['password'];
        $name = $_SESSION['name'];
        $last_name = $_SESSION['lastname'];
        $phone = $_SESSION['phone'];
        $email = $_SESSION['email'];
        $position = $_SESSION['position'];
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
                <?php
                if (isset($username)) {
                    ?>
                    <div class="classynav">
                        <ul>
                            <li><a href="#">Bienvenid@
                                    <?php echo "$username"; ?>
                                </a></li>
                            <li><a href="logout-admmin.php">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                    <?php
                }
                ?>
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
                        <h2>CRUD Clientes/Usuarios</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <br>

    <!-- ##### Menu Area Start ##### -->
    <div class="container">
        <button class="btn btn-primary container" onclick="createUser()">Create User</button>
    </div>

    <br>

    <div class="container">
        <button class="btn btn-info container" onclick="readUser()">Read User</button>
    </div>

    <br>

    <div class="container">
        <button class="btn btn-secondary container" onclick="updateUser()">Update User</button>
    </div>

    <br>

    <div class="container">
        <button class="btn btn-danger container" onclick="deleteUser()">Delete User</button>
    </div>
    <!-- ##### Menu Area End ##### -->

    <!-- ##### Script Area Start ##### -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
    <script>
        function createUser() {
            // Redireccionar a la página PHP deseada
            window.location.href = 'create-user.php'; // Reemplaza con la ruta correcta de tu otra página PHP
        }
    </script>

    <script>
        function readUser() {
            // Redireccionar a la página PHP deseada
            window.location.href = 'read-user.php'; // Reemplaza con la ruta correcta de tu otra página PHP
        }
    </script>

    <script>
        function updateUser() {
            // Redireccionar a la página PHP deseada
            window.location.href = 'update-user.php'; // Reemplaza con la ruta correcta de tu otra página PHP
        }
    </script>

    <script>
        function deleteUser() {
            // Redireccionar a la página PHP deseada
            window.location.href = 'delete-user.php'; // Reemplaza con la ruta correcta de tu otra página PHP
        }
    </script>
    <!-- ##### Script Area End ##### -->