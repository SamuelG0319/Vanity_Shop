<?php
require_once('dbconn.php');
require_once('user.php');
require_once('admin.php');
require_once('products.php');

session_start();

$userObject = null;
$adminObject = null;
$productObject = null;

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
        $productCode = $_POST['id'];

        if ($checkCart->rowCount() > 0) {
            /* --- User has a cart --- */
            $cartRow = $checkCart->fetch(PDO::FETCH_ASSOC);
            $cart_id = $cartRow['cart_id'];

            /* --- Insert item into the cart --- */
            $queryAddToCart = "INSERT INTO cart_item (cart_id, product_code) VALUES (:cart_id, :product_code)";
            $addToCart = $dbconn->prepare($queryAddToCart);
            $addToCart->execute(array(':cart_id' => $cart_id, ':product_code' => $productCode));
            header("Location: single-product.php?id=" . $productCode);
            exit();
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
            header("Location: single-product.php?id=" . $productCode);
            exit();
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

        header("Location: single-product.php?id=" . $productCode);
        $success = true;
        echo json_encode(['success' => $success]);
        exit;
    }
} elseif (isset($_SESSION['cod_admin'])) {
    $adminObject = new Administrador($_SESSION['user'], $_SESSION['name'], $_SESSION['lastname'], $_SESSION['cod_admin'], $_SESSION['position']);
    $cod_admin = $_SESSION['cod_admin'];
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
        exit();
    }
} else {
    echo "Código de producto no proporcionado.";
    exit();
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
    <title>Vanity -
        <?php echo $productDetails['name']; ?>
    </title>

    <!-- Favicon  -->
    <link rel="icon" href="assets/img/core-img/logo.ico">

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
                <?php
                if (isset($cod_admin) || isset($checkIfUser) == '') {
                    /* --- Nothing to show --- */
                } else {
                    ?>
                    <div class="cart-area">
                        <a href="#" id="essenceCartBtn"><img src="assets/img/core-img/bag.svg" alt=""> <span>
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
                                            <input type="hidden" name="product_code_to_remove" id="product_code_to_remove"
                                                value="">
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
                    <a href="checkout.html" class="btn essence-btn">check out</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ========================================================================================================== -->

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
            <span>
                <?php echo $productDetails['brand']; ?>
            </span>
            <a href="#">
                <h2>
                    <?php echo $productDetails['name']; ?>
                </h2>
            </a>
            <span>
                Talla:
                <?php echo $productDetails['size']; ?>
            </span>
            <?php
            if (isset($company_code) || isset($cod_admin)) {
                ?>
                <span>Stock:
                    <?php echo $productDetails['stock']; ?>
                </span>
                <?php
            }
            ?>
            <p class="product-price">
                <?php echo $productDetails['price']; ?>
            </p>

            <!-- Form para agregar al carrito, tallas, colores, etc. -->
            <div class="cart-fav-box d-flex align-items-center">
                <!-- Cart -->
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <input type="hidden" name="id" value="<?php echo $productDetails['product_code']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $productDetails['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $productDetails['price']; ?>">
                    <input type="hidden" name="product_size" value="<?php echo $productDetails['size']; ?>">
                    <input type="hidden" name="product_brand" value="<?php echo $productDetails['brand']; ?>">
                    <div class="add-to-cart-btn">
                        <button type="submit" name="add_cart" value="5" class="btn essence-btn">Add to
                            Cart</button>
                    </div>
                </form>
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

    <script>
        function submitForm(productCode) {
            document.getElementById('product_code_to_remove').value = productCode;
            document.getElementById('delete_item').submit();
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Agregar un evento de clic al botón de eliminación
            document.querySelectorAll('.product-remove').forEach(function (removeButton) {
                removeButton.addEventListener('click', function (event) {
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