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


$productList = $db->getProduct($_GET["id"]);

if (count($productList) == 0) {
    echo "Prodotto non trovato!";
    exit();
}


include("../includes/header.php");

$products = $db->seller->getProductsSoldBy($_SESSION["email"]);
print_r($products);
?>

<div>
    <h1>Benvenuto <?= $_SESSION["name"] ?></h1>
</div>

<?php foreach ($products as $product_id): ?>
    <p>
        <?php
        $prod = new Product(...$db->getProduct($product_id['id_product'])[0]);
        echo $prod->getName();
        ?>
    </p>
<?php endforeach; ?>



<?php
include("../includes/footer.php");
?>