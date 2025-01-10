<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/ProductList.php");
// TODO: fare redirect a se stessi in tutte le pagine dopo una post in modo che non ho la form resubmissione query multiple

if (!isUserLoggedIn()) {
    header("Location: login.php");
}

$sudoku_solved = $db->sudokuRunner->isTodaySudokuWon($_SESSION["email"]);
$cart = new ProductList($db->getCart($_SESSION["email"]));
$products = $cart->getProducts();
include '../includes/header.php';

?>

<?php if (empty($products)) : ?>
    <h1>Il carrello è vuoto</h1>
<?php else: ?>
    <div>
        <h1> Prezzo totale: $<?= number_format($cart->getTotalPrice($db, $sudoku_solved), 2) ?> </h1>
        <a href="/pages/checkout.php" class="btn btn-info">Vai al checkout</a>
    </div>
<?php endif; ?>

<!-- TODO mostrare la quantità -->
<?= displayProductPreviews($products, $db, $sudoku_solved) ?>

<?php
include '../includes/footer.php';
?>