-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Nov 06, 2018 at 09:29 AM
-- Server version: 10.1.34-MariaDB
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `techzara`
--

-- --------------------------------------------------------

--
-- Table structure for table `migration_versions`
--

CREATE TABLE `migration_versions` (
  `version` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `migration_versions`
--

INSERT INTO `migration_versions` (`version`) VALUES
('20181014193900'),
('20181016102306'),
('20181016125506'),
('20181016141024'),
('20181016202505'),
('20181017083300'),
('20181017163622'),
('20181018134153'),
('20181019201909'),
('20181019201946'),
('20181021091027');

-- --------------------------------------------------------

--
-- Table structure for table `tz_activite`
--

CREATE TABLE `tz_activite` (
  `id` int(11) NOT NULL,
  `act_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `act_desc` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tz_activite`
--

INSERT INTO `tz_activite` (`id`, `act_title`, `act_desc`) VALUES
(4, 'za', 'zazaza'),
(5, 'a', 'aa');

-- --------------------------------------------------------

--
-- Table structure for table `tz_article`
--

CREATE TABLE `tz_article` (
  `id` int(11) NOT NULL,
  `art_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `art_author` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `art_photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `art_content` longtext COLLATE utf8_unicode_ci,
  `art_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tz_article`
--

INSERT INTO `tz_article` (`id`, `art_title`, `art_author`, `art_photo`, `art_content`, `art_date`) VALUES
(4, 'aatest', NULL, '/upload/article/83ced1cc8ac2edec55f28655eed85779.png', 'testeaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2018-10-18 17:08:46'),
(5, 'a', 'a', '/upload/article/99e0480ce0bc691577194e3a7f343ad2.jpeg', 'a', '2018-10-18 05:51:37'),
(6, 'a', 'a', NULL, 'aaaaaaaaaaaaaaaaaaaaaaaze', '2018-10-18 15:38:49'),
(7, 'a', 'a', '/upload/article/9c8783b2732d1153dba8df899ed107f6.png', 'a', '2018-10-18 17:08:32');

-- --------------------------------------------------------

--
-- Table structure for table `tz_email_newsletter`
--

CREATE TABLE `tz_email_newsletter` (
  `id` int(11) NOT NULL,
  `nws_email` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `nws_subscribed` tinyint(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tz_email_newsletter`
--

INSERT INTO `tz_email_newsletter` (`id`, `nws_email`, `nws_subscribed`) VALUES
(1, 'julien@juli.com', 1),
(2, 'julienrajerison5@gmail.com', 1),
(3, 'julien@juli.coma', 0);

-- --------------------------------------------------------

--
-- Table structure for table `tz_message_newsletter`
--

CREATE TABLE `tz_message_newsletter` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tz_message_newsletter`
--

INSERT INTO `tz_message_newsletter` (`id`) VALUES
(1),
(2);

-- --------------------------------------------------------

--
-- Table structure for table `tz_message_newsletter_translation`
--

CREATE TABLE `tz_message_newsletter_translation` (
  `id` int(11) NOT NULL,
  `translatable_id` int(11) DEFAULT NULL,
  `message_newsletter_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `message_newsletter_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tz_message_newsletter_translation`
--

INSERT INTO `tz_message_newsletter_translation` (`id`, `translatable_id`, `message_newsletter_title`, `message_newsletter_content`, `locale`) VALUES
(1, 1, 'teste', '<p>rsa</p>', 'fr'),
(2, 2, 'za', '<p>zaza</p>', 'fr');

-- --------------------------------------------------------

--
-- Table structure for table `tz_programme`
--

CREATE TABLE `tz_programme` (
  `id` int(11) NOT NULL,
  `tz_programme_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tz_programme_desc` longtext COLLATE utf8_unicode_ci,
  `tz_programme_photo` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tz_programme_intervenants` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tz_programme_date_debut` datetime DEFAULT NULL,
  `tz_programme_date_fin` datetime DEFAULT NULL,
  `tz_programme_lieu` varchar(150) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tz_programme`
--

INSERT INTO `tz_programme` (`id`, `tz_programme_title`, `tz_programme_desc`, `tz_programme_photo`, `tz_programme_intervenants`, `tz_programme_date_debut`, `tz_programme_date_fin`, `tz_programme_lieu`) VALUES
(3, 'teste', 'testezz', NULL, 'etstet', '2018-10-21 00:00:00', '2018-10-21 00:00:00', 'aaaa'),
(4, 'Programme demain', 'Demain is a programme entre Techzara est blablabla and we wna to tech how to practice in these ligne to have a fun andd pr', '/upload/programme/5284e66b1b82c8c942878d042b1d5e08.jpeg', 'RAKOTO', '2018-10-21 00:00:00', '2018-09-21 00:00:00', 'aaaa'),
(5, 'a', 'a', NULL, '²a', '2018-10-21 00:00:00', '2018-10-21 00:00:00', 'aa'),
(6, 'ab', 'bab', NULL, 'ab', '2018-10-21 00:00:00', '2018-10-21 00:00:00', 'a'),
(7, 'Programme', 'Programme', NULL, 'Programme', '2018-10-21 00:00:00', '2018-10-21 00:00:00', 'Teste'),
(8, 'teste', 'Teste', '/upload/programme/d4b7d45238e6a035e5c89ff887fc10c2.png', 'teste', '2018-10-21 00:00:00', '2018-10-21 00:00:00', 'Teste'),
(9, 'test', 'te', NULL, 'test', '2018-10-21 00:00:00', '2018-10-21 00:00:00', 'aaa');

-- --------------------------------------------------------

--
-- Table structure for table `tz_role`
--

CREATE TABLE `tz_role` (
  `id` int(11) NOT NULL,
  `rl_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tz_role`
--

INSERT INTO `tz_role` (`id`, `rl_name`) VALUES
(1, 'Superadmin'),
(2, 'Admin'),
(3, 'Partenaires'),
(4, 'Membres');

-- --------------------------------------------------------

--
-- Table structure for table `tz_user`
--

CREATE TABLE `tz_user` (
  `id` int(11) NOT NULL,
  `tz_role_id` int(11) DEFAULT NULL,
  `username` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `username_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `email_canonical` varchar(180) COLLATE utf8_unicode_ci NOT NULL,
  `enabled` tinyint(1) NOT NULL,
  `salt` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `last_login` datetime DEFAULT NULL,
  `confirmation_token` varchar(180) COLLATE utf8_unicode_ci DEFAULT NULL,
  `password_requested_at` datetime DEFAULT NULL,
  `roles` longtext COLLATE utf8_unicode_ci NOT NULL COMMENT '(DC2Type:array)',
  `usr_firstname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_lastname` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_date_create` datetime DEFAULT NULL,
  `usr_date_update` datetime DEFAULT NULL,
  `usr_phone` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_is_valid` tinyint(1) NOT NULL,
  `usr_nom_entreprise` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_tache` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `usr_social` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `admin_testimonial` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data for table `tz_user`
--

INSERT INTO `tz_user` (`id`, `tz_role_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `usr_firstname`, `usr_lastname`, `usr_address`, `usr_date_create`, `usr_date_update`, `usr_phone`, `usr_photo`, `usr_is_valid`, `usr_nom_entreprise`, `usr_tache`, `usr_social`, `admin_testimonial`) VALUES
(1, 2, 'superadmin@techzara.fr', 'superadmin@techzara.fr', 'julienrajerison5@gmail.com', 'julienrajerison5@gmail.com', 1, NULL, '$2y$13$43pnoJ2ysuDWAl778OpIKegI49OpY/3Lya97.0iJsHMFIDjvy3FVG', '2018-10-21 13:33:07', NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'Julien', 'RAJERISON', 'Androndra', '2018-10-14 21:48:37', '2018-10-18 17:57:46', '+261329473033', '/upload/user/301fe6f8d9df9a89d921e5074284fb7c.jpeg', 0, 'Techzara', NULL, NULL, NULL),
(2, 2, 'membre@membre', 'membre@membre', 'teste@teste.cmo', 'teste@teste.cmo', 1, NULL, '$2y$13$GrVbOkjQMKeuUXr9fY1nCOjf56S0u.HPbN9In2Bv6dcTUJwRwTJcC', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'teste', 'teste', 'teste', '2018-10-14 23:55:42', NULL, 'teste', NULL, 0, 'Teste', NULL, NULL, NULL),
(3, 2, 'superadmin@techzara.fra', 'superadmin@techzara.fra', 'julienrajerison5@jul.comaaa', 'julienrajerison5@jul.comaaa', 1, NULL, '$2y$13$4ZOZKmbMDEZvQG5OqVHX7./2mLNnHLUrl.wCoo0Ptbq0sU2AJ/0jW', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'a', 'a', 'aa', '2018-10-14 23:58:46', NULL, '+261329473033', NULL, 0, 'a', NULL, NULL, NULL),
(4, 2, 'superadmin@techzara.fraa', 'superadmin@techzara.fraa', 'ra@ra.ra', 'ra@ra.ra', 1, NULL, '$2y$13$40rvSJRugtZAqnBtfxYze.4B25QR4saSPgXynEmpnx9dtf9fya5V6', '2018-10-16 14:58:40', NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'ra', 'ra', 'ra', '2018-10-15 00:00:43', NULL, '+261329473033', '/upload/user/768a3aa5eaba78fbe3f1585313b5d955.jpeg', 0, 'za', NULL, NULL, NULL),
(5, 2, 'superadmin@techzara.fraaAA', 'superadmin@techzara.fraaaa', 'ZA@ZA.ZA', 'za@za.za', 1, NULL, '$2y$13$mdABEvbtc7wqZ1QjiWkgPON70gbrVIhcOSztJjPMndCMpowGcX3ze', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'ZA', 'ZA', 'ZA', '2018-10-15 06:00:22', NULL, '+261329473033', NULL, 0, 'ZA', NULL, NULL, NULL),
(6, 2, 'jul', 'jul', 'julienrajerison5@jul.com', 'julienrajerison5@jul.com', 1, NULL, '$2y$13$Ng5TXjhZFQo1BiQ69LZ26OssXuxep4IGSt1R4puUYgqIgedE92T86', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'Julien', 'RAJERISON', 'Androndra', '2018-10-16 12:26:50', NULL, '+261329473033', NULL, 0, 'Techzara', NULL, 'https://www.facebook.com/', NULL),
(7, 2, 'a', 'a', 'Androndraa@aaa.com', 'androndraa@aaa.com', 1, NULL, '$2y$13$0syiwQDJWi8WE7Un848Zje9zxkQ50NPoa3Gj/ERrBKE4k6Qfg/goK', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'a', 'a', 'a', '2018-10-16 12:34:48', NULL, '+261329473033', NULL, 0, 'a', NULL, 'https://www.facebook.com/', NULL),
(8, 2, 'aa', 'aa', 'julienrajerisona5@gmail.com', 'julienrajerisona5@gmail.com', 1, NULL, '$2y$13$pcRLbu4GHKq81l1djqB1kOPX6k3aOFUbubXdDKGj8dxa15pkvsQ3W', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'Vatosoa', 'RAJERISON', 'Itaosy', '2018-10-16 12:35:26', NULL, '+261329473033', NULL, 0, 'Techzara', NULL, 'https://www.facebook.com/julkwel', NULL),
(9, 2, 'superadmin@techzara.fraaaaaaaaaaa', 'superadmin@techzara.fraaaaaaaaaaa', 'vatosoa@gmail.coma', 'vatosoa@gmail.coma', 1, NULL, '$2y$13$bQDiMu6J.VufQPOn3D8/K.dACu/C.R/sWERcX.Wg0ZIOO4oQa5BBm', NULL, NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'a', 'RINAMIHANTA', 'teste', '2018-10-16 15:39:52', NULL, '+261329473033', NULL, 0, 'Techzara', 'az', 'https://www.facebook.com/toky.belooh?fref=ufi', 'az'),
(10, 2, 'teste@teste.te', 'teste@teste.te', 'teste@teste.teste', 'teste@teste.teste', 1, NULL, '$2y$13$dp97Jf/aaNk/HJ8kmzENde9S/a7ckK3Jki8bRNFXGeHIzZNfLCqvm', NULL, NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'teste', 'teste', 'teste', '2018-10-16 15:48:11', NULL, '+261329473033', NULL, 0, 'teste', NULL, 'https://www.facebook.com', NULL),
(11, 2, 'zeze', 'zeze', 'Androndraa@aaa.coma', 'androndraa@aaa.coma', 1, NULL, '$2y$13$.12IRN023TU5jA6PxpPYW.5UVyURQmXRvjPqbilQ3Obv1Owbg/Z4m', NULL, NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'a', 'a', 'a', '2018-10-16 21:08:58', '2018-10-17 10:29:51', '+261329473033', NULL, 0, 'aaaaaa', 'a', 'https://www.facebook.com/', 'az');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `migration_versions`
--
ALTER TABLE `migration_versions`
  ADD PRIMARY KEY (`version`);

--
-- Indexes for table `tz_activite`
--
ALTER TABLE `tz_activite`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_article`
--
ALTER TABLE `tz_article`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_email_newsletter`
--
ALTER TABLE `tz_email_newsletter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_225BC762D5D52DEC` (`nws_email`);

--
-- Indexes for table `tz_message_newsletter`
--
ALTER TABLE `tz_message_newsletter`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_message_newsletter_translation`
--
ALTER TABLE `tz_message_newsletter_translation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tz_message_newsletter_translation_unique_translation` (`translatable_id`,`locale`),
  ADD KEY `IDX_DEC446972C2AC5D3` (`translatable_id`);

--
-- Indexes for table `tz_programme`
--
ALTER TABLE `tz_programme`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_role`
--
ALTER TABLE `tz_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_user`
--
ALTER TABLE `tz_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_canonical_UNIQUE` (`username_canonical`),
  ADD UNIQUE KEY `email_canonical_UNIQUE` (`email_canonical`),
  ADD UNIQUE KEY `confirmation_token_UNIQUE` (`confirmation_token`),
  ADD KEY `IDX_396654AEBECC1867` (`tz_role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tz_activite`
--
ALTER TABLE `tz_activite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tz_article`
--
ALTER TABLE `tz_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `tz_email_newsletter`
--
ALTER TABLE `tz_email_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tz_message_newsletter`
--
ALTER TABLE `tz_message_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tz_message_newsletter_translation`
--
ALTER TABLE `tz_message_newsletter_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tz_programme`
--
ALTER TABLE `tz_programme`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `tz_role`
--
ALTER TABLE `tz_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tz_user`
--
ALTER TABLE `tz_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tz_message_newsletter_translation`
--
ALTER TABLE `tz_message_newsletter_translation`
  ADD CONSTRAINT `FK_DEC446972C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `tz_message_newsletter` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tz_user`
--
ALTER TABLE `tz_user`
  ADD CONSTRAINT `FK_396654AEBECC1867` FOREIGN KEY (`tz_role_id`) REFERENCES `tz_role` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
