<?php
include_once("../includes/bootstrap.php");
require_once("../classes/Product.php");
$db->insertProduct("RivistaFacile", 3, "Rivista per principianti", "link", 1);
$productList = $db->getProduct($_GET["id"]);

if (count($productList) == 0) {
    echo "Prodotto non trovato!";
    exit();
}
// print_r($productList[0]);

$product = new Product(...$productList[0]);
// print_r($product->getDescription());

include '../includes/header.php';
?>

<div>
    <h1><?= $product->getName(); ?></h1>
    <div class="product-info">
        <img src="<?= $product->getImg(); ?>" alt="">
        <div>
            <p>Prezzo: <strong>&euro;<?= $product->getPrice(); ?></strong></p>
            <!-- TODO -->
            <p>Disponibilità: <strong>Disponibile</strong></p> 
            <button>Aggiungi al carrello</button>

        </div>
    </div>
    <div>
        <p><?= $product->getDescription();?></p>
    </div>

</div>
<?php
include '../includes/footer.php';
?>