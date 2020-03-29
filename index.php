<?php
session_start();
require 'BD config/BD_config.php';
require 'Repositoire/RayonRepository.php';
require 'Repositoire/CategorieRepository.php';

$bdConfig = new BD_config();
$rayon_repository = new RayonRepository($bdConfig);
$categorie_repository = new CategorieRepository($bdConfig);
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
    <div class="row bg-info" id="rayons">
        <div class="col-md-12 text-center h3 p-2 text-uppercase">
            Visitez nos rayons
        </div>
    </div>
    <?php foreach ($rayons as $rayon) { ?>
    <div class="row mt-2">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <div class="row">
                            <div class="col-md-4 font-weight-bold h6 text-uppercase">
                                <div>
                                    <a href="produitByRayon.php?id_rayon=<?=$rayon['id_rayon']?>">
                                        <?= $rayon['nom']?>
                                    </a>
                                </div>
                                 <div class="barre" style="width: 100%; border: #0c5460 solid 2px">
                                 </div>
                            </div>
                            <div class="col-md-8">
                                <ul class="list-group">
                                    <?php
                                        $categories = $categorie_repository->getALLByRayon($rayon['id_rayon']);
                                        foreach ($categories as $categorie) {
                                            echo '<li class="list-group-item"><a href="produitByRayon.php?id_rayon='.$rayon['id_rayon'].'&id_categorie='.$categorie['id_Categorie'].'" class="list-group-item-action text-capitalize">'.$categorie['nomC'].'</a></li>';
                                        }
                                    ?>
                                </ul>

                            </div>
                        </div>
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
