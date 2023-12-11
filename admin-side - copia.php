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
                            <li><a href="logout-admin.php">Cerrar Sesión</a></li>
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
                        <h2>Admin Side</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <?php
    global $dbconn;

    // Consultar la base de datos para obtener todos los registros de la tabla 'user'
    $sql = "SELECT * FROM user";
    $result = $dbconn->query($sql);

    // Inicializar dos arreglos para almacenar filas con y sin company_code
    $rowsWithCompanyCode = [];
    $rowsWithoutCompanyCode = [];

    if ($result->rowCount() > 0) {
        // Separar las filas según la condición del company_code
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
            if ($row['company_code'] !== null) {
                $rowsWithCompanyCode[] = $row;
            } else {
                $rowsWithoutCompanyCode[] = $row;
            }
        }

        // Mostrar la tabla HTML para filas con company_code a la derecha
        echo "<br><div style='display: flex; justify-content:center;'><h2>User´s Empresariales</h2></div>";
        echo "<div style='display: flex; justify-content: center; text-aling: center; aling-items:center; padding: 5px;'>";
        echo "<table border='1' style='text-aling: center'>
            <tr>
                <th style='padding: 5px; text-align: center;'>cod_user</th>
                <th style='padding: 5px; text-align: center;'>company_code</th>
                <th style='padding: 5px; text-align: center;'>user</th>
                <th style='padding: 5px; text-align: center;'>password</th>
                <th style='padding: 5px; text-align: center;'>name</th>
                <th style='padding: 5px; text-align: center;'>last_name</th>
                <th style='padding: 5px; text-align: center;'>email</th>
                <th style='padding: 5px; text-align: center;'>address</th>
                <th style='padding: 5px; text-align: center;'>phone</th>
            </tr>";

        foreach ($rowsWithCompanyCode as $row) {
            echo "<tr>
                    <td style='padding: 5px; text-align: center;'>" . $row["cod_user"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["company_code"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["user"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["password"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["name"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["last_name"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["email"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["address"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["phone"] . "</td>
                </tr>";
        }

        echo "</table></div>";

        // Mostrar la tabla HTML para filas sin company_code a la izquierda
        echo "<br><div style='display: flex; justify-content:center;'><h2>User´s Común</h2></div>";
        echo "<div style='display: flex; justify-content: center; text-aling: center; aling-items:center; padding: 5px;'>";
        echo "<table border='1'>
            <tr>
                <th style='padding: 5px; text-align: center;'>cod_user</th>
                <th style='padding: 5px; text-align: center;'>company_code</th>
                <th style='padding: 5px; text-align: center;'>user</th>
                <th style='padding: 5px; text-align: center;'>password</th>
                <th style='padding: 5px; text-align: center;'>name</th>
                <th style='padding: 5px; text-align: center;'>last_name</th>
                <th style='padding: 5px; text-align: center;'>email</th>
                <th style='padding: 5px; text-align: center;'>address</th>
                <th style='padding: 5px; text-align: center;'>phone</th>
            </tr>";

        foreach ($rowsWithoutCompanyCode as $row) {
            echo "<tr>
                    <td style='padding: 5px; text-align: center;'>" . $row["cod_user"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["company_code"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["user"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["password"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["name"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["last_name"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["email"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["address"] . "</td>
                    <td style='padding: 5px; text-align: center;'>" . $row["phone"] . "</td>
                </tr>";
        }

        echo "</table></div>";
    } else {
        echo "No se encontraron resultados en la tabla 'user'.";
    }
    ?>
</body>

</html>