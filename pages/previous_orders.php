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
// var_dump($orders);

// for each order, create a label with order date and total price. 
// When the label is clicked, show the order details (products, quantity, total price) through a dropdown menu.
// The dropdown menu should be hidden by default and should be shown when the label is clicked.
// The dropdown menu should be hidden when the label is clicked again.
// The dropdown menu should be hidden when another label is clicked.

// include '../includes/header.php';
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
        ?>
    <?php endforeach; ?>
</div>