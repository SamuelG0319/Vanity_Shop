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

    if (isset($_GET['id'])) {
        $productCode = $_GET['id'];

        // Construir la consulta SQL para obtener los detalles del producto por código
        $query = "SELECT * FROM products WHERE product_code = :productCode";

        // Preparar la consulta
        $stmt = $dbconn->prepare($query);

        // Vincular el código del producto
        $stmt->bindParam(':productCode', $productCode, PDO::PARAM_STR);

        // Ejecutar la consulta
        $stmt->execute();

        // Verificar si se encontró el producto
        if ($stmt->rowCount() > 0) {
            // Obtener los detalles del producto
            $productDetails = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            echo "Producto no encontrado.";
            // Puedes redirigir o mostrar un mensaje de error según tus necesidades
            exit();
        }
    } else {
        echo "Código de producto no proporcionado.";
        // Puedes redirigir o mostrar un mensaje de error según tus necesidades
        exit();
    }
    ?>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Vanity - <?php echo $productDetails['name']; ?></title>

    <!-- Favicon  -->
    <link rel="icon" href="assets/img/core-img/favicon.ico">

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

    <!-- ##### Single Product Details Area Start ##### -->
    <section class="single_product_details_area d-flex align-items-center">
        <!-- Single Product Thumb -->
        <div class="single_product_thumb clearfix">
            <div class="product_thumbnail_slides owl-carousel">
                <!-- Aquí puedes usar las imágenes del producto si las tienes en tu base de datos -->
                <img src="<?php echo $productDetails['image']; ?>" alt="<?php echo $productDetails['name']; ?>">
                <img src="<?php echo $productDetails['image']; ?>" alt="<?php echo $productDetails['name']; ?>">
            </div>
        </div>

        <!-- Single Product Description -->
        <div class="single_product_desc clearfix">
            <span><?php echo $productDetails['brand']; ?></span>
            <a href="cart.html">
                <h2><?php echo $productDetails['name']; ?></h2>
            </a>
            <p class="product-price">
                $<?php echo $productDetails['price']; ?>
            </p>

            <!-- Form para agregar al carrito, tallas, colores, etc. -->
            <div class="cart-fav-box d-flex align-items-center">
                <!-- Cart -->
                <button type="submit" name="addtocart" value="5" class="btn essence-btn">Add to cart</button>
            </div>

        </div>
    </section>
    <!-- ##### Single Product Details Area End ##### -->

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