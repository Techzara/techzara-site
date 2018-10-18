-- phpMyAdmin SQL Dump
-- version 4.8.2
-- https://www.phpmyadmin.net/
--
-- Host: localhost
-- Generation Time: Oct 18, 2018 at 08:12 AM
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
-- Database: `dev`
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
('20181017163622');

-- --------------------------------------------------------

--
-- Table structure for table `tz_activite`
--

CREATE TABLE `tz_activite` (
  `id` int(11) NOT NULL,
  `act_title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `act_desc` longtext COLLATE utf8_unicode_ci
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(4, 'aateste', NULL, '/upload/article/35d501b18cabf42e810fc8e785a7d898.jpeg', 'testeaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa', '2018-10-17 22:17:28'),
(5, 'a', 'a', '/upload/article/99e0480ce0bc691577194e3a7f343ad2.jpeg', 'a', '2018-10-18 05:51:37');

-- --------------------------------------------------------

--
-- Table structure for table `tz_client`
--

CREATE TABLE `tz_client` (
  `id` int(11) NOT NULL,
  `clt_name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_firstname` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_address` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_tel` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_mdp` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_is_valid` tinyint(1) NOT NULL,
  `clt_nom_entreprise` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `clt_last_connected` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(2, 'julienrajerison5@gmail.com', 1);

-- --------------------------------------------------------

--
-- Table structure for table `tz_faq`
--

CREATE TABLE `tz_faq` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_faq_translation`
--

CREATE TABLE `tz_faq_translation` (
  `id` int(11) NOT NULL,
  `translatable_id` int(11) DEFAULT NULL,
  `faqt_question` longtext COLLATE utf8_unicode_ci NOT NULL,
  `faqt_response` longtext COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1);

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
(1, 1, 'teste', '<p>rsa</p>', 'fr');

-- --------------------------------------------------------

--
-- Table structure for table `tz_news`
--

CREATE TABLE `tz_news` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_news_translation`
--

CREATE TABLE `tz_news_translation` (
  `id` int(11) NOT NULL,
  `translatable_id` int(11) DEFAULT NULL,
  `cmst_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cmst_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cmst_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_portfolio`
--

CREATE TABLE `tz_portfolio` (
  `id` int(11) NOT NULL,
  `pf_tp_id` int(11) DEFAULT NULL,
  `pf_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_description` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `pf_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_portfolio_type`
--

CREATE TABLE `tz_portfolio_type` (
  `id` int(11) NOT NULL,
  `pf_tp_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Table structure for table `tz_service`
--

CREATE TABLE `tz_service` (
  `id` int(11) NOT NULL,
  `tz_srv_tp_id` int(11) DEFAULT NULL,
  `srv_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `srv_desc` longtext COLLATE utf8_unicode_ci,
  `srv_prix` double DEFAULT NULL,
  `srv_reduction` double DEFAULT NULL,
  `srv_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_service_client`
--

CREATE TABLE `tz_service_client` (
  `id` int(11) NOT NULL,
  `tz_srv_id` int(11) DEFAULT NULL,
  `tz_clt_id` int(11) DEFAULT NULL,
  `tz_usr_id` int(11) DEFAULT NULL,
  `srv_clt_is_payed` tinyint(1) DEFAULT NULL,
  `srv_clt_payment_type` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `srv_clt_payment_is_facture` tinyint(1) DEFAULT NULL,
  `srv_clt_project_link` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `srv_clt_date` datetime DEFAULT NULL,
  `srv_clt_date_livraison_prev` datetime DEFAULT NULL,
  `srv_clt_date_livraison` datetime DEFAULT NULL,
  `srv_clt_desc` longtext COLLATE utf8_unicode_ci,
  `srv_clt_lien_code_source` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `srv_clt_lien_livre` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `srv_clt_nbr_page` int(11) DEFAULT NULL,
  `srv_clt_nbr_page_decline` int(11) DEFAULT NULL,
  `srv_clt_prix` double DEFAULT NULL,
  `srv_clt_status_validation` smallint(6) DEFAULT '0',
  `srv_clt_status_project` smallint(6) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_service_client_jointe`
--

CREATE TABLE `tz_service_client_jointe` (
  `id` int(11) NOT NULL,
  `tz_srv_clt_id` int(11) DEFAULT NULL,
  `srv_clt_jt_ext` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `srv_clt_jt_path` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_service_client_service_option`
--

CREATE TABLE `tz_service_client_service_option` (
  `tz_srv_clt_id` int(11) NOT NULL,
  `tz_srv_opt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_service_option`
--

CREATE TABLE `tz_service_option` (
  `id` int(11) NOT NULL,
  `tz_srv_opt_tp_id` int(11) DEFAULT NULL,
  `tz_srv_opt_val_tp_id` int(11) DEFAULT NULL,
  `srv_opt_label` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `srv_opt_desc` longtext COLLATE utf8_unicode_ci,
  `srv_opt_type` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL,
  `srv_opt_valeur` double DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_service_option_type`
--

CREATE TABLE `tz_service_option_type` (
  `id` int(11) NOT NULL,
  `srv_opt_tp_label` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_service_option_valeur_type`
--

CREATE TABLE `tz_service_option_valeur_type` (
  `id` int(11) NOT NULL,
  `srv_opt_val_tp_is_percent` tinyint(1) DEFAULT NULL,
  `srv_opt_val_tp_is_reduction` tinyint(1) DEFAULT NULL,
  `srv_opt_val_tp_is_gratuit` tinyint(1) DEFAULT NULL,
  `srv_opt_val_tp_val` smallint(6) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_service_service_option`
--

CREATE TABLE `tz_service_service_option` (
  `tz_srv_id` int(11) NOT NULL,
  `tz_srv_opt_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_service_type`
--

CREATE TABLE `tz_service_type` (
  `id` int(11) NOT NULL,
  `srv_tp_label` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_slide`
--

CREATE TABLE `tz_slide` (
  `id` int(11) NOT NULL,
  `sld_first_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sld_second_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sld_third_title` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `sld_image_url` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_temoignage`
--

CREATE TABLE `tz_temoignage` (
  `id` int(11) NOT NULL,
  `tm_message` longtext COLLATE utf8_unicode_ci,
  `tm_nom_personne` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `tm_poste_personne` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
(1, 1, 'superadmin@techzara.fr', 'superadmin@techzara.fr', 'julienrajerison5@gmail.com', 'julienrajerison5@gmail.com', 1, NULL, '$2y$13$KWwhY6x5sf1OofX94pgiIemLbedw0bATvtLYqOmGSy4E2LuBA.ppG', '2018-10-17 19:21:43', NULL, NULL, 'a:1:{i:0;s:15:\"ROLE_SUPERADMIN\";}', 'Julien', 'RAJERISON', 'Androndra', '2018-10-14 21:48:37', '2018-10-14 23:48:59', '+261329473033', '/upload/user/7529853dc973c432f8619db069d2e86c.jpeg', 0, 'Techzara', NULL, NULL, NULL),
(2, 2, 'membre@membre', 'membre@membre', 'teste@teste.cmo', 'teste@teste.cmo', 1, NULL, '$2y$13$GrVbOkjQMKeuUXr9fY1nCOjf56S0u.HPbN9In2Bv6dcTUJwRwTJcC', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'teste', 'teste', 'teste', '2018-10-14 23:55:42', NULL, 'teste', NULL, 0, 'Teste', NULL, NULL, NULL),
(3, 2, 'superadmin@techzara.fra', 'superadmin@techzara.fra', 'julienrajerison5@jul.comaaa', 'julienrajerison5@jul.comaaa', 1, NULL, '$2y$13$4ZOZKmbMDEZvQG5OqVHX7./2mLNnHLUrl.wCoo0Ptbq0sU2AJ/0jW', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'a', 'a', 'aa', '2018-10-14 23:58:46', NULL, '+261329473033', NULL, 0, 'a', NULL, NULL, NULL),
(4, 2, 'superadmin@techzara.fraa', 'superadmin@techzara.fraa', 'ra@ra.ra', 'ra@ra.ra', 1, NULL, '$2y$13$40rvSJRugtZAqnBtfxYze.4B25QR4saSPgXynEmpnx9dtf9fya5V6', '2018-10-16 14:58:40', NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'ra', 'ra', 'ra', '2018-10-15 00:00:43', NULL, '+261329473033', '/upload/user/768a3aa5eaba78fbe3f1585313b5d955.jpeg', 0, 'za', NULL, NULL, NULL),
(5, 2, 'superadmin@techzara.fraaAA', 'superadmin@techzara.fraaaa', 'ZA@ZA.ZA', 'za@za.za', 1, NULL, '$2y$13$mdABEvbtc7wqZ1QjiWkgPON70gbrVIhcOSztJjPMndCMpowGcX3ze', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'ZA', 'ZA', 'ZA', '2018-10-15 06:00:22', NULL, '+261329473033', NULL, 0, 'ZA', NULL, NULL, NULL),
(6, 2, 'jul', 'jul', 'julienrajerison5@jul.com', 'julienrajerison5@jul.com', 1, NULL, '$2y$13$Ng5TXjhZFQo1BiQ69LZ26OssXuxep4IGSt1R4puUYgqIgedE92T86', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'Julien', 'RAJERISON', 'Androndra', '2018-10-16 12:26:50', NULL, '+261329473033', NULL, 0, 'Techzara', NULL, 'https://www.facebook.com/', NULL),
(7, 2, 'a', 'a', 'Androndraa@aaa.com', 'androndraa@aaa.com', 1, NULL, '$2y$13$0syiwQDJWi8WE7Un848Zje9zxkQ50NPoa3Gj/ERrBKE4k6Qfg/goK', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'a', 'a', 'a', '2018-10-16 12:34:48', NULL, '+261329473033', NULL, 0, 'a', NULL, 'https://www.facebook.com/', NULL),
(8, 2, 'aa', 'aa', 'julienrajerisona5@gmail.com', 'julienrajerisona5@gmail.com', 1, NULL, '$2y$13$pcRLbu4GHKq81l1djqB1kOPX6k3aOFUbubXdDKGj8dxa15pkvsQ3W', NULL, NULL, NULL, 'a:1:{i:0;s:12:\"ROLE_MEMBRES\";}', 'Vatosoa', 'RAJERISON', 'Itaosy', '2018-10-16 12:35:26', NULL, '+261329473033', NULL, 0, 'Techzara', NULL, 'https://www.facebook.com/julkwel', NULL),
(9, 2, 'superadmin@techzara.fraaaaaaaaaaa', 'superadmin@techzara.fraaaaaaaaaaa', 'vatosoa@gmail.coma', 'vatosoa@gmail.coma', 1, NULL, '$2y$13$bQDiMu6J.VufQPOn3D8/K.dACu/C.R/sWERcX.Wg0ZIOO4oQa5BBm', NULL, NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'a', 'RINAMIHANTA', 'teste', '2018-10-16 15:39:52', NULL, '+261329473033', NULL, 0, 'Techzara', 'az', 'https://www.facebook.com/toky.belooh?fref=ufi', 'az'),
(10, 2, 'teste@teste.te', 'teste@teste.te', 'teste@teste.teste', 'teste@teste.teste', 1, NULL, '$2y$13$dp97Jf/aaNk/HJ8kmzENde9S/a7ckK3Jki8bRNFXGeHIzZNfLCqvm', NULL, NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'teste', 'teste', 'teste', '2018-10-16 15:48:11', NULL, '+261329473033', NULL, 0, 'teste', NULL, 'https://www.facebook.com', NULL),
(11, 2, 'zeze', 'zeze', 'Androndraa@aaa.coma', 'androndraa@aaa.coma', 1, NULL, '$2y$13$.12IRN023TU5jA6PxpPYW.5UVyURQmXRvjPqbilQ3Obv1Owbg/Z4m', NULL, NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'a', 'a', 'a', '2018-10-16 21:08:58', '2018-10-17 10:29:51', '+261329473033', NULL, 0, 'aaaaaa', 'a', 'https://www.facebook.com/', 'az'),
(12, 2, 'aaaaaaa', 'aaaaaaa', 'Androndraa@aaa.comaaa', 'androndraa@aaa.comaaa', 1, NULL, '$2y$13$q559T8OJCnMFnu0bmcF9kOL8TihqF0UeRsLPI4mBURiBKF6pbAbYa', NULL, NULL, NULL, 'a:1:{i:0;s:10:\"ROLE_ADMIN\";}', 'a', 'a', 'a', '2018-10-17 10:30:20', NULL, 'a', NULL, 0, 'a', 'a', 'https://www.facebook.com/', 'a');

-- --------------------------------------------------------

--
-- Table structure for table `tz_user_service_client`
--

CREATE TABLE `tz_user_service_client` (
  `id` int(11) NOT NULL,
  `tz_usr_admin_id` int(11) DEFAULT NULL,
  `tz_srv_clt_id` int(11) DEFAULT NULL,
  `usr_srv_clt_date_debut` datetime DEFAULT NULL,
  `usr_srv_clt_date_attribution` datetime DEFAULT NULL,
  `usr_srv_clt_estimation` double DEFAULT NULL,
  `usr_srv_clt_date_finalisation` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_user_service_client_tester`
--

CREATE TABLE `tz_user_service_client_tester` (
  `tz_usr_srv_clt_id` int(11) NOT NULL,
  `tz_tst_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `tz_user_service_client_user`
--

CREATE TABLE `tz_user_service_client_user` (
  `tz_usr_srv_clt_id` int(11) NOT NULL,
  `tz_usr_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

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
-- Indexes for table `tz_client`
--
ALTER TABLE `tz_client`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_email_newsletter`
--
ALTER TABLE `tz_email_newsletter`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_225BC762D5D52DEC` (`nws_email`);

--
-- Indexes for table `tz_faq`
--
ALTER TABLE `tz_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_faq_translation`
--
ALTER TABLE `tz_faq_translation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `tz_faq_translation_unique_translation` (`translatable_id`,`locale`),
  ADD KEY `IDX_328559C62C2AC5D3` (`translatable_id`);

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
-- Indexes for table `tz_news`
--
ALTER TABLE `tz_news`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_news_translation`
--
ALTER TABLE `tz_news_translation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_6D31435586A085A0` (`cmst_slug`),
  ADD UNIQUE KEY `tz_news_translation_unique_translation` (`translatable_id`,`locale`),
  ADD KEY `IDX_6D3143552C2AC5D3` (`translatable_id`);

--
-- Indexes for table `tz_portfolio`
--
ALTER TABLE `tz_portfolio`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_47EFAF9A22A177B5` (`pf_tp_id`);

--
-- Indexes for table `tz_portfolio_type`
--
ALTER TABLE `tz_portfolio_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_role`
--
ALTER TABLE `tz_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_service`
--
ALTER TABLE `tz_service`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8952A019A35D6729` (`tz_srv_tp_id`);

--
-- Indexes for table `tz_service_client`
--
ALTER TABLE `tz_service_client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_7AF4E3F7ABBBDD3` (`tz_srv_id`),
  ADD KEY `IDX_7AF4E3FCB45E20` (`tz_clt_id`),
  ADD KEY `IDX_7AF4E3F1EE0E029` (`tz_usr_id`);

--
-- Indexes for table `tz_service_client_jointe`
--
ALTER TABLE `tz_service_client_jointe`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_8CC9735F83740837` (`tz_srv_clt_id`);

--
-- Indexes for table `tz_service_client_service_option`
--
ALTER TABLE `tz_service_client_service_option`
  ADD PRIMARY KEY (`tz_srv_clt_id`,`tz_srv_opt_id`),
  ADD KEY `IDX_EAC9CA6C83740837` (`tz_srv_clt_id`),
  ADD KEY `IDX_EAC9CA6C51A6B2CF` (`tz_srv_opt_id`);

--
-- Indexes for table `tz_service_option`
--
ALTER TABLE `tz_service_option`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_9A6D4ADA8D76555` (`tz_srv_opt_val_tp_id`),
  ADD KEY `IDX_9A6D4ADA52FF4D00` (`tz_srv_opt_tp_id`);

--
-- Indexes for table `tz_service_option_type`
--
ALTER TABLE `tz_service_option_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_service_option_valeur_type`
--
ALTER TABLE `tz_service_option_valeur_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_service_service_option`
--
ALTER TABLE `tz_service_service_option`
  ADD PRIMARY KEY (`tz_srv_id`,`tz_srv_opt_id`),
  ADD KEY `IDX_508790587ABBBDD3` (`tz_srv_id`),
  ADD KEY `IDX_5087905851A6B2CF` (`tz_srv_opt_id`);

--
-- Indexes for table `tz_service_type`
--
ALTER TABLE `tz_service_type`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_slide`
--
ALTER TABLE `tz_slide`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tz_temoignage`
--
ALTER TABLE `tz_temoignage`
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
-- Indexes for table `tz_user_service_client`
--
ALTER TABLE `tz_user_service_client`
  ADD PRIMARY KEY (`id`),
  ADD KEY `IDX_17FAC72CC82673DF` (`tz_usr_admin_id`),
  ADD KEY `IDX_17FAC72C83740837` (`tz_srv_clt_id`);

--
-- Indexes for table `tz_user_service_client_tester`
--
ALTER TABLE `tz_user_service_client_tester`
  ADD PRIMARY KEY (`tz_usr_srv_clt_id`,`tz_tst_id`),
  ADD KEY `IDX_CED9EBF8B624D5A0` (`tz_usr_srv_clt_id`),
  ADD KEY `IDX_CED9EBF8F0D76C50` (`tz_tst_id`);

--
-- Indexes for table `tz_user_service_client_user`
--
ALTER TABLE `tz_user_service_client_user`
  ADD PRIMARY KEY (`tz_usr_srv_clt_id`,`tz_usr_id`),
  ADD KEY `IDX_82CDC078B624D5A0` (`tz_usr_srv_clt_id`),
  ADD KEY `IDX_82CDC0781EE0E029` (`tz_usr_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `tz_activite`
--
ALTER TABLE `tz_activite`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `tz_article`
--
ALTER TABLE `tz_article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `tz_client`
--
ALTER TABLE `tz_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_email_newsletter`
--
ALTER TABLE `tz_email_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tz_faq`
--
ALTER TABLE `tz_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_faq_translation`
--
ALTER TABLE `tz_faq_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_message_newsletter`
--
ALTER TABLE `tz_message_newsletter`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tz_message_newsletter_translation`
--
ALTER TABLE `tz_message_newsletter_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `tz_news`
--
ALTER TABLE `tz_news`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_news_translation`
--
ALTER TABLE `tz_news_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_portfolio`
--
ALTER TABLE `tz_portfolio`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_portfolio_type`
--
ALTER TABLE `tz_portfolio_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_role`
--
ALTER TABLE `tz_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `tz_service`
--
ALTER TABLE `tz_service`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_service_client`
--
ALTER TABLE `tz_service_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_service_client_jointe`
--
ALTER TABLE `tz_service_client_jointe`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_service_option`
--
ALTER TABLE `tz_service_option`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_service_option_type`
--
ALTER TABLE `tz_service_option_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_service_option_valeur_type`
--
ALTER TABLE `tz_service_option_valeur_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_service_type`
--
ALTER TABLE `tz_service_type`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_slide`
--
ALTER TABLE `tz_slide`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_temoignage`
--
ALTER TABLE `tz_temoignage`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `tz_user`
--
ALTER TABLE `tz_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `tz_user_service_client`
--
ALTER TABLE `tz_user_service_client`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `tz_faq_translation`
--
ALTER TABLE `tz_faq_translation`
  ADD CONSTRAINT `FK_328559C62C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `tz_faq` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tz_message_newsletter_translation`
--
ALTER TABLE `tz_message_newsletter_translation`
  ADD CONSTRAINT `FK_DEC446972C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `tz_message_newsletter` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tz_news_translation`
--
ALTER TABLE `tz_news_translation`
  ADD CONSTRAINT `FK_6D3143552C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `tz_news` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tz_portfolio`
--
ALTER TABLE `tz_portfolio`
  ADD CONSTRAINT `FK_47EFAF9A22A177B5` FOREIGN KEY (`pf_tp_id`) REFERENCES `tz_portfolio_type` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tz_service`
--
ALTER TABLE `tz_service`
  ADD CONSTRAINT `FK_8952A019A35D6729` FOREIGN KEY (`tz_srv_tp_id`) REFERENCES `tz_service_type` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tz_service_client`
--
ALTER TABLE `tz_service_client`
  ADD CONSTRAINT `FK_7AF4E3F1EE0E029` FOREIGN KEY (`tz_usr_id`) REFERENCES `tz_user` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_7AF4E3F7ABBBDD3` FOREIGN KEY (`tz_srv_id`) REFERENCES `tz_service` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_7AF4E3FCB45E20` FOREIGN KEY (`tz_clt_id`) REFERENCES `tz_client` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tz_service_client_jointe`
--
ALTER TABLE `tz_service_client_jointe`
  ADD CONSTRAINT `FK_8CC9735F83740837` FOREIGN KEY (`tz_srv_clt_id`) REFERENCES `tz_service_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tz_service_client_service_option`
--
ALTER TABLE `tz_service_client_service_option`
  ADD CONSTRAINT `FK_EAC9CA6C51A6B2CF` FOREIGN KEY (`tz_srv_opt_id`) REFERENCES `tz_service_option` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_EAC9CA6C83740837` FOREIGN KEY (`tz_srv_clt_id`) REFERENCES `tz_service_client` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tz_service_option`
--
ALTER TABLE `tz_service_option`
  ADD CONSTRAINT `FK_9A6D4ADA52FF4D00` FOREIGN KEY (`tz_srv_opt_tp_id`) REFERENCES `tz_service_option_type` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_9A6D4ADA8D76555` FOREIGN KEY (`tz_srv_opt_val_tp_id`) REFERENCES `tz_service_option_valeur_type` (`id`);

--
-- Constraints for table `tz_service_service_option`
--
ALTER TABLE `tz_service_service_option`
  ADD CONSTRAINT `FK_5087905851A6B2CF` FOREIGN KEY (`tz_srv_opt_id`) REFERENCES `tz_service_option` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_508790587ABBBDD3` FOREIGN KEY (`tz_srv_id`) REFERENCES `tz_service` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tz_user`
--
ALTER TABLE `tz_user`
  ADD CONSTRAINT `FK_396654AEBECC1867` FOREIGN KEY (`tz_role_id`) REFERENCES `tz_role` (`id`);

--
-- Constraints for table `tz_user_service_client`
--
ALTER TABLE `tz_user_service_client`
  ADD CONSTRAINT `FK_17FAC72C83740837` FOREIGN KEY (`tz_srv_clt_id`) REFERENCES `tz_service_client` (`id`) ON DELETE SET NULL,
  ADD CONSTRAINT `FK_17FAC72CC82673DF` FOREIGN KEY (`tz_usr_admin_id`) REFERENCES `tz_user` (`id`) ON DELETE SET NULL;

--
-- Constraints for table `tz_user_service_client_tester`
--
ALTER TABLE `tz_user_service_client_tester`
  ADD CONSTRAINT `FK_CED9EBF8B624D5A0` FOREIGN KEY (`tz_usr_srv_clt_id`) REFERENCES `tz_user_service_client` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_CED9EBF8F0D76C50` FOREIGN KEY (`tz_tst_id`) REFERENCES `tz_user` (`id`) ON DELETE CASCADE;

--
-- Constraints for table `tz_user_service_client_user`
--
ALTER TABLE `tz_user_service_client_user`
  ADD CONSTRAINT `FK_82CDC0781EE0E029` FOREIGN KEY (`tz_usr_id`) REFERENCES `tz_user` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `FK_82CDC078B624D5A0` FOREIGN KEY (`tz_usr_srv_clt_id`) REFERENCES `tz_user_service_client` (`id`) ON DELETE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
