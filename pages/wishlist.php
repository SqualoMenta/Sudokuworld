<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/ProductList.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
}

$sudoku_solved = $db->sudokuRunner->isTodaySudokuWon($_SESSION["email"]);
$cart = new ProductList($db->getWishlist($_SESSION["email"]));
$products = $cart->getProducts();
include '../includes/header.php';

?>
<?php if (empty($products)) : ?>
    <h1>La lista desideri è vuota</h1>
<?php else: ?>

<?php displayProductPreviews($products, $db, $sudoku_solved); ?>

<?php endif; ?>

<?php
include '../includes/footer.php';
?>