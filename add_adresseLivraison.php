<?php
session_start();
require 'security/auth.php';
require 'BD config/BD_config.php';
require 'Repositoire/AdresseLivraisonRepository.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adresse = new Adresse_l();
    $adresse->setQuartier($_POST['quartier']);
    $adresse->setVille($_POST['ville']);
    $adresse->setNumeroRue($_POST['numeroRue']);
    $adresse->setClientId($_SESSION['client']['id_client']);

    $bdConfig = new BD_config();
    $adresse_repository = new AdresseLivraisonRepository($bdConfig);
    $adresse_repository->create($adresse);
    header('Location: commander.php#shippingInfo');
}
?>