-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.1.26-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win32
-- HeidiSQL Versión:             9.4.0.5125
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;

-- Volcando estructura para tabla bramcastillo.details
CREATE TABLE IF NOT EXISTS `details` (
  `productid` int(11) NOT NULL,
  `description` varchar(50) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` float NOT NULL,
  `total` float NOT NULL,
  PRIMARY KEY (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla bramcastillo.details: ~1 rows (aproximadamente)
/*!40000 ALTER TABLE `details` DISABLE KEYS */;
INSERT INTO `details` (`productid`, `description`, `quantity`, `price`, `total`) VALUES
	(1, 'Apple', 6, 0.3, 1.8);
/*!40000 ALTER TABLE `details` ENABLE KEYS */;

-- Volcando estructura para tabla bramcastillo.product
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(50) NOT NULL DEFAULT '0',
  `price` float NOT NULL DEFAULT '0',
  `img` varchar(100) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla bramcastillo.product: ~4 rows (aproximadamente)
/*!40000 ALTER TABLE `product` DISABLE KEYS */;
INSERT INTO `product` (`id`, `name`, `price`, `img`) VALUES
	(1, 'Apple', 0.3, 'images/apples.jpg'),
	(2, 'Beer', 2, 'images/beer.jpg'),
	(3, 'Water', 1, 'images/water.jpg'),
	(4, 'Cheese', 3.74, 'images/cheese.jpg'),
	(5, 'Hamburger', 5.99, 'images/hamburger.jpg'),
	(6, 'Taco', 3.5, 'images/taco.jpg'),
	(7, 'Orange Juice', 2.35, 'images/orange-juice.jpg');
/*!40000 ALTER TABLE `product` ENABLE KEYS */;

-- Volcando estructura para tabla bramcastillo.tbl_rating
CREATE TABLE IF NOT EXISTS `tbl_rating` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `productid` int(11) NOT NULL DEFAULT '0',
  `rate` int(11) NOT NULL DEFAULT '0',
  `sessionid` varchar(50) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Volcando datos para la tabla bramcastillo.tbl_rating: ~7 rows (aproximadamente)
/*!40000 ALTER TABLE `tbl_rating` DISABLE KEYS */;
INSERT INTO `tbl_rating` (`id`, `productid`, `rate`, `sessionid`) VALUES
	(1, 2, 4, 'f2a5m0q5v7t0n4do4a51ffepe6'),
	(2, 3, 5, 've6u3od861301s69gtuu3nh0a9'),
	(3, 2, 2, 've6u3od861301s69gtuu3nh0a9'),
	(4, 1, 1, 've6u3od861301s69gtuu3nh0a9'),
	(5, 4, 5, 've6u3od861301s69gtuu3nh0a9'),
	(6, 2, 2, 'recfjk2sp2ql6ld2gb8k7egfhf'),
	(7, 3, 1, 'recfjk2sp2ql6ld2gb8k7egfhf');
/*!40000 ALTER TABLE `tbl_rating` ENABLE KEYS */;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
