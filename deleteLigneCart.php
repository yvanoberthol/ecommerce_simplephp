<?php
session_start();
require 'security/auth.php';
require 'BD config/BD_config.php';
require 'Repositoire/LignePanierRepository.php';
if (isset($_GET['id'])){
    $bdConfig = new BD_config();
    $lignepanier_repository = new LignePanierRepository($bdConfig);
    $lignepanier_repository->delete($_GET['id']);

    header('Location: yourCart.php');
}else{
    header('Location: yourCart.php');
}