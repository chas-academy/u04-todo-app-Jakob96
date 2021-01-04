/* Create and use database */

CREATE DATABASE tododb;
USE tododb;

/* Table structure for lists */

CREATE TABLE `lists` (
 `ID` int NOT NULL AUTO_INCREMENT,
 `title` varchar(250) NOT NULL,
 `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
 `userID` int NOT NULL,
 PRIMARY KEY (`ID`),
 KEY `userID` (`userID`),
 CONSTRAINT `userID` FOREIGN KEY (`userID`) REFERENCES `users` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

/* Table structure for tasks */

CREATE TABLE `tasks` (
 `ID` int NOT NULL AUTO_INCREMENT,
 `listID` int NOT NULL,
 `dueDate` date NOT NULL,
 `title` varchar(250) NOT NULL,
 `description` varchar(500) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci DEFAULT NULL,
 `done` tinyint(1) NOT NULL DEFAULT '0',
 PRIMARY KEY (`ID`),
 KEY `listID` (`listID`),
 CONSTRAINT `listID` FOREIGN KEY (`listID`) REFERENCES `lists` (`ID`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci

/* Table structure for users */

CREATE TABLE `users` (
 `ID` int NOT NULL AUTO_INCREMENT,
 `email` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
 PRIMARY KEY (`ID`),
 UNIQUE KEY `email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci