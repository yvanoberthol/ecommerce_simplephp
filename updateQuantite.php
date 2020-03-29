<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST'){

    session_start();
    require 'security/auth.php';
    require 'BD config/BD_config.php';
    require 'Repositoire/LignePanierRepository.php';

    $bdConfig = new BD_config();
    $lignepanier_repository = new LignePanierRepository($bdConfig);

    $lignePanier = new Ligne_panier();
    $lignePanier->setQuantiteCom($_POST['quantite']);
    $lignePanier->setIdLignePanier($_POST['id']);
    $montant = $_POST['quantite'] * $_POST['prix'];
    $lignePanier->setSousTotal($montant);

    $lignepanier_repository->updateQte($lignePanier);

    header('Location: yourCart.php');

}
?>