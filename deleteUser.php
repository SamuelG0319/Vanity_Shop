<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    require_once('dbconn.php');

    session_start();

    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION['user'])) {
        // Si ha iniciado sesión, guarda los datos en variables de sesión
        $user = $_SESSION['user'];
        $name = $_SESSION['name'];
        $lastname = $_SESSION['lastname'];
        $cod_user = $_SESSION['cod_user'];
    }
    ?>

    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Vanity - Delete User</title>

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
                            <li><a href="tops.php">Partes de arriba</a></li>
                            <li><a href="bottom.php">Partes de abajo</a></li>
                            <li><a href="shoes.php">Zapatos</a></li>
                            <li><a href="accesories.php">Accesorios</a></li>
                        </ul>
                    </div>
                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <?php
                if (isset($user)) {
                    ?>
                    <div class="classynav">
                        <ul>
                            <li><a href="#">Bienvenid@
                                    <?php echo "$user"; ?>
                                </a></li>
                            <li><a href="logout.php">Cerrar Sesión</a></li>
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
                        <h2>Delete User</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->
    <br>
    <!-- ##### Main Area Start ##### -->
    <div class="row">
        <div class="col-xl-8  container">
            <div class="card mb-4 text-center">
                <div class="card-header">Confirmation to delete user</div>
                <div class="card-body">

                    <form action="" method="POST">

                        <div class="mb-3 text-center">
                            <div>¿Are you sure that you want to delete your account?</div>
                        </div>
                        <div class="container">
                            <button class="btn btn-danger container" type="submit">Yes</button>
                        </div>

                    </form>
                </div>
                <div class="container">
                    <button class="btn btn-primary container" onclick="editProfile()">No</button>
                </div>
                <br>
            </div>
        </div>
    </div>
    <!-- ##### Main Area End ##### -->

    <!-- ##### Script Area Start ##### -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
    <script>
        function editProfile() {
            // Redireccionar a la página PHP deseada
            window.location.href = 'profile.php'; // Reemplaza con la ruta 
        }
    </script>
    <script>
        function redirigirAPagina() {
            // Redirigir a la página deseada
            window.location.href = 'index.php'; // Reemplaza con la ruta correcta de tu otra página PHP
        }
    </script>
    <!-- ##### Script Area End ##### -->

    <!-- ##### Process Area Start ##### -->
    <?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        global $dbconn;
        $user = $_SESSION['user'];

        // Sentencia SQL de actualización con marcadores de posición
        $sql = "DELETE FROM user WHERE user = :user";

        // Preparar la consulta
        $stmt = $dbconn->prepare($sql);

        // Vincular los valores a los marcadores de posición
        $stmt->bindParam(':user', $user);

        // Ejecutar la consulta
        $stmt->execute();
        
        session_destroy();

    } else {
        echo "Error al actualizar el registro: ";
    }

    ?>
    <!-- ##### Process Area End ##### -->
</body>

</html>