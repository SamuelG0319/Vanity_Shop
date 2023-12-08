-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Servidor: localhost:3306
-- Tiempo de generación: 08-12-2023 a las 01:10:47
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
  `cod_admin` varchar(4) NOT NULL,
  `username` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(15) NOT NULL,
  `last_name` varchar(15) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `email` varchar(255) NOT NULL,
  `position` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `cart_id` varchar(20) NOT NULL,
  `cod_user` varchar(4) NOT NULL,
  `created_date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_item`
--

CREATE TABLE `cart_item` (
  `item_id` int NOT NULL,
  `cart_id` varchar(20) NOT NULL,
  `product_code` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `company`
--

CREATE TABLE `company` (
  `company_code` varchar(4) NOT NULL,
  `company_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_detail`
--

CREATE TABLE `order_detail` (
  `order_id` varchar(10) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cod_user` varchar(4) NOT NULL,
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

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `products_line`
--

CREATE TABLE `products_line` (
  `product_line` varchar(50) NOT NULL,
  `description` varchar(400) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `cod_user` varchar(4) NOT NULL,
  `company_code` varchar(4) DEFAULT NULL,
  `user` varchar(25) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(15) NOT NULL,
  `last_name` varchar(15) NOT NULL,
  `address` varchar(255) NOT NULL,
  `phone` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;

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
-- AUTO_INCREMENT de la tabla `cart_item`
--
ALTER TABLE `cart_item`
  MODIFY `item_id` int NOT NULL AUTO_INCREMENT;

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
