<?php
if (isset($_GET['id_panier'])){
    session_start();
    require 'security/auth.php';
    require 'BD config/BD_config.php';
    require 'Repositoire/LignePanierRepository.php';
    $bdConfig = new BD_config();
    $lignepanier_repository = new LignePanierRepository($bdConfig);
    $lignepanier_repository->viderPanier($_GET['id_panier']);
    header('Location: yourCart.php');

}