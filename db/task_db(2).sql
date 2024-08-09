-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : ven. 09 août 2024 à 02:56
-- Version du serveur : 8.0.13
-- Version de PHP : 8.1.17

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données : `task_db`
--

-- --------------------------------------------------------

--
-- Structure de la table `department`
--

CREATE TABLE `department` (
  `department_id` int(11) NOT NULL,
  `libelle` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `color` varchar(50) COLLATE utf8mb4_general_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `department`
--

INSERT INTO `department` (`department_id`, `libelle`, `color`) VALUES
(1, 'Human Resources', '#0432ff'),
(3, 'Finances', '#0852ff');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(10) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'ADMIN'),
(2, 'RESPO');

-- --------------------------------------------------------

--
-- Structure de la table `task`
--

CREATE TABLE `task` (
  `task_id` int(11) NOT NULL,
  `title` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `todo` text COLLATE utf8mb4_general_ci NOT NULL,
  `due_date` datetime NOT NULL,
  `created_at` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `isChecked` tinyint(1) DEFAULT '0',
  `isCheckedByAdmin` tinyint(1) DEFAULT '0',
  `userid` int(11) DEFAULT NULL,
  `file` varchar(100) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `isArchived` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `task`
--

INSERT INTO `task` (`task_id`, `title`, `todo`, `due_date`, `created_at`, `isChecked`, `isCheckedByAdmin`, `userid`, `file`, `isArchived`) VALUES
(25, 'hjkcdjknd', 'mnsdfnsdfndsf', '2024-12-01 01:01:00', '2024-08-05 00:00:00', 0, 0, 3, '[\"assignedFiles\\/DEVIS.pdf\"]', 0),
(28, 'hjkcdjknd', 'mnsdfnsdfndsf', '2024-12-01 01:01:00', '2024-08-05 00:00:00', 0, 1, 3, '[\"assignedFiles\\/DEVIS.pdf\"]', 0),
(29, 'hjkcdjknd', 'mnsdfnsdfndsf', '2024-08-08 01:01:00', '2024-08-05 00:00:00', 0, 1, 3, '[\"assignedFiles\\/DEVIS.pdf\"]', 0),
(30, 'hjkcdjknd', 'mnsdfnsdfndsf', '2024-12-01 01:01:00', '2024-08-05 00:00:00', 1, 0, 3, '[\"assignedFiles\\/DEVIS.pdf\"]', 0),
(37, 'call the customer in Dhaby', 'today', '2024-08-04 01:00:00', '2024-08-07 00:00:00', 0, 0, 1, '[\"assignedFiles\\/Projet-WEB-PiSE-2024-CDC.pdf\"]', 0),
(38, 'read pdf', 'jdsjkdsjkdfs', '2024-01-01 07:00:00', '2024-08-07 00:00:00', 0, 0, 1, '[\"assignedFiles\\/DEVIS.pdf\"]', 0);

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `fullname` varchar(100) COLLATE utf8mb4_general_ci NOT NULL,
  `email` varchar(50) COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(254) COLLATE utf8mb4_general_ci NOT NULL,
  `department` int(11) NOT NULL,
  `roleid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `fullname`, `email`, `password`, `department`, `roleid`) VALUES
(1, 'Ange traore', 'angetraore.dev@gmail.com', '$2y$10$2YRP51a8AO/y1e7OOq4Wne55YRjefDpD37XWDo4UWKm3LBGeS2DVC', 1, 1),
(3, 'second user', 'second@mail.com', '$2y$10$Q3xKogs0FefSru8lRnYv7eTFkAQD7O1GiaKpcZsP4SOFSHLlNpCrS', 1, 2);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `department`
--
ALTER TABLE `department`
  ADD PRIMARY KEY (`department_id`);

--
-- Index pour la table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`role_id`);

--
-- Index pour la table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`task_id`),
  ADD KEY `userid` (`userid`);

--
-- Index pour la table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `user_department_fk` (`department`),
  ADD KEY `user_roleid_fk` (`roleid`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`user_id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_department_fk` FOREIGN KEY (`department`) REFERENCES `department` (`department_id`),
  ADD CONSTRAINT `user_roleid_fk` FOREIGN KEY (`roleid`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
