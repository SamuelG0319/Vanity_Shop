<!DOCTYPE html>
<html lang="es">

<head>
    <?php
    require_once('dbconn.php');
    session_start();

    // Verificar si el usuario ha iniciado sesión
    if (isset($_SESSION['cod_user'])) {
        // Si ha iniciado sesión, guarda los datos en variables de sesión
        $user = $_SESSION['user'];
        $name = $_SESSION['name'];
        $lastname = $_SESSION['lastname'];
        $cod_user = $_SESSION['cod_user'];
        $company_code = $_SESSION['company_code'];
    }

    // Verificar si el usuario que inició sesión es un administrador
    if (isset($_SESSION['cod_admin'])) {
        $user = $_SESSION['user'];
        $name = $_SESSION['name'];
        $lastname = $_SESSION['lastname'];
        $cod_admin = $_SESSION['cod_admin'];
        $position = $_SESSION['position'];
    }
    ?>

    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Title  -->
    <title>Consulta de Producto</title>

    <!-- Title  -->
    <title>Vanity - Consulta Empresarial</title>

    <!-- Favicon  -->
    <link rel="icon" href="assets/img/core-img/logo.png">

    <!-- Core Style CSS -->
    <link rel="stylesheet" href="assets/css/core-style.css">
    <link rel="stylesheet" href="assets/style.css">

    <!-- jQuery -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>

    <!-- ##### Header Area Start ##### -->
    <header class="header_area">
        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="index.php"><img src="assets/img/core-img/logo.png" alt="" height="100px" width="100px"></a>
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
                            <?php
                            if (isset($cod_admin)) {
                            ?>
                                <li><a href="#">Administración</a></li>
                            <?php
                            }
                            ?>
                            <?php
                            if (isset($company_code)) {
                            ?>
                                <li><a href="consulta.php">Consulta Empresarial</a></li>
                            <?php
                            }
                            ?>
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
                            <li><a href="#">Bienvenid@ <?php echo $name; ?></a></li>
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
                <!-- Cart Area -->
                <div class="cart-area">
                    <a href="#" id="essenceCartBtn"><img src="assets/img/core-img/bag.svg" alt=""> <span>3</span></a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Blog Wrapper Area Start ##### -->
    <div class="single-blog-wrapper">

        <!-- Single Blog Post Thumb -->
        <div class="single-blog-post-thumb">
            <img src="assets/img/bg-img/bg-8.jpg" alt="">
        </div>

        <div class="container">
            <h1>Consulta de Producto</h1>

            <form id="productForm">
                <label for="productCode">Código del Producto:</label>
                <input type="text" id="productCode" name="productCode" required>
                <button type="button" onclick="getProductInfo()">Consultar Producto</button>
            </form>

            <div id="productInfo"></div>
        </div>
    </div>
    <!-- ##### Blog Wrapper Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area d-flex mb-30">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="#"><img src="assets/img/core-img/logo.png" alt="" height="100px" width="100px"></a>
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="tops.php">Partes de arriba</a></li>
                                <li><a href="bottom.php">Partes de abajo</a></li>
                                <li><a href="shoes.php">Zapatos</a></li>
                                <li><a href="accesories.php">Accesorios</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row align-items-end">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_social_area">
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i class="fa fa-pinterest" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p>
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://github.com/SamuelG0319/Vanity_Shop.git" target="_blank">Keily Marín, Samuel Lasso, Miguel Rodríguez & Carlos Serrano</a>
                    </p>
                </div>
            </div>

        </div>
    </footer>


    <script>
        function getProductInfo() {
            var productCode = $("#productCode").val();

            $.ajax({
                type: "GET",
                url: "api.php",
                data: {
                    action: "get_product_info",
                    productCode: productCode
                },
                dataType: "json",
                success: function(response) {
                    if (response.status === "success") {
                        $("#productInfo").html("<p>Precio: $" + response.price + "<br>Stock: " + response.stock + "</p>");
                    } else {
                        $("#productInfo").html("<p>Error: " + response.message + "</p>");
                    }
                },
                error: function() {
                    $("#productInfo").html("<p>Error al procesar la solicitud.</p>");
                }
            });
        }
    </script>

</body>

</html>