<?php
session_start();
require 'security/auth.php';
require 'BD config/BD_config.php';
require 'Repositoire/LignePanierRepository.php';

$bdConfig = new BD_config();
$msgCommande = false;
$lignepanier_repository = new LignePanierRepository($bdConfig);
$ligne_paniers = $lignepanier_repository->getALL($_SESSION['client']['id_client']);

if(count($ligne_paniers) <= 0){
    if (isset($_GET['msg_cmde']) && $_GET['msg_cmde']){
        $msgCommande = true;
    }
}else{
    $msgCommande = false;
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
    <div class="row bg-info">
        <div class="col-md-12 text-center h3 p-2 text-uppercase">
            Votre panier
        </div>
    </div>
    <?php if ($msgCommande){ ?>
    <div class="row mt-4 mb-2">
        <div class="col-md-12 alert alert-success p-5 h5 font-weight-bold text-center">
          <i class="fa fa-check-circle"></i>  Votre commande a été placée avec succès. <br>
            <a href="index.php">Rechercher d'autres produits</a>
        </div>
    </div>
    <?php } ?>
    <div class="row mt-2">
        <div class="col-md-8 offset-md-2">
            <?php if (count($ligne_paniers) > 0){ ?>
            <div class="row mt-2 pb-2">
                <div class="col-md-12">
                    <a href="commander.php" class="btn btn-success pull-right">
                        Commander &nbsp;<i class="fa fa-arrow-right"></i>
                    </a>
                </div>
            </div>
            <table class="table">
                <tr class="font-weight-bold">
                    <td></td>
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
                <tr >
                    <td>
                        <img class="img-fluid shelf-book"
                             src="BACK-END/Produit/Images/<?= $ligne_panier['photo_produit']?>"
                             style="width:50px;height: 50px">
                    </td>
                    <td class="text-uppercase"><?= $ligne_panier['nom']?></td>
                    <td><?= $ligne_panier['prix_vente']?></td>
                    <td>
                        <form action="updateQuantite.php" method="post" class="form-inline">
                            <table class="table-borderless">
                                <tr>
                                    <td>
                                        <input type="hidden" name="id" value="<?= $ligne_panier['id_ligne_panier']?>">
                                        <input type="hidden" name="prix" value="<?= $ligne_panier['prix_vente']?>">
                                        <input id="<?= $ligne_panier['id_ligne_panier']?>" type="number" class="form-control input"
                                               style="width: 80px" name="quantite" value="<?= $ligne_panier['quantite_com']?>">
                                    </td>
                                    <td style="display: none;" class="lp" id="lp<?= $ligne_panier['id_ligne_panier']?>">
                                        <button class="btn btn-primary">
                                            <i class="fa fa-check"></i>
                                        </button>
                                    </td>
                                </tr>
                            </table>
                        </form>

                    </td>
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
                    <td colspan="2" class="text-right">Montant total(FCFA):</td>
                    <td class="font-weight-bold"><?= $montant_total?></td>
                    <td class="text-right">
                        <a class="text-center btn btn-outline-danger font-weight-bold" href="emptyCart.php?id_panier=<?= $ligne_paniers[0]['panier_id']?>">
                          <i class="fa fa-trash"></i>  Vider le panier
                        </a>
                    </td>
                </tr>
            </table>
            <?php }else if (!$msgCommande && count($ligne_paniers) <= 0){ ?>
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
<script>
    $(document).ready(function () {

        let input = $('.input');

        input.change(function () {
           $('.lp').css('display','none');
           $('#lp'+$(this).attr('id')).css('display','block');
       });
    });
</script>
</body>
</html>
