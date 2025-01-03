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
    $db->seller->updateProduct($_GET["id_product"], $_POST["name"], $_POST["description"], $_POST["price"], $imageName);
    echo "Prodotto aggiotnato con successo!";
}

$productList = $db->getProduct($_GET["id_product"]);
if (count($productList) == 0) {
    echo "Prodotto non trovato!";
    exit();
}
$product = new Product(...$productList[0]);
include("../includes/header.php");
?>
<form action="#" method="POST" enctype="multipart/form-data">
    <h2>Modifica Prodotto</h2>
    <ul>
        <li>
            <label for="name">Nome:</label><input type="text" id="name" name="name" value="<?= $product->getName() ?>" />
        </li>
        <li>
            <label for="description">Descrizione:</label><input type="text" id="description" name="description" value="<?= $product->getDescription() ?>" />
        </li>
        <li>
            <label for="price">Prezzo:</label><input type="number" id="price" name="price" value="<?= $product->getPrice() ?>" />
        </li>
        <li>
            <label for="price">Sconto:</label><input type="number" id="discount" name="discount" value="<?= $product->getDiscount() ?>" />
        </li>
        <li>
            <label for="price">Immagine:</label>
            <img src="<?= $product->getImg(); ?>" alt="" style="max-width:100px" />
            <input type="file" name="image" id="image" accept="image/*" />
        </li>
        <li>
            <input type="submit" name="submit" value="Salva" />
        </li>
    </ul>
</form>

<?php
include("../includes/footer.php");
?>