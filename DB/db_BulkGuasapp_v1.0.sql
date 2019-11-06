-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Versión del servidor:         10.3.16-MariaDB - mariadb.org binary distribution
-- SO del servidor:              Win64
-- HeidiSQL Versión:             10.2.0.5599
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;


-- Volcando estructura de base de datos para u273129444_todxs
CREATE DATABASE IF NOT EXISTS `u273129444_todxs` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci */;
USE `u273129444_todxs`;

-- Volcando estructura para tabla u273129444_todxs.user
CREATE TABLE IF NOT EXISTS `user` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `USER` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `PASSWORD` varchar(200) COLLATE utf8mb4_unicode_ci NOT NULL,
  `NAME` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LASTNAME` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `EMAIL` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `STATUS` int(11) NOT NULL DEFAULT 0,
  `COUNTERROR` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `Índice 2` (`USER`),
  UNIQUE KEY `Índice 3` (`EMAIL`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla u273129444_todxs.campaign
CREATE TABLE IF NOT EXISTS `campaign` (
  `IDCAMPAIGN` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DESCRIPTION` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `USERID` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDCAMPAIGN`),
  KEY `FK_campaign_user` (`USERID`),
  CONSTRAINT `FK_campaign_user` FOREIGN KEY (`USERID`) REFERENCES `user` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla u273129444_todxs.message
CREATE TABLE IF NOT EXISTS `message` (
  `IDMESSAGE` int(11) NOT NULL AUTO_INCREMENT,
  `IDCAMPANA` int(11) DEFAULT NULL,
  `NAME` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `MESSAGE` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `USERID` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDMESSAGE`),
  KEY `FK_message_user` (`USERID`),
  CONSTRAINT `FK_message_user` FOREIGN KEY (`USERID`) REFERENCES `user` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla u273129444_todxs.segment
CREATE TABLE IF NOT EXISTS `segment` (
  `IDSEGMENT` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DESCRIPTION` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `CREATIONDATE` datetime DEFAULT current_timestamp(),
  `USERID` int(11) DEFAULT NULL,
  PRIMARY KEY (`IDSEGMENT`),
  KEY `FK_segment_user` (`USERID`),
  CONSTRAINT `FK_segment_user` FOREIGN KEY (`USERID`) REFERENCES `user` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla u273129444_todxs.person
CREATE TABLE IF NOT EXISTS `person` (
  `ID` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `LASTNAME` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `NICKNAME` varchar(25) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PHONE` bigint(20) NOT NULL,
  `DNI` int(11) DEFAULT NULL,
  `ADDRESS` int(50) DEFAULT NULL,
  `LOCATION` int(50) DEFAULT NULL,
  `USERID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ID`),
  UNIQUE KEY `PHONE` (`PHONE`),
  KEY `FK_person_user` (`USERID`),
  CONSTRAINT `FK_person_user` FOREIGN KEY (`USERID`) REFERENCES `user` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=9754 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla u273129444_todxs.message_person
CREATE TABLE IF NOT EXISTS `message_person` (
  `IDMESSAGE` int(11) DEFAULT NULL,
  `IDPERSON` int(11) DEFAULT NULL,
  `STATUS` int(11) DEFAULT NULL,
  `SENDDATE` datetime DEFAULT NULL,
  KEY `FK_MESSAGE_PERSON_MESSAGE` (`IDMESSAGE`),
  KEY `FK_MESSAGE_PERSON_PERSON` (`IDPERSON`),
  CONSTRAINT `FK_MESSAGE_PERSON_MESSAGE` FOREIGN KEY (`IDMESSAGE`) REFERENCES `message` (`IDMESSAGE`),
  CONSTRAINT `FK_MESSAGE_PERSON_PERSON` FOREIGN KEY (`IDPERSON`) REFERENCES `person` (`ID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla u273129444_todxs.rawdata
CREATE TABLE IF NOT EXISTS `rawdata` (
  `Name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Given Name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Additional Name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `Family Name` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PhoneType` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PhoneValue` varchar(250) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `PhoneFormat` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla u273129444_todxs.segment_person
CREATE TABLE IF NOT EXISTS `segment_person` (
  `IDSEGMENT` int(11) DEFAULT NULL,
  `IDPERSON` int(11) DEFAULT NULL,
  UNIQUE KEY `FK_SEGMENTPERSON` (`IDSEGMENT`,`IDPERSON`),
  KEY `FK_SEGMENT_PERSON_PERSON` (`IDPERSON`),
  KEY `FK_SEGMENT_PERSON_SEGMENT` (`IDSEGMENT`),
  CONSTRAINT `FK_SEGMENT_PERSON_PERSON` FOREIGN KEY (`IDPERSON`) REFERENCES `person` (`ID`),
  CONSTRAINT `FK_SEGMENT_PERSON_SEGMENT` FOREIGN KEY (`IDSEGMENT`) REFERENCES `segment` (`IDSEGMENT`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla u273129444_todxs.lot
CREATE TABLE IF NOT EXISTS `lot` (
  `IDLOT` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DESCRIPTION` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `INITDATE` datetime DEFAULT NULL,
  `ENDDATE` datetime DEFAULT NULL,
  `CREATIONDATE` datetime NOT NULL DEFAULT current_timestamp(),
  `IDCAMPAIGN` int(11) NOT NULL DEFAULT 0,
  `IDMESSAGE` int(11) DEFAULT NULL,
  `IDSEGMENT` int(11) DEFAULT NULL,
  `STATUS` int(11) DEFAULT 0,
  `USERID` int(11) NOT NULL,
  PRIMARY KEY (`IDLOT`),
  KEY `FK_LOT_MESSAGE` (`IDMESSAGE`),
  KEY `FK_LOT_CAMPAIGN` (`IDCAMPAIGN`),
  KEY `FK_LOT_SEGMENT` (`IDSEGMENT`),
  KEY `FK_lot_user` (`USERID`),
  CONSTRAINT `FK_LOT_MESSAGE` FOREIGN KEY (`IDMESSAGE`) REFERENCES `message` (`IDMESSAGE`),
  CONSTRAINT `FK_LOT_SEGMENT` FOREIGN KEY (`IDSEGMENT`) REFERENCES `segment` (`IDSEGMENT`),
  CONSTRAINT `FK_lot_user` FOREIGN KEY (`USERID`) REFERENCES `user` (`ID`)
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-- Volcando estructura para tabla u273129444_todxs.version
CREATE TABLE IF NOT EXISTS `version` (
  `IDVERSION` int(11) NOT NULL AUTO_INCREMENT,
  `NAME` varchar(50) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `DESCRIPTION` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`IDVERSION`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- La exportación de datos fue deseleccionada.

-----------STORED PROCEDURE--------------

-- Volcando estructura para procedimiento u273129444_todxs.CheckUser
DELIMITER //
CREATE PROCEDURE `CheckUser`(
	IN `_user` VARCHAR(50)
)
BEGIN
select ID from user 
where user = _user;
END//
DELIMITER ;

-- Volcando estructura para procedimiento u273129444_todxs.ListaPersonas
DELIMITER //
CREATE PROCEDURE `ListaPersonas`()
BEGIN
Select * from person;
END//
DELIMITER ;

-- Volcando estructura para procedimiento u273129444_todxs.MarcarFinLote
DELIMITER //
CREATE PROCEDURE `MarcarFinLote`(
	IN `_userid` INT
)
BEGIN
update lot set lot.ENDDATE = NOW() 
where lot.USERID = _userid and `STATUS` = 1 ;
END//
DELIMITER ;

-- Volcando estructura para procedimiento u273129444_todxs.MarcarInicioLote
DELIMITER //
CREATE PROCEDURE `MarcarInicioLote`(
	IN `_userid` INT
)
BEGIN
update lot set lot.INITDATE = NOW() 
where lot.USERID = _userid and `STATUS` = 1 ;
END//
DELIMITER ;

-- Volcando estructura para procedimiento u273129444_todxs.ObtenerLista
DELIMITER //
CREATE PROCEDURE `ObtenerLista`(
	IN `USERID` INT
)
BEGIN
SELECT 
        NICKNAME,
		  PHONE
    FROM lot AS l
	 RIGHT JOIN segment_person ON segment_person.IDSEGMENT = l.IDSEGMENT 
	 RIGHT JOIN person ON segment_person.IDPERSON = person.ID
	 WHERE 
	 l.STATUS = 1 AND l.USERID = USERID;
END//
DELIMITER ;

-- Volcando estructura para procedimiento u273129444_todxs.ObtenerMensaje
DELIMITER //
CREATE PROCEDURE `ObtenerMensaje`(
	IN `userid` INT
)
BEGIN
	 SELECT message.MESSAGE   	
    FROM lot AS l
	 RIGHT JOIN message ON message.IDMESSAGE = l.IDMESSAGE 
	 WHERE 
	 l.STATUS = 1 AND l.USERID =userid;
END//
DELIMITER ;

/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IF(@OLD_FOREIGN_KEY_CHECKS IS NULL, 1, @OLD_FOREIGN_KEY_CHECKS) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
