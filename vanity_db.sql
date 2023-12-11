-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 11-12-2023 a las 19:21:01
-- Versión del servidor: 8.0.30
-- Versión de PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `vanity_db`
--

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `admin`
--

CREATE TABLE `admin` (
  `cod_admin` int NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(15) NOT NULL,
  `last_name` varchar(15) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `admin`
--

INSERT INTO `admin` (`cod_admin`, `username`, `password`, `name`, `last_name`, `phone`, `email`, `position`) VALUES
(1, 'heyissac', 'biala1715', 'Carlos', 'Serrano', '6593-4083', 'cisg1703@gmail.com', 'Database administrator'),
(2, 'samuel.alg', 'biala1715', 'Samuel', 'Lasso', '6355-9482', 'samuel.lasso@utp.ac.pa', 'Web developer'),
(3, 'm1gu3ldara20', 'biala1715', 'Miguel', 'Rodríguez', '6009-3741', 'm1gu3ldara20@gmail.com', 'Security engineer'),
(4, 'keix1y', 'biala1715', 'Keily', 'Marín', '6854-5404', 'keily.marin@utp.ac.pa', 'Software test engineer');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `cart_id` int NOT NULL,
  `cod_user` int NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cart`
--

INSERT INTO `cart` (`cart_id`, `cod_user`, `created_date`) VALUES
(1, 3, '2023-12-10'),
(15, 40, '2023-12-11'),
(16, 38, '2023-12-11'),
(17, 41, '2023-12-11'),
(18, 34, '2023-12-11'),
(19, 44, '2023-12-11'),
(20, 43, '2023-12-11'),
(21, 35, '2023-12-11'),
(22, 42, '2023-12-11');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_item`
--

CREATE TABLE `cart_item` (
  `item_id` int NOT NULL,
  `cart_id` int NOT NULL,
  `product_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `cart_item`
--

INSERT INTO `cart_item` (`item_id`, `cart_id`, `product_code`) VALUES
(248, 1, 'A-4014'),
(249, 1, 'T-1008'),
(250, 1, 'T-1003'),
(251, 15, 'B-2005'),
(252, 15, 'B-2011'),
(253, 16, 'S-3003'),
(254, 16, 'A-4005'),
(255, 16, 'A-4011'),
(256, 17, 'B-2011'),
(257, 17, 'T-1013'),
(258, 17, 'S-3013'),
(259, 18, 'B-2003'),
(260, 18, 'S-3005'),
(261, 19, 'A-4005'),
(262, 19, 'A-4015'),
(263, 20, 'B-2001'),
(264, 20, 'T-1010'),
(265, 20, 'S-3006'),
(266, 20, 'A-4006'),
(267, 21, 'B-2009'),
(268, 21, 'S-3001'),
(269, 21, 'A-4003'),
(270, 22, 'T-1001'),
(271, 22, 'A-4012'),
(272, 16, 'T-1015'),
(273, 16, 'B-2013'),
(274, 16, 'B-2015');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

CREATE TABLE `company` (
  `company_code` varchar(4) NOT NULL,
  `company_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `company`
--

INSERT INTO `company` (`company_code`, `company_name`) VALUES
('3ND1', 'Fendi'),
('4D1D', 'Adidas'),
('ABCD', 'Amazon'),
('C4_T', 'Cartier'),
('C4KL', 'Calvin Klein'),
('G0C1', 'Gucci'),
('H&M1', 'H&M'),
('H3RM', 'Hermes'),
('L0VU', 'Louis Vuitton'),
('L3V1', 'Levis'),
('M3T4', 'Meta'),
('N1K3', 'Nike'),
('P0Y4', 'Pedidos Ya'),
('R0LX', 'Rolex'),
('T35L', 'Tesla'),
('TXTW', 'X'),
('WALM', 'Walmart'),
('Y4PP', 'Yappy'),
('Z4R4', 'Zara');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_detail`
--

CREATE TABLE `order_detail` (
  `order_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cod_user` int NOT NULL,
  `order_time` date NOT NULL,
  `retail_price` decimal(10,2) NOT NULL,
  `sales_tax` decimal(10,2) NOT NULL,
  `total` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products`
--

CREATE TABLE `products` (
  `product_code` varchar(10) NOT NULL,
  `product_line` varchar(50) NOT NULL,
  `name` varchar(100) NOT NULL,
  `price` decimal(10,2) NOT NULL,
  `size` varchar(10) NOT NULL,
  `brand` varchar(50) NOT NULL,
  `stock` int NOT NULL,
  `image` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `products`
--

INSERT INTO `products` (`product_code`, `product_line`, `name`, `price`, `size`, `brand`, `stock`, `image`) VALUES
('A-4001', 'ACCESORIES', 'Beanie', 24.99, 'One Size', 'H&M', 15, 'assets/img/product-img/accs-img/acc-1.jpg'),
('A-4002', 'ACCESORIES', 'Fedora Hat', 39.99, 'One Size', 'H&M', 10, 'assets/img/product-img/accs-img/acc-2.jpg'),
('A-4003', 'ACCESORIES', 'Bucket Hat', 15.99, 'One Size', 'H&M', 15, 'assets/img/product-img/accs-img/acc-3.jpg'),
('A-4004', 'ACCESORIES', 'Leather Belt', 15.00, 'One Size', 'H&M', 20, 'assets/img/product-img/accs-img/acc-4.jpg'),
('A-4005', 'ACCESORIES', 'Canvas Belt', 34.99, 'One Size', 'Zara', 12, 'assets/img/product-img/accs-img/acc-5.jpg'),
('A-4006', 'ACCESORIES', 'Crossbody Bag', 26.98, 'One Size', 'H&M', 12, 'assets/img/product-img/accs-img/acc-6.jpg'),
('A-4007', 'ACCESORIES', 'Backpack', 49.99, 'One Size', 'Zara', 10, 'assets/img/product-img/accs-img/acc-7.jpg'),
('A-4008', 'ACCESORIES', 'Tote Bag', 10.99, 'One Size', 'Zara', 15, 'assets/img/product-img/accs-img/acc-8.jpg'),
('A-4009', 'ACCESORIES', 'Briefcase', 69.99, 'One Size', 'Zara', 8, 'assets/img/product-img/accs-img/acc-9.jpg'),
('A-4010', 'ACCESORIES', 'Gold Necklace', 20.99, 'One Size', 'H&M', 15, 'assets/img/product-img/accs-img/acc-10.jpg'),
('A-4011', 'ACCESORIES', 'Gold Bracelet', 15.99, 'One Size', 'H&M', 18, 'assets/img/product-img/accs-img/acc-11.jpg'),
('A-4012', 'ACCESORIES', 'Gold Ring', 12.99, 'One Size', 'H&M', 26, 'assets/img/product-img/accs-img/acc-12.jpg'),
('A-4013', 'ACCESORIES', 'Gold Earrings', 19.99, 'One Size', 'Zara', 8, 'assets/img/product-img/accs-img/acc-13.jpg'),
('A-4014', 'ACCESORIES', 'Baseball Cap', 19.99, 'One Size', 'Nike', 20, 'assets/img/product-img/accs-img/acc-14.jpg'),
('A-4015', 'ACCESORIES', 'Cute Keychain', 8.99, 'One Size', 'H&M', 25, 'assets/img/product-img/accs-img/acc-15.jpg'),
('B-2001', 'BOTTOMS', 'Jeans', 49.99, '28', 'Levis', 20, 'assets/img/product-img/bottoms-img/bottom-1.jpg'),
('B-2002', 'BOTTOMS', 'Chino Pants', 39.99, 'S', 'Levis', 10, 'assets/img/product-img/bottoms-img/bottom-2.jpg'),
('B-2003', 'BOTTOMS', 'Shorts', 24.99, '29', 'Levis', 10, 'assets/img/product-img/bottoms-img/bottom-3.jpg'),
('B-2004', 'BOTTOMS', 'Sweatpants', 34.99, 'M', 'Zara', 12, 'assets/img/product-img/bottoms-img/bottom-4.jpg'),
('B-2005', 'BOTTOMS', 'Running Shorts', 29.99, 'S', 'H&M', 12, 'assets/img/product-img/bottoms-img/bottom-5.jpg'),
('B-2006', 'BOTTOMS', 'Yoga Pants', 39.99, 'XS', 'Zara', 12, 'assets/img/product-img/bottoms-img/bottom-6.jpg'),
('B-2007', 'BOTTOMS', 'Dress Pants', 79.99, 'M', 'Zara', 5, 'assets/img/product-img/bottoms-img/bottom-7.jpg'),
('B-2008', 'BOTTOMS', 'Suit Pants', 59.99, 'L', 'Old Navy', 8, 'assets/img/product-img/bottoms-img/bottom-8.jpg'),
('B-2009', 'BOTTOMS', 'Jeans', 39.99, '40', 'Levis', 15, 'assets/img/product-img/bottoms-img/bottom-9.jpg'),
('B-2010', 'BOTTOMS', 'Chino Pants', 26.98, 'L', 'Old Navy', 9, 'assets/img/product-img/bottoms-img/bottom-10.jpg'),
('B-2011', 'BOTTOMS', 'Short deportivo', 24.99, 'M', 'Nike', 19, 'assets/img/product-img/bottoms-img/bottom-11.jpg'),
('B-2012', 'BOTTOMS', 'Sweatpants', 28.99, 'S', 'Old Navy', 15, 'assets/img/product-img/bottoms-img/bottom-12.jpg'),
('B-2013', 'BOTTOMS', 'Dress Pants', 45.99, 'M', 'Levis', 12, 'assets/img/product-img/bottoms-img/bottom-13.jpg'),
('B-2014', 'BOTTOMS', 'Suit Pants', 39.99, 'M', 'Zara', 10, 'assets/img/product-img/bottoms-img/bottom-14.jpg'),
('B-2015', 'BOTTOMS', 'Short de tela', 18.99, 'S', 'Old Navy', 13, 'assets/img/product-img/bottoms-img/bottom-15.jpg'),
('S-3001', 'SHOES', 'Casual Sneakers', 59.99, '9', 'Zara', 20, 'assets/img/product-img/shoes-img/shoes-1.jpg'),
('S-3002', 'SHOES', 'Running Shoes', 79.99, '7', 'New Balance', 15, 'assets/img/product-img/shoes-img/shoes-2.jpg'),
('S-3003', 'SHOES', 'Ankle Boots', 89.99, '9', 'Zara', 10, 'assets/img/product-img/shoes-img/shoes-3.jpg'),
('S-3004', 'SHOES', 'Chelsea Boots', 99.99, '8', 'Zara', 12, 'assets/img/product-img/shoes-img/shoes-4.jpg'),
('S-3005', 'SHOES', 'Casual Sandals', 39.99, '5', 'Zara', 20, 'assets/img/product-img/shoes-img/shoes-5.jpg'),
('S-3006', 'SHOES', 'Dress Sandals', 59.99, '6', 'Zara', 18, 'assets/img/product-img/shoes-img/shoes-6.jpg'),
('S-3007', 'SHOES', 'Stilettos', 69.99, '7', 'Zara', 5, 'assets/img/product-img/shoes-img/shoes-7.jpg'),
('S-3008', 'SHOES', 'Pumps', 59.99, '6', 'Zara', 15, 'assets/img/product-img/shoes-img/shoes-8.jpg'),
('S-3009', 'SHOES', 'Wedges', 49.99, '9', 'Zara', 20, 'assets/img/product-img/shoes-img/shoes-9.jpg'),
('S-3010', 'SHOES', 'Penny Loafers', 79.99, '10', 'Zara', 15, 'assets/img/product-img/shoes-img/shoes-10.jpg'),
('S-3011', 'SHOES', 'Boat Shoes', 69.99, '10', 'Zara', 10, 'assets/img/product-img/shoes-img/shoes-11.jpg'),
('S-3012', 'SHOES', 'House Slippers', 10.99, '7', 'Zara', 25, 'assets/img/product-img/shoes-img/shoes-12.jpg'),
('S-3013', 'SHOES', 'High-Top Sneakers', 150.00, '10', 'New Balance', 15, 'assets/img/product-img/shoes-img/shoes-13.jpg'),
('S-3014', 'SHOES', 'Platform Sneakers', 100.00, '9', 'New Balance', 12, 'assets/img/product-img/shoes-img/shoes-14.jpg'),
('S-3015', 'SHOES', 'Sports Sandals', 49.99, '6', 'Zara', 10, 'assets/img/product-img/shoes-img/shoes-15.jpg'),
('T-1001', 'TOPS', 'White T-Shirt', 44.50, 'M', 'Zara', 20, 'assets/img/product-img/tops-img/top-1.jpg'),
('T-1002', 'TOPS', 'Black T-Shirt', 44.50, 'M', 'Zara', 20, 'assets/img/product-img/tops-img/top-2.jpg'),
('T-1003', 'TOPS', 'Striped T-Shirt	', 5.99, 'S', 'Old Navy', 15, 'assets/img/product-img/tops-img/top-3.jpg'),
('T-1004', 'TOPS', 'Polo Shirt', 78.00, 'L', 'Levis', 10, 'assets/img/product-img/tops-img/top-4.jpg'),
('T-1005', 'TOPS', 'Sports Tee', 15.99, 'M', 'Puma', 12, 'assets/img/product-img/tops-img/top-5.jpg'),
('T-1006', 'TOPS', 'Tank Top', 19.95, 'XS', 'Zara', 18, 'assets/img/product-img/tops-img/top-6.jpg'),
('T-1007', 'TOPS', 'Dress Shirt', 49.99, 'M', 'Old Navy', 8, 'assets/img/product-img/tops-img/top-7.jpg'),
('T-1008', 'TOPS', 'Button-Down Shirt', 54.99, 'L', 'Old Navy', 5, 'assets/img/product-img/tops-img/top-8.jpg'),
('T-1009', 'TOPS', 'Tuxedo Shirt', 79.99, 'L', 'Old Navy', 2, 'assets/img/product-img/tops-img/top-9.jpg'),
('T-1010', 'TOPS', 'Hoodie', 35.99, 'XL', 'H&M', 15, 'assets/img/product-img/tops-img/top-10.jpg'),
('T-1011', 'TOPS', 'Sweatshirt', 34.99, 'S', 'Old Navy', 10, 'assets/img/product-img/tops-img/top-11.jpg'),
('T-1012', 'TOPS', 'Sweater', 49.99, 'M', 'Old Navy', 8, 'assets/img/product-img/tops-img/top-12.jpg'),
('T-1013', 'TOPS', 'Henley Shirt', 29.99, 'S', 'Old Navy', 12, 'assets/img/product-img/tops-img/top-13.jpg'),
('T-1014', 'TOPS', 'Long-Sleeve T-Shirt', 24.99, 'XS', 'Old Navy', 18, 'assets/img/product-img/tops-img/top-14.jpg'),
('T-1015', 'TOPS', 'Athletic Tank Top', 6.98, 'S', 'Old Navy', 20, 'assets/img/product-img/tops-img/top-15.jpg');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_line`
--

CREATE TABLE `products_line` (
  `product_line` varchar(50) NOT NULL,
  `description` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `products_line`
--

INSERT INTO `products_line` (`product_line`, `description`) VALUES
('ACCESORIES', 'Prendas que aportan un toque de estilo y personalidad'),
('BOTTOMS', 'Prendas versátiles para cualquier ocasión'),
('SHOES', 'Ideales para cualquier ocasión'),
('TOPS', 'Prendas básicas y cómodas para el día a día');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `cod_user` int NOT NULL,
  `company_code` varchar(4) DEFAULT NULL,
  `user` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(15) NOT NULL,
  `last_name` varchar(15) NOT NULL,
  `email` varchar(255) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`cod_user`, `company_code`, `user`, `password`, `name`, `last_name`, `email`, `address`, `phone`) VALUES
(3, NULL, 'mdara', 'biala1715', 'Miguel', 'Rodriguez', 'miguel@gmail.com', 'Bugaba, Chiriquí', '6521-9901'),
(34, NULL, 'queenrhaenyra', 'biala1715', 'Rhaenyra', 'Targeryen', 'rhaenyratar01@gmail.com', 'Dragonstone, Westeros', '6431-9901'),
(35, 'G0C1', 'tchalamet', 'biala1715', 'Timothée', 'Chalamet', 'tchalamet11@gmail.com', 'Hells Kitchen, New York', '6727-3747'),
(36, NULL, 'frodhobbit', 'biala1715', 'Frodo', 'Baggins', 'frodhobbit@gmail.com', 'Bag End, Hobbiton, The Shire', '6323-4556'),
(37, 'H3RM', 'jonsnow', 'biala1715', 'Jon', 'Snow', 'jonsnow@gmail.com', 'Castle Black, The Wall, Westeros', '6921-9612'),
(38, 'T35L', 'elonmusk', 'biala1715', 'Elon', 'Musk', 'elonmusk@gmail.com', 'Boca Chica, Texas', '6333-2167'),
(39, NULL, 'seshatvlt', 'biala1715', 'Seshat', 'Valteri', 'seshvlt@gmail.com', 'Thurgon, Sunny Castle', '6901-3101'),
(40, NULL, 'edmaverick', 'biala1715', 'Eduardo', 'Maverick', 'edmaverick@gmail.com', 'Delicias, Chihuahua, México', '5901-5541'),
(41, 'N1K3', 'cristiano', 'biala1715', 'Cristiano', 'Ronaldo', 'cr7@gmail.com', 'Riad, Arabia Saudita', '6503-5083'),
(42, '4D1D', 'messi10', 'biala1715', 'Lionel', 'Messi', 'leomessi@gmail.com', 'Miami Beach, Miamo', '6701-2210'),
(43, NULL, 'sansa', 'biala1715', 'Sansa', 'Stark', 'sansa@outlook.com', 'Winterfell, The North, Westeros', '6901-1242'),
(44, NULL, 'geobaratheon', 'biala1715', 'Geoffrey', 'Baratheon', 'geo@gmail.com', 'Red Keep, King Landing', '5654-2124'),
(45, NULL, 'trancos', 'biala1715', 'Aragorn', 'Eleassar', 'trancos@gmail.com', 'Minas Tirith, Gondor', '4643-1231');

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`cod_admin`);

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cart_id`),
  ADD KEY `cod_user_fk` (`cod_user`);

--
-- Indices de la tabla `cart_item`
--
ALTER TABLE `cart_item`
  ADD PRIMARY KEY (`item_id`),
  ADD KEY `cart_id_fk` (`cart_id`),
  ADD KEY `product_code` (`product_code`);

--
-- Indices de la tabla `company`
--
ALTER TABLE `company`
  ADD PRIMARY KEY (`company_code`);

--
-- Indices de la tabla `order_detail`
--
ALTER TABLE `order_detail`
  ADD PRIMARY KEY (`order_id`),
  ADD KEY `cod_user_order_fk` (`cod_user`);

--
-- Indices de la tabla `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_code`),
  ADD KEY `product_line_fk` (`product_line`);

--
-- Indices de la tabla `products_line`
--
ALTER TABLE `products_line`
  ADD PRIMARY KEY (`product_line`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`cod_user`),
  ADD KEY `company_code_fk` (`company_code`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `admin`
--
ALTER TABLE `admin`
  MODIFY `cod_admin` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `cart_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT de la tabla `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=275;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `cod_user` int NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=46;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cod_user_fk` FOREIGN KEY (`cod_user`) REFERENCES `user` (`cod_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `cart_item`
--
ALTER TABLE `cart_item`
  ADD CONSTRAINT `cart_id_fk` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`cart_id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  ADD CONSTRAINT `product_code` FOREIGN KEY (`product_code`) REFERENCES `products` (`product_code`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `cod_user_order_fk` FOREIGN KEY (`cod_user`) REFERENCES `user` (`cod_user`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `products`
--
ALTER TABLE `products`
  ADD CONSTRAINT `product_line_fk` FOREIGN KEY (`product_line`) REFERENCES `products_line` (`product_line`) ON DELETE RESTRICT ON UPDATE RESTRICT;

--
-- Filtros para la tabla `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `company_code_fk` FOREIGN KEY (`company_code`) REFERENCES `company` (`company_code`) ON DELETE RESTRICT ON UPDATE RESTRICT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
