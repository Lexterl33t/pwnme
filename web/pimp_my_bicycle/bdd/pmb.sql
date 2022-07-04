-- SET NAMES utf8;
-- SET time_zone = '+00:00';
-- SET foreign_key_checks = 0;
-- SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

CREATE DATABASE IF NOT EXISTS `pmb` /*!40100 DEFAULT CHARACTER SET latin1 */;
USE `pmb`;
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `pseudo` varchar(20) UNIQUE NOT NULL,
  `password` varchar(150) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `users` (`id`, `pseudo`, `password`) VALUES
(1,	'eteck',	'$2y$10$XC8G/4ZpBbLlcFweZ4PsQefQUo4fk2rsGYzal2Zi89iQHYgZDy4G2'),
(2,	'Dylanfoot',	'$2y$10$/QE/d5zEuQEVThkaY7.B7uEq9qf7R64Ib0QhWX86gPgO/hwg8.b7e'),
(3,	'admin',	'$2y$10$WcVa9fZHWYz4B5T8n8NJpeEfnq/eGRYDLPEAqpqlHgZypGTpxforW');
-- Admin pass: Th4re_1s_a_Pr0bl3m_1f_u_f0und_M3

DROP TABLE IF EXISTS `bikes`;
CREATE TABLE `bikes` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_id` int(11) DEFAULT NULL,
  `data` json DEFAULT NULL,
  `likes` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`),
  CONSTRAINT `bikes_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `bikes` (`id`, `user_id`, `data`, `likes`) VALUES
(2,	1,	'[{\"id\": \"roue0\", \"slot\": 0, \"colors\": [\"#53ff00\", \"#ee0006\"]}, {\"id\": \"roue1\", \"slot\": 1, \"colors\": [\"#400040\", \"#00ff00\"]}, {\"id\": \"guidon1\", \"slot\": 2, \"colors\": [\"#ff0080\"]}, {\"id\": \"selle0\", \"slot\": 3, \"colors\": [\"#ff8040\"]}, {\"id\": \"cadre1\", \"slot\": 4, \"colors\": [\"#5f5f5f\"]}]',	5),
(3,	1,	'[{\"id\": \"roue3\", \"slot\": 0, \"colors\": [\"#ff0f00\", \"#ff0f00\"]}, {\"id\": \"roue2\", \"slot\": 1, \"colors\": [\"#ff0f00\", \"#ff0f00\"]}, {\"id\": \"guidon1\", \"slot\": 2, \"colors\": [\"#ff0f00\"]}, {\"id\": \"selle0\", \"slot\": 3, \"colors\": [\"#ff0f00\"]}, {\"id\": \"cadre1\", \"slot\": 4, \"colors\": [\"#ff0f00\"]}]',	3),
(4,	1,	'[{\"id\": \"roue3\", \"slot\": 0, \"colors\": [\"#53ff00\", \"#ee0006\"]}, {\"id\": \"roue2\", \"slot\": 1, \"colors\": [\"#400040\", \"#00ff00\"]}, {\"id\": \"guidon1\", \"slot\": 2, \"colors\": [\"#64ee11\"]}, {\"id\": \"selle0\", \"slot\": 3, \"colors\": [\"#48f74d\"]}, {\"id\": \"cadre0\", \"slot\": 4, \"colors\": [\"#800003\"]}]',	7),
(6,	2,	'[{\"id\": \"roue1\", \"slot\": 0, \"colors\": [\"#ff8040\", \"#8080ff\"]}, {\"id\": \"roue1\", \"slot\": 1, \"colors\": [\"#8080ff\", \"#ff8000\"]}, {\"id\": \"guidon2\", \"slot\": 2, \"colors\": [\"#8080ff\", \"#8080ff\"]}, {\"id\": \"selle2\", \"slot\": 3, \"colors\": [\"#8080ff\"]}, {\"id\": \"cadre3\", \"slot\": 4, \"colors\": [\"#ff8040\"]}]',	11);

DROP TABLE IF EXISTS `elements`;
CREATE TABLE `elements` (
  `name` varchar(20) NOT NULL,
  `type` tinyint(4) NOT NULL,
  `svg` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

INSERT INTO `elements` (`name`, `type`, `svg`) VALUES
('roue0',	1,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"100px\" height=\"100px\" viewBox=\"-53 -3 106 106\"><path d=\"M0,0 A 50 50, 0, 0 0, 0 100\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d=\"M0,0 A 50 50, 0, 1 1, 0 100\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/></svg>'),
('roue1',	1,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"110px\" height=\"110px\" viewBox=\"-53 -3 106 106\"><path d =\"M0,0 A 50 50, 0, 0 0, 0 100\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>    <path d =\"M0,0 A 50 50, 0, 1 1, 0 100\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/><path d =\"M0,20 A 30 30, 0, 0 0, 0 80\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M0,20 A 30 30, 0, 1 1, 0 80\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/></svg>'),
('guidon0',	2,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"110px\" height=\"110px\" viewBox=\"-70 -3 130 100\"><path d =\"M-40 0 L 30 0\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M-40 30 L 30 30\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M-39,0 A 15 15, 0, 0 0, -39 30\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M-30,30 L-45,60\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/></svg>'),
('guidon1',	2,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"110px\" height=\"110px\" viewBox=\"-70 -3 130 100\"><path d =\"M-40 0 L 30 0\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M-55 30 L 15 30\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M-30,30 L-45,60\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M-37 0 A 8 8, 1, 1 1, -52 30\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/></svg>'),
('guidon2',	2,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"110px\" height=\"110px\" viewBox=\"-70 -3 130 100\"><path d =\"M-40 0 L 30 0\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M-55 30 L 15 30\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/><path d =\"M-30,30 L-45,60\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M-37 0 L -52 30\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M27 0 L 30 -5\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M12 30 L 15 25\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/></svg>'),
('selle0',	3,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"110px\" height=\"110px\" viewBox=\"-70 -3 130 100\"><path d =\"M-55 30 L 15 30\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/><path d =\"M-35,30 L-25,70\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/></svg>'),
('cadre0',	4,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"250px\" height=\"200px\" viewBox=\"-180 -3 250 200\">\r\n  <path d =\"M-170 120 L -60 120\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-95 10 L 70 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-167 120 L -92 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-63 120 L -93 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-62 120 L 70 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M30 42 L 45 120\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n</svg>\r\n'),
('cadre1',	4,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"250px\" height=\"200px\" viewBox=\"-180 -3 250 200\">\r\n  <path d =\"M-170 120 L -95 120\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-95 10 L 70 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-167 120 L -95 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-95 120 L -95 7\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-97 120 L 70 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M27 38 L 45 120\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n</svg>\r\n'),
('cadre2',	4,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"250px\" height=\"200px\" viewBox=\"-180 -3 250 200\">\r\n  <path d =\"M-170 120 L -95 120\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-95 10 L 70 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-167 120 L -95 40\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-95 123 L -95 7\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-96 100 L 70 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M27 31 L 45 120\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n</svg>\r\n'),
('cadre3',	4,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"250px\" height=\"200px\" viewBox=\"-180 -3 250 200\">\r\n  <path d =\"M-170 120 L -95 120\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-95 10 L 70 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-167 120 L -94 9\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-97 120 C -65 105, -65 30, -97 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-96 120 L 70 10\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M28 38 L 45 120\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n</svg>\r\n'),
('selle1',	3,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"110px\" height=\"110px\" viewBox=\"-70 -3 130 100\">\r\n  <path d =\"M-55 30 L 15 30\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-25 30 L-30,70\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-52 30 C -52 24, -30 24, -30 30 \" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n</svg>\r\n\r\n'),
('selle2',	3,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"110px\" height=\"110px\" viewBox=\"-70 -3 130 100\">\r\n  <path d =\"M-55 30 L 25 30\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-25 30 L-25,70\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-52 30 C -52 24, -30 24, -30 30 \" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-27 30 C -27 24, -5 24, -5 30 \" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M-2 30 C -2 24, 20 24, 20 30 \" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n</svg>\r\n'),
('roue2',	1,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"110px\" height=\"110px\" viewBox=\"-53 -3 106 106\">\r\n  <path d =\"M0,0 A 50 50, 0, 0 0, 0 100\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M0,0 A 50 50, 0, 1 1, 0 100\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M0,40 A 10 10, 0, 0 0, 0 60\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M0,40 A 10 10, 0, 1 1, 0 60\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n\r\n  <g id=\"rayons\" fill=\"none\" transform=\"translate(0 50)\">\r\n    <path d =\"M0,10 L 0,50\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,10 L 0,50\" transform=\"rotate(45)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,10 L 0,50\" transform=\"rotate(90)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,10 L 0,50\" transform=\"rotate(135)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,10 L 0,50\" transform=\"rotate(180)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,10 L 0,50\" transform=\"rotate(225)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,10 L 0,50\" transform=\"rotate(270)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,10 L 0,50\" transform=\"rotate(315)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n  </g>\r\n</svg>\r\n'),
('roue3',	1,	'<svg xmlns=\"http://www.w3.org/2000/svg\" version=\"1.1\" width=\"110px\" height=\"110px\" viewBox=\"-53 -3 106 106\">\r\n  <path d =\"M0,0 A 50 50, 0, 0 0, 0 100\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n  <path d =\"M0,0 A 50 50, 0, 1 1, 0 100\" fill=\"none\" stroke=\"%COLOR0%\" stroke-width=\"6\"/>\r\n\r\n  <g id=\"rayons\" fill=\"none\" transform=\"translate(0 50)\">\r\n    <path d =\"M0,0 L 0,50\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,0 L 0,50\" transform=\"rotate(45)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,0 L 0,50\" transform=\"rotate(90)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,0 L 0,50\" transform=\"rotate(135)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,0 L 0,50\" transform=\"rotate(180)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,0 L 0,50\" transform=\"rotate(225)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,0 L 0,50\" transform=\"rotate(270)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n    <path d =\"M0,0 L 0,50\" transform=\"rotate(315)\" fill=\"none\" stroke=\"%COLOR1%\" stroke-width=\"6\"/>\r\n  </g>\r\n</svg>\r\n');



