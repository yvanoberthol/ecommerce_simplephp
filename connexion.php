<?php
session_start();
require 'BD config/BD_config.php';
require 'Repositoire/ClientRepository.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $username = $_POST['login'];
    $password = $_POST['password'];

    $bdConfig = new BD_config();
    $client_repository = new ClientRepository($bdConfig);
    $client = $client_repository->verifier($username, $password);

    if (!empty($client)){
        session_start();
        $_SESSION['client'] = $client;
        header('Location: index.php');
    }else{
        $msg = true;
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
                    <h3 class="card-title text-uppercase">
                        COnnexion
                    </h3>
                </div>
                <div class="card-body">
                    <?php if (isset($msg)){ ?>
                    <div class="text-center alert alert-danger">
                       <i class="fa fa-close"></i> Nom d'utilisateur ou mot de passe incorrect
                    </div>
                    <?php } ?>
                    <form action="" method="post">
                        <div class="form-group">
                            <input required type="text" name="login" class="form-control form-control-lg" placeholder="Nom d'utilisateur">
                        </div>
                        <div class="form-group">
                            <input required type="password" name="password" class="form-control form-control-lg" placeholder="Mot de passe">
                        </div>
                        <div>
                            <button class="btn btn-primary">
                                <i class="fa fa-sign-in"></i> Se connecter
                            </button>
                            <a href="inscription.php">Vous n'avez pas de compte?</a>
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
