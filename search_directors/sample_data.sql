-- Original fictional sample for the movie-director finder demo.
-- Not derived from IMDb or any commercial film database.
-- Licensed 0BSD, same as this project's code.

CREATE DATABASE IF NOT EXISTS `movie_directors` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `movie_directors`;

DROP TABLE IF EXISTS `roles`;
DROP TABLE IF EXISTS `movies_genres`;
DROP TABLE IF EXISTS `movies_directors`;
DROP TABLE IF EXISTS `directors_genres`;
DROP TABLE IF EXISTS `movies`;
DROP TABLE IF EXISTS `directors`;
DROP TABLE IF EXISTS `actors`;

CREATE TABLE `directors` (
  `id` int NOT NULL,
  `first_name` varchar(100) DEFAULT NULL,
  `last_name` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `movies` (
  `id` int NOT NULL,
  `name` varchar(100) DEFAULT NULL,
  `year` int DEFAULT NULL,
  `rank` float DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

CREATE TABLE `movies_directors` (
  `director_id` int DEFAULT NULL,
  `movie_id` int DEFAULT NULL,
  KEY `idx_director_id` (`director_id`),
  KEY `idx_movie_id` (`movie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

INSERT INTO `directors` (`id`, `first_name`, `last_name`) VALUES
  (1, 'Nora', 'Vale'),
  (2, 'Jin', 'Park'),
  (3, 'Sam', 'Ortega'),
  (4, 'Leila', 'Hassan');

INSERT INTO `movies` (`id`, `name`, `year`, `rank`) VALUES
  (101, 'The Last Lantern', 2015, 8.1),
  (102, 'Copper Sky', 2019, 7.4),
  (103, 'Quiet Harbor', 2022, 8.6),
  (104, 'Paper Kites', 2008, 6.9),
  (105, 'Winter Circuit', 2024, 7.8),
  (106, 'Glass Orchard', 2021, 8.0),
  (107, 'North of Maple', 1999, 7.2);

INSERT INTO `movies_directors` (`director_id`, `movie_id`) VALUES
  (1, 101),
  (2, 102),
  (1, 103),
  (3, 104),
  (2, 105),
  (4, 106),
  (3, 107);
