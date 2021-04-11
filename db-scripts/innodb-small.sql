-- phpMyAdmin SQL Dump
-- version 4.6.6deb4
-- https://www.phpmyadmin.net/
--
-- Client :  localhost:3306
-- Généré le :  Sam 10 Avril 2021 à 14:22
-- Version du serveur :  10.1.44-MariaDB-0+deb9u1
-- Version de PHP :  7.3.1-1+0~20190113101756.25+stretch~1.gbp15aaa9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `innodb-small`
--
CREATE DATABASE IF NOT EXISTS `innodb-small` DEFAULT CHARACTER SET utf8 COLLATE utf8_bin;
USE `innodb-small`;

-- --------------------------------------------------------

--
-- Structure de la table `category_`
--

CREATE TABLE `category_` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8_bin DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `category_`
--

INSERT INTO `category_` (`id`, `name`) VALUES
(1, 'Proin Mi Aliquam Associates'),
(2, 'Pellentesque A Facilisis Ltd'),
(3, 'Per Corp.'),
(4, 'Phasellus Elit Pede Consulting'),
(5, 'Sed Hendrerit Inc.'),
(6, 'Tortor Integer Ltd'),
(7, 'Orci Adipiscing Non LLP'),
(8, 'Magna Corporation'),
(9, 'Sollicitudin Corporation'),
(10, 'Sed Dui Ltd');

-- --------------------------------------------------------

--
-- Structure de la table `user_`
--

CREATE TABLE `user_` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `firstname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `lastname` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `age` mediumint(9) DEFAULT NULL,
  `sexe` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `city` varchar(255) COLLATE utf8_bin DEFAULT NULL,
  `idCategory` mediumint(8) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Contenu de la table `user_`
--

INSERT INTO `user_` (`id`, `firstname`, `lastname`, `age`, `sexe`, `city`, `idCategory`) VALUES
(1, 'Akeem', 'Faulkner', 6, '0', 'Sanquhar', 6),
(2, 'Thor', 'Sweet', 34, '1', 'Castel Ritaldi', 5),
(3, 'Bianca', 'Stuart', 95, '1', 'La Reina', 5),
(4, 'Sigourney', 'Jacobson', 48, '0', 'Peñalolén', 5),
(5, 'Cassandra', 'Camacho', 24, '1', 'Tocopilla', 9),
(6, 'Renee', 'Mcclure', 68, '0', 'Baileux', 9),
(7, 'Josiah', 'Long', 93, '1', 'Tallahassee', 8),
(8, 'Colton', 'Guerrero', 96, '1', 'Pointe-au-Pic', 10),
(9, 'Odessa', 'Ewing', 88, '1', 'Montgomery', 1),
(10, 'Brian', 'Gaines', 56, '0', 'Kailua', 2),
(11, 'Jamalia', 'Keith', 40, '0', 'Winchester', 10),
(12, 'Justin', 'Mccarthy', 81, '1', 'San Pedro Garza García', 1),
(13, 'Ryan', 'Burgess', 45, '0', 'Stornaway', 2),
(14, 'Ramona', 'Delacruz', 55, '1', 'Karlsruhe', 8),
(15, 'Wylie', 'Chandler', 35, '0', 'Roermond', 4),
(16, 'Bertha', 'Bruce', 4, '0', 'Southend', 10),
(17, 'Jillian', 'Bryan', 22, '1', 'Padre las Casas', 7),
(18, 'Warren', 'Abbott', 47, '1', 'Jodhpur', 2),
(19, 'Caldwell', 'Wong', 11, '1', 'Opoeteren', 8),
(20, 'Charles', 'Ramirez', 10, '0', 'Sanghar', 3),
(21, 'Iliana', 'Whitaker', 27, '0', 'Mira Bhayandar', 2),
(22, 'Noelani', 'Castaneda', 59, '0', 'Bollnäs', 10),
(23, 'Driscoll', 'Kelley', 81, '0', 'Kumbakonam', 9),
(24, 'Taylor', 'Kaufman', 34, '1', 'Beho', 8),
(25, 'Keiko', 'Keller', 14, '1', 'Cuttack', 4),
(26, 'Barclay', 'Campos', 12, '0', 'Denderwindeke', 2),
(27, 'Charlotte', 'Smith', 23, '1', 'Conca Casale', 1),
(28, 'Daniel', 'Witt', 11, '1', 'Panchià', 8),
(29, 'April', 'Reid', 96, '0', 'Poggiorsini', 7),
(30, 'Kyra', 'Elliott', 45, '1', 'Nasirabad', 3),
(31, 'Graham', 'Woodard', 62, '0', 'Staraya Kupavna', 5),
(32, 'Ima', 'Reynolds', 39, '0', 'Mazy', 7),
(33, 'Tanya', 'Moses', 24, '0', 'Palestrina', 7),
(34, 'Madeline', 'Fleming', 59, '1', 'Cumberland', 1),
(35, 'Aimee', 'Nieves', 72, '0', 'Hohen Neuendorf', 2),
(36, 'Sonia', 'Stokes', 66, '1', 'Newark', 9),
(37, 'Lacota', 'Lewis', 45, '1', 'Mesa', 6),
(38, 'Neville', 'Bright', 6, '0', 'New Sarepta', 6),
(39, 'Louis', 'Forbes', 88, '0', 'Rajapalaiyam', 3),
(40, 'Castor', 'Gordon', 96, '0', 'Sparwood', 10),
(41, 'Joelle', 'Hunt', 90, '0', 'Paternopoli', 8),
(42, 'Colton', 'Sweeney', 23, '0', 'Cuxhaven', 5),
(43, 'Vivian', 'Chaney', 62, '1', 'Tanjung Pinang', 3),
(44, 'Florence', 'Wooten', 22, '0', 'Perinaldo', 4),
(45, 'Ian', 'Howard', 43, '1', 'Mildura', 6),
(46, 'Kirby', 'Stone', 14, '1', 'Lesve', 4),
(47, 'Regan', 'Jefferson', 7, '1', 'Envigado', 10),
(48, 'Zena', 'Strickland', 62, '1', 'Baton Rouge', 6),
(49, 'Hiram', 'Gould', 86, '1', 'Port Moody', 10),
(50, 'Kato', 'Benjamin', 42, '0', 'Woodlands County', 4),
(51, 'Winter', 'Witt', 10, '0', 'Melville', 8),
(52, 'Kadeem', 'Todd', 91, '1', 'Mexicali', 4),
(53, 'Kessie', 'Vance', 69, '1', 'Acosse', 4),
(54, 'Ishmael', 'Myers', 2, '1', 'Deerlijk', 8),
(55, 'Aileen', 'Duncan', 73, '0', 'Felitto', 6),
(56, 'Eden', 'Bullock', 75, '0', 'Matiari', 3),
(57, 'Abra', 'Klein', 42, '1', 'Hameln', 4),
(58, 'Gannon', 'Berg', 5, '1', 'Mogi das Cruzes', 4),
(59, 'Ina', 'Jefferson', 5, '0', 'Nacimiento', 7),
(60, 'Shana', 'Daniels', 34, '0', 'Turgutlu', 9),
(61, 'Lars', 'Gordon', 32, '0', 'Sant\'Eusanio Forconese', 4),
(62, 'Mara', 'Chase', 77, '0', 'Lebach', 3),
(63, 'Julian', 'Washington', 58, '1', 'Eluru', 10),
(64, 'Wade', 'Frederick', 54, '0', 'Zierikzee', 5),
(65, 'Minerva', 'Rice', 78, '1', 'Connah\'s Quay', 10),
(66, 'Dai', 'Hutchinson', 11, '1', 'Thame', 2),
(67, 'Nerea', 'Watts', 40, '1', 'Cali', 6),
(68, 'Kevyn', 'Mcgowan', 52, '0', 'Armidale', 4),
(69, 'Echo', 'Mckenzie', 90, '0', 'Yumbel', 2),
(70, 'Duncan', 'Phillips', 66, '1', 'Austin', 2),
(71, 'Jasper', 'Herman', 85, '0', 'Fryazino', 1),
(72, 'Marvin', 'Horton', 43, '0', 'Chesapeake', 4),
(73, 'Brian', 'Sloan', 95, '1', 'Conca Casale', 5),
(74, 'Chaim', 'Simpson', 50, '0', 'Cabo de Santo Agostinho', 3),
(75, 'Kaitlin', 'Wilkinson', 97, '0', 'Boston', 3),
(76, 'Benedict', 'Campos', 80, '1', 'Quilleco', 8),
(77, 'Lars', 'Rowland', 25, '1', 'Ballarat', 3),
(78, 'Lavinia', 'Cooper', 46, '0', 'Monte Vidon Corrado', 9),
(79, 'Melanie', 'Vazquez', 37, '0', 'Albi', 10),
(80, 'Farrah', 'Sullivan', 33, '0', 'Belmont', 1),
(81, 'Riley', 'Reeves', 40, '1', 'Emblem', 8),
(82, 'Charity', 'Ochoa', 54, '0', 'Hudiksvall', 6),
(83, 'Azalia', 'Wilcox', 67, '0', 'Portland', 7),
(84, 'Rhiannon', 'Barrera', 4, '1', 'Radicofani', 10),
(85, 'Chandler', 'Salazar', 89, '0', 'Couthuin', 9),
(86, 'Inez', 'Cooke', 89, '1', 'Beypazarı', 4),
(87, 'Ryan', 'Sears', 97, '1', 'Campitello di Fassa', 2),
(88, 'Dorian', 'Gillespie', 35, '0', 'Penna San Giovanni', 6),
(89, 'Brady', 'Franks', 76, '1', 'Nashville', 8),
(90, 'Arthur', 'Mccarthy', 24, '0', 'Beaconsfield', 5),
(91, 'Jemima', 'Pope', 55, '0', 'Gubkin', 4),
(92, 'Iliana', 'Kemp', 13, '1', 'Kearney', 10),
(93, 'TaShya', 'Chang', 21, '1', 'Gujrat', 6),
(94, 'Orson', 'Lopez', 37, '1', 'El Carmen', 1),
(95, 'Lucian', 'Morales', 12, '0', 'Gold Coast', 10),
(96, 'Lillith', 'Peterson', 45, '1', 'Minna', 2),
(97, 'Mohammad', 'Rollins', 62, '1', 'Kungälv', 10),
(98, 'Mikayla', 'Logan', 20, '0', 'Berhampore', 1),
(99, 'Tanek', 'Reynolds', 4, '0', 'Sommariva Perno', 10),
(100, 'Fay', 'Mcmillan', 83, '0', 'Windermere', 7);

--
-- Index pour les tables exportées
--

--
-- Index pour la table `category_`
--
ALTER TABLE `category_`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `user_`
--
ALTER TABLE `user_`
  ADD PRIMARY KEY (`id`),
  ADD KEY `idCategory` (`idCategory`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `category_`
--
ALTER TABLE `category_`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
--
-- AUTO_INCREMENT pour la table `user_`
--
ALTER TABLE `user_`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=101;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `user_`
--
ALTER TABLE `user_`
  ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`idCategory`) REFERENCES `category_` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
