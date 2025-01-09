<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
include_once("../classes/Product.php");
include_once("../classes/ProductList.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}
$orders = $db->getOrders($_SESSION["email"]);
?>

<div>
    <h1>I miei ordini</h1>
    <?php foreach ($orders as $order) : ?>
        <?php
            $products = $db->getOrderProducts($order["id_order"]);
        ?>
            <label>Data: <?= $order["day"] ?> - Ordine numero: <?= $order["id_order"] ?> Prezzo Ordine: <?= $order["price"] ?>$</label>
            <div>
                <?php displayProductPreviews($products, $db, false);?>
            </div>
    <?php endforeach; ?>
</div>