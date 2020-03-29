<?php
session_start();
unset($_SESSION['client']);
session_destroy();
header('location: connexion.php');