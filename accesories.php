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
    <title>Vanity - Accesorios</title>

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
                            <li><a href="#">Bienvenid@ <?php echo "$user"; ?></a></li>
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

    <!-- ##### Right Side Cart Area ##### -->
    <div class="cart-bg-overlay"></div>

    <div class="right-side-cart-area">

        <!-- Cart Button -->
        <div class="cart-button">
            <a href="#" id="rightSideCart"><img src="assets/img/core-img/bag.svg" alt=""> <span>3</span></a>
        </div>

        <div class="cart-content d-flex">

            <!-- Cart List Area -->
            <div class="cart-list">
                <!-- Single Cart Item -->
                <div class="single-cart-item">
                    <a href="#" class="product-image">
                        <img src="assets/img/product-img/product-1.jpg" class="cart-thumb" alt="">
                        <!-- Cart Item Desc -->
                        <div class="cart-item-desc">
                            <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>
                            <span class="badge">Mango</span>
                            <h6>Button Through Strap Mini Dress</h6>
                            <p class="size">Size: S</p>
                            <p class="color">Color: Red</p>
                            <p class="price">$45.00</p>
                        </div>
                    </a>
                </div>

                <!-- Single Cart Item -->
                <div class="single-cart-item">
                    <a href="#" class="product-image">
                        <img src="assets/img/product-img/product-2.jpg" class="cart-thumb" alt="">
                        <!-- Cart Item Desc -->
                        <div class="cart-item-desc">
                            <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>
                            <span class="badge">Mango</span>
                            <h6>Button Through Strap Mini Dress</h6>
                            <p class="size">Size: S</p>
                            <p class="color">Color: Red</p>
                            <p class="price">$45.00</p>
                        </div>
                    </a>
                </div>

                <!-- Single Cart Item -->
                <div class="single-cart-item">
                    <a href="#" class="product-image">
                        <img src="assets/img/product-img/product-3.jpg" class="cart-thumb" alt="">
                        <!-- Cart Item Desc -->
                        <div class="cart-item-desc">
                            <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>
                            <span class="badge">Mango</span>
                            <h6>Button Through Strap Mini Dress</h6>
                            <p class="size">Size: S</p>
                            <p class="color">Color: Red</p>
                            <p class="price">$45.00</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-amount-summary">

                <h2>Summary</h2>
                <ul class="summary-table">
                    <li><span>subtotal:</span> <span>$274.00</span></li>
                    <li><span>delivery:</span> <span>Free</span></li>
                    <li><span>discount:</span> <span>-15%</span></li>
                    <li><span>total:</span> <span>$232.00</span></li>
                </ul>
                <div class="checkout-btn mt-100">
                    <a href="checkout.html" class="btn essence-btn">check out</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Right Side Cart End ##### -->

    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img" style="background-image: url(assets/img/bg-img/breadcumb.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Accesorios</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Breadcumb Area End ##### -->

    <!-- ##### Shop Grid Area Start ##### -->
    <section class="shop_grid_area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="shop_sidebar_area">

                        <!-- ##### Single Widget ##### -->
                        <div class="widget brands mb-50">
                            <!-- Widget Title 2 -->
                            <p class="widget-title2 mb-30">Marcas</p>
                            <div class="widget-desc">
                                <ul>
                                    <?php
                                    // Obtener todas las marcas distintas
                                    $brandQuery = "SELECT DISTINCT brand FROM products WHERE product_line = 'accesories'";
                                    $brandStmt = $dbconn->query($brandQuery);

                                    // Verificar si hay marcas
                                    if ($brandStmt->rowCount() > 0) {
                                        // Iterar sobre las marcas y mostrar cada una
                                        while ($brandRow = $brandStmt->fetch(PDO::FETCH_ASSOC)) {
                                            $brand = $brandRow['brand'];
                                    ?>
                                            <li><a href="?brand=<?php echo $brand; ?>"><?php echo $brand; ?></a></li>
                                    <?php
                                        }
                                    } else {
                                        echo "No hay marcas disponibles.";
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-md-8 col-lg-9">
                    <div class="shop_grid_product_area">
                        <div class="row">

                            <?php

                            // Obtener la marca seleccionada (si hay una)
                            $selectedBrand = isset($_GET['brand']) ? $_GET['brand'] : '';

                            // Construir la consulta SQL basada en la marca seleccionada
                            $query = "SELECT * FROM products WHERE product_line = 'accesories'";
                            if (!empty($selectedBrand)) {
                                $query .= " AND brand = :brand";
                            }

                            // Agregar limitación para la paginación
                            $query .= " LIMIT 25";

                            // Preparar la consulta
                            $stmt = $dbconn->prepare($query);

                            // Vincular la marca si está presente en la consulta
                            if (!empty($selectedBrand)) {
                                $stmt->bindParam(':brand', $selectedBrand, PDO::PARAM_STR);
                            }

                            // Ejecutar la consulta
                            $stmt->execute();

                            // Verificar si hay productos
                            if ($stmt->rowCount() > 0) {
                                // Iterar sobre los productos y mostrar cada uno
                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                            ?>
                                    <!-- Single Product -->
                                    <div class="col-12 col-sm-6 col-lg-4">
                                        <div class="single-product-wrapper">
                                            <!-- Product Image -->
                                            <div class="product-img">
                                                <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                                                <!-- Hover Thumb -->
                                                <img class="hover-img" src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                                            </div>

                                            <!-- Product Description -->
                                            <div class="product-description">
                                                <span><?php echo $row['brand']; ?></span>
                                                <a href="single-product-details.html">
                                                    <h6><?php echo $row['name']; ?></h6>
                                                </a>
                                                <p class="product-price">
                                                    $<?php echo $row['price']; ?>
                                                </p>

                                                <!-- Hover Content -->
                                                <div class="hover-content">
                                                    <!-- Add to Cart -->
                                                    <div class="add-to-cart-btn">
                                                        <a href="#" class="btn essence-btn">Add to Cart</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "No hay productos disponibles para la línea 'accesories'.";
                            }
                            ?>

                        </div>
                    </div>
                    <!-- Pagination -->
                    <nav aria-label="navigation">
                        <ul class="pagination mt-50 mb-70">
                            <?php
                            // Obtener el número total de productos sin límite
                            $totalQuery = "SELECT COUNT(*) as total FROM products WHERE product_line = 'accesories'";
                            $totalStmt = $dbconn->query($totalQuery);
                            $totalRow = $totalStmt->fetch(PDO::FETCH_ASSOC);
                            $totalProducts = $totalRow['total'];

                            // Calcular el número total de páginas
                            $totalPages = ceil($totalProducts / 25);

                            // Iterar sobre las páginas
                            for ($i = 1; $i <= $totalPages; $i++) {
                            ?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $i; ?>&brand=<?php echo $selectedBrand; ?>"><?php echo $i; ?></a></li>
                            <?php
                            }
                            ?>

                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Shop Grid Area End ##### -->

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
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright &copy;<script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://github.com/SamuelG0319/Vanity_Shop.git" target="_blank">Keily Marín, Samuel Lasso, Miguel Rodríguez & Carlos Serrano</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>

        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <script>
        document.getElementById('userLoginInfo').addEventListener('click', function() {
            <?php
            // Verificar si el usuario ha iniciado sesión
            if (!isset($_SESSION['user'])) {
            ?>
                // Si no está iniciado sesión, redirigir a login.php
                window.location.href = 'login.php';
            <?php
            } else {
            ?>
                window.location.href = 'profile.php';
            <?php
            }
            ?>
            // Si está iniciada la sesión, enviar a profile.php
        });
    </script>

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="assets/js/jquery/jquery-2.2.4.min.js"></script>
    <!-- Popper js -->
    <script src="assets/js/popper.min.js"></script>
    <!-- Bootstrap js -->
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- Plugins js -->
    <script src="assets/js/plugins.js"></script>
    <!-- Classy Nav js -->
    <script src="assets/js/classy-nav.min.js"></script>
    <!-- Active js -->
    <script src="assets/js/active.js"></script>

</body>

</html>