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
    <div class="row bg-info">
        <div class="col-md-12 text-center h3 p-2 text-uppercase">
            Votre panier
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <table>
                <tr>
                    <td>Produit</td>
                    <td>Prix unitaire</td>
                    <td>Quantité</td>
                    <td>Montant</td>
                </tr>
                <tr>

                </tr>
            </table>
        </div>
    </div>
    <?php require 'commons/footer.html'?>
</div>
<?php require 'commons/js.html'?>
</body>
</html>
