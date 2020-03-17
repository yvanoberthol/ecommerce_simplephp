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
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fa fa-user-circle"></i>   <?= $_SESSION['client']['nom'].' '.$_SESSION['client']['prenom']?>
                </a>
            </li>
        </ul>
        <?php } ?>
    </div>
</nav>


