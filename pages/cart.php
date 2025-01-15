<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/ProductList.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
}

if(isset($_POST['remove_cart'])){
    $db->removeProductFromCart($_SESSION["email"], $_POST['id_product']);
}

if (isset($_POST["action"])) {
    $product = new Product(...$db->getProduct($_POST["id_product"])[0]);
    if ($_POST["action"] === "increase_cart") {
        $cartProduct = $db->getCartProduct($_SESSION['email'], $product->getId())[0];
        if ($cartProduct['quantity'] < $product->getAvailability()) {
            $db->updateQuantityInCart($_SESSION["email"], $product->getId(), $cartProduct['quantity'] + 1);
        }
    } elseif ($_POST["action"] === "decrease_cart") {
        $cartProduct = $db->getCartProduct($_SESSION['email'], $product->getId())[0];
        if ($cartProduct['quantity'] > 1) {
            $db->updateQuantityInCart($_SESSION["email"], $product->getId(), $cartProduct['quantity'] - 1);
        }
    }
}


$sudoku_solved = $db->sudokuRunner->isTodaySudokuWon($_SESSION["email"]);
$cart = new ProductList($db->getCart($_SESSION["email"]));
$products = $cart->getProducts();
include '../includes/header.php';

?>
<main>
<div class="container text-center">
    <?php if (empty($products)) : ?>
        <h1>Il carrello è vuoto</h1>
    <?php else: ?>
        <div>
            <h1 id='price'>Prezzo totale: $<?= number_format($cart->getTotalPrice($db, $sudoku_solved), 2) ?></h1>
            <a href="/pages/checkout.php" class="btn btn-info">Vai al checkout</a>
        </div>
    <?php endif; ?>
</div>
<?= displayProductPreviews($products, $db, $sudoku_solved, is_cart: true) ?>
</main>



<?php
include '../includes/footer.php';
?>