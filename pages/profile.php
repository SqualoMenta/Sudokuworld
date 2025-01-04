<?php

include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
}
include("../includes/header.php");
?>

<div>
    <h1>Benvenuto <?= $_SESSION["name"] ?></h1>
    <aside>
        <div>
            <a href="">Informazioni</a>
        </div>
        <div>
            <a href="">I miei ordini</a>
        </div>
        <div>
            <a href="">Lista desideri</a>
        </div>
        <div>
            <a href="cart.php">Carrello</a>
        </div>
        <div>
            <a href="logout.php">Esci</a>
        </div>
    </aside>

    <?php if ($_SESSION["is_seller"]): ?>
        <div>
            <a href="seller_dashboard.php"> Dashboard</a>
        </div>
    <?php endif; ?>


    <?php
    include("../includes/footer.php");
    ?>