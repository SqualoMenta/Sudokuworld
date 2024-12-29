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
if (isUserLoggedIn() && isset($_POST["add_to_cart"])) {
    $db->addProductToCart($_SESSION["email"], $product->getId());
}

include '../includes/header.php';
?>

<div>
    <h1><?= $product->getName(); ?></h1>
    <div class="product-info">
        <img src="<?= $product->getImg(); ?>" alt="">
        <div>
            <p>Prezzo: <strong>&euro;<?= $product->getPrice(); ?></strong></p>
            <p>Disponibilità: <strong>Disponibile</strong></p>
            <?php if (isUserLoggedIn() && !$db->isProductInCart($_SESSION['email'], $product->getId())): ?>
                <form action="#" method="post">
                    <input type="hidden" name="add_to_cart" value=true>
                    <button type="submit">Aggiungi al carrello</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <div>
        <p><?= $product->getDescription(); ?></p>
        <p> Venduto da: <?= $product->getSellerEmail(); ?></p>
    </div>

</div>
<?php
include '../includes/footer.php';
?>