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
    // TODO: pensare a come gestire uno che ha già il prodotto nel carrello ma vuole cambiare la quantità
    if (isset($_POST["add_to_cart"]) && !$db->isProductInCart($_SESSION["email"], $product->getId())) {
        $db->addProductToCart($_SESSION["email"], $product->getId(), $_POST["quantity"]);
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

    if (isset($_POST["action"])) {
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
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $queryString = $_SERVER['QUERY_STRING'];
    $url = $_SERVER['PHP_SELF'] . ($queryString ? '?' . $queryString : '');
    header("Location: " . $url);
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
            <?php if (!$product->isRemoved()): ?>
                <p><strong>Quantit&agrave; disponibile:</strong> <?= $product->getAvailability() ?></p>
            <?php endif; ?>
            <p><strong>Venditore:</strong> <?= htmlspecialchars($product->getSellerEmail()) ?></p>

            <?php if (isUserLoggedIn() && !$product->isRemoved()): ?>
                <?php if ($db->isProductInCart($_SESSION['email'], $product->getId())): ?>
                    <p class="text-success"><strong>Il prodotto è nel carrello</strong></p>
                    <?php $cartProduct = $db->getCartProduct($_SESSION['email'], $product->getId())[0]; ?>
                    <form method="POST" class="d-inline-block">
                        <div class="d-flex align-items-center">
                            <button type="submit" name="action" value="decrease_cart" class="btn btn-danger me-3" <?php echo $cartProduct['quantity'] <= 1 ? 'disabled' : ''; ?>>-</button>
                            <h2 class="display-6 mb-0"><?php echo $cartProduct['quantity']; ?></h2>
                            <button type="submit" name="action" value="increase_cart" class="btn btn-success ms-3" <?php echo $product->getAvailability() <= 0 ? 'disabled' : ''; ?>>+</button>
                        </div>
                    </form>
                    <form action="#" method="post">
                        <input type="hidden" name="remove_from_cart" value="true">
                        <button type="submit" class="btn btn-danger">Rimuovi dal carrello</button>
                    </form>
                <?php elseif ($product->getAvailability() > 0): ?>
                    <form action="#" method="post">
                        <label for="quantity">Quantit&agrave;:</label>
                        <input type="number" id="quantity" name="quantity" class="form-control" value="1" min="1" max=<?= $product->getAvailability() ?> />
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
                        <button type="submit" class="btn btn-info">Aggiungi alla wishlist</button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>

            <?php if ($product->isRemoved()): ?>
                <p class="text-danger"><strong>Il prodotto è stato rimosso dal venditore</strong></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
include '../includes/footer.php';
?>