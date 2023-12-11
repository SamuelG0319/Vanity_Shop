<!DOCTYPE html>
<html lang="en">
<head>

    <?php
    require_once('dbconn.php');
    require_once('user.php');
    require_once('admin.php');
    session_start();

    if (empty($_SESSION["user"])) {
        header("location: index.php");
        exit;
    }

    $userObject = null;
    $adminObject = null;

    $showProducts = [];
    $showTotalItems = [];
    $company_code = null;
    $receipt = [];

    if (isset($_SESSION['cod_user'])) {
        // Si ha iniciado sesión, guarda los datos en variables de sesión
        $userObject = new Usuario($_SESSION['user'], $_SESSION['name'], $_SESSION['lastname'], $_SESSION['cod_user'], $_SESSION['company_code']);
        $company_code = $userObject->getCompanyCode();
        $cod_user = $_SESSION['cod_user'];

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

            $success = true;
            echo json_encode(['success' => $success]);
            exit;
        }
    } elseif (isset($_SESSION['cod_admin'])) {
                $adminObject = new Administrador($_SESSION['user'], $_SESSION['name'], $_SESSION['lastname'], $_SESSION['cod_admin'], $_SESSION['position']);
                $cod_admin = $_SESSION['cod_admin'];
            }
?>

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
    <link rel="stylesheet" href="assets/card.css">

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
                                <li><a href="#">Administración</a></li>
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
                            <li><a href="logout.php">Cerrar Sesión
                                    <?php echo $userObject->getUser(); ?>
                                </a></li>
                        </ul>
                    </div>
                    <?php
                } elseif (isset($adminObject)) {
                    ?>
                    <div class="classynav">
                        <ul>
                            <li><a href="logout.php">Cerrar Sesión
                                    <?php echo $adminObject->getUser(); ?>
                                </a></li>
                        </ul>
                    </div>
                    <?php
                }
                ?>
                <!-- User Login Info -->
                <div class="user-login-info" id="userLoginInfo">
                    <a href="profile.php"><img src="assets/img/core-img/user.svg" alt=""></a>
                </div>
            </div>
        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Checkout Area Start ##### -->
    <div class="checkout_area section-padding-80">
        <div class="container">
            <div class="row">

                <div class="col-12 col-md-6">
                    <div class="checkout_details_area mt-50 clearfix">

                        <div class="cart-page-heading mb-30">
                            <h5>Dirección de envío</h5>
                        </div>

                        <form action="#" method="post">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first_name">Primer nombre <span>*</span></label>
                                    <input type="text" class="form-control" id="first_name" value="" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last_name">Apellido <span>*</span></label>
                                    <input type="text" class="form-control" id="last_name" value="" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="company">Nombre de empresa</label>
                                    <input type="text" class="form-control" id="company" value="">
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="country">País <span>*</span></label>
                                    <select class="w-100" id="country" value="" required>
                                        <option value="usa">Estados Unidos</option>
                                        <option value="uk">Reino Unido</option>
                                        <option value="ger">Alemania</option>
                                        <option value="fra">Francia</option>
                                        <option value="ind">India</option>
                                        <option value="aus">Australia</option>
                                        <option value="bra">Brasil</option>
                                        <option value="cana">Canadá</option>
                                        <option value="cana">Panamá</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="street_address">Dirección <span>*</span></label>
                                    <input type="text" class="form-control mb-3" id="street_address" value="" required>
                                    <input type="text" class="form-control" id="street_address2" value="" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="postcode">Código postal <span>*</span></label>
                                    <input type="text" class="form-control" id="postcode" value="" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="city">Pueblo/Ciudad <span>*</span></label>
                                    <input type="text" class="form-control" id="city" value="" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="state">Provincia <span>*</span></label>
                                    <input type="text" class="form-control" id="state" value="" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="phone_number">Número telefónico <span>*</span></label>
                                    <input type="number" class="form-control" id="phone_number" min="0" value="" required>
                                </div>
                                <div class="col-12 mb-4">
                                    <label for="email_address">Dirección de correo electrónico <span>*</span></label>
                                    <input type="email" class="form-control" id="email_address" value="" required>
                                </div>

                                <div class="col-12">
                                    <div class="custom-control custom-checkbox d-block mb-2">
                                        <input type="checkbox" class="custom-control-input" id="customCheck1">
                                        <label class="custom-control-label" for="customCheck1">Términos y condiciones</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-block mb-2">
                                        <input type="checkbox" class="custom-control-input" id="customCheck2">
                                        <label class="custom-control-label" for="customCheck2">Crea una cuenta</label>
                                    </div>
                                    <div class="custom-control custom-checkbox d-block">
                                        <input type="checkbox" class="custom-control-input" id="customCheck3">
                                        <label class="custom-control-label" for="customCheck3">Suscríbete a nuestro servicio</label>
                                        <br></br>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
               

                <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">
                    <div class="order-details-confirmation">

                        <div class="cart-page-heading">
                            <h5>Su pedido</h5>
                            <p>Detalles</p>
                        </div>

                        <ul class="order-details-form mb-4">
                            <li><span>subtotal:</span> <span>
                                    <?php echo $receipt['total_price']; ?>
                                </span></li>
                            <li><span>delivery:</span> <span>Free</span></li>
                            <li><span>discount:</span> <span>-15%</span></li>
                            <li><span>total:</span> <span>
                                    <?php echo number_format($receipt['total_price'] * 0.85, 2); ?>
                                </span></li>
                        </ul>

                        <div class="container">
                        <!-- CREDIT CARD FORM STARTS HERE -->
                            <div class="panel panel-default credit-card-box customwidth center-block">
                                <div class="panel-heading display-table" >
                                    <div class="row display-tr" >
                                        <h5 class="panel-title display-td" >Detalles de pago</h5>
                                        <div class="display-td" id="cardLogoTop">                            
                                            <img class="img-responsive pull-right" src="https://i.imgur.com/gIMFDbp.png">
                                            <!-- <img class="img-responsive pull-right" src="https://i.imgur.com/WluzPvZ.png">
                                            <img class="img-responsive pull-right" src="https://i.imgur.com/H5lJRwk.png">
                                            <img class="img-responsive pull-right" src="https://i.imgur.com/1U8OBnM.png">
                                            <img class="img-responsive pull-right" src="https://i.imgur.com/iqIDYfz.png">
                                            -->
                                        </div>
                                    </div>                    
                                </div>
                                <div class="panel-body">
                                    <form role="form" id="payment-form" method="post" action="" onSubmit="return false;">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label for="cardNumber">NÚMERO DE TARJETA</label>
                                                    <div class="input-group">
                                                        <input 
                                                            type="tel"
                                                            class="form-control"
                                                            name="cardNumber"
                                                            id="cardNumber"
                                                            placeholder="XXXX-XXXX-XXXX-XXXX"
                                                            autocomplete="cc-number"
                                                            pattern="^(?:4[0-9]{12}(?:[0-9]{3})?|5[1-5][0-9]{14}|3[47][0-9]{13}|3(?:0[0-5]|[68][0-9])[0-9]{11}|6(?:011|5[0-9]{2})[0-9]{12}|(?:2131|1800|35\d{3})\d{11})$"
                                                            required autofocus
                                                            onchange="validar(this.value)"
                                                            onblur="
                                                            // save input string and strip out non-numbers
                                                            cc_number_saved = this.value;
                                                            this.value = this.value.replace(/[^\d]/g, '');
                                                            if(!validar(this.value)) {
                                                                alert('Disculpe, este número de tarjeta no es válido');
                                                                this.value = '';
                                                            }
                                                            " onfocus="
                                                            // restore saved string
                                                            if(this.value != cc_number_saved) this.value = cc_number_saved;
                                                            "
                                                        />
                                                        <span class="input-group-addon"><i class="fa fa-credit-card" id="cardlogo" style="color:purple;font-size:2rem;"></i></span>
                                                    </div>
                                                </div>                            
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-xs-7 col-md-7">
                                                <div class="form-group">
                                                    <label for="cardExpiry">FECHA DE EXPIRACIÓN</label>
                                                    <input 
                                                        type="tel" 
                                                        class="form-control" 
                                                        name="cardExpiry"
                                                        placeholder="MM / YY"
                                                        autocomplete="cc-exp"
                                                        required 
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-xs-5 col-md-5 pull-right">
                                                <div class="form-group">
                                                    <label for="cardCVC">CÓDIGO CV</label>
                                                    <input 
                                                        type="tel" 
                                                        class="form-control"
                                                        name="cardCVC"
                                                        placeholder="CVC"
                                                        autocomplete="cc-csc"
                                                        required
                                                        pattern="^[0-9]{3}"
                                                        title="Debe escribir un código válido"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="row">
                                            <div class="col-xs-12">
                                                <div class="form-group">
                                                    <label for="couponCode">COUPON CODE</label>
                                                    <input type="text" class="form-control" name="couponCode" />
                                                </div>
                                            </div>                        
                                        </div>-->
                                        <div class="row">
                                            <div class="col-xs-12">
                                                <button class="btn btn-success btn-lg btn-block" type="submit">Realizar pedido</button>
                                            </div>
                                        </div>
                                        <div class="row" style="display:none;">
                                            <div class="col-xs-12">
                                                <p class="payment-errors"></p>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>            
                            <!-- CREDIT CARD FORM ENDS HERE -->
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Checkout Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area d-flex mb-30">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="#"><img src="img/core-img/logo2.png" alt=""></a>
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
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area mb-30">
                        <ul class="footer_widget_menu">
                            <li><a href="#">Estado del pedido</a></li>
                            <li><a href="#">Opciones de pago</a></li>
                            <li><a href="#">Envío y entrega</a></li>
                            <li><a href="#">Guías</a></li>
                            <li><a href="#">Política de privacidad</a></li>
                            <li><a href="#">Condiciones de uso</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row align-items-end">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_heading mb-30">
                        <li><h6>Suscríbete</h6></li>
                        </div>
                        <div class="subscribtion_form">
                            <form action="register.php" method="post">
                                <input type="email" name="mail" class="mail" placeholder="Tu correo electrónico aquí">
                                <button type="submit" class="submit"><i class="fa fa-long-arrow-right" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
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
                        </script> All rights reserved | Made with <i class="fa fa-heart-o" aria-hidden="true"></i> by <a href="https://github.com/SamuelG0319/Vanity_Shop.git" target="_blank">Keily Marín, Samuel Lasso, Miguel Rodríguez & Carlos Serrano</a>
    <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
            
        </div>


    </footer>
    <!-- ##### Footer Area End ##### -->

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
    <script src="assets/js/card.js"></script>
    <!-- Dirección -->
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Agrega un listener para el evento submit del formulario
        document.getElementById('payment-form').addEventListener('submit', function(event) {
            // Realiza la validación antes de permitir el envío del formulario
            if (!validateAddress()) {
                // Si la validación falla, muestra una alerta y detiene el envío del formulario
                alert('Por favor, complete todos los campos de la dirección de envío.');
                event.preventDefault();
            } else {
                // Si la validación es exitosa, muestra la alerta de "Pedido realizado con éxito"
                alert('Pedido realizado con éxito.');

                // Redirige a index.php
                window.location.href = 'index.php';
            }
        });

        // Función para validar la dirección de envío
        function validateAddress() {
            // Obtiene los valores de los campos
            var firstName = document.getElementById('first_name').value;
            var lastName = document.getElementById('last_name').value;
            var country = document.getElementById('country').value;
            var streetAddress = document.getElementById('street_address').value;
            var postcode = document.getElementById('postcode').value;
            var city = document.getElementById('city').value;
            var state = document.getElementById('state').value;
            var phoneNumber = document.getElementById('phone_number').value;
            var emailAddress = document.getElementById('email_address').value;

            // Realiza la validación: todos los campos deben tener algún valor
            if (firstName === '' || lastName === '' || country === '' || streetAddress === '' || postcode === '' || city === '' || state === '' || phoneNumber === '' || emailAddress === '') {
                return false; // La validación falla
            }

            return true; // La validación es exitosa
        }
    });
    </script>
</body>
</html>