<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/ProductList.php");

if (isset($_POST['searched-product'])) {
    header("Location: search.php");
}

$bestSellers = [];
$bestSellersId = $db->getMostSoldProducts();
foreach ($bestSellersId as $key => $value) {
    $productData = $db->getProduct($value['id_product'])[0];
    $prod = new Product(...$productData);
    array_push($bestSellers, $prod);
}

$specialProducts = [];
$specialProductsId = [4, 5];
foreach ($specialProductsId as $key => $value) {
    $productData = $db->getProduct($value)[0];
    $prod = new Product(...$productData);
    array_push($specialProducts, $prod);
}

?>
<?php
include '../includes/header.php';
?>

<main>
    <div class="container">
        <div id="specialProductsCarousel" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <?php
                foreach ($specialProducts as $key => $product):
                ?>
                    <li data-bs-target="#specialProductsCarousel" data-bs-slide-to="<?= $key ?>" <?php if ($key == 0) echo ('class="active"') ?>></li>
                <?php endforeach; ?>
            </ol>
            <div class="carousel-inner">
                <?php
                foreach ($specialProducts as $key => $product):
                ?>
                    <div class="carousel-item <?php if ($key == 0) echo ('active') ?>">
                        <a href="product.php?id=<?= $product->getId() ?>"><img src="<?= htmlspecialchars($product->getImg()) ?>" class="carousel-img" alt="<?= $product->getName()?>"></a>
                        <div class="carousel-caption">
                            <h3 class="caption-text" ><?= htmlspecialchars($product->getName()) ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#specialProductsCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#specialProductsCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="row m-4 equal-container">
            <div class="col-lg-4 mb-4">
                <div class="container border-box">
                    <figure>
                        <figcaption>
                            <h2>Sudoku del giorno</h2>
                        </figcaption>
                        <a href="/pages/sudoku.php">
                            <img src="/uploads/SudokuExample.png" class="img-fluid img-box" alt="Sudoku del giorno">
                        </a>
                    </figure>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="container border-box">
                    <figure>
                        <figcaption>
                            <h2>Vai al Profilo</h2>
                        </figcaption>
                        <div class="container">
                            <a href="/pages/profile.php">
                                <img src="/uploads/Profile.jpg" class="img-fluid img-box" alt="Profilo">
                            </a>
                        </div>
                    </figure>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="container border-box">
                    <figure>
                        <figcaption>
                            <h2>Esplora</h2>
                        </figcaption>
                        <div class="container">
                            <a href="/pages/search.php">
                                <img src="/uploads/Esplora.png" class="img-fluid img-box" alt="Esplora">
                            </a>
                        </div>
                    </figure>
                </div>
            </div>
        </div>
        <h2> I più venduti </h2>
        <div id="bestSellersCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
            <div class="carousel-inner">
                <?php
                foreach ($bestSellers as $key => $product):
                ?>
                    <div class="carousel-item <?php if ($key == 0) echo ('active') ?>">
                        <a href="product.php?id=<?= $product->getId() ?>"><img src="<?= htmlspecialchars($product->getImg()) ?>" class="carousel-img" alt="<?= $product->getName() ?>"></a>
                        <div class="carousel-caption">
                            <h3 class="caption-text"><?= htmlspecialchars($product->getName()) ?></h3>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <a class="carousel-control-prev" href="#bestSellersCarousel" role="button" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#bestSellersCarousel" role="button" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>

</main>

<?php
include '../includes/footer.php';
?>
