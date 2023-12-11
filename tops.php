<?php
require_once('dbconn.php');
require_once('user.php');
require_once('admin.php');
require_once('products.php');
session_start();

$userObject = null;
$adminObject = null;
$productObject = null;

$showProducts = [];
$showTotalItems = [];

// Verificar si el usuario ha iniciado sesión
if (isset($_SESSION['cod_user'])) {
    // Si ha iniciado sesión, guarda los datos en variables de sesión
    $userObject = new Usuario($_SESSION['user'], $_SESSION['name'], $_SESSION['lastname'], $_SESSION['cod_user'], $_SESSION['company_code']);
    $company_code = $userObject->getCompanyCode();
    $cod_user = $_SESSION['cod_user'];

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
    $queryBringProducts = "SELECT p.name, p.price, p.size, p.brand, p.image, p.product_code, p.stock
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

        header("Location: tops.php?id=" . $productCode);
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
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title  -->
    <title>Vanity - Partes de arriba</title>

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
                            <?php
                            if (isset($cod_admin)) {
                            ?>
                                <li><a href="consulta.php">Consulta Empresarial</a></li>
                                <li><a href="admin-side.php">Administración</a></li>
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
                <div class="cart-area">
                    <a href="#" id="essenceCartBtn"><img src="assets/img/core-img/bag.svg" alt="">
                        <span>
                            <?php
                            if ($showTotalItems != null) {
                                echo $showTotalItems['total'];
                            } else {
                                echo '';
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
                    <?php if ($showProducts !== null) : ?>
                        <?php foreach ($showProducts as $producto) : ?>
                            <?php
                            $productObject = new Producto($producto['brand'], $producto['name'], $producto['stock'], $producto['price'], $producto['size'], $producto['image']);
                            ?>
                            <!-- Single Cart Item -->
                            <form method="POST" id="delete_item" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                <div class="single-cart-item" onclick="submitForm('<?php echo $producto['product_code']; ?>')">
                                    <a href="#" class="product-image">
                                        <img src="<?php echo $producto['image']; ?>" class="cart-thumb" alt="">
                                        <!-- Cart Item Desc -->
                                        <div class="cart-item-desc">
                                            <input type="hidden" name="product_code_to_remove" id="product_code_to_remove" value="">
                                            <span class="badge">
                                                <?php echo $productObject->getBrand(); ?>
                                            </span>
                                            <h6>
                                                <?php echo $productObject->getName(); ?>
                                            </h6>
                                            <p class="size">Size:
                                                <?php echo $productObject->getSize(); ?>
                                            </p>
                                            <p class="price">$
                                                <?php echo $productObject->getPrice(); ?>
                                            </p>
                                        </div>
                                    </a>
                                </div>
                            </form>
                        <?php endforeach; ?>
                    <?php else : ?>
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

    <!-- ##### Breadcumb Area Start ##### -->
    <div class="breadcumb_area bg-img" style="background-image: url(assets/img/bg-img/breadcumb.jpg);">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Partes de Arriba</h2>
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
                                    $brandQuery = "SELECT DISTINCT brand FROM products WHERE product_line = 'tops'";
                                    $brandStmt = $dbconn->query($brandQuery);

                                    // Verificar si hay marcas
                                    if ($brandStmt->rowCount() > 0) {
                                        // Iterar sobre las marcas y mostrar cada una
                                        while ($brandRow = $brandStmt->fetch(PDO::FETCH_ASSOC)) {
                                            $brand = $brandRow['brand'];
                                    ?>
                                            <li><a href="?brand=<?php echo $brand; ?>">
                                                    <?php echo $brand; ?>
                                                </a></li>
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
                            $query = "SELECT * FROM products WHERE product_line = 'tops'";
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
                                    // Crear un objeto Producto para cada producto
                                    $producto = new Producto($row['brand'], $row['name'], $row['stock'], $row['price'], $row['size'], $row['image']);

                                    // Resto de tu lógica para mostrar productos
                            ?>
                                    <!-- Single Product -->
                                    <div class="col-12 col-sm-6 col-lg-4">
                                        <div class="single-product-wrapper">
                                            <!-- Product Image -->
                                            <div class="product-img">
                                                <img src="<?php echo $producto->getImage(); ?>" alt="<?php echo $producto->getName(); ?>">
                                                <!-- Hover Thumb -->
                                                <img class="hover-img" src="<?php echo $producto->getImage(); ?>" alt="<?php echo $producto->getName(); ?>">
                                            </div>

                                            <!-- Product Description -->
                                            <div class="product-description">
                                                <span>
                                                    <?php echo $producto->getBrand(); ?>
                                                </span>
                                                <a href="single-product.php?id=<?php echo $row['product_code']; ?>">
                                                    <h6>
                                                        <?php echo $producto->getName(); ?>
                                                    </h6>
                                                </a>
                                                <span>
                                                    Talla: <?php echo $producto->getSize(); ?>
                                                </span>
                                                <?php
                                                if (isset($company_code) || isset($cod_admin)) {
                                                ?>
                                                    <span>Stock:
                                                        <?php echo $producto->getStock(); ?>
                                                    </span>
                                                <?php
                                                }
                                                ?>
                                                <p class="product-price">
                                                    $
                                                    <?php echo $producto->getPrice(); ?>
                                                </p>

                                                <!-- Hover Content -->
                                                <div class="hover-content">
                                                    <!-- Form to get data from each product -->
                                                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                                                        <input type="hidden" name="product_code" value="<?php echo $row['product_code']; ?>">
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
                                    </div>
                            <?php
                                }
                            } else {
                                echo "No hay productos disponibles para la línea 'tops'.";
                            }
                            ?>

                        </div>
                    </div>
                    <!-- Pagination -->
                    <nav aria-label="navigation">
                        <ul class="pagination mt-50 mb-70">
                            <?php
                            // Obtener el número total de productos sin límite
                            $totalQuery = "SELECT COUNT(*) as total FROM products WHERE product_line = 'tops'";
                            $totalStmt = $dbconn->query($totalQuery);
                            $totalRow = $totalStmt->fetch(PDO::FETCH_ASSOC);
                            $totalProducts = $totalRow['total'];

                            // Calcular el número total de páginas
                            $totalPages = ceil($totalProducts / 25);

                            // Iterar sobre las páginas
                            for ($i = 1; $i <= $totalPages; $i++) {
                            ?>
                                <li class="page-item"><a class="page-link" href="?page=<?php echo $i; ?>&brand=<?php echo $selectedBrand; ?>">
                                        <?php echo $i; ?>
                                    </a></li>
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

    <script>
        function submitForm(productCode) {
            document.getElementById('product_code_to_remove').value = productCode;
            document.getElementById('delete_item').submit();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Agregar un evento de clic al botón de eliminación
            document.querySelectorAll('.product-remove').forEach(function(removeButton) {
                removeButton.addEventListener('click', function(event) {
                    event.preventDefault();

                    // Obtener el código del producto a eliminar
                    var productCodeToRemove = this.dataset.productCode;

                    // Realizar la solicitud AJAX para eliminar el producto
                    fetch('index.php', {
                            method: 'POST',
                            body: new URLSearchParams({
                                'product_code_to_remove': productCodeToRemove
                            }),
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            }
                        })
                        .then(response => response.json())
                        .then(data => {
                            // Manejar la respuesta del servidor
                            if (data.success) {
                                // Eliminar visualmente el producto de la interfaz
                                var cartItem = this.closest('.single-cart-item');
                                cartItem.parentNode.removeChild(cartItem);
                            } else {
                                alert('Error al eliminar el producto.');
                            }
                        })
                        .catch(error => console.error('Error:', error));
                });
            });
        });
    </script>

</body>

</html>