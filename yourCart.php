<?php
session_start();
require 'security/auth.php';
require 'BD config/BD_config.php';
require 'Repositoire/LignePanierRepository.php';

$bdConfig = new BD_config();
$lignepanier_repository = new LignePanierRepository($bdConfig);

$ligne_paniers = $lignepanier_repository->getALL($_SESSION['client']['id_client']);
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
    <div class="row bg-info">
        <div class="col-md-12 text-center h3 p-2 text-uppercase">
            Votre panier
        </div>
    </div>
    <div class="row mt-2">
        <div class="col-md-6 offset-md-3">
            <div>
                <a href="commander.php" class="btn btn-success pull-right">
                    Commander &nbsp;<i class="fa fa-arrow-right"></i>
                </a>
            </div>
            <?php if (count($ligne_paniers) > 0){ ?>
            <table class="table table-striped">
                <tr class="font-weight-bold">
                    <td>Produit</td>
                    <td>Prix unitaire</td>
                    <td>Quantité</td>
                    <td>Montant</td>
                    <td></td>
                </tr>
                <?php
                $montant_total = 0;
                foreach ($ligne_paniers as $ligne_panier){
                ?>
                <tr>
                    <td class="text-uppercase"><?= $ligne_panier['nom']?></td>
                    <td><?= $ligne_panier['prix_vente']?></td>
                    <td><?= $ligne_panier['quantite_com']?></td>
                    <td><?= $ligne_panier['sous_total']?></td>
                    <td>
                        <a class="btn btn-danger"
                           href="deleteLigneCart.php?id=<?= $ligne_panier['id_ligne_panier']?>">
                            <i class="fa fa-minus-circle"></i>
                        </a>
                    </td>
                </tr>
                <?php
                    $montant_total += $ligne_panier['sous_total'];
                } ?>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Montant Total</td>
                    <td class="font-weight-bold"><?= $montant_total?> FCFA</td>
                    <td></td>
                </tr>
            </table>
            <?php }else{ ?>
            <div class="alert alert-info text-center mt-3">
               <i class="fa fa-info-circle"></i>
                Aucun produit n'a encore été ajouté au panier
            </div>
            <?php } ?>
        </div>
    </div>
    <?php require 'commons/footer.html'?>
</div>
<?php require 'commons/js.html'?>
</body>
</html>
