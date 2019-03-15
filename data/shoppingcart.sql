-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.37-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.5.0.5196
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para shoppingcart
CREATE DATABASE IF NOT EXISTS `shoppingcart` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `shoppingcart`;

-- Volcando estructura para tabla shoppingcart.user
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(100) NOT NULL,
  `created_at` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla shoppingcart.user: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `user` DISABLE KEYS */;
INSERT INTO `user` (`id`, `email`, `password`, `created_at`) VALUES
  (17, 'test@gmail.com', '$2y$12$5oRdKYgId6hMRhPTQQ.Oeuo2XmKApKdZLnvNGq4jg0DrhXDgqsZ9G', '2019-01-26 08:53:55');
/*!40000 ALTER TABLE `user` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;

-- Volcando estructura para tabla shoppingcart.product
CREATE TABLE IF NOT EXISTS `product` (
  `product_id` int(11) NOT NULL AUTO_INCREMENT,
  `description` varchar(30) NOT NULL,
  `price` float NOT NULL,
  `picture` varchar(255) NOT NULL,
  `rating` float NOT NULL,
  PRIMARY KEY (`product_id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla shoppingcart.product: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`product_id`, `description`, `price`, `picture`, `rating`) VALUES
  (1, 'Apple', 0.3, 'img/apples.jpg', 2.5),
  (2, 'Beer', 2, 'img/beer.jpg', 2.5),
  (3, 'Water', 1, 'img/water.jpg', 1),
  (4, 'Cheese', 3.74, 'img/cheese.jpg', 1),
  (5, 'Burger', 5.99, 'img/hamburger.jpg', 0),
  (6, 'Taco', 3.99, 'img/taco.jpg', 4),
  (7, 'Orange Juice', 2.35, 'img/orange-juice.jpg', 3.5);
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Volcando estructura para tabla shoppingcart.rating
CREATE TABLE IF NOT EXISTS `rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `rating_product_id` int(11) NOT NULL,
  `rating_value` float NOT NULL,
  `session_id` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `FK_rating_product` (`rating_product_id`),
  CONSTRAINT `FK_rating_product` FOREIGN KEY (`rating_product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=83 DEFAULT CHARSET=utf8;

-- Volcando estructura para tabla shoppingcart.cart
CREATE TABLE IF NOT EXISTS `cart` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`),
  KEY `FK_cart_user` (`user_id`),
  CONSTRAINT `FK_cart_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla shoppingcart.cart: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `cart` DISABLE KEYS */;
INSERT INTO `cart` (`id`, `user_id`, `status`) VALUES
  (7, 17, b'1');
/*!40000 ALTER TABLE `cart` ENABLE KEYS */;

-- Volcando estructura para tabla shoppingcart.cart_items
CREATE TABLE IF NOT EXISTS `cart_items` (
  `cart_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `subtotal` float NOT NULL,
  KEY `FK_cart_items_product` (`product_id`),
  KEY `FK_cart_items_cart` (`cart_id`),
  CONSTRAINT `FK_cart_items_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_cart_items_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Volcando datos para la tabla shoppingcart.cart_items: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `cart_items` DISABLE KEYS */;
/*!40000 ALTER TABLE `cart_items` ENABLE KEYS */;

-- Volcando estructura para tabla shoppingcart.order
CREATE TABLE IF NOT EXISTS `order` (
  `order_id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) NOT NULL,
  `cart_id` int(11) NOT NULL,
  `created_at` datetime NOT NULL,
  `transport_costs` int(11) NOT NULL,
  `total` float NOT NULL,
  PRIMARY KEY (`order_id`),
  KEY `FK_order_cart` (`cart_id`),
  KEY `FK_order_user` (`user_id`),
  CONSTRAINT `FK_order_cart` FOREIGN KEY (`cart_id`) REFERENCES `cart` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_order_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB AUTO_INCREMENT=50 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla shoppingcart.order: ~3 rows (aproximadamente)
/*!40000 ALTER TABLE `order` DISABLE KEYS */;
INSERT INTO `order` (`order_id`, `user_id`, `cart_id`, `created_at`, `transport_costs`, `total`) VALUES
  (47, 17, 7, '2019-01-26 08:54:55', 0, 4),
  (48, 17, 7, '2019-01-26 11:15:13', 0, 2),
  (49, 17, 7, '2019-01-26 11:15:21', 0, 1);
/*!40000 ALTER TABLE `order` ENABLE KEYS */;

-- Volcando estructura para tabla shoppingcart.order_items
CREATE TABLE IF NOT EXISTS `order_items` (
  `order_id` int(11) DEFAULT NULL,
  `product_id` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL,
  `subtotal` float DEFAULT NULL,
  KEY `FK_order_items_product` (`product_id`),
  KEY `FK_order_items_order` (`order_id`),
  CONSTRAINT `FK_order_items_order` FOREIGN KEY (`order_id`) REFERENCES `order` (`order_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `FK_order_items_product` FOREIGN KEY (`product_id`) REFERENCES `product` (`product_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla shoppingcart.order_items: ~6 rows (aproximadamente)
/*!40000 ALTER TABLE `order_items` DISABLE KEYS */;
INSERT INTO `order_items` (`order_id`, `product_id`, `quantity`, `subtotal`) VALUES
  (47, 2, 2, 4),
  (47, 2, 1, 2),
  (48, 2, 1, 2),
  (47, 3, 1, 1),
  (48, 3, 1, 1),
  (49, 3, 1, 1);
/*!40000 ALTER TABLE `order_items` ENABLE KEYS */;

-- Volcando datos para la tabla shoppingcart.rating: ~0 rows (aproximadamente)
/*!40000 ALTER TABLE `rating` DISABLE KEYS */;
/*!40000 ALTER TABLE `rating` ENABLE KEYS */;

-- Volcando estructura para tabla shoppingcart.session
CREATE TABLE IF NOT EXISTS `session` (
  `session_id` varchar(50) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start` datetime NOT NULL,
  `end` datetime DEFAULT NULL,
  `status` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`session_id`),
  KEY `FK_session_user` (`user_id`),
  CONSTRAINT `FK_session_user` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla shoppingcart.session: ~5 rows (aproximadamente)
/*!40000 ALTER TABLE `session` DISABLE KEYS */;
INSERT INTO `session` (`session_id`, `user_id`, `start`, `end`, `status`) VALUES
  ('eldtpjippru8dgbdpgsgjv2oe4', 17, '2019-01-27 09:54:40', NULL, b'1'),
  ('gku95bk1g7olr2os2hqk52fbcp', 17, '2019-01-26 11:14:57', '2019-01-26 11:15:31', b'0'),
  ('hm7q7r8k4rd6q7u49af6e28rno', 17, '2019-01-26 08:54:37', '2019-01-26 08:55:09', b'0');
/*!40000 ALTER TABLE `session` ENABLE KEYS */;