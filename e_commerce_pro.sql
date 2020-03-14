-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Client :  127.0.0.1
-- Généré le :  Dim 08 Mars 2020 à 16:47
-- Version du serveur :  5.7.14
-- Version de PHP :  5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Base de données :  `e_commerce_pro`
--

-- --------------------------------------------------------

--
-- Structure de la table `adresse_f`
--

CREATE TABLE `adresse_f` (
  `id_adresse_f` int(11) NOT NULL,
  `ville` text NOT NULL,
  `quartier` varchar(40) NOT NULL,
  `utilisatuer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `adresse_l`
--

CREATE TABLE `adresse_l` (
  `id_adresse_l` int(11) NOT NULL,
  `utilisatuer_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `categorie`
--

CREATE TABLE `categorie` (
  `id_Categorie` int(11) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `rayon_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `categorie`
--

INSERT INTO `categorie` (`id_Categorie`, `nom`, `rayon_id`) VALUES
(16, 'telecoms', 11),
(17, 'desin', 1),
(18, 'pain', 9);

-- --------------------------------------------------------

--
-- Structure de la table `client`
--

CREATE TABLE `client` (
  `id_client` int(11) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `prenom` varchar(30) NOT NULL,
  `email` varchar(60) NOT NULL,
  `tel` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `commande`
--

CREATE TABLE `commande` (
  `id_commande` int(11) NOT NULL,
  `date` int(11) NOT NULL,
  `montant` int(11) NOT NULL,
  `adresse_f_id` int(11) NOT NULL,
  `adresse_l_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `ligne_panier`
--

CREATE TABLE `ligne_panier` (
  `id_ligne_panier` int(11) NOT NULL,
  `produit_id` int(11) NOT NULL,
  `panier_id` int(11) NOT NULL,
  `quantite_com` int(11) NOT NULL,
  `sous_total` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `panier`
--

CREATE TABLE `panier` (
  `id_panier` int(11) NOT NULL,
  `utilisateur_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Structure de la table `produit`
--

CREATE TABLE `produit` (
  `id_Produit` int(11) NOT NULL,
  `nom` varchar(40) NOT NULL,
  `prix_achat` int(30) NOT NULL,
  `prix_vente` int(30) NOT NULL,
  `quantite` int(30) NOT NULL,
  `Categorie_id` int(11) NOT NULL,
  `quantite_alert` int(11) NOT NULL,
  `photo_produit` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `produit`
--

INSERT INTO `produit` (`id_Produit`, `nom`, `prix_achat`, `prix_vente`, `quantite`, `Categorie_id`, `quantite_alert`, `photo_produit`) VALUES
(7, 'vans', 100, 125, 34, 18, 4, 'images (39).jpg'),
(9, 'mixa', 2364, 12, 12, 16, 1, 'images (4).jpg');

-- --------------------------------------------------------

--
-- Structure de la table `rayon`
--

CREATE TABLE `rayon` (
  `id_rayon` int(11) NOT NULL,
  `nom` varchar(40) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `rayon`
--

INSERT INTO `rayon` (`id_rayon`, `nom`) VALUES
(1, 'patiseriess'),
(6, 'charcuterie'),
(9, 'manga books'),
(11, 'moto parts');

-- --------------------------------------------------------

--
-- Structure de la table `utilisateur`
--

CREATE TABLE `utilisateur` (
  `id_utilisateur` int(11) NOT NULL,
  `username` text NOT NULL,
  `password` text NOT NULL,
  `role` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Contenu de la table `utilisateur`
--

INSERT INTO `utilisateur` (`id_utilisateur`, `username`, `password`, `role`) VALUES
(1, 'axel nzagadou', '12345', 'ADMIN'),
(3, 'kameni', '0000', 'SUPER-ADMIN');

--
-- Index pour les tables exportées
--

--
-- Index pour la table `adresse_f`
--
ALTER TABLE `adresse_f`
  ADD PRIMARY KEY (`id_adresse_f`),
  ADD KEY `utilisatuer_id` (`utilisatuer_id`);

--
-- Index pour la table `adresse_l`
--
ALTER TABLE `adresse_l`
  ADD PRIMARY KEY (`id_adresse_l`),
  ADD KEY `utilisatuer_id` (`utilisatuer_id`);

--
-- Index pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD PRIMARY KEY (`id_Categorie`),
  ADD KEY `fk_categorei_c` (`rayon_id`);

--
-- Index pour la table `client`
--
ALTER TABLE `client`
  ADD PRIMARY KEY (`id_client`);

--
-- Index pour la table `commande`
--
ALTER TABLE `commande`
  ADD KEY `fk_addresse_f` (`adresse_f_id`),
  ADD KEY `fk_adresse_l_l` (`adresse_l_id`);

--
-- Index pour la table `ligne_panier`
--
ALTER TABLE `ligne_panier`
  ADD PRIMARY KEY (`id_ligne_panier`),
  ADD KEY `fk_ligne_p_p` (`panier_id`),
  ADD KEY `fk_ligne_pagnier_p` (`produit_id`);

--
-- Index pour la table `panier`
--
ALTER TABLE `panier`
  ADD PRIMARY KEY (`id_panier`),
  ADD KEY `fk_panier_p` (`utilisateur_id`);

--
-- Index pour la table `produit`
--
ALTER TABLE `produit`
  ADD PRIMARY KEY (`id_Produit`),
  ADD KEY `fk_categorie_id` (`Categorie_id`);

--
-- Index pour la table `rayon`
--
ALTER TABLE `rayon`
  ADD PRIMARY KEY (`id_rayon`);

--
-- Index pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  ADD PRIMARY KEY (`id_utilisateur`);

--
-- AUTO_INCREMENT pour les tables exportées
--

--
-- AUTO_INCREMENT pour la table `adresse_f`
--
ALTER TABLE `adresse_f`
  MODIFY `id_adresse_f` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `adresse_l`
--
ALTER TABLE `adresse_l`
  MODIFY `id_adresse_l` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `categorie`
--
ALTER TABLE `categorie`
  MODIFY `id_Categorie` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;
--
-- AUTO_INCREMENT pour la table `client`
--
ALTER TABLE `client`
  MODIFY `id_client` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `ligne_panier`
--
ALTER TABLE `ligne_panier`
  MODIFY `id_ligne_panier` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `panier`
--
ALTER TABLE `panier`
  MODIFY `id_panier` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT pour la table `produit`
--
ALTER TABLE `produit`
  MODIFY `id_Produit` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
--
-- AUTO_INCREMENT pour la table `rayon`
--
ALTER TABLE `rayon`
  MODIFY `id_rayon` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT pour la table `utilisateur`
--
ALTER TABLE `utilisateur`
  MODIFY `id_utilisateur` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- Contraintes pour les tables exportées
--

--
-- Contraintes pour la table `categorie`
--
ALTER TABLE `categorie`
  ADD CONSTRAINT `fk_categorei_c` FOREIGN KEY (`rayon_id`) REFERENCES `rayon` (`id_rayon`);

--
-- Contraintes pour la table `commande`
--
ALTER TABLE `commande`
  ADD CONSTRAINT `fk_addresse_f` FOREIGN KEY (`adresse_f_id`) REFERENCES `adresse_f` (`id_adresse_f`),
  ADD CONSTRAINT `fk_adresse_l` FOREIGN KEY (`adresse_l_id`) REFERENCES `adresse_l` (`id_adresse_l`);

--
-- Contraintes pour la table `ligne_panier`
--
ALTER TABLE `ligne_panier`
  ADD CONSTRAINT `fk_ligne_p_p` FOREIGN KEY (`panier_id`) REFERENCES `panier` (`id_panier`),
  ADD CONSTRAINT `fk_ligne_pagnier_p` FOREIGN KEY (`produit_id`) REFERENCES `produit` (`id_Produit`);

--
-- Contraintes pour la table `panier`
--
ALTER TABLE `panier`
  ADD CONSTRAINT `fk_panier_p` FOREIGN KEY (`utilisateur_id`) REFERENCES `utilisateur` (`id_utilisateur`);

--
-- Contraintes pour la table `produit`
--
ALTER TABLE `produit`
  ADD CONSTRAINT `fk_categorie_id` FOREIGN KEY (`Categorie_id`) REFERENCES `categorie` (`id_Categorie`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
