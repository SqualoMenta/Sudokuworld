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
    $imageName = $imageName ?? null;
    $_POST["price"] = 100 * $_POST["price"];
    $db->seller->updateProduct($_GET["id_product"], $_POST["name"], $_POST["description"], $_POST["price"], $imageName, $_POST["category"], $_POST["discount"], $_POST["availability"]);
    echo "Prodotto aggiotnato con successo!";
}

$productList = $db->getProduct($_GET["id_product"]);
if (count($productList) == 0) {
    echo "Prodotto non trovato!";
    exit();
}
$product = new Product(...$productList[0]);
$categories = $db->getAllCategories();
include("../includes/header.php");
?>

<?= $product->displayEditForm("Modifica prodotto", $categories) ?>

<?php
include("../includes/footer.php");
?>