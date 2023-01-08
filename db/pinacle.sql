-- --------------------------------------------------------
-- Host:                         127.0.0.1
-- Server version:               10.4.27-MariaDB - mariadb.org binary distribution
-- Server OS:                    Win64
-- HeidiSQL Version:             12.3.0.6589
-- --------------------------------------------------------

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET NAMES utf8 */;
/*!50503 SET NAMES utf8mb4 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;


-- Dumping database structure for pinacle
CREATE DATABASE IF NOT EXISTS `pinacle` /*!40100 DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci */;
USE `pinacle`;

-- Dumping structure for procedure pinacle.card_deal
DELIMITER //
CREATE PROCEDURE `card_deal`()
BEGIN
	
	DECLARE counter INT;
	DECLARE tempId TINYINT(5); 
	SET counter=0;
	
	while (counter < 12) DO
		SELECT cardId INTO tempId FROM clonedeck LIMIT 1;	
		INSERT INTO hand (playerId, cardId) VALUES (1, tempId);
		DELETE  FROM clonedeck WHERE cardId IN (SELECT c.cardId FROM clonedeck c INNER JOIN hand h WHERE c.cardId = h.cardId);
		
		SELECT cardId INTO tempId FROM clonedeck LIMIT 1;	
		INSERT INTO hand (playerId, cardId) VALUES (1, tempId);
		DELETE  FROM clonedeck WHERE cardId IN (SELECT c.cardId FROM clonedeck c INNER JOIN hand h WHERE c.cardId = h.cardId);
		
		SELECT cardId INTO tempId FROM clonedeck LIMIT 1;	
		INSERT INTO hand (playerId, cardId) VALUES (2, tempId);
		DELETE  FROM clonedeck WHERE cardId IN (SELECT c.cardId FROM clonedeck c INNER JOIN hand h WHERE c.cardId = h.cardId);
		
		SELECT cardId INTO tempId FROM clonedeck LIMIT 1;	
		INSERT INTO hand (playerId, cardId) VALUES (2, tempId);
		DELETE  FROM clonedeck WHERE cardId IN (SELECT c.cardId FROM clonedeck c INNER JOIN hand h WHERE c.cardId = h.cardId);
		
		SET counter = counter + 2;
		SELECT * FROM clonedeck;
	END while;
	
END//
DELIMITER ;

-- Dumping structure for procedure pinacle.card_shuffle
DELIMITER //
CREATE PROCEDURE `card_shuffle`()
BEGIN
	DROP TABLE IF EXISTS `clonedeck`;
		CREATE TABLE clonedeck AS
		SELECT * FROM deck			
		ORDER BY RAND();				
	END//
DELIMITER ;

-- Dumping structure for procedure pinacle.clean_game
DELIMITER //
CREATE PROCEDURE `clean_game`()
BEGIN

DROP TABLE IF EXISTS clonedeck;
	CREATE TABLE clonedeck AS SELECT * FROM deck;
	DELETE FROM players;
	ALTER TABLE players AUTO_INCREMENT=1;
	#UPDATE players 
	#SET p_turn = 0 WHERE playerId IN (SELECT p.playerId FROM players p INNER JOIN game_status gs WHERE p.playerId = gs.playerId)game_status;
	UPDATE game_status 
	SET g_status ='not active',result=NULL, last_change = NOW();
	DELETE FROM discarded_cards;
	DELETE FROM hand;
	
END//
DELIMITER ;

-- Dumping structure for table pinacle.clonedeck
CREATE TABLE IF NOT EXISTS `clonedeck` (
  `card_number` int(11) NOT NULL CHECK (`card_number` between 1 and 13),
  `cardCode` varchar(10) NOT NULL,
  `cardId` tinyint(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pinacle.clonedeck: ~24 rows (approximately)
INSERT INTO `clonedeck` (`card_number`, `cardCode`, `cardId`) VALUES
	(11, '11D', 50),
	(4, '4C', 30),
	(1, '1D', 40),
	(9, '9S', 22),
	(3, '3S', 16),
	(1, '1H', 1),
	(6, '6C', 32),
	(4, '4S', 17),
	(1, '1S', 14),
	(11, '11', 37),
	(2, '2S', 15),
	(4, '4H', 4),
	(8, '8H', 8),
	(9, '9D', 48),
	(2, '2D', 41),
	(12, '12S', 25),
	(12, '12C', 38),
	(5, '5S', 18),
	(9, '9C', 35),
	(7, '7D', 46),
	(13, '13S', 26);

-- Dumping structure for table pinacle.deck
CREATE TABLE IF NOT EXISTS `deck` (
  `card_number` int(11) NOT NULL CHECK (`card_number` between 1 and 13),
  `cardCode` varchar(10) NOT NULL,
  `cardId` tinyint(5) NOT NULL,
  PRIMARY KEY (`cardId`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pinacle.deck: ~52 rows (approximately)
INSERT INTO `deck` (`card_number`, `cardCode`, `cardId`) VALUES
	(1, '1H', 1),
	(2, '2H', 2),
	(3, '3H', 3),
	(4, '4H', 4),
	(5, '5H', 5),
	(6, '6H', 6),
	(7, '7H', 7),
	(8, '8H', 8),
	(9, '9H', 9),
	(10, '10H', 10),
	(11, '11H', 11),
	(12, '12H', 12),
	(13, '13H', 13),
	(1, '1S', 14),
	(2, '2S', 15),
	(3, '3S', 16),
	(4, '4S', 17),
	(5, '5S', 18),
	(6, '6S', 19),
	(7, '7S', 20),
	(8, '8S', 21),
	(9, '9S', 22),
	(10, '10S', 23),
	(11, '11S', 24),
	(12, '12S', 25),
	(13, '13S', 26),
	(1, '1C', 27),
	(2, '2C', 28),
	(3, '3C', 29),
	(4, '4C', 30),
	(5, '5C', 31),
	(6, '6C', 32),
	(7, '7C', 33),
	(8, '8C', 34),
	(9, '9C', 35),
	(10, '10', 36),
	(11, '11', 37),
	(12, '12C', 38),
	(13, '13C', 39),
	(1, '1D', 40),
	(2, '2D', 41),
	(3, '3D', 42),
	(4, '4D', 43),
	(5, '5D', 44),
	(6, '6D', 45),
	(7, '7D', 46),
	(8, '8D', 47),
	(9, '9D', 48),
	(10, '10D', 49),
	(11, '11D', 50),
	(12, '12D', 51),
	(13, '13D', 52);

-- Dumping structure for table pinacle.discarded_cards
CREATE TABLE IF NOT EXISTS `discarded_cards` (
  `number` int(20) NOT NULL AUTO_INCREMENT,
  `cardCode` varchar(10) NOT NULL,
  PRIMARY KEY (`number`)
) ENGINE=InnoDB AUTO_INCREMENT=52 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pinacle.discarded_cards: ~10 rows (approximately)
INSERT INTO `discarded_cards` (`number`, `cardCode`) VALUES
	(1, '8D'),
	(3, '7D'),
	(4, '3D'),
	(6, '8C'),
	(7, '8C'),
	(8, '7C'),
	(48, '1C'),
	(49, '1D'),
	(50, '1H'),
	(51, '1S');

-- Dumping structure for table pinacle.game_status
CREATE TABLE IF NOT EXISTS `game_status` (
  `g_status` enum('not active','initialized','started','\r\nended','aborded') NOT NULL DEFAULT 'not active',
  `playerId` tinyint(4) DEFAULT NULL,
  `result` enum('user1','user2') DEFAULT NULL,
  `last_change` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pinacle.game_status: ~1 rows (approximately)
INSERT INTO `game_status` (`g_status`, `playerId`, `result`, `last_change`) VALUES
	('started', 1, NULL, '2022-12-31 09:38:33');

-- Dumping structure for table pinacle.hand
CREATE TABLE IF NOT EXISTS `hand` (
  `playerId` int(6) NOT NULL,
  `cardId` int(6) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pinacle.hand: ~25 rows (approximately)
INSERT INTO `hand` (`playerId`, `cardId`) VALUES
	(1, 39),
	(2, 33),
	(2, 20),
	(1, 19),
	(1, 21),
	(2, 28),
	(1, 44),
	(1, 11),
	(2, 7),
	(2, 2),
	(1, 36),
	(1, 45),
	(2, 5),
	(2, 9),
	(1, 29),
	(1, 24),
	(2, 23),
	(1, 6),
	(1, 31),
	(2, 10),
	(1, 37),
	(1, 43),
	(1, 47),
	(1, 13),
	(1, 14);

-- Dumping structure for procedure pinacle.play3samecards
DELIMITER //
CREATE PROCEDURE `play3samecards`(
	IN `CAR1` VARCHAR(30),
	IN `CAR2` VARCHAR(30),
	IN `CAR3` VARCHAR(30)
)
BEGIN
DECLARE X1 INT;
DECLARE X2 INT;
DECLARE X3 INT;
SET X1=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR1 AND players.p_turn=0 LIMIT 1) ;
SET X2=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR2 AND players.p_turn=0 LIMIT 1);
SET X3=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR3 AND players.p_turn=0 LIMIT 1);
IF (X1=X2 AND X2=X3) THEN
INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR1));
INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR2));
INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR3));

DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR1 AND p_turn = 0) LIMIT 1;
DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR2 AND p_turn = 0) LIMIT 1;
DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR3 AND p_turn = 0) LIMIT 1;

END IF;
END//
DELIMITER ;

-- Dumping structure for procedure pinacle.play4samecards
DELIMITER //
CREATE PROCEDURE `play4samecards`(CAR1 VARCHAR(30),CAR2 VARCHAR(30),CAR3 VARCHAR(30),CAR4 VARCHAR(30))
BEGIN
DECLARE X1 INT;
DECLARE X2 INT;
DECLARE X3 INT;
DECLARE X4 INT;
SET X1=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR1 AND players.p_turn=0 LIMIT 1) ;
SET X2=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR2 AND players.p_turn=0 LIMIT 1);
SET X3=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR3 AND players.p_turn=0 LIMIT 1);
SET X4=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR4 AND players.p_turn=0 LIMIT 1);
IF (X1=X2 AND X2=X3 AND X3=X4) THEN
INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR1));
INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR2));
INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR3));
INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR4));


DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR1 AND p_turn = 0) LIMIT 1;
DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR2 AND p_turn = 0) LIMIT 1;
DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR3 AND p_turn = 0) LIMIT 1;
DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR4 AND p_turn = 0) LIMIT 1;

END IF;
END//
DELIMITER ;

-- Dumping structure for table pinacle.players
CREATE TABLE IF NOT EXISTS `players` (
  `username` varchar(20) DEFAULT NULL,
  `playerId` tinyint(4) NOT NULL AUTO_INCREMENT,
  `token` varchar(100) DEFAULT NULL,
  `last_action` timestamp NULL DEFAULT NULL,
  `p_turn` tinyint(4) NOT NULL,
  PRIMARY KEY (`playerId`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Dumping data for table pinacle.players: ~2 rows (approximately)
INSERT INTO `players` (`username`, `playerId`, `token`, `last_action`, `p_turn`) VALUES
	('jacob', 1, '142db00ce535075d41a277a559f4cae4', NULL, 0),
	('kwstas', 2, 'a53e484f65165fde1b4143caf1604320', NULL, 1);

-- Dumping structure for procedure pinacle.playerTurn
DELIMITER //
CREATE PROCEDURE `playerTurn`()
BEGIN
	
	DECLARE tempval TINYINT(5);
	SELECT p_turn INTO tempval FROM players WHERE playerid = 1;
	
	IF(tempval > 0) THEN
		UPDATE players SET p_turn = 0 WHERE playerId = 1;
		UPDATE players SET p_turn = 1 WHERE playerId = 2;
	ELSE
		UPDATE players SET p_turn = 1 WHERE playerId = 1;
		UPDATE players SET p_turn = 0 WHERE playerId = 2;
	END IF;
	
END//
DELIMITER ;

-- Dumping structure for procedure pinacle.sequenceof5cards
DELIMITER //
CREATE PROCEDURE `sequenceof5cards`(CAR1 VARCHAR(30),CAR2 VARCHAR(30),CAR3 VARCHAR(30),CAR4 VARCHAR(30),CAR5 VARCHAR(30))
BEGIN
 
DECLARE X1 INT;
DECLARE X2 INT;
DECLARE X3 INT;
DECLARE X4 INT;
DECLARE X5 INT;
 
SET X1=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR1 AND players.p_turn=0 LIMIT 1);
SET X2=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR2 AND players.p_turn=0 LIMIT 1);
SET X3=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR3 AND players.p_turn=0 LIMIT 1);
SET X4=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR4 AND players.p_turn=0 LIMIT 1);
SET X5=(SELECT card_number FROM deck INNER JOIN hand ON deck.cardId=hand.cardId INNER JOIN players ON hand.playerId=players.playerId WHERE deck.cardCode= CAR5 AND players.p_turn=0 LIMIT 1);

 
IF (X3-X1=2 AND X5-X3=2) THEN

INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR1));
INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR2));
INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR3));
INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR4));
INSERT INTO discarded_cards (cardCode) VALUES ((SELECT cardCode FROM deck WHERE cardCode=CAR45));

DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR1 AND p_turn = 0) LIMIT 1;
DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR2 AND p_turn = 0) LIMIT 1;
DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR3 AND p_turn = 0) LIMIT 1;
DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR4 AND p_turn = 0) LIMIT 1;
DELETE FROM hand WHERE cardId IN (SELECT hand.cardId FROM hand INNER JOIN deck on deck.cardId = hand.cardId INNER JOIN players on hand.playerId = players.playerId WHERE deck.cardCode = CAR5 AND p_turn = 0) LIMIT 1;

END IF;

END//
DELIMITER ;

-- Dumping structure for trigger pinacle.game_status_update
SET @OLDTMP_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_ZERO_IN_DATE,NO_ZERO_DATE,NO_ENGINE_SUBSTITUTION';
DELIMITER //
CREATE TRIGGER game_status_update BEFORE UPDATE
ON game_status
FOR EACH ROW BEGIN
SET NEW.last_change = NOW();
END//
DELIMITER ;
SET SQL_MODE=@OLDTMP_SQL_MODE;

/*!40103 SET TIME_ZONE=IFNULL(@OLD_TIME_ZONE, 'system') */;
/*!40101 SET SQL_MODE=IFNULL(@OLD_SQL_MODE, '') */;
/*!40014 SET FOREIGN_KEY_CHECKS=IFNULL(@OLD_FOREIGN_KEY_CHECKS, 1) */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40111 SET SQL_NOTES=IFNULL(@OLD_SQL_NOTES, 1) */;
