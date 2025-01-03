<?php
include_once("../includes/bootstrap.php");
require_once("../includes/functions.php");
require_once("../classes/Product.php");
$productList = $db->getProduct($_GET["id"]);

if (count($productList) == 0) {
    echo "Prodotto non trovato!";
    exit();
}

$product = new Product(...$productList[0]);
if (isUserLoggedIn()) {
    if (isset($_POST["add_to_cart"]) && !$db->isProductInCart($_SESSION["email"], $product->getId())) {
        $db->addProductToCart($_SESSION["email"], $product->getId());
    }

    if (isset($_POST["remove_from_cart"]) && $db->isProductInCart($_SESSION["email"], $product->getId())) {
        $db->removeProductFromCart($_SESSION["email"], $product->getId());
    }
}

include '../includes/header.php';
?>

<?php $product->displayFullPage($db) ?>

<?php
include '../includes/footer.php';
?>