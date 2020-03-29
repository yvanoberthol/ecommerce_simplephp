<?php
session_start();
require 'security/auth.php';
require 'BD config/BD_config.php';
require 'Repositoire/PanierRepository.php';
require 'Repositoire/CommandeRepository.php';
require 'Pdf.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $commande = new Commande();
    $commande->setMontant($_POST['montant']);
    $commande->setAdresseLId($_POST['adresse_l']);
    $commande->setClientId($_POST['client_id']);
    $commande->setPanierId($_POST['panier_id']);
    $commande->setCompteId($_POST['compte_id']);

    $bdConfig = new BD_config();
    $cmde_repository = new CommandeRepository($bdConfig);
    $panier_repository = new PanierRepository($bdConfig);
    $panier_repository->submitPanier($_POST['panier_id']);
    $cmde_repository->create($commande);
}