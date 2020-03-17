<?php
session_start();
require 'BD config/BD_config.php';
require 'Repositoire/ClientRepository.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client = new Client();
    $client->setNom($_POST['nom']);
    $client->setPrenom($_POST['prenom']);
    $client->setTelephone($_POST['telephone']);
    $client->setEmail($_POST['email']);
    $client->setLogin($_POST['login']);
    $client->setPassword($_POST['password']);

    $bdConfig = new BD_config();
    $client_repository = new ClientRepository($bdConfig);
    $client_repository->create($client);
    $msg = true;
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <?php require 'commons/css.html'?>
    <title>INNOVA</title>
</head>
<body>
<div class="container-fluid">
    <?php include 'commons/header_front.php' ?>
    <div class="row p-5">
        <div class="col-md-6 offset-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-uppercase">
                        Inscription
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (isset($msg)){ ?>
                        <div class="text-center alert alert-success">
                            <i class="fa fa-check-circle"></i> Inscription réussie
                        </div>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <input type="text" name="nom" class="form-control form-control-lg" placeholder="nom">
                        </div>
                        <div class="form-group">
                            <input required type="text" name="prenom" class="form-control form-control-lg" placeholder="prénom">
                        </div>
                        <div class="form-group">
                            <input required type="email" name="email" class="form-control form-control-lg" placeholder="email">
                        </div>
                        <div class="form-group">
                            <input required type="tel" name="telephone" class="form-control form-control-lg" placeholder="téléphone">
                        </div>
                        <div class="form-group">
                            <input required type="text" name="login" class="form-control form-control-lg" placeholder="login">
                        </div>
                        <div class="form-group">
                            <input required type="password" name="password" class="form-control form-control-lg" placeholder="password">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-user"></i> S'inscrire
                            </button>

                            <a href="connexion.php">Vous avez déjà un compte?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <?php require 'commons/footer.html'?>
</div>
<?php require 'commons/js.html'?>
</body>
</html>
