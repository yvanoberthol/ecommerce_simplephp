<?php
session_start();
require 'security/auth.php';
require 'BD config/BD_config.php';
require 'Repositoire/CompteRepository.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $compte = new Compte();
    $compte->setNom($_POST['nom']);
    $compte->setType($_POST['type']);
    $compte->setTelephone($_POST['telephone']);
    $compte->setClientId($_SESSION['client']['id_client']);

    $bdConfig = new BD_config();
    $compte_repository = new CompteRepository($bdConfig);
    $compte_repository->create($compte);
    header('Location: commander.php#paymentInfo');
}
?>