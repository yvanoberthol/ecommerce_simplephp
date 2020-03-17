<?php
session_start();
require 'BD config/BD_config.php';
require 'Repositoire/RayonRepository.php';
require 'Repositoire/CategorieRepository.php';
require 'Repositoire/ProduitRepository.php';
require 'Repositoire/LignePanierRepository.php';
require 'Repositoire/PanierRepository.php';
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

    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        require 'security/auth.php';
        $panier_repository = new PanierRepository($bdConfig);
        $panier = $panier_repository->getByClient($_SESSION['client']['id_client']);

        $lignepanier_repository = new LignePanierRepository($bdConfig);
        $ligne_panierByProduit = $lignepanier_repository->getONEByProduit($_POST['produit_id']);
        $ligne_panier = new Ligne_panier();

        if (empty($ligne_panierByProduit)){
            if (empty($panier)){
                $panierToCreate['utilisateur_id'] = $_SESSION['client']['id_client'];
                $id_created = $panier_repository->create($panierToCreate);
                $ligne_panier->setPanierId($id_created);
            }else{
                $ligne_panier->setPanierId($panier['id_panier']);
            }
        }
        $ligne_panier->setProduitId($_POST['produit_id']);
        if (empty($ligne_panierByProduit)){
            $ligne_panier->setQuantiteCom($_POST['qte']);
            $sous_total = $_POST['qte'] * $_POST['prix'];
            $ligne_panier->setSousTotal($sous_total);
            $lignepanier_repository->create($ligne_panier);
        }else{
            $ligne_panier->setQuantiteCom($ligne_panierByProduit['quantite_com'] + $_POST['qte']);
            $sous_total = ($ligne_panierByProduit['quantite_com'] + $_POST['qte']) * $_POST['prix'];
            $ligne_panier->setSousTotal($sous_total);
            $lignepanier_repository->updateQte($ligne_panier);
        }
        $msgSuccess = true;
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
    <?php if (isset($msgSuccess)){?>
    <div class="row">
        <div class="col-md-12">
            <div class="alert alert-success text-center">
                <i class="fa fa-check-circle"></i> Produit ajouté au panier
            </div>
        </div>
    </div>
    <?php } ?>
    <div class="row mt-2 mb-2">
        <div class="col-md-3">
            <h3 class="h3 text-center">Catégorie(s)</h3>
            <div class="list-group list-group-flush text-center">
                <?php foreach ($categories as $categorie){?>
                <a href="#" class="text-uppercase list-group-item list-group-item-primary
                list-group-item-action h6 <?php if ($categorie == $categories[0]) echo 'active'?>">
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
                        <div class="card-header color-meduim-titre">
                            <div class="card-title h4 text-center text-uppercase">
                                <?= $produit['nom']?>
                            </div>
                        </div>
                        <div class="card-body">
                            <a href="#p<?= $produit['id_Produit'] ?>" data-toggle="modal">
                            <img src="BACK-END/Produit/Images/<?= $produit['photo_produit'] ?>" width="100%" height="120px" alt="">
                            </a>
                        </div>
                        <div class="card-footer text-center bg-info">
                            <div class="row">
                                <div class="col-md-12 text-center">
                                    <span class="h4 text-white">
                                        <?= $produit['prix_vente']?> FCFA
                                    </span>
                                    <button data-target="#p<?= $produit['id_Produit'] ?>" data-toggle="modal" type="button" class="btn btn-success h4 pull-right">
                                        <i class="fa fa-arrow-circle-down"></i>
                                    </button>

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="p<?= $produit['id_Produit'] ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header color-meduim-titre">
                                    <h3 class="modal-title text-uppercase" id="exampleModalLabel">Détail du produit</h3>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <img src="BACK-END/Produit/Images/<?= $produit['photo_produit'] ?>"
                                                 width="100%" height="200px" alt="">
                                        </div>
                                        <div class="col-md-6">
                                            <form action="" method="post">
                                                <input type="hidden" name="produit_id" value="<?= $produit['id_Produit'] ?>">
                                                <input type="hidden" name="prix" value="<?= $produit['prix_vente'] ?>">
                                                <table class="table">
                                                    <tr>
                                                        <td>
                                                            <span class="h5">Nom:</span> &nbsp;
                                                            <span class="h5 font-weight-bold text-uppercase"><?= $produit['nom']?></span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <span class="h5">Prix:</span> &nbsp;
                                                            <span class="h5 font-weight-bold text-uppercase"><?= $produit['prix_vente']?> FCFA</span>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <label for="qte">Quantité</label>
                                                            <input type="number" id="qte" name="qte" required>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <button type="submit" class="btn btn-success">
                                                                <i class="fa fa-plus"></i>
                                                                Ajouter au panier
                                                            </button>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </form>
                                        </div>
                                    </div>
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