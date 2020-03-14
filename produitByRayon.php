<?php
require 'BD config/BD_config.php';
require 'Repositoire/RayonRepository.php';
require 'Repositoire/CategorieRepository.php';
require 'Repositoire/ProduitRepository.php';
if (isset($_GET['id_rayon'])) {
    if (!empty($_GET['id_rayon'])) {
        $bdConfig = new BD_config();
        $categorie_repository = new CategorieRepository($bdConfig);
        $categories = $categorie_repository->getALLByRayon($_GET['id_rayon']);

        if (count($categories) <= 0) {
            header('Location: index.php');
        }

        $produit_repository = new ProduitRepository($bdConfig);
        $produits = $produit_repository->getALLByCategorie($categories[0]['id_Categorie']);
    }
}else {
    header('Location: index.php');
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
    <div class="row alert-dark">
        <div class="col-md-12 text-center h3 p-2 text-uppercase">
            Rayon <span class="text-black-50"><?= $categories[0]['nomR']?></span>
        </div>
    </div>
    <div class="row bg-info">
        <div class="col-md-12 text-center h4 p-2 text-uppercase">
            Nos produits
        </div>
    </div>
    <div class="row mt-2 mb-2">
        <div class="col-md-3">
            <h3 class="h3 text-center">Catégorie(s)</h3>
            <div class="list-group list-group-flush text-center">
                <?php foreach ($categories as $categorie){?>
                <a href="#" class="text-uppercase list-group-item list-group-item-primary
                list-group-item-action h5 <?php if ($categorie == $categories[0]) echo 'active'?>">
                    <?= $categorie['nomC']?>
                </a>
                <?php } ?>
            </div>
        </div>
        <div class="col-md-9">
            <div class="row">
                <div class="col-md-3">
                    <?php foreach ($produits as $produit){ ?>
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title h4 text-center">
                                <?= $produit['nom']?>
                            </div>
                        </div>
                        <div class="card-body">
                            <img src="BACK-END/Produit/Images/<?= $produit['photo_produit'] ?>" width="100%" height="120px" alt="">
                        </div>
                        <div class="card-footer text-center">
                            <span class="badge badge-info">
                                <?= $produit['prix_vente']?> FCFA
                            </span>
                            <a href="#p<?= $produit['id_Produit'] ?>" data-toggle="modal" class="badge badge-primary">
                                Détails
                            </a>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="p<?= $produit['id_Produit'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?= $produit['nom']?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <img src="BACK-END/Produit/Images/<?= $produit['photo_produit'] ?>"
                                         width="100%" height="200px" alt="">
                                    <p>
                                        <table class="table">
                                            <tr>
                                               <td class="h5">Quantité</td>
                                               <td>
                                                   <input type="number" name="qte">
                                               </td>
                                            </tr>
                                        <tr>
                                            <td></td>
                                            <td>
                                                <button class="btn btn-success">
                                                    <i class="fa fa-plus"></i>
                                                    Ajouter au panier
                                                </button>
                                            </td>
                                        </tr>
                                        </table>
                                    </p>
                                </div>
                                <!--<div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                </div>-->
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>

    <?php require 'commons/footer.html'?>
</div>
<?php require 'commons/js.html'?>
</body>
</html>