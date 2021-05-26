CREATE DATABASE myshop;

USE myshop;

CREATE TABLE `user` (
	id int(11) NOT NULL AUTO_INCREMENT,
	firstname varchar(45) NOT NULL,
	lastname varchar(45) NOT NULL,
	birthdate date NOT NULL,
	email varchar(100) NOT NULL,
	login varchar(10) NOT NULL,
	password varchar(60) NOT NULL,
	PRIMARY KEY (id)
);

INSERT INTO `user` VALUES (1, 'Dupuis', 'Jean', '1975-08-10', 'jean.dupuis@gmail.com', 'JD100875', 'motdepasseJean'),
(2, 'Delamare', 'Marie', '1994-12-19', 'marie.delamarre@gmail.com', 'MD191294', 'motdepasseMarie'),
(3, 'Temporaire', 'Test', '2000-01-01', 'test@test.fr', 'TT010100', 'motdepasseTest');

-- UPDATE `user` SET pwd = 'ceciestunmdp' WHERE login = 'TT010100';

-- SELECT * FROM `user`;

-- SELECT login, email FROM `user` LIMIT 1;

-- DELETE FROM `user` WHERE login = 'TT010100';

-- CREATE TABLE car (
-- 	id int(11) NOT NULL AUTO_INCREMENT,
-- 	model varchar(45) NOT NULL,
-- 	numberplate varchar(20) NOT NULL,
-- 	user_id int(11) NOT NULL,
-- 	PRIMARY KEY (id),
-- 	CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES `user`(id)
-- );

-- INSERT INTO car VALUES 
-- (1, 'Porsche 911', 'FE-007-FE', 1),
-- (2, 'Coccinelle', 'AB-123-CD', 2);

-- SELECT * FROM car;