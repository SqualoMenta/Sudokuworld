<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/ProductList.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
}

$cart = new ProductList($db->getWishlist($_SESSION["email"]));
$products = $cart->getProducts();
include '../includes/header.php';

?>
<?= displayProductPreviews($products, $db) ?>

<?php
include '../includes/footer.php';
?>