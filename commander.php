<?php
session_start();
require 'security/auth.php';
require 'BD config/BD_config.php';
require 'Repositoire/LignePanierRepository.php';
require 'Repositoire/AdresseLivraisonRepository.php';
require 'Repositoire/CompteRepository.php';
require 'commons/villes.php';

$bdConfig = new BD_config();
$lignepanier_repository = new LignePanierRepository($bdConfig);
$adresse_repository = new AdresseLivraisonRepository($bdConfig);
$compte_repository = new CompteRepository($bdConfig);


$ligne_paniers = $lignepanier_repository->getALL($_SESSION['client']['id_client']);
$adresses = $adresse_repository->getALL($_SESSION['client']['id_client']);
$comptes = $compte_repository->getALL($_SESSION['client']['id_client']);

if (count($ligne_paniers) <= 0){
    header('Location: yourCart.php');
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
        Commande
    </div>
</div>
<div style="margin-top: 10px;">
<div class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <p class="alert alert-info" style="font-size: smaller">
                   <i class="fa fa-info-circle"></i> Avant de placer votre commande, vérifiez vos informations personnelles
                    et l'adresse de livraison
                </p>
                <hr/>
                <h4>Récapitulatif de la commande</h4>
                <div class="row">
                    <div class="col-md-7 text-left">
                        Total sans taxe:
                    </div>
                    <div class="col-md-5 text-left">
                        <?php
                            $montant_hors_taxe = 0;
                            foreach ($ligne_paniers as $ligne_panier){
                                $montant_hors_taxe += $ligne_panier['sous_total'];
                            }

                            echo $montant_hors_taxe;
                        ?> FCFA
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 text-left">
                        Taxe estimée (5%):
                    </div>
                    <div class="col-md-5 text-left">
                        <span>
                            <?php
                            $taxe = $montant_hors_taxe * 0.05;
                            echo $taxe;
                            ?> FCFA
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 text-left" style="padding-top: 5px">
                        <h5><strong>Montant Total: </strong></h5>
                    </div>
                    <div class="col-md-5 text-left">
                        <h5>
                            <strong style="color: darkred">
                                <span>
                                    <?php
                                    $montant_total =$montant_hors_taxe + $taxe;
                                    echo ceil($montant_total);
                                    ?>
                                </span> FCFA
                            </strong>
                        </h5>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                La livraison est gratuite.
            </div>
        </div>
    </div>
    <!--checkout info-->
    <div class="col-md-8">
        <div class="card-group row" id="accordion">
            <!--shipping address-->
            <div class="col-md-12">
                <div class="row">
                    <div class="card col-md-12">
                        <div class="card-header">
                            <h5 class="card-title">
                                <a data-toggle="collapse" href="#shippingInfo" aria-expanded="true" aria-controls="shippingInfo">
                                    1. Adresse de livraison
                                </a>
                            </h5>
                        </div>
                        <div class="collapse show" data-parent="#accordion" id="shippingInfo">
                            <div class="card-body">
                                <?php if (count($adresses) > 0){ ?>
                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th>Ville</th>
                                        <th>Quartier(numéro de la rue)</th>
                                        <th>Operations</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($adresses as $adresse){ ?>
                                    <tr>
                                        <td>
                                            <?= $adresse['ville'] ?>
                                        </td>
                                        <td>
                                            <?= $adresse['quartier'] ?>(<?= $adresse['numero_rue'] ?>)
                                        </td>
                                        <td>
                                            <input type="checkbox" class="checkadresse"
                                                   id="<?= $adresse['id_adresse_l']?>" value="<?= $adresse['id_adresse_l']?>">
                                            <label for="id_adresse">utiliser cette adresse</label>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                                <form action="add_adresseLivraison.php" method="post">
                                    <div class="form-group">
                                        <label>* Ville</label>
                                        <select class="form-control" name="ville" required>
                                            <option value="" disabled selected>--Sélectionner une ville--</option>
                                            <?php foreach ($villes as $ville){ ?>
                                                <option value="<?= $ville ?>"><?= $ville ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="form-group">
                                        <label for="quartier">* Quartier</label>
                                        <input type="text" class="form-control" id="quartier"
                                               name="quartier" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="numRue">* Numéro de la rue</label>
                                        <input type="number" class="form-control" id="numeroRue"
                                               name="numeroRue" required>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">
                                            Enregistrer
                                        </button>
                                    </div>
                                </form>
                                <a data-toggle="collapse" data-parent="#accordion"
                                   class="btn btn-warning pull-right" href="#paymentInfo">
                                    Suivant
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!--payment info-->
                    <div class="card col-md-12">
                        <div class="card-header">
                            <h5 class="card-title">
                                <a data-toggle="collapse" href="#paymentInfo" aria-expanded="false" aria-controls="paymentInfo">
                                    2. Information de paiement
                                </a>
                            </h5>
                        </div>
                        <div class="collapse" id="paymentInfo" data-parent="#accordion">
                            <div class="card-body">
                                <?php if (count($comptes) > 0){ ?>
                                <h3>Vos comptes</h3>
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Nom</th>
                                        <th>N° de Téléphone</th>
                                        <th>Type</th>
                                        <th>Operations</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($comptes as $compte){ ?>
                                    <tr>
                                        <td><?= $compte['nom_compte']?></td>
                                        <td><?= $compte['numero_tel']?></td>
                                        <td><?= $compte['type_paiement']?></td>
                                        <td>
                                            <input type="checkbox" class="checkcompte" id="<?= $compte['id_compte']?>" value="<?= $compte['id_compte']?>">
                                            <label for="id_compte">utiliser ce compte</label>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <?php } ?>
                                <!--credit card information-->
                                <form action="add_compte.php" method="post">
                                    <div class="form-group">
                                        <h5>* Donnez un nom à votre compte de paiement: </h5>
                                        <input type="text" class="form-control" id="nom"
                                               name="nom" required>
                                    </div>
                                    <div class="form-group">
                                        <label for="type">* Mode de paiement</label>
                                        <select name="type" id="type" class="form-control" required>
                                            <option value="" selected disabled>selectionez en un</option>
                                            <option value="MOMO">MTN MONEY</option>
                                            <option value="OM">ORANGE MONEY</option>
                                        </select>
                                    </div>
                                    <div class="form-group">
                                        <label for="telephone">* Numéro de téléphone</label>
                                        <input type="tel" class="form-control" id="telephone"
                                               name="telephone" required>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary" type="submit">
                                            Enregistrer
                                        </button>
                                    </div>
                                </form>
                                <a data-toggle="collapse" data-parent="#accordion"
                                   class="btn btn-warning pull-right" href="#reviewItemsInfo">
                                    Suivant
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!--Review Items and Shipping-->
                    <div class="card col-md-12">
                        <h5 class="card-header">
                            <div class="card-title">
                                <a data-toggle="collapse" href="#reviewItemsInfo" aria-expanded="true" aria-controls="reviewItemsInfo">
                                    3. Mon panier
                                </a>
                            </div>
                        </h5>
                        <div class="card-collapse collapse" id="reviewItemsInfo" data-parent="#accordion">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th></th>
                                                    <th>Produit(s)</th>
                                                    <th>Prix unitaire</th>
                                                    <th>Quantité</th>
                                                    <th>Montant</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php foreach ($ligne_paniers as $ligne_panier){ ?>
                                            <tr>
                                                <td>
                                                    <img class="img-fluid shelf-book"
                                                         src="BACK-END/Produit/Images/<?= $ligne_panier['photo_produit']?>"
                                                         style="width:50px;height: 50px">
                                                </td>
                                                <td>
                                                    <span><?= $ligne_panier['nom']?></span><br/>
                                                    <span>
                                                        <a href="deleteLigneCart.php?id=<?= $ligne_panier['id_ligne_panier']?>">
                                                            Delete
                                                        </a>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span><?= $ligne_panier['prix_vente']?></span>
                                                </td>
                                                <td>
                                                    <span><?= $ligne_panier['quantite_com']?></span>
                                                </td>
                                                <td>
                                                    <span><?= $ligne_panier['sous_total']?></span>
                                                </td>
                                            </tr>
                                            <?php } ?>
                                            <tr>
                                                <td></td>
                                                <td colspan="3" class="text-right">
                                                    <strong class="h6">Montant Hors taxe(HT):</strong>
                                                </td>
                                                <td>
                                                    <span class="h6" style="color: darkred">
                                                        <?= ceil($montant_hors_taxe)?>
                                                    </span> FCFA
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td colspan="3" class="text-right">
                                                    <strong class="h6">Taxe(5%):</strong>
                                                </td>
                                                <td>
                                                    <span class="h6" style="color: darkred">
                                                        <?= ceil($taxe)?>
                                                    </span> FCFA
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <a href="dowloadPanier.php" target="_blank">Télécharger la facture</a>
                                                </td>
                                                <td colspan="3" class="text-right">
                                                    <strong class="h5">Montant Total(<span class="text-black-50"><?= count($ligne_paniers)?></span>) TTC:</strong>
                                                </td>
                                                <td>
                                                    <span class="h5" style="color: darkred">
                                                        <?= ceil($montant_total)?>
                                                    </span> FCFA
                                                </td>
                                            </tr>
                                            </tbody>
                                        </table>
                                        <h4></h4>
                                    </div>
                                </div>

                                <!--separation line with the title-->
                                <div class="row">
                                    <div class="col-md-12 separation">
                                        <hr/>
                                    </div>
                                </div>
                                <br>
                                <button id="submit" type="button" class="btn btn-warning btn-block">Soumettre votre commande</button>
                                <p style="font-size: smaller">
                                    En plaçant votre commande, vous acceptez les conditions d'utilisation de vos
                                    informations sur notre site.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
</div>
    <?php require 'commons/footer.html'?>
</div>
<?php require 'commons/js.html'?>
<script type="application/javascript">
    $(document).ready(function () {
        let adresse_id = 0;
        let compte_id = 0;

        // toogle checkbox adresse
        $(".checkadresse").change(function () {
            $(".checkadresse").prop('checked',false);
            $(this).prop('checked',true);
            adresse_id = $(this).val();
        });

        // toogle checkbox compte
        $(".checkcompte").change(function () {
            $(".checkcompte").prop('checked',false);
            $(this).prop('checked',true);
            compte_id = $(this).val();
        });

        $("#submit").click(() => {
            if (compte_id === 0){
                alert("vérifier si vous avez coché un mode de paiement");
            } else if (adresse_id === 0){
                alert("vérifier si vous avez coché une adresse de livraison");
            } else {
                const data = {
                    montant: <?= ceil($montant_total)?>,
                    adresse_l: adresse_id,
                    panier_id: <?= $ligne_paniers[0]['panier_id']?>,
                    compte_id: compte_id,
                    client_id: <?= $_SESSION['client']['id_client'] ?>
                };

                $.post('postcommander.php', data ,function(result){
                    $(location).attr('href','yourCart.php?msg_cmde=true');
                });
            }
        });
    });
</script>
</body>
</html>