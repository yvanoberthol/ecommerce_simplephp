<?php
require 'BD config/BD_config.php';
require 'Repositoire/RayonRepository.php';

$bdConfig = new BD_config();
$rayon_repository = new RayonRepository($bdConfig);
$rayons = $rayon_repository->getALL();
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
    <div class="row color-meduim-titre">
        <div class="col-md-12">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <img src="Assets/photos/Logo%20innova%20complet.png" alt="">
                        </div>
                    </div>
                    <p class="lead text-center pt-2">Nous vous proposons des produits de haute qualité</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row bg-info">
        <div class="col-md-12 text-center h3 p-2 text-uppercase">
            Visitez nos rayons
        </div>
    </div>
    <?php foreach ($rayons as $rayon) { ?>
    <div class="row mt-2">
        <div class="col-md-4 offset-md-4">
            <div class="card">
                <div class="card-header">
                    <div class="card-title text-center font-weight-bold h5">
                        <a href="produitByRayon.php?id_rayon=<?=$rayon['id_rayon']?>">
                            <?= $rayon['nom']?>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php } ?>
    <?php require 'commons/footer.html'?>
</div>
<?php require 'commons/js.html'?>
</body>
</html>
