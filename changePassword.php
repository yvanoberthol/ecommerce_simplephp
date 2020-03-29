<?php
session_start();
require 'security/auth.php';
require 'BD config/BD_config.php';
require 'Repositoire/ClientRepository.php';

$msgSuccess = false;
$passwordNotMatches = false;

$clientToUpdate = $_SESSION['client'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['password'] === $clientToUpdate['password']){
        $client = new Client();
        $client->setLogin($_POST['login']);
        $client->setPassword($_POST['confirmpassword']);
        $client->setId($_POST['id']);

        $bdConfig = new BD_config();
        $client_repository = new ClientRepository($bdConfig);
        $client_repository->updateIdentifiant($client);
        $msgSuccess = true;
    }else{
        $passwordNotMatches = true;
    }
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
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-uppercase text-center">
                        Changer mes identifiants de connexion
                    </h3>
                </div>
                <div class="card-body">
                    <?php if ($msgSuccess){ ?>
                        <div class="text-center alert alert-success">
                            <i class="fa fa-check-circle"></i> Modification réussie
                        </div>
                    <?php } ?>
                    <?php if ($passwordNotMatches){ ?>
                        <div class="text-center alert alert-danger">
                            <i class="fa fa-close"></i> Ancien mot de passe incorrect
                        </div>
                    <?php } ?>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $clientToUpdate['id_client']?>">
                        <div class="form-group">
                            <input type="text" name="login" value="<?= $clientToUpdate['login']?>"
                                   class="form-control form-control-lg" placeholder="Nom d'utilisateur">
                        </div>
                        <div class="form-group">
                            <input required type="password" name="password"  value=""
                                   class="form-control form-control-lg" placeholder="Ancien mot de passe">
                        </div>
                        <div class="form-group">
                            <input required type="password" name="confirmPassword"  value=""
                                   class="form-control form-control-lg" placeholder="Nouveau mot de passe">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-edit"></i> Changer
                            </button>
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
