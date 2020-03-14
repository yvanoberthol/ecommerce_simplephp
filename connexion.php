<?php ?>
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
                        COnnexion
                    </h3>
                </div>
                <div class="card-body">
                    <form action="">
                        <div class="form-group">
                            <input type="text" class="form-control form-control-lg" placeholder="Nom d'utilisateur">
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-lg" placeholder="Mot de passe">
                        </div>
                        <div>
                            <button class="btn btn-primary">
                                <i class="fa fa-sign-in"></i> Se connecter
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
