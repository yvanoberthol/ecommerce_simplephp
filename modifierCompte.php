<?php
session_start();
require 'security/auth.php';
require 'BD config/BD_config.php';
require 'Repositoire/ClientRepository.php';


$clientToUpdate = $_SESSION['client'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $client = new Client();
    $client->setNom($_POST['nom']);
    $client->setPrenom($_POST['prenom']);
    $client->setTelephone($_POST['telephone']);
    $client->setEmail($_POST['email']);
    $client->setId($_POST['id']);

    $bdConfig = new BD_config();
    $client_repository = new ClientRepository($bdConfig);
    $client_repository->updateInformation($client);
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
        <div class="col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title text-uppercase text-center">
                        Modifier mes informations personnelles
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (isset($msg)){ ?>
                        <div class="text-center alert alert-success">
                            <i class="fa fa-check-circle"></i> Modification réussie
                        </div>
                    <?php } ?>
                    <form action="" method="post">
                        <input type="hidden" name="id" value="<?= $clientToUpdate['id_client']?>">
                        <div class="form-group">
                            <input type="text" name="nom" value="<?= $clientToUpdate['nom']?>"
                                   class="form-control form-control-lg" placeholder="nom">
                        </div>
                        <div class="form-group">
                            <input required type="text" name="prenom"  value="<?= $clientToUpdate['prenom']?>"
                                   class="form-control form-control-lg" placeholder="prénom">
                        </div>
                        <div class="form-group">
                            <input required type="email" name="email"  value="<?= $clientToUpdate['email']?>"
                                   class="form-control form-control-lg" placeholder="email">
                        </div>
                        <div class="form-group">
                            <input required type="tel" name="telephone"  value="<?= $clientToUpdate['tel']?>"
                                   class="form-control form-control-lg" placeholder="téléphone">
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-edit"></i> Modifier
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
