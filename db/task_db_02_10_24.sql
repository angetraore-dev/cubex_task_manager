-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Hôte : localhost
-- Généré le : mer. 02 oct. 2024 à 16:13
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
-- Structure de la table `archive`
--

CREATE TABLE `archive` (
  `archive_id` int(11) NOT NULL,
  `libelle` varchar(250) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `archive`
--

INSERT INTO `archive` (`archive_id`, `libelle`) VALUES
(30, 'byDepartment'),
(31, 'july folder'),
(32, 'august-Folder'),
(33, 'September Folder'),
(34, 'geno');

-- --------------------------------------------------------

--
-- Structure de la table `archivetask`
--

CREATE TABLE `archivetask` (
  `archivetask_id` int(11) NOT NULL,
  `taskid` int(11) NOT NULL,
  `observation` varchar(250) COLLATE utf8mb4_general_ci DEFAULT NULL,
  `archiveid` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `archivetask`
--

INSERT INTO `archivetask` (`archivetask_id`, `taskid`, `observation`, `archiveid`) VALUES
(21, 5, 'Done On Time', 33),
(22, 11, 'Done On Time', 33),
(24, 8, 'Done Before Time', 34);

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
(4, 'ceo', '#FFFFFF'),
(25, 'finance', '#4fad5b'),
(26, 'shared services', '#4fadea'),
(27, 'procurement', '#8e2966'),
(34, 'GreyDepartment', '#8d8d8d'),
(35, 'ceo-bis', '#be56d9');

-- --------------------------------------------------------

--
-- Structure de la table `role`
--

CREATE TABLE `role` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(150) COLLATE utf8mb4_general_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `role`
--

INSERT INTO `role` (`role_id`, `role_name`) VALUES
(1, 'ADMIN'),
(2, 'RESPO'),
(3, 'CEO'),
(4, 'USER');

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
(2, 'read pdf 2', '1', '2024-08-25 23:00:00', '2024-08-07 00:00:00', 1, 0, 1, '[\"assignedFiles\\/DEVIS.pdf\"]', 0),
(5, 'read pdf 5', '2', '2024-08-25 23:00:00', '2024-08-07 00:00:00', 1, 1, 1, '[\"assignedFiles\\/DEVIS.pdf\"]', 1),
(8, 'read pdf 8', '3', '2024-08-25 23:00:00', '2024-08-07 00:00:00', 1, 1, 3, '[\"assignedFiles\\/DEVIS.pdf\"]', 1),
(11, 'read pdf', '4', '2024-08-25 23:00:00', '2024-08-07 00:00:00', 1, 1, 3, '[\"assignedFiles\\/DEVIS.pdf\"]', 1),
(42, 'AddTaskPage and TaskPage', '5', '2024-09-24 11:11:00', '2024-09-03 00:00:00', 1, 1, 8, '[\"assignedFiles\\/IMG_1411.jpeg\"]', 0);

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
  `roleid` int(11) NOT NULL,
  `header` tinyint(1) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Déchargement des données de la table `user`
--

INSERT INTO `user` (`user_id`, `fullname`, `email`, `password`, `department`, `roleid`, `header`) VALUES
(1, 'Ange traore', 'angetraore.dev@gmail.com', '$2y$10$2YRP51a8AO/y1e7OOq4Wne55YRjefDpD37XWDo4UWKm3LBGeS2DVC', 1, 1, 0),
(3, 'second user', 'second@mail.com', '$2y$10$Q3xKogs0FefSru8lRnYv7eTFkAQD7O1GiaKpcZsP4SOFSHLlNpCrS', 1, 2, 0),
(8, 'Traore Massi Hilaire', 'to.massi@mail.com', '$2y$10$YftQCPmkITaltZScHPCpueo4X1Aq1hyeRcf03aYRsrOEBMd.OIJ56', 26, 2, 0),
(9, 'Fukk', 'fullne@mail.com', '$2y$10$ca1VvFLFRIGlDPzU5QaEaeiT48JmTZkodH3DZ1l9IS1urXnH6L6oO', 25, 4, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `archive`
--
ALTER TABLE `archive`
  ADD PRIMARY KEY (`archive_id`);

--
-- Index pour la table `archivetask`
--
ALTER TABLE `archivetask`
  ADD PRIMARY KEY (`archivetask_id`),
  ADD KEY `archivetask_task_fk` (`taskid`),
  ADD KEY `archivetask_archive_fk` (`archiveid`);

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
  ADD KEY `user_roleid_fk` (`roleid`),
  ADD KEY `user_department_fk` (`department`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `archive`
--
ALTER TABLE `archive`
  MODIFY `archive_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pour la table `archivetask`
--
ALTER TABLE `archivetask`
  MODIFY `archivetask_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pour la table `department`
--
ALTER TABLE `department`
  MODIFY `department_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- AUTO_INCREMENT pour la table `role`
--
ALTER TABLE `role`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `task`
--
ALTER TABLE `task`
  MODIFY `task_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT pour la table `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `archivetask`
--
ALTER TABLE `archivetask`
  ADD CONSTRAINT `archivetask_archive_fk` FOREIGN KEY (`archiveid`) REFERENCES `archive` (`archive_id`),
  ADD CONSTRAINT `archivetask_task_fk` FOREIGN KEY (`taskid`) REFERENCES `task` (`task_id`);

--
-- Contraintes pour la table `task`
--
ALTER TABLE `task`
  ADD CONSTRAINT `task_ibfk_1` FOREIGN KEY (`userid`) REFERENCES `user` (`user_id`);

--
-- Contraintes pour la table `user`
--
ALTER TABLE `user`
  ADD CONSTRAINT `user_department_fk` FOREIGN KEY (`department`) REFERENCES `department` (`department_id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `user_roleid_fk` FOREIGN KEY (`roleid`) REFERENCES `role` (`role_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
