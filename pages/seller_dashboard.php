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

if (isset($_POST["delete"])) {
    $db->seller->deleteProduct($_POST["id_product"]);
    echo "Prodotto cancellato con successo!";
}

$id_products = $db->seller->getProductsSoldBy($_SESSION["email"]);
include("../includes/header.php");
?>

<div>
    <h1>Benvenuto <?= $_SESSION["name"] ?></h1>
</div>

<form action="/pages/add_product.php" method="GET">
    <input type="submit" value="Aggiungi Prodotto" class="btn btn-info" />
</form>
<?=
displayProductPreviews($id_products, $db, true);
?>

<?php
include("../includes/footer.php");
?>