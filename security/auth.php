<?php
if (!isset($_SESSION['client'])){
    header('Location: connexion.php');
}
