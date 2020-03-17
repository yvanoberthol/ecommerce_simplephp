<?php
session_start();
require 'security/auth.php';
require 'BD config/BD_config.php';
require 'Repositoire/LignePanierRepository.php';
require 'commons/villes.php';

$bdConfig = new BD_config();
$lignepanier_repository = new LignePanierRepository($bdConfig);
$adresse_repository = new AdresseLivraisonRepository($bdConfig);


$ligne_paniers = $lignepanier_repository->getALL($_SESSION['client']['id_client']);
$adresses = $adresse_repository->getALL($_SESSION['client']['id_client']);

if (count($ligne_paniers) <= 0){
    header('Location: yourCart.php');
}
?>
<div style="margin-top: 10px;">
<form action="" method="post" class="row">
    <div class="col-md-4">
        <div class="card">
            <div class="card-body">
                <button type="submit" class="btn btn-warning btn-block">Commander</button>
                <p style="font-size: smaller">
                    Avant de placer ta commande, vérifies tes informations personnelles
                    et l'adresse de livraison
                </p>
                <hr/>
                <h3>Récapitulatif de la commande</h3>
                <div class="row">
                    <div class="col-md-7 text-left">
                        Total sans taxe:
                    </div>
                    <div class="col-md-5 text-right">
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
                        Taxe estimée:
                    </div>
                    <div class="col-md-5 text-right">
                        <span>
                            <?php
                            $taxe  = $montant_hors_taxe * 0.1925;
                            echo $taxe;
                            ?> FCFA
                        </span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-7 text-left" style="padding-top: 5px">
                        <h5><strong>Montant Total: </strong></h5>
                    </div>
                    <div class="col-md-5 text-right">
                        <h3>
                            <strong style="color: darkred">
                                <span>
                                    <?php
                                    $montant_total =$montant_hors_taxe + $taxe;
                                    echo $montant_total;
                                    ?>
                                </span> FCFA
                            </strong>
                        </h3>
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
                        <div class="collapse" data-parent="#accordion" id="shippingInfo">
                            <div class="card-body">
                                <table class="table">
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
                                            <a href="">utiliser</a>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <label class="custom-control-label">* Ville</label>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <select class="form-control" name="ville" required>
                                                <option value="" disabled selected>--Sélectionner une ville--</option>
                                                <?php foreach ($adresses as $adresse){ ?>
                                                <option value="<?= $adresse ?>"><?= $adresse ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="quartier">* Quartier</label>
                                    <input type="text" class="form-control" id="quartier"
                                           name="quartier" required>
                                </div>
                                <div class="form-group">
                                    <label for="numRue" class="custom-control-label">* Numéro de la rue</label>
                                    <input type="text" class="form-control" id="numRue"
                                           name="numeroRue" required>
                                </div>
                                <a data-toggle="collapse" data-parent="#accordion"
                                   class="btn btn-warning pull-right" href="#paymentInfo">
                                    Next
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
                                <a data-toggle="collapse" href="#paymentInfo" aria-expanded="true" aria-controls="paymentInfo">
                                    2. Payment Information
                                </a>
                            </h5>
                        </div>
                        <div class="collapse" id="paymentInfo" data-parent="#accordion">
                            <div class="card-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Vos cartes de crédit</th>
                                        <th>Operations</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr th:each="userPayment: ${userPaymentList}">
                                        <td th:text="${userPayment.cardName}">
                                        </td>
                                        <td>
                                            <a th:href="@{/setPaymentMethod(userPaymentId=${userPayment.idPayment})}">use
                                                this payment</a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <!--credit card information-->
                                <div class="row">
                                    <div class="col-md-12">
                                        <img class="img-fluid" th:src="@{/imgs/creditcard1.png}" alt="rien"><br/>
                                        <input type="hidden" name="idPayement">
                                        <div class="form-group">
                                            <h5>* Donnez un nom à votre compte de paiement: </h5>
                                            <input type="text" class="form-control" id="cardName"
                                                   placeholder="Card Name"
                                                   name="cardName" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="cardType">* Mode de paiement</label>
                                            <select name="type" id="cardType" class="form-control" required>
                                                <option value="" disabled>selectionez en un</option>
                                                <option value="visa" th:selected="${payment.type} == 'visa'">MTN MONEY</option>
                                                <option value="mastercard" th:selected="${payment.type} == 'mastercard'">ORANGE MONEY</option>
                                                <option value="discover" th:selected="${payment.type} == 'discover'">Discover</option>
                                                <option value="amex" th:selected="${payment.type} == 'amex'">American Express</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="cardNumber">* Numéro de téléphone</label>
                                            <input type="tel" class="form-control" id="cardNumber"
                                                   placeholder="Card Number"
                                                   name="cardNumber" required>
                                        </div>
                                    </div>
                                </div>
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
                                    <div class="col-md-8">
                                        <h4>Produit(s)</h4>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Prix</h4>
                                    </div>
                                    <div class="col-md-2">
                                        <h4>Quantité</h4>
                                    </div>
                                </div>

                                <!--separation line with the title-->
                                <div class="row">
                                    <div class="col-md-12 separation">
                                        <hr/>
                                    </div>
                                </div>

                                <!--display products in cart-->
                                <div class="row" th:each="cartItem:${cartItemList}">
                                    <div class="col-md-2">
                                        <a th:href="@{/bookDetail(id=${cartItem.book.id})}">
                                            <img class="img-fluid shelf-book"
                                                 th:src="#{adminPath}+@{/images/books/}+${cartItem.book.id}+'.png'"
                                                 style="height: 80px">
                                        </a>
                                    </div>
                                    <div class="col-md-5 offset-md-1">
                                        <p>
                                            <span th:text="${cartItem.book.title}"></span><br/>
                                            <span th:if="${cartItem.book.stockNumber&gt;10}" style="color: green">
                                                In Stock
                                            </span>
                                            <span th:if="${cartItem.book.stockNumber&lt;10 and cartItem.book.stockNumber&gt;0}"
                                                  style="color: green">
                                                Only <span th:text="${cartItem.book.stockNumber}" style="color: darkred"></span> In Stock
                                            </span>
                                            <span th:if="${cartItem.book.stockNumber == 0}" style="color: green">
                                                Product unavailable
                                            </span>
                                            <br/>
                                            <span>
                                                <a th:href="@{/shoppingCart/removeItem(id=${cartItem.idCartItem})}">Delete</a>
                                            </span>
                                        </p>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 style="color: #db3208; font-size: large">
                                            $<span th:text="${cartItem.book.ourPrice}"
                                                   th:style="${cartItem.book.stockNumber}==0? 'text-decoration: line-through'"></span>
                                        </h5>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="hidden" name="idCartItem" th:value="${cartItem.idCartItem}">
                                        <h5 style="color: #db3208; font-size: large" th:text="${cartItem.qty}">
                                        </h5>
                                    </div>
                                </div>

                                <!--separation line with the title-->
                                <div class="row">
                                    <div class="col-md-12 separation">
                                        <hr/>
                                    </div>
                                </div>
                                <div class="row">
                                    <h4 class="col-md-12 text-right">
                                        <strong style="font-size: large">Montant Total(<span><?= count($ligne_paniers)?></span> article(s)):</strong>
                                        <span style="color: darkred">
                                            <?= $montant_total?>
                                        </span>
                                    </h4>
                                </div>
                                <br>
                                <button type="submit" class="btn btn-warning btn-block">Soumettre votre commande</button>
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
