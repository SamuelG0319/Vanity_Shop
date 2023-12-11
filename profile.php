<!DOCTYPE html>
<html lang="en">

<head>

    <?php
    require_once('dbconn.php');

    session_start();

    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION['user'])) {
        // Si ha iniciado sesión, guarda los datos en variables de sesión
        $cod_user = $_SESSION['cod_user'];
        $user = $_SESSION['user'];
        $password = $_SESSION['password'];
        $name = $_SESSION['name'];
        $lastname = $_SESSION['lastname'];
        $phone = $_SESSION['phone'];
        $email = $_SESSION['email'];
        $address = $_SESSION['address'];
    }


    ?>

    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Vanity - Edit Profile</title>

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
                        <h2>Editar Perfil</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <br>

    <!-- ##### Edit Area Start ##### -->
    <div class="row">
        <div class="col-xl-8  container">
            <div class="card mb-4">
                <div class="card-header">Account Details</div>
                <div class="card-body">

                    <form action="" method="POST">

                        <div class="row gx-3 mb-3">
                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">UserName</label>
                                <input class="form-control" name="userName" id="userName" type="text"
                                    value="<?php echo $user; ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName">Password</label>
                                <input class="form-control" name="uPassword" id="uPassword" type="text"
                                    value="<?php echo $password; ?>" required>
                            </div>
                        </div>

                        <div class="row gx-3 mb-3">

                            <div class="col-md-6">
                                <label class="small mb-1" for="inputFirstName">First name</label>
                                <input class="form-control" name="fName" id="fName" type="text"
                                    value="<?php echo $name; ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLastName">Last name</label>
                                <input class="form-control" name="lastName" id="lasName" type="text"
                                    value="<?php echo $lastname; ?>" required>
                            </div>
                        </div>

                        <div class="row gx-3 mb-3">

                            <div class="col-md-6">
                                <label class="small mb-1" for="inputOrgName">Phone Number</label>
                                <input class="form-control" name="nPhone" id="nPhone" type="text"
                                    value="<?php echo $phone; ?>" required>
                            </div>

                            <div class="col-md-6">
                                <label class="small mb-1" for="inputLocation">Email</label>
                                <input class="form-control" name="aEmail" id="aEmail" type="email"
                                    value="<?php echo $email; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="small mb-1" for="inputEmailAddress">Address</label>
                            <input class="form-control" name="iAddress" id="iAddress" type="text"
                                value="<?php echo $address; ?>" required>
                        </div>

                        <div class="container">
                            <button class="btn btn-primary container" type="submit">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="container">
                <button class="btn btn-danger container" onclick="deleteaccount()">Delete Account</button>
            </div>
        </div>
    </div>
    <!-- ##### Edit Area End ##### -->


    <!-- ##### Script Area Start ##### -->
    <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript"></script>
    <script>
        function deleteaccount() {
            // Redireccionar a la página PHP deseada
            window.location.href = 'deleteUser.php'; // Reemplaza con la ruta correcta de tu otra página PHP
        }
    </script>
    <!-- ##### Script Area End ##### -->

    <!-- ##### Process Area Start ##### -->
    <?php

    try {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            global $dbconn;
            // Datos recibidos del formulario (asegúrate de validar y sanear estos valores)
            $userName = $_POST['userName'];
            $userPassword = $_POST['uPassword'];
            $fName = $_POST['fName'];
            $lastName = $_POST['lastName'];
            $Email = $_POST['aEmail'];
            $Address = $_POST['iAddress'];
            $Phone = $_POST['nPhone'];

            $_SESSION['user'] = $userName;
            $_SESSION['password'] = $userPassword;
            $_SESSION['name'] = $fName;
            $_SESSION['lastname'] = $lastName;
            $_SESSION['email'] = $Email;
            $_SESSION['address'] = $Address;
            $_SESSION['phone'] = $Phone;

            // Sentencia SQL de actualización con marcadores de posición
            $sql = "UPDATE user SET user=:user, password=:password, name=:name, last_name=:lastname, email=:email, address=:address, phone=:phone WHERE user=:user";

            // Preparar la consulta
            $stmt = $dbconn->prepare($sql);

            // Vincular los valores a los marcadores de posición
            $stmt->bindParam(':password', $userPassword);
            $stmt->bindParam(':name', $fName);
            $stmt->bindParam(':lastname', $lastName);
            $stmt->bindParam(':email', $Email);
            $stmt->bindParam(':address', $Address);
            $stmt->bindParam(':phone', $Phone);
            $stmt->bindParam(':user', $userName);

            // Ejecutar la consulta
            $stmt->execute();

        }
    } catch (PDOException $e) {
        echo "Error al actualizar el registro: " . $e->getMessage();
    }
    ?>
    <!-- ##### Process Area End ##### -->
</body>

</html>