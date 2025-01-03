<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/Cart.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
}

$cart = new Cart($db->getCart($_SESSION["email"]));
$products = $cart->getProducts();
include '../includes/header.php';

?>
<?= displayProductPreviews($products, $db) ?>

<?php
include '../includes/footer.php';
?>