--
-- Contenu de la table `tz_service_type`
--

INSERT INTO `tz_service_type` (`id`, `srv_tp_label`) VALUES
(1, 'Découpe'),
(2, 'Intégration');

--
-- Contenu de la table `tz_service`
--

INSERT INTO `tz_service` (`id`, `tz_srv_tp_id`, `srv_label`, `srv_desc`, `srv_prix`, `srv_reduction`) VALUES
(1, 1, 'PSD	vers Découpe HTML/CSS', NULL, 49, 50),
(2, 1, 'PSD	vers Découpe HTML5/CSS3', NULL, 85, 50),
(3, 2, 'PSD	vers intégration Wordpress', NULL, 149, 50),
(4, 2, 'PSD	vers intégration Prestashop', NULL, 299, 50);

--
-- Contenu de la table `tz_service_option_type`
--

INSERT INTO `tz_service_option_type` (`id`, `srv_opt_tp_label`) VALUES
(1, 'Options de mise en forme'),
(2, 'Options HTML'),
(3, 'Options Javascript');

--
-- Contenu de la table `tz_service_option_valeur_type`
--

INSERT INTO `tz_service_option_valeur_type` (`id`, `srv_opt_val_tp_is_percent`, `srv_opt_val_tp_is_reduction`, `srv_opt_val_tp_is_gratuit`, `srv_opt_val_tp_val`) VALUES
(1, 1, 0, 0, 2),
(2, 0, 0, 1, 0),
(3, 0, 0, 0, 1),
(4, 0, 0, 1, 0),
(5, 0, 0, 0, 1),
(6, 0, 0, 0, 1),
(7, 0, 0, 0, 1),
(8, 0, 0, 0, 1),
(9, 0, 0, 0, 1),
(10, 0, 0, 0, 1),
(11, 0, 0, 0, 1),
(12, 0, 0, 0, 1),
(13, 0, 0, 0, 1),
(14, 0, 0, 0, 1),
(15, 0, 0, 0, 1),
(16, 0, 0, 1, 0),
(17, 0, 0, 1, 0),
(18, 0, 0, 0, 0);

--
-- Contenu de la table `tz_service_option`
--

INSERT INTO `tz_service_option` (`id`, `srv_opt_label`, `srv_opt_desc`, `srv_opt_type`, `srv_opt_valeur`, `tz_srv_opt_tp_id`, `tz_srv_opt_val_tp_id`) VALUES
(1, 'Intégration responsive', NULL, NULL, 20, 1, 1),
(2, 'Mise en place du CSS3', NULL, NULL, NULL, 1, 2),
(3, 'Mise en place de sous-menus', NULL, NULL, 39, 2, 3),
(4, 'Code commenté', NULL, NULL, NULL, 2, 4),
(5, 'Popup / Lightbox', NULL, NULL, 39, 3, 5),
(6, 'Slider / Diaporama', NULL, NULL, 39, 3, 6),
(7, 'Filtres de tri', NULL, NULL, 39, 3, 7),
(8, 'Polices non Web', NULL, NULL, 20, 1, 8),
(9, 'Compatibilité IE6', NULL, NULL, 49, 2, 9),
(11, 'Éléments de formulaires spéciaux', NULL, NULL, 39, 2, 11),
(12, 'Onglets / Tabs', NULL, NULL, 39, 2, 12),
(13, 'Accordéon', NULL, NULL, 39, 2, 13),
(14, 'Tooltip', NULL, NULL, 39, 3, 14),
(15, 'Calendrier', NULL, NULL, 39, 3, 15),
(16, 'Temps de chargement optimisé', NULL, NULL, NULL, 1, 16),
(17, 'Optimisé pour le SEO', NULL, NULL, NULL, 1, 17),
(18, 'Mise en place du code HMTL', NULL, NULL, NULL, 2, 18);
