-- phpMyAdmin SQL Dump
-- version 4.7.8
-- https://www.phpmyadmin.net/
--
-- Hôte : 127.0.0.1
-- Généré le :  ven. 23 fév. 2018 à 07:34
-- Version du serveur :  5.7.14
-- Version de PHP :  7.2.1

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

--
-- Base de données :  `techzara`
--

-- --------------------------------------------------------

--
-- Structure de la table `tz_cms`
--

CREATE TABLE `tz_cms` (
  `id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `tz_cms`
--

INSERT INTO `tz_cms` (`id`) VALUES
(1),
(2);

-- --------------------------------------------------------

--
-- Structure de la table `tz_cms_translation`
--

CREATE TABLE `tz_cms_translation` (
  `id` int(11) NOT NULL,
  `translatable_id` int(11) DEFAULT NULL,
  `cmst_title` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `cmst_content` longtext COLLATE utf8_unicode_ci NOT NULL,
  `cmst_slug` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `locale` varchar(255) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `tz_cms_translation`
--

INSERT INTO `tz_cms_translation` (`id`, `translatable_id`, `cmst_title`, `cmst_content`, `cmst_slug`, `locale`) VALUES
(1, 2, 'Legal Notice', '<p>Legal Notice<br></p>', 'legal-notice', 'en'),
(2, 2, 'Mentions légales', '<p>Mentions légales<br></p>', 'mentions-legales', 'fr'),
(3, 1, 'Terms', 'Terms<p><br></p>', 'terms', 'en'),
(4, 1, 'CGV', '<p>CGV<br></p>', 'cgv', 'fr');

-- --------------------------------------------------------

--
-- Structure de la table `tz_role`
--

CREATE TABLE `tz_role` (
  `id` int(11) NOT NULL,
  `rl_name` varchar(45) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `tz_role`
--

INSERT INTO `tz_role` (`id`, `rl_name`) VALUES
(1, 'Superadmin'),
(2, 'Admin'),
(3, 'Superviseur'),
(4, 'Integrateur');

-- --------------------------------------------------------

--
-- Structure de la table `tz_user`
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
  `usr_photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Déchargement des données de la table `tz_user`
--

INSERT INTO `tz_user` (`id`, `tz_role_id`, `username`, `username_canonical`, `email`, `email_canonical`, `enabled`, `salt`, `password`, `last_login`, `confirmation_token`, `password_requested_at`, `roles`, `usr_firstname`, `usr_lastname`, `usr_address`, `usr_date_create`, `usr_date_update`, `usr_phone`, `usr_photo`) VALUES
(1, 1, 'superadmin@techzara.fr', 'superadmin@techzara.fr', 'superadmin@techzara.fr', 'superadmin@techzara.fr', 1, NULL, '$2y$13$DR4K4DCat1Z3LTY27kSYIeQiaHyRObfXtUL5wDftU7dvwQJaKZIOa', '2018-02-22 12:04:03', NULL, NULL, 'a:1:{i:0;s:15:\"ROLE_SUPERADMIN\";}', 'Niaina', 'RAKOTONOMENJANAHARY', NULL, '2018-02-22 11:20:29', '2018-02-22 11:51:27', NULL, NULL);

--
-- Index pour les tables déchargées
--

--
-- Index pour la table `tz_cms`
--
ALTER TABLE `tz_cms`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tz_cms_translation`
--
ALTER TABLE `tz_cms_translation`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `UNIQ_E741596E86A085A0` (`cmst_slug`),
  ADD UNIQUE KEY `tz_cms_translation_unique_translation` (`translatable_id`,`locale`),
  ADD KEY `IDX_E741596E2C2AC5D3` (`translatable_id`);

--
-- Index pour la table `tz_role`
--
ALTER TABLE `tz_role`
  ADD PRIMARY KEY (`id`);

--
-- Index pour la table `tz_user`
--
ALTER TABLE `tz_user`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username_canonical_UNIQUE` (`username_canonical`),
  ADD UNIQUE KEY `email_canonical_UNIQUE` (`email_canonical`),
  ADD UNIQUE KEY `confirmation_token_UNIQUE` (`confirmation_token`),
  ADD KEY `IDX_1A95467C6C812A6F` (`tz_role_id`);

--
-- AUTO_INCREMENT pour les tables déchargées
--

--
-- AUTO_INCREMENT pour la table `tz_cms`
--
ALTER TABLE `tz_cms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT pour la table `tz_cms_translation`
--
ALTER TABLE `tz_cms_translation`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `tz_role`
--
ALTER TABLE `tz_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT pour la table `tz_user`
--
ALTER TABLE `tz_user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Contraintes pour les tables déchargées
--

--
-- Contraintes pour la table `tz_cms_translation`
--
ALTER TABLE `tz_cms_translation`
  ADD CONSTRAINT `FK_E741596E2C2AC5D3` FOREIGN KEY (`translatable_id`) REFERENCES `tz_cms` (`id`) ON DELETE CASCADE;

--
-- Contraintes pour la table `tz_user`
--
ALTER TABLE `tz_user`
  ADD CONSTRAINT `FK_1A95467C6C812A6F` FOREIGN KEY (`tz_role_id`) REFERENCES `tz_role` (`id`);
COMMIT;
