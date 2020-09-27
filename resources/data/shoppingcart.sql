-- phpMyAdmin SQL Dump
-- version 5.0.1
-- https://www.phpmyadmin.net/
--
-- Servidor: 127.0.0.1
-- Tiempo de generación: 27-09-2020 a las 10:29:32
-- Versión del servidor: 10.4.11-MariaDB
-- Versión de PHP: 7.4.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de datos: `shoppingcart`
--
CREATE DATABASE IF NOT EXISTS `shoppingcart` DEFAULT CHARACTER SET latin1 COLLATE latin1_swedish_ci;
USE `shoppingcart`;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `status`) VALUES
(2, 60, b'1'),
(3, 61, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `cart_items`
--

CREATE TABLE `cart_items` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `size` varchar(3) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `cart_items`
--

INSERT INTO `cart_items` (`cart_id`, `product_id`, `size`, `quantity`, `subtotal`) VALUES
(3, 1020, 'M', 1, 24.99),
(3, 1018, '6', 1, 40);

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order`
--

CREATE TABLE `order` (
  `order_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `transport_costs` float NOT NULL,
  `total` float NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `order_details`
--

CREATE TABLE `order_details` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `product`
--

CREATE TABLE `product` (
  `product_id` int(11) NOT NULL,
  `description` varchar(150) NOT NULL,
  `price` float NOT NULL,
  `discount` tinyint(4) NOT NULL DEFAULT 0,
  `rating` float NOT NULL DEFAULT 0,
  `sizes` varchar(100) DEFAULT 'null'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Volcado de datos para la tabla `product`
--

INSERT INTO `product` (`product_id`, `description`, `price`, `discount`, `rating`, `sizes`) VALUES
(1000, 'White floral dress', 35.99, 0, 0, 'S, M, L, XL'),
(1001, 'Gray spaghetti strap dress', 29.5, 0, 0, 'S, M, L, XL'),
(1002, 'Purple lace knitted dress', 48, 0, 0, 'S, M, L, XL'),
(1003, 'Pastel pink, floral halter-top dress', 38, 30, 0, 'S, M, L, XL'),
(1004, 'White dress with floral textile', 40, 0, 0, 'S, M, L, XL'),
(1005, 'White V-Neck sleeveless dress', 32, 0, 0, 'S, M, L, XL'),
(1006, 'Red sleeveless dress', 41, 0, 0, 'S, M, L, XL'),
(1007, 'Red floral dress', 26.99, 0, 0, 'S, M, L, XL'),
(1008, 'Metallic blue jumpsuit', 60, 0, 0, 'S, M, L, XL'),
(1009, 'Gray jumpsuit', 53.5, 0, 0, 'S, M, L, XL'),
(1010, 'Light blue striped jumpsuit', 42, 30, 0, 'S, M, L, XL'),
(1011, 'White spaghetti strap jumpsuit', 47.5, 0, 0, 'S, M, L, XL'),
(1012, 'Beige sleeveless jumpsuit', 58.99, 0, 0, 'S, M, L, XL'),
(1013, 'Green athletic shoes', 39.99, 0, 0, '4.5, 5.5, 6, 7, 8, 8.5, 9.5, 10'),
(1014, 'Simple white sneakers', 30, 0, 0, '4.5, 5.5, 6, 7, 8, 8.5, 9.5, 10'),
(1015, 'Red sneakers', 42.5, 30, 0, '4.5, 5.5, 6, 7, 8, 8.5, 9.5, 10'),
(1016, 'Pink patent leather stilettos', 54.99, 0, 0, '4.5, 5.5, 6, 7, 8, 8.5, 9.5, 10'),
(1017, 'Gold leather heeled sandals', 49.99, 0, 0, '4.5, 5.5, 6, 7, 8, 8.5, 9.5, 10'),
(1018, 'Black stilettos', 40, 0, 0, '4.5, 5.5, 6, 7, 8, 8.5, 9.5, 10'),
(1019, 'Yellow tracksuit', 75, 30, 0, 'S, M, L, XL'),
(1020, 'Black skull hand top', 24.99, 0, 0, 'S, M, L, XL'),
(1021, 'Gray turtle-neck top', 29.99, 30, 0, 'S, M, L, XL'),
(1022, 'Blue denim shorts', 24.99, 0, 0, 'S, M, L, XL'),
(1023, 'Black long sleeve t-shirt', 20, 0, 0, 'S, M, L, XL'),
(1024, 'Green halter bikini', 17.99, 0, 0, 'S, M, L, XL'),
(1025, 'Basic black bikini', 12.99, 0, 0, 'S, M, L, XL'),
(1026, 'Red with white dots bikini', 14.99, 0, 0, 'S, M, L, XL'),
(1027, 'Animal print bikini top', 12, 0, 0, 'S, M, L, XL'),
(1028, 'Floral halter bikini top', 11.5, 0, 0, 'S, M, L, XL');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `rating`
--

CREATE TABLE `rating` (
  `id` int(11) NOT NULL,
  `rating_product_id` int(11) NOT NULL,
  `rating_user_id` int(11) NOT NULL,
  `rating_value` int(1) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `remembered_logins`
--

CREATE TABLE `remembered_logins` (
  `token_hash` varchar(64) NOT NULL,
  `user_id` int(11) NOT NULL,
  `session_id` varchar(50) NOT NULL,
  `expires_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `remembered_logins`
--

INSERT INTO `remembered_logins` (`token_hash`, `user_id`, `session_id`, `expires_at`) VALUES
('c9e510f05b364c86d9495472a6a24e50848c420d43dc11563e0e14ea020fcd80', 60, 'olhmii2fi1gpmmvh5u0qmirstf', '2020-10-27 04:12:45');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `review`
--

CREATE TABLE `review` (
  `id` int(11) NOT NULL,
  `review_product_id` int(11) NOT NULL,
  `review_user_id` int(11) NOT NULL,
  `review_content` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `session`
--

CREATE TABLE `session` (
  `session_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `started_at` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1'
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `session`
--

INSERT INTO `session` (`session_id`, `user_id`, `started_at`, `end`, `status`) VALUES
('8mg359teremhuinhchchoerg8o', 60, '2020-09-26 15:13:50', NULL, b'1'),
('fgbhm0d2vmhtdj58m4088ouunk', 60, '2020-09-23 23:09:36', NULL, b'1'),
('kbdckblvif21rj93epfb1se2ca', 61, '2020-09-27 04:11:46', '2020-09-27 04:12:34', b'0'),
('olhmii2fi1gpmmvh5u0qmirstf', 60, '2020-09-27 04:12:44', '0000-00-00 00:00:00', b'1'),
('qm0t4mt3j0d92rrc1kj5ah1aki', 60, '2020-09-27 01:32:15', '2020-09-27 04:00:49', b'0'),
('vkhv23j9vcrl3eh1h2lies7qdf', 60, '2020-09-25 18:32:37', NULL, b'1');

-- --------------------------------------------------------

--
-- Estructura de tabla para la tabla `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `email` varchar(60) NOT NULL,
  `name` varchar(60) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  `password_reset_hash` varchar(64) DEFAULT NULL,
  `password_reset_expires_at` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Volcado de datos para la tabla `user`
--

INSERT INTO `user` (`id`, `email`, `name`, `password`, `created_at`, `password_reset_hash`, `password_reset_expires_at`) VALUES
(60, 'crjoseabraham@gmail.com', 'Bram', '$2y$10$t/QlawJDNZXzEGVNas/SyuCc8mm95AyYi2fsn.fn3rRQyjHwfgrTi', '2020-09-23 23:09:36', NULL, NULL),
(61, 'monica@piedpiper.com', 'Monica', '$2y$10$AYMl4l1S0Gt3NIFgiYrvTeoo2.x6cuj428P1y.PddN3PfDLf0EhYS', '2020-09-27 04:11:46', NULL, NULL);

--
-- Índices para tablas volcadas
--

--
-- Indices de la tabla `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_cart_user` (`user_id`);

--
-- Indices de la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD KEY `FK_cart_items_product` (`product_id`),
  ADD KEY `FK_cart_items_cart` (`cart_id`);

--
-- Indices de la tabla `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`order_id`);

--
-- Indices de la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD KEY `FK_order_items_product` (`product_id`),
  ADD KEY `FK_order_items_order` (`order_id`);

--
-- Indices de la tabla `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`product_id`);

--
-- Indices de la tabla `rating`
--
ALTER TABLE `rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK_rating_product` (`rating_product_id`);

--
-- Indices de la tabla `remembered_logins`
--
ALTER TABLE `remembered_logins`
  ADD PRIMARY KEY (`token_hash`),
  ADD KEY `session_id` (`session_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indices de la tabla `review`
--
ALTER TABLE `review`
  ADD PRIMARY KEY (`id`),
  ADD KEY `FK__product` (`review_product_id`),
  ADD KEY `FK__user` (`review_user_id`);

--
-- Indices de la tabla `session`
--
ALTER TABLE `session`
  ADD PRIMARY KEY (`session_id`),
  ADD KEY `FK_session_user` (`user_id`);

--
-- Indices de la tabla `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `password_reset_hash` (`password_reset_hash`);

--
-- AUTO_INCREMENT de las tablas volcadas
--

--
-- AUTO_INCREMENT de la tabla `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT de la tabla `order`
--
ALTER TABLE `order`
  MODIFY `order_id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `product`
--
ALTER TABLE `product`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1029;

--
-- AUTO_INCREMENT de la tabla `rating`
--
ALTER TABLE `rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `review`
--
ALTER TABLE `review`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT de la tabla `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- Restricciones para tablas volcadas
--

--
-- Filtros para la tabla `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `FK_cart_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `cart_items`
--
ALTER TABLE `cart_items`
  ADD CONSTRAINT `FK_cart_items_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_cart_items_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `order_details`
--
ALTER TABLE `order_details`
  ADD CONSTRAINT `FK_order_details_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK_order_details_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `rating`
--
ALTER TABLE `rating`
  ADD CONSTRAINT `FK_rating_product` FOREIGN KEY (`rating_product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `review`
--
ALTER TABLE `review`
  ADD CONSTRAINT `FK__product` FOREIGN KEY (`review_product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `FK__user` FOREIGN KEY (`review_user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Filtros para la tabla `session`
--
ALTER TABLE `session`
  ADD CONSTRAINT `FK_session_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
