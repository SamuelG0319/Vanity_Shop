<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once('dbconn.php');
    session_start();
    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION['user'])) {
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
                        <h2>Delete Admins</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <div class="checkout_area section-padding-80">
        <div class="container">
            <div class="text">
                <div class="checkout_details_area mt-50 clearfix">
                    <div class="cart-page-heading mb-30 text-center">
                        <h5>Enter the Admin code for Delete</h5>
                    </div>
                    <form action="#" method="post">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="userCode">Admin Code</label>
                                <input type="text" class="form-control" name="adminCode" id="adminCode" value=""
                                    required>
                            </div>

                            <div class="container">
                                <button class="btn btn-danger container" type="submit">Delete</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $adminCode = $_POST['adminCode'];
        global $dbconn;
        $sql = "DELETE FROM admin WHERE cod_admin LIKE $adminCode";
        $result = $dbconn->query($sql);
        echo "<div style='display: flex; text-aling: center; justify-content: center; font-size:18px;'>Admin eliminado con exito</div>";
    }
    ?>
</body>

</html>