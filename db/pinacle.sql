players CREATE TABLE players (
username VARCHAR(20) DEFAULT NULL,
playerId TINYINT(4) AUTO_INCREMENT,
token VARCHAR(100) DEFAULT NULL,
last_action TIMESTAMP NULL DEFAULT NULL,
p_turn TINYINT(4) NOT NULL, 
PRIMARY KEY (playerId)
);

INSERT INTO players 
VALUES ('thomas',1,'111',NULL,0);

INSERT INTO players
VALUES ('jacob',2,'222',NULL,1);

CREATE TABLE deck (
card_number INT NOT NULL CHECK ( CARD_NUMBER BETWEEN 1 AND 13),
cardCode VARCHAR (10) NOT NULL,
cardId TINYINT(5) NOT NULL,
PRIMARY KEY (cardId)
);

CREATE TABLE game_status (
g_status enum('not active','initialized','started','
ended','aborted') NOT NULL DEFAULT 'not active',
playerId TINYINT(4) DEFAULT NULL,
result enum('user1','user2') DEFAULT NULL,
last_change timestamp NULL DEFAULT NULL
);

INSERT INTO game_status VALUES ('not active',NULL,NULL, '2021-11-22 18:04:52');

CREATE TABLE clonedeck AS
SELECT * FROM deck
ORDER BY RAND();


INSERT INTO deck VALUES
(1,'1H',1),
(2,'2H',2),
(3,'3H',3),
(4,'4H',4),
(5,'5H',5),
(6,'6H',6),
(7,'7H',7),
(8,'8H',8),
(9,'9H',9),
(10,'10H',10),
(11,'11H',11),
(12,'12H',12),
(13,'13H',13),
(1,'1S',14),
(2,'2S',15),
(3,'3S',16),
(4,'4S',17),
(5,'5S',18),
(6,'6S',19),
(7,'7S',20),
(8,'8S',21),
(9,'9S',22),
(10,'10S',23),
(11,'11S',24),
(12,'12S',25),
(13,'13S',26),
(1,'1C',27),
(2,'2C',28),
(3,'3C',29),
(4,'4C',30),
(5,'5C',31),
(6,'6C',32),
(7,'7C',33),
(8,'8C',34),
(9,'9C',35),
(10,'10',36),
(11,'11',37),
(12,'12C',38),
(13,'13C',39),
(1,'1D',40),
(2,'2D',41),
(3,'3D',42),
(4,'4D',43),
(5,'5D',44),
(6,'6D',45),
(7,'7D',46),
(8,'8D',47),
(9,'9D',48),
(10,'10D',49),
(11,'11D',50),
(12,'12D',51),
(13,'13D',52);





CREATE TABLE hand (
  `playerId` int(6) NOT NULL,
  `cardId` int(6) NOT NULL
); 

CREATE TABLE discarded_cards(
	number INT (20) NOT NULL,
	cardCode VARCHAR (10) NOT NULL
	PRIMARY KEY (number)
);
	
INSERT INTO discarded_cards VALUES (1,'9C');

DELIMITER $$
CREATE
TRIGGER game_status_update BEFORE UPDATE
ON game_status
FOR EACH ROW BEGIN
SET NEW.last_change = NOW();
END$$
DELIMITER ;



DELIMITER //
CREATE PROCEDURE card_shuffle()
BEGIN
	DROP TABLE IF EXISTS `clonedeck`;
		CREATE TABLE clonedeck AS
		SELECT * FROM deck			
		ORDER BY RAND();				
	END//

DELIMITER ;

#CALL card_shuffle();
#SELECT COUNT(*) FROM clonedeck; 
 
DELIMITER //
CREATE PROCEDURE card_deal()
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

#CALL card_deal();
#SELECT COUNT(*) FROM clonedeck;

DELIMITER //

CREATE PROCEDURE playerTurn()  
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
#CALL playerTurn();

SELECT COUNT(*) FROM clonedeck;

DELIMITER //
CREATE PROCEDURE clean_game()
BEGIN

	DROP TABLE IF EXISTS `clonedeck`;
		CREATE TABLE clonedeck AS
		SELECT * FROM deck;
	UPDATE players 
	SET p_turn = 0 WHERE playerId IN (SELECT p.playerId FROM players p INNER JOIN game_status gs WHERE p.playerId = gs.playerId);
	UPDATE game_status 
	SET g_status ='not active', playerId = NULL, result=NULL, last_change = NOW();
	DELETE FROM discarded_cards;
	DELETE FROM hand;
	
END//
DELIMITER ;
#CALL clean_game;
