<?php

include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
if (!isUserLoggedIn()) {
    header("Location: login.php");
}
if (!$_SESSION["is_seller"]) {
    echo "Non sei un venditore, non puoi accedere a questa pagina!";
    die();
}
if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $imageName = "/uploads/products/" . uploadImage("../uploads/products/", $_FILES["image"])[1];
}

if (isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["price"]) && isset($_POST["discount"])) {
    // TODO: mi sa che sta roba si può rompere
    $imageName = $imageName ?? null;
    $_POST["price"] = 100 * $_POST["price"];
    $db->seller->insertProduct($_POST["name"], $_POST["description"], $_POST["price"], $imageName, $_SESSION["email"], $_POST["discount"]);
    echo "Prodotto inserito con successo!";
}
$product = new Product(null, '', 0, '', '', $_SESSION["email"], 0);
include("../includes/header.php");
?>

<?= $product->displayEditForm("Inserisci prodotto") ?>

<?php
include("../includes/footer.php");
?>