<?php
require_once('dbconn.php');
require_once('user.php');
require_once('admin.php');
session_start();

$userObject = null;
$adminObject = null;

$showProducts = [];
$showTotalItems = [];
$company_code = null;

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['cod_user'])) {
    // Si ha iniciado sesión, guarda los datos en variables de sesión
    $userObject = new Usuario($_SESSION['user'], $_SESSION['name'], $_SESSION['lastname'], $_SESSION['cod_user'], $_SESSION['company_code']);
    $company_code = $userObject->getCompanyCode();
    $cod_user = $_SESSION['cod_user'];
    $checkIfUser = $_SESSION['user'];

    /* --- Verify if user already has a cart --- */
    $queryCheckCart = "SELECT cart_id FROM cart WHERE cod_user = :cod_user";
    $checkCart = $dbconn->prepare($queryCheckCart);
    $checkCart->bindParam(':cod_user', $cod_user);
    $checkCart->execute();

    /* --- Verify if add_cart form was sent or user open his cart --- */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_cart']) || isset($_POST['rightSideCart'])) {
        /* --- Get form's data --- */
        $productCode = $_POST['product_code'];

        if ($checkCart->rowCount() > 0) {
            /* --- User has a cart --- */
            $cartRow = $checkCart->fetch(PDO::FETCH_ASSOC);
            $cart_id = $cartRow['cart_id'];

            /* --- Insert item into the cart --- */
            $queryAddToCart = "INSERT INTO cart_item (cart_id, product_code) VALUES (:cart_id, :product_code)";
            $addToCart = $dbconn->prepare($queryAddToCart);
            $addToCart->execute(array(':cart_id' => $cart_id, ':product_code' => $productCode));
        } else {
            /* --- User doesn't have a cart --- */
            $queryCreateCart = "INSERT INTO cart (cod_user, created_date) VALUES (:cod_user, NOW())";
            $createCart = $dbconn->prepare($queryCreateCart);
            $createCart->bindParam(':cod_user', $cod_user);
            $createCart->execute();

            /* --- Get id of the cart --- */
            $cart_id = $dbconn->lastInsertId();

            /* --- Insert item into the cart --- */
            $queryAddToCart = "INSERT INTO cart_item (cart_id, product_code) VALUES (:cart_id, :product_code)";
            $addToCart = $dbconn->prepare($queryAddToCart);
            $addToCart->execute(array(':cart_id' => $cart_id, ':product_code' => $productCode));
        }
    }

    /* --- Bring items on the cart --- */
    $queryBringProducts = "SELECT p.name, p.price, p.size, p.brand, p.image, p.product_code
    FROM products p
    INNER JOIN cart_item ci ON p.product_code = ci.product_code
    INNER JOIN cart c ON ci.cart_id = c.cart_id
    INNER JOIN user u ON u.cod_user = c.cod_user
    WHERE u.cod_user = :cod_user";
    $bringProducts = $dbconn->prepare($queryBringProducts);
    $bringProducts->execute(array(':cod_user' => $cod_user));
    $showProducts = $bringProducts->fetchAll(PDO::FETCH_ASSOC);

    /* --- Total of items on cart --- */
    $queryTotal = "SELECT COUNT(*) as total FROM cart_item ci
    INNER JOIN cart c ON ci.cart_id = c.cart_id
    INNER JOIN user u ON u.cod_user = c.cod_user
    WHERE u.cod_user = :cod_user";
    $totalItems = $dbconn->prepare($queryTotal);
    $totalItems->execute(array(':cod_user' => $cod_user));
    $showTotalItems = $totalItems->fetch(PDO::FETCH_ASSOC);

    /* --- Receipt --- */
    $queryReceipt = "SELECT SUM(p.price) as total_price
    FROM products p
    INNER JOIN cart_item ci ON p.product_code = ci.product_code
    INNER JOIN cart c ON ci.cart_id = c.cart_id
    INNER JOIN user u ON u.cod_user = c.cod_user
    WHERE u.cod_user = :cod_user";
    $totalPrice = $dbconn->prepare($queryReceipt);
    $totalPrice->execute(array(':cod_user' => $cod_user));
    $receipt = $totalPrice->fetch(PDO::FETCH_ASSOC);

    /* --- Delete item from cart --- */
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_code_to_remove'])) {
        $productCodeToRemove = $_POST['product_code_to_remove'];

        /* --- Delete the item in the database --- */
        $queryRemoveItem = "DELETE FROM cart_item WHERE product_code = :product_code AND cart_id IN (SELECT cart_id FROM cart WHERE cod_user = :cod_user)";
        $removeItem = $dbconn->prepare($queryRemoveItem);
        $removeItem->execute(array(':product_code' => $productCodeToRemove, ':cod_user' => $cod_user));

        header("Location: index.php?id=" . $productCode);
        $success = true;
        echo json_encode(['success' => $success]);
        exit;
    }
} elseif (isset($_SESSION['cod_admin'])) {
    $adminObject = new Administrador($_SESSION['user'], $_SESSION['name'], $_SESSION['lastname'], $_SESSION['cod_admin'], $_SESSION['position']);
    $cod_admin = $_SESSION['cod_admin'];
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Vanity - Tu tienda de ropa</title>

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
                            <li><a href="tops.php">Partes de arriba</a></li>
                            <li><a href="bottom.php">Partes de abajo</a></li>
                            <li><a href="shoes.php">Zapatos</a></li>
                            <li><a href="accesories.php">Accesorios</a></li>
                            <?php
                            if (isset($cod_admin)) {
                                ?>
                                <li><a href="consulta.php">Consulta Empresarial</a></li>
                                <li><a href="admin-side.php">Administración</a></li>
                                <?php
                            }
                            ?>
                            <?php
                            if ($company_code != null) {
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
                if (isset($userObject)) {
                    ?>
                    <div class="classynav">
                        <ul>
                            <li><a href="#">Bienvenid@
                                    <?php echo $userObject->getUser(); ?>
                                </a></li>
                            <li><a href="logout.php">Cerrar Sesión</a></li>
                        </ul>
                    </div>
                    <?php
                } elseif (isset($adminObject)) {
                    ?>
                    <div class="classynav">
                        <ul>
                            <li><a href="#">Bienvenid@
                                    <?php echo $adminObject->getUser(); ?>
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
                <!-- Cart Area -->
                <?php
                if (isset($cod_admin) || isset($checkIfUser) == '') {
                    /* --- Nothing to show --- */
                } else {
                ?>
                <div class="cart-area">
                    <a href="#" id="essenceCartBtn"><img src="assets/img/core-img/bag.svg" alt="">
                        <span>
                            <?php
                            if ($showTotalItems != null) {
                                echo $showTotalItems['total'];
                            } else {
                                echo '';
                            }
                        }
                            ?>
                        </span></a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ================================================== CART ================================================== -->
    <div class="cart-bg-overlay"></div>

    <div class="right-side-cart-area">

        <!-- Cart Button -->
        <div class="cart-button">
            <a href="#" id="rightSideCart"><img src="assets/img/core-img/bag.svg" alt="">
                <span>
                    <?php
                    if ($showTotalItems != null) {
                        echo $showTotalItems['total'];
                    } else {
                        echo '';
                    }
                    ?>
                </span>
            </a>
        </div>

        <div class="cart-content d-flex">

            <!-- Cart List Area -->
            <div class="cart-list">
                <!-- Single Cart Item -->
                <div class="cart-items">
                    <?php if ($showProducts !== null): ?>
                        <?php foreach ($showProducts as $producto): ?>
                            <!-- Single Cart Item -->
                            <form method="POST" id="delete_item" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="single-cart-item" onclick="submitForm('<?php echo $producto['product_code']; ?>')">
                                    <a href="#" class="product-image">
                                        <img src="<?php echo $producto['image']; ?>" class="cart-thumb" alt="">
                                        <!-- Cart Item Desc -->
                                        <div class="cart-item-desc">
                                            <input type="hidden" name="product_code_to_remove" id="product_code_to_remove"
                                                value="">
                                            <span class="badge">
                                                <?php echo $producto['brand']; ?>
                                            </span>
                                            <h6>
                                                <?php echo $producto['name']; ?>
                                            </h6>
                                            <p class="size">Size:
                                                <?php echo $producto['size']; ?>
                                            </p>
                                            <p class="price">$
                                                <?php echo $producto['price']; ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </form>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p>No hay productos en el carrito.</p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-amount-summary">

                <h2>Factura</h2>
                <ul class="summary-table">
                    <li><span>subtotal:</span> <span>
                            <?php echo $receipt['total_price']; ?>
                        </span></li>
                    <li><span>delivery:</span> <span>Free</span></li>
                    <li><span>discount:</span> <span>-15%</span></li>
                    <li><span>total:</span> <span>
                            <?php echo number_format($receipt['total_price'] * 0.85, 2); ?>
                        </span></li>
                </ul>
                <div class="checkout-btn mt-100">
                    <a href="checkout.php" class="btn essence-btn">check out</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================================================================================================== -->

    <!-- ##### Welcome Area Start ##### -->
    <section class="welcome_area bg-img background-overlay" style="background-image: url(assets/img/bg-img/bg-1.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="hero-content">
                        <h5>micasa</h5>
                        <h2>Vanity Shop</h2>
                        <h6>Tu tienda de ropa online</h6>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### Welcome Area End ##### -->

    <!-- ##### Top Catagory Area Start ##### -->
    <div class="top_catagory_area section-padding-80 clearfix">
        <div class="container">
            <div class="row justify-content-center">

                <!-- Single Category -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img"
                        style="background-image: url(assets/img/bg-img/bg-2.jpg);">
                        <div class="catagory-content">
                            <a href="tops.php">Partes de arriba</a>
                        </div>
                    </div>
                </div>
                <!-- Single Category -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img"
                        style="background-image: url(assets/img/bg-img/bg-5.jpg);">
                        <div class="catagory-content">
                            <a href="bottom.php">Partes de abajo</a>
                        </div>
                    </div>
                </div>
                <!-- Single Category -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img"
                        style="background-image: url(assets/img/bg-img/bg-3.jpg);">
                        <div class="catagory-content">
                            <a href="shoes.php">Zapatos</a>
                        </div>
                    </div>
                </div>
                <!-- Single Category -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img"
                        style="background-image: url(assets/img/bg-img/bg-4.jpg);">
                        <div class="catagory-content">
                            <a href="accesories.php">Accesorios</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Top Catagory Area End ##### -->

    <!-- ##### New Arrivals Area Start ##### -->
    <section class="new_arrivals_area section-padding-80 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h2>Productos Populares</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="popular-products-slides owl-carousel">

                        <?php
                        // Obtener todos los productos
                        $query = "SELECT * FROM products ORDER BY RAND() LIMIT 10";
                        $stmt = $dbconn->query($query);

                        // Verificar si hay productos
                        if ($stmt->rowCount() > 0) {
                            // Iterar sobre los productos y mostrar cada uno
                            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                ?>
                                <!-- Single Product -->
                                <div class="single-product-wrapper">
                                    <!-- Product Image -->
                                    <div class="product-img">
                                        <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                                        <!-- Hover Thumb -->
                                        <img class="hover-img" src="<?php echo $row['image']; ?>"
                                            alt="<?php echo $row['name']; ?>">
                                    </div>
                                    <!-- Product Description -->
                                    <div class="product-description">
                                        <span>
                                            <?php echo $row['brand']; ?>
                                        </span>
                                        <a href="single-product.php?id=<?php echo $row['product_code']; ?>">
                                            <h6>
                                                <?php echo $row['name']; ?>
                                            </h6>
                                        </a>
                                        <span>
                                            Talla:
                                            <?php echo $row['size']; ?>
                                        </span>
                                        <p class="product-price">$
                                            <?php echo $row['price']; ?>
                                        </p>

                                        <!-- Hover Content -->
                                        <div class="hover-content">
                                            <!-- Form to get data from each product -->
                                            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                <input type="hidden" name="product_code"
                                                    value="<?php echo $row['product_code']; ?>">
                                                <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                                                <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                                                <input type="hidden" name="product_size" value="<?php echo $row['size']; ?>">
                                                <input type="hidden" name="product_brand" value="<?php echo $row['brand']; ?>">
                                                <div class="add-to-cart-btn">
                                                    <button type="submit" name="add_cart" class="btn essence-btn">Add to
                                                        Cart</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            echo "No hay productos disponibles.";
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### New Arrivals Area End ##### -->

    <!-- ##### Brands Area Start ##### -->
    <div class="brands-area d-flex align-items-center justify-content-between">
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="assets/img/core-img/brand1.png" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="assets/img/core-img/brand2.png" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="assets/img/core-img/brand3.png" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="assets/img/core-img/brand4.png" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="assets/img/core-img/brand5.png" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="assets/img/core-img/brand6.png" alt="">
        </div>
    </div>
    <!-- ##### Brands Area End ##### -->

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
                                <li><a href="admin-login.php">Admin</a></li>
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
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Facebook"><i
                                    class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Instagram"><i
                                    class="fa fa-instagram" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Twitter"><i
                                    class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Pinterest"><i
                                    class="fa fa-pinterest" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title="Youtube"><i
                                    class="fa fa-youtube-play" aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p>
                        Copyright &copy;
                        <script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by
                        <a href="https://github.com/SamuelG0319/Vanity_Shop.git" target="_blank">Keily Marín, Samuel
                            Lasso, Miguel Rodríguez & Carlos Serrano</a>
                    </p>
                </div>
            </div>

        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <script>
        document.getElementById('userLoginInfo').addEventListener('click', function () {
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