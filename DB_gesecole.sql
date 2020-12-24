-- phpMyAdmin SQL Dump
-- version 4.7.0
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  mar. 07 jan. 2020 à 17:55
-- Version du serveur :  10.1.25-MariaDB
-- Version de PHP :  5.6.31

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `gesecole`
--

-- --------------------------------------------------------

--
-- Structure de la table `absences`
--

CREATE TABLE `absences` (
  `id` int(11) NOT NULL,
  `type` varchar(20) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `reason` varchar(50) DEFAULT NULL,
  `note` mediumtext,
  `date` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `absences`
--

INSERT INTO `absences` (`id`, `type`, `full_name`, `reason`, `note`, `date`) VALUES
(2, 'teacher', 'Mickel Foursov', 'malady', 'bonjour mr le directeur  Par la presente, je sollicite votre autorisation pour pouvoir m absenter de l etablissement  le (02/11/2019). En effet, je suis malade Il m est pas consequent impossible de me rendre au travail ce jour la.Pour compenser mes heures de travail perdues pendant mon absence, je vous propose de rattraper les heures, ', '24/11/2019');

-- --------------------------------------------------------

--
-- Structure de la table `administrator`
--

CREATE TABLE `administrator` (
  `id` int(11) NOT NULL,
  `admin_index` varchar(30) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `administrator`
--

INSERT INTO `administrator` (`id`, `admin_index`, `username`, `password`, `email`) VALUES
(1, '46150738488', 'admin', 'b59c67bf196a4758191e42f76670ceba', 'issamanthem@gmail.com');

-- --------------------------------------------------------

--
-- Structure de la table `classes`
--

CREATE TABLE `classes` (
  `id` int(11) NOT NULL,
  `class_name` varchar(50) DEFAULT NULL,
  `class_numeric` varchar(30) DEFAULT NULL,
  `class_note` mediumtext,
  `emplois` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `classes`
--

INSERT INTO `classes` (`id`, `class_name`, `class_numeric`, `class_note`, `emplois`) VALUES
(3, 'L3 MIAGE', '1', 'methodes info appliqué a la gestion des entreprises', 'tdi.png'),
(4, 'TSGE1', '2', 'Technicien spécialisé en gestion des entreprise', ''),
(5, 'TSGE2', '3', 'Technicien spécialisé en gestion des entreprise', ''),
(6, 'TDI', '4', 'technique de développement informatique', NULL);

-- --------------------------------------------------------

--
-- Structure de la table `comments`
--

CREATE TABLE `comments` (
  `id` int(11) NOT NULL,
  `comment` text,
  `type` varchar(50) DEFAULT NULL,
  `author` varchar(200) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `comment_date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments`
--

INSERT INTO `comments` (`id`, `comment`, `type`, `author`, `article_id`, `comment_date`) VALUES
(3, 'merci', 'student', '22054683', 1, '01/11/2019'),
(4, 'merci', 'teacher', '54749191', 1, '01/11/2019'),
(5, 'hhhh', 'student', '22054683', 1, '07/01/2020');

-- --------------------------------------------------------

--
-- Structure de la table `comments_formateurs`
--

CREATE TABLE `comments_formateurs` (
  `id` int(11) NOT NULL,
  `comment` text,
  `type` varchar(50) DEFAULT NULL,
  `author` varchar(200) DEFAULT NULL,
  `article_id` int(11) DEFAULT NULL,
  `comment_date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `comments_formateurs`
--

INSERT INTO `comments_formateurs` (`id`, `comment`, `type`, `author`, `article_id`, `comment_date`) VALUES
(0, 'merci', 'teacher', '54749191', 2, '31/12/2019');

-- --------------------------------------------------------

--
-- Structure de la table `comments_lessons`
--

CREATE TABLE `comments_lessons` (
  `id` int(11) NOT NULL,
  `comment` text,
  `type` varchar(50) DEFAULT NULL,
  `author` varchar(250) DEFAULT NULL,
  `lesson_id` int(11) DEFAULT NULL,
  `comment_date` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Déchargement des données de la table `comments_lessons`
--

INSERT INTO `comments_lessons` (`id`, `comment`, `type`, `author`, `lesson_id`, `comment_date`) VALUES
(1, 'test comment', 'teacher', '54749191', 4, '02/01/2020'),
(2, '&lt;script&gt;alert(\'Injected!\');&lt;/script&gt;', 'teacher', '54749191', 4, '07/01/2020');

-- --------------------------------------------------------

--
-- Structure de la table `control`
--

CREATE TABLE `control` (
  `id` int(1) NOT NULL,
  `close_message` tinytext,
  `close_site` int(2) DEFAULT NULL,
  `pagination` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `control`
--

INSERT INTO `control` (`id`, `close_message`, `close_site`, `pagination`) VALUES
(1, 'A bientot', 0, 6);

-- --------------------------------------------------------

--
-- Structure de la table `exam`
--

CREATE TABLE `exam` (
  `id` int(11) NOT NULL,
  `class` varchar(50) DEFAULT NULL,
  `teacher_name` varchar(50) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `time` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `exam`
--

INSERT INTO `exam` (`id`, `class`, `teacher_name`, `subject`, `date`, `time`) VALUES
(3, 'L3 MIAGE', 'Mickaël Foursov', 'Programmation Java', '25/01/2020', '14:00');

-- --------------------------------------------------------

--
-- Structure de la table `index_users`
--

CREATE TABLE `index_users` (
  `id` int(11) NOT NULL,
  `index_num` varchar(30) DEFAULT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `index_users`
--

INSERT INTO `index_users` (`id`, `index_num`, `full_name`, `type`) VALUES
(1, '46150738488', 'administrator', 'administrator'),
(3, '7279272', 'issam elmoutii', 'student'),
(4, '22054683', 'issam elmoutii', 'student'),
(5, '54749191', 'Mickaël Foursov', 'teacher'),
(7, '43453432', 'Etudiant X', 'student');

-- --------------------------------------------------------

--
-- Structure de la table `lessons`
--

CREATE TABLE `lessons` (
  `lesson_id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `lesson` text,
  `author` varchar(50) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `class` varchar(30) DEFAULT NULL,
  `subject` varchar(100) DEFAULT NULL,
  `jointes` varchar(200) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `lessons`
--

INSERT INTO `lessons` (`lesson_id`, `title`, `lesson`, `author`, `date`, `class`, `subject`, `jointes`) VALUES
(4, 'Cours JAVA', '&lt;div style=&quot;text-align: center;&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-weight: bold; font-style: italic; text-decoration-line: underline;&quot;&gt;Initiation à la programmation orientée-objet\r\navec le langage Java&lt;/span&gt;&lt;/div&gt;&lt;div style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-weight: bold; font-style: italic; text-decoration-line: underline;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/div&gt;&lt;div style=&quot;text-align: left;&quot;&gt;&lt;span style=&quot;font-size: 10pt; font-weight: bold; font-style: italic; text-decoration-line: underline;&quot;&gt;&lt;br&gt;&lt;/span&gt;&lt;/div&gt;&lt;div style=&quot;text-align: left;&quot;&gt;Le langage Java est un langage généraliste de programmation synthétisant les principaux langages existants lors de sa création en  par Sun Microsystems. Il permet une programmation\r\norientée-objet (à l’instar de SmallTalk et, dans une moindre mesure, C++), modulaire (langage\r\nADA) et reprend une syntaxe très proche de celle du langage C.\r\nOutre son orientation objet, le langage Java a l’avantage d’être modulaire (on peut écrire des\r\nportions de code génériques, c-à-d utilisables par plusieurs applications), rigoureux (la plupart\r\ndes erreurs se produisent à la compilation et non à l’exécution) et portable (un même programme\r\ncompilé peut s’exécuter sur différents environnements). En contre-partie, les applications Java ont\r\nle défaut d’être plus lentes à l’exécution que des applications programmées en C par exemple.&amp;nbsp;&lt;/div&gt;', 'Mickaël Foursov', '02/01/2020', 'L3 MIAGE', 'Programmation Java', '1578003920.pdf');

-- --------------------------------------------------------

--
-- Structure de la table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `message_from` varchar(30) DEFAULT NULL,
  `name` varchar(50) DEFAULT NULL,
  `subject` varchar(200) DEFAULT NULL,
  `message` mediumtext,
  `date` varchar(10) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `parents_users`
--

CREATE TABLE `parents_users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `parent_index` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(30) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `image` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `parents_users`
--

INSERT INTO `parents_users` (`id`, `full_name`, `parent_index`, `username`, `password`, `email`, `phone`, `sex`, `address`, `image`) VALUES
(1, 'elmoutii brahim', '54297680', 'guardien1', 'b59c67bf196a4758191e42f76670ceba', 'elmoutii@gmail.com', '097655767888', 'male', 'rennes', ''),
(2, 'boutbagha omar', '41835816', 'boutbagha ', 'b59c67bf196a4758191e42f76670ceba', 'boutbagha@gmail.com', '04838384783', 'male', 'rennes', '');

-- --------------------------------------------------------

--
-- Structure de la table `reports`
--

CREATE TABLE `reports` (
  `report_id` int(11) NOT NULL,
  `student_index` varchar(20) DEFAULT NULL,
  `to_parents` int(2) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `title` varchar(250) DEFAULT NULL,
  `report` mediumtext,
  `date` varchar(10) DEFAULT NULL,
  `read_report` int(2) DEFAULT NULL,
  `hide_report` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `reset_pass`
--

CREATE TABLE `reset_pass` (
  `id` int(11) NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `reset_code` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `reset_pass`
--

INSERT INTO `reset_pass` (`id`, `email`, `reset_code`) VALUES
(1, 'issamanthem@gmail.com', '0fe7eb8a29b2dd07f3bc67509c16101b'),
(2, 'issamanthem@gmail.com', '62568b2fc56950cf1cd52d016cafcd06');

-- --------------------------------------------------------

--
-- Structure de la table `students_marks`
--

CREATE TABLE `students_marks` (
  `id` int(11) NOT NULL,
  `student_id` varchar(50) DEFAULT NULL,
  `date` varchar(10) DEFAULT NULL,
  `subject` varchar(50) DEFAULT NULL,
  `teacher_name` varchar(50) DEFAULT NULL,
  `mark` varchar(50) DEFAULT NULL,
  `note` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `students_marks`
--

INSERT INTO `students_marks` (`id`, `student_id`, `date`, `subject`, `teacher_name`, `mark`, `note`) VALUES
(1, '22054683', '01/11/2019', 'Programmation Java', 'Mickaël Foursov', '17', 'tres bien'),
(2, '22054683', '01/11/2019', 'Programmation Web', 'Mickaël Foursov', '18', 'bien');

-- --------------------------------------------------------

--
-- Structure de la table `students_users`
--

CREATE TABLE `students_users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(250) DEFAULT NULL,
  `registration_num` int(10) DEFAULT NULL,
  `parent_index` varchar(50) DEFAULT NULL,
  `image` varchar(250) DEFAULT NULL,
  `student_index` varchar(50) DEFAULT NULL,
  `username` varchar(250) DEFAULT NULL,
  `password` varchar(250) DEFAULT NULL,
  `email` varchar(250) DEFAULT NULL,
  `phone` varchar(200) DEFAULT NULL,
  `sex` varchar(20) DEFAULT NULL,
  `address` varchar(250) DEFAULT NULL,
  `birthday` varchar(10) DEFAULT NULL,
  `student_class` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `students_users`
--

INSERT INTO `students_users` (`id`, `full_name`, `registration_num`, `parent_index`, `image`, `student_index`, `username`, `password`, `email`, `phone`, `sex`, `address`, `birthday`, `student_class`) VALUES
(2, 'issam elmoutii', 11222, '54297680', 'BB11.jpg', '22054683', 'issam', 'b59c67bf196a4758191e42f76670ceba', 'omario5@hotmail.fr', '097655767888', 'male', 'AGADIR', '1997/03/25', 'L3 MIAGE'),
(3, 'etudiant X', 12344456, '41835816', '', '43453432', 'nidal', 'b59c67bf196a4758191e42f76670ceba', 'boutbagha@gmail.com', '048484848', 'Femelle', 'tiznit', '1992/03/25', 'L3 MIAGE');

-- --------------------------------------------------------

--
-- Structure de la table `subjects`
--

CREATE TABLE `subjects` (
  `id` int(11) NOT NULL,
  `subject_name` varchar(50) DEFAULT NULL,
  `subject_teacher` varchar(50) DEFAULT NULL,
  `subject_class` varchar(50) DEFAULT NULL,
  `subject_note` mediumtext
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `subjects`
--

INSERT INTO `subjects` (`id`, `subject_name`, `subject_teacher`, `subject_class`, `subject_note`) VALUES
(1, 'Systeme informatique', 'ff', 'L3 MIAGE', '30 heures'),
(2, 'Programmation Java', 'Mickaël Foursov', 'L3 MIAGE', '30 heures'),
(3, 'Programmation événementielle ', 'Mickaël Foursov', 'L3 MIAGE', '120  heures'),
(4, 'Programmation Web', 'virginie sans', 'L3 MIAGE', '120  heures'),
(5, 'Gestion financiere', 'Mathieu Le Barz', 'L3 MIAGE', '120  heures'),
(6, 'Algorithmes des graphes', 'Rumen Andonov', 'L3 MIAGE', '30 heures');

-- --------------------------------------------------------

--
-- Structure de la table `teachers_users`
--

CREATE TABLE `teachers_users` (
  `id` int(11) NOT NULL,
  `full_name` varchar(50) DEFAULT NULL,
  `teacher_index` varchar(50) DEFAULT NULL,
  `subject` varchar(50) DEFAULT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(50) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `sex` varchar(10) DEFAULT NULL,
  `address` varchar(50) DEFAULT NULL,
  `image` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `teachers_users`
--

INSERT INTO `teachers_users` (`id`, `full_name`, `teacher_index`, `subject`, `username`, `password`, `email`, `phone`, `sex`, `address`, `image`) VALUES
(1, 'Mickaël Foursov', '54749191', '', 'foursov', 'b59c67bf196a4758191e42f76670ceba', 'Mickaël.Foursov@gmail.com', '061111111', 'Homme', 'rennes', 'AA11.jpg');

-- --------------------------------------------------------

--
-- Structure de la table `topics`
--

CREATE TABLE `topics` (
  `id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `topic` text,
  `image` varchar(150) DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `topics`
--

INSERT INTO `topics` (`id`, `title`, `topic`, `image`, `date`) VALUES
(1, 'inscription hackatown', 'L\'inscription au hackatown sont ouvertes merci de contacter l\'administration&lt;br&gt;', '1491477059.png', '06-11-2019');

-- --------------------------------------------------------

--
-- Structure de la table `topics_formateurs`
--

CREATE TABLE `topics_formateurs` (
  `id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `topic` text,
  `image` varchar(150) DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `topics_formateurs`
--

INSERT INTO `topics_formateurs` (`id`, `title`, `topic`, `image`, `date`) VALUES
(2, 'Réunion', 'Bonjour , chères formateurs&amp;nbsp; demain&amp;nbsp; matin réunion dans la salle B ', '1496190597.PNG', '31-11-2019');

-- --------------------------------------------------------

--
-- Structure de la table `topics_visitors`
--

CREATE TABLE `topics_visitors` (
  `id` int(11) NOT NULL,
  `title` varchar(250) DEFAULT NULL,
  `topic` text,
  `image` varchar(150) DEFAULT NULL,
  `date` varchar(20) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `topics_visitors`
--

INSERT INTO `topics_visitors` (`id`, `title`, `topic`, `image`, `date`) VALUES
(2, 'Inscription 2020_2019', 'Venez vous Inscrire dans notre école les inscription sont ouverts', '1495816491.jpg', '26-05-2019'),
(3, 'portes ouvertes 2020', 'Les portes ouvertes 2019 vous presente ecoleX ....', '1495820012.jpg', '26-05-2019');

-- --------------------------------------------------------

--
-- Structure de la table `transport`
--

CREATE TABLE `transport` (
  `id` int(11) NOT NULL,
  `day` varchar(20) DEFAULT NULL,
  `time_start_e` varchar(30) DEFAULT NULL,
  `time_return_e` varchar(30) DEFAULT NULL,
  `class_name` varchar(50) DEFAULT NULL,
  `time_start_m` varchar(20) DEFAULT NULL,
  `time_return_m` varchar(30) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `users_messages`
--

CREATE TABLE `users_messages` (
  `id` int(11) NOT NULL,
  `author_index` varchar(30) DEFAULT NULL,
  `author_name` varchar(50) DEFAULT NULL,
  `to_index` varchar(30) DEFAULT NULL,
  `type` varchar(30) DEFAULT NULL,
  `subject` varchar(250) DEFAULT NULL,
  `message` mediumtext,
  `date` varchar(10) DEFAULT NULL,
  `msg_read` int(2) DEFAULT NULL,
  `hide_msg` int(2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Déchargement des données de la table `users_messages`
--

INSERT INTO `users_messages` (`id`, `author_index`, `author_name`, `to_index`, `type`, `subject`, `message`, `date`, `msg_read`, `hide_msg`) VALUES
(1, '54297680', 'AMKRAZ', '46150738488', 'parent', 'hhh', 'hhggh', '20/05/2019', 1, 0),
(2, '22054683', 'issam elmoutii', '54749191', 'student', 'Bonjour', 'est ce que on a un CC demain de gestion du projet ?', '26/05/2019', 1, 0),
(3, '54749191', 'Mickaël Foursov', '22054683', 'teacher', 'Bonjour', 'oui demain aprés midi ', '26/05/2019', 1, 0);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `absences`
--
ALTER TABLE `absences`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `administrator`
--
ALTER TABLE `administrator`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `classes`
--
ALTER TABLE `classes`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments`
--
ALTER TABLE `comments`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments_formateurs`
--
ALTER TABLE `comments_formateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `comments_lessons`
--
ALTER TABLE `comments_lessons`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `control`
--
ALTER TABLE `control`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `exam`
--
ALTER TABLE `exam`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `index_users`
--
ALTER TABLE `index_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `lessons`
--
ALTER TABLE `lessons`
  ADD PRIMARY KEY (`lesson_id`);

--
-- Index pour la table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `parents_users`
--
ALTER TABLE `parents_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `reports`
--
ALTER TABLE `reports`
  ADD PRIMARY KEY (`report_id`);

--
-- Index pour la table `reset_pass`
--
ALTER TABLE `reset_pass`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `students_marks`
--
ALTER TABLE `students_marks`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `students_users`
--
ALTER TABLE `students_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `subjects`
--
ALTER TABLE `subjects`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `teachers_users`
--
ALTER TABLE `teachers_users`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `topics`
--
ALTER TABLE `topics`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `topics_formateurs`
--
ALTER TABLE `topics_formateurs`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `topics_visitors`
--
ALTER TABLE `topics_visitors`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `transport`
--
ALTER TABLE `transport`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `users_messages`
--
ALTER TABLE `users_messages`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `absences`
--
ALTER TABLE `absences`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `administrator`
--
ALTER TABLE `administrator`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `classes`
--
ALTER TABLE `classes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `comments`
--
ALTER TABLE `comments`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;
--
-- AUTO_INCREMENT pour la table `comments_lessons`
--
ALTER TABLE `comments_lessons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `control`
--
ALTER TABLE `control`
  MODIFY `id` int(1) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `exam`
--
ALTER TABLE `exam`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `index_users`
--
ALTER TABLE `index_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;
--
-- AUTO_INCREMENT pour la table `lessons`
--
ALTER TABLE `lessons`
  MODIFY `lesson_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT pour la table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `parents_users`
--
ALTER TABLE `parents_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `reports`
--
ALTER TABLE `reports`
  MODIFY `report_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `reset_pass`
--
ALTER TABLE `reset_pass`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `students_marks`
--
ALTER TABLE `students_marks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `students_users`
--
ALTER TABLE `students_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `subjects`
--
ALTER TABLE `subjects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;
--
-- AUTO_INCREMENT pour la table `teachers_users`
--
ALTER TABLE `teachers_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `topics`
--
ALTER TABLE `topics`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT pour la table `topics_formateurs`
--
ALTER TABLE `topics_formateurs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT pour la table `topics_visitors`
--
ALTER TABLE `topics_visitors`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- AUTO_INCREMENT pour la table `transport`
--
ALTER TABLE `transport`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `users_messages`
--
ALTER TABLE `users_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
