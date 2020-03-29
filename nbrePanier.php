<?php
session_start();
if (isset($_SESSION['client']['id_client'])){
    require 'security/auth.php';
    require 'BD config/BD_config.php';
    require 'Repositoire/LignePanierRepository.php';

    $bdConfig = new BD_config();
    $msgCommande = false;
    $lignepanier_repository = new LignePanierRepository($bdConfig);
    $ligne_paniers = $lignepanier_repository->getALL($_SESSION['client']['id_client']);
    echo json_encode(count($ligne_paniers));
}else{
    echo json_encode('null');
}

?>