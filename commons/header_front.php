<?php
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">
        <img src="Assets/photos/logo%20innova.png" alt="" width="50px" height="50px">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
            </li>
        </ul>
        <?php if (isset($_SESSION['client'])){?>
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="yourCart.php">
                    <i class="fa fa-shopping-cart"></i> Panier
                    <span class="badge badge-success">
                        <span id="nbrePanier"></span>
                    </span>
                </a>
            </li>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-user-circle"></i> <?= $_SESSION['client']['nom'].' '.$_SESSION['client']['prenom']?>
                </a>
                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                    <a class="dropdown-item" href="modifierCompte.php">
                       <i class="fa fa-table"></i> Mon compte
                    </a>
                    <a class="dropdown-item" href="changePassword.php">
                        <i class="fa fa-key"></i> Changer mes identifiants
                    </a>
                    <a class="dropdown-item" href="logout.php">
                       <i class="fa fa-sign-out"></i> Déconnexion
                    </a>
                </div>
            </div>
        </ul>
        <?php } else { ?>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="inscription.php">
                        <i class="fa fa-user-circle-o"></i> S'inscrire
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="connexion.php">
                        <i class="fa fa-sign-in"></i> Se connecter
                    </a>
                </li>
            </ul>
        <?php }?>
    </div>
</nav>


