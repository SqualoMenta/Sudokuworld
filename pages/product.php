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
$sudoku_solved = false;
if (isUserLoggedIn()) {
    if (isset($_POST["add_to_cart"]) && !$db->isProductInCart($_SESSION["email"], $product->getId())) {
        $db->addProductToCart($_SESSION["email"], $product->getId());
    }

    if (isset($_POST["remove_from_cart"]) && $db->isProductInCart($_SESSION["email"], $product->getId())) {
        $db->removeProductFromCart($_SESSION["email"], $product->getId());
    }

    if (isset($_POST["add_to_wishlist"]) && !$db->isProductInWishlist($_SESSION["email"], $product->getId())) {
        $db->addProductToWishlist($_SESSION["email"], $product->getId());
    }

    if (isset($_POST["remove_from_wishlist"]) && $db->isProductInWishlist($_SESSION["email"], $product->getId())) {
        $db->removeProductFromWishlist($_SESSION["email"], $product->getId());
    }
    $sudoku_solved = $db->sudokuRunner->isTodaySudokuWon($_SESSION["email"]);
}

include '../includes/header.php';
?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <img src="<?= htmlspecialchars($product->getImg()) ?>" class="img-fluid" alt="<?= htmlspecialchars($product->getName()) ?>">
        </div>
        <div class="col-md-6">
            <h2><?= htmlspecialchars($product->getName()) ?></h2>
            <p><strong>Descrizione:</strong> <?= htmlspecialchars($product->getDescription()) ?></p>
            <p><strong>Prezzo:</strong> $<?= number_format($product->getPrice(), 2) ?></p>

            <?php if ($product->getDiscount() > 0): ?>
                <p class="text-danger"><strong>Prezzo scontato:</strong> $<?= number_format($product->getFinalPrice($sudoku_solved), 2) ?> (<?= $product->getDiscount($sudoku_solved) ?>% off)</p>
            <?php endif; ?>

            <p><strong>Venditore:</strong> <?= htmlspecialchars($product->getSellerEmail()) ?></p>

            <?php if (isUserLoggedIn()): ?>
                <?php if ($db->isProductInCart($_SESSION['email'], $product->getId())): ?>
                    <form action="#" method="post">
                        <input type="hidden" name="remove_from_cart" value="true">
                        <button type="submit" class="btn btn-danger">Rimuovi dal carrello</button>
                    </form>
                <?php else: ?>
                    <form action="#" method="post">
                        <input type="hidden" name="add_to_cart" value="true">
                        <button type="submit" class="btn btn-primary">Aggiungi al carrello</button>
                    </form>
                <?php endif; ?>

                <?php if ($db->isProductInWishlist($_SESSION['email'], $product->getId())): ?>
                    <form action="#" method="post">
                        <input type="hidden" name="remove_from_wishlist" value="true">
                        <button type="submit" class="btn btn-warning">Rimuovi dalla wishlist</button>
                    </form>
                <?php else: ?>
                    <form action="#" method="post">
                        <input type="hidden" name="add_to_wishlist" value="true">
                        <button type="submit" class="btn btn-secondary">Aggiungi alla wishlist</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>