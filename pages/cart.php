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
<?php foreach ($products as $product_id): ?>
    <p>
        <?php
        $prod = new Product(...$db->getProduct($product_id['id_product'])[0]);
        echo $prod->getName();
        ?>
    </p>
<?php endforeach; ?>

<?php
include '../includes/footer.php';
?>