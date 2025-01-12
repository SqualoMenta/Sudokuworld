<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/ProductList.php");

if (isset($_POST['searched-product'])) {
    header("Location: search.php");
}

?>
<!DOCTYPE html>
<?php
include '../includes/header.php';

?>
<!-- <body>
<div class="container mt-4">
    <h1>Benvenuti</h1>
    <article>Vai al Sudoku del giorno</article>
    <article>Offerte speciali</article>

    <article>Passatempo</article>
    <article>Abbigliamento</article>
    <article>Cucina</article>
    <article>Per Lei</article>
    <article>Feste</article>
</div>
</body> -->

<main>
    <div class="container">
        <div id="specialProductsCarousel" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-bs-target="#specialProductsCarousel" data-bs-slide-to="0" class="active"></li>
                <li data-bs-target="#specialProductsCarousel" data-bs-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/uploads/products/5090.jpg" class="d-block w-100" alt="First slide"
                        style="aspect-ratio: 21 / 9; object-fit: cover; object-position: center center; overflow: hidden;">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Nome del prodotto speciale</h5>
                        <p>...</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/uploads/products/copricerchi.jpg" class="d-block w-100" alt="Second slide"
                        style="aspect-ratio: 21 / 9; object-fit: cover; object-position: center center; overflow: hidden;">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Nome del prodotto speciale</h5>
                        <p>...</p>
                    </div>
                </div>
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
                <div class="container border border-primary p-4 rounded h-100" style="aspect-ratio: 1;">
                    <figure>
                        <figcaption>
                            <h3> Sudoku del giorno</h3>
                        </figcaption>
                        <a href="/pages/sudoku.php">
                            <img src="/uploads/SudokuExample.png" class="img-fluid mx-auto p-4 w-100" alt="">
                        </a>
                    </figure>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="container border border-primary p-4 rounded h-100" style="aspect-ratio: 1;">
                    <h3>Vai al Profilo</h3>
                    <div class="container">
                        <a href="/pages/profile.php">
                            <img src="/uploads/Profile.jpg" class="img-fluid w-100 p-4" alt="" style="max-height: 100%;">
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mb-4">
                <div class="container border border-primary p-4 rounded h-100" style="aspect-ratio: 1;">
                    <h3>Esplora</h3>
                    <div class="container">
                        <a href="/pages/search.php">
                            <img src="/uploads/Esplora.png" class="img-fluid w-100 p-4 bg-white" alt="" style="max-height: 100%;">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row m-4 equal-container">
            <div class="col mb-4">
                <div class="container border border-dark p-4 rounded h-100" style="aspect-ratio: 1;">Passatempo</div>
            </div>
            <div class="col mb-4">
                <div class="container border border-dark p-4 rounded h-100" style="aspect-ratio: 1;">Abbigliamento</div>
            </div>
            <div class=" col mb-4">
                <div class="container border border-dark p-4 rounded h-100" style="aspect-ratio: 1;">Cucina</div>
            </div>
            <div class=" col mb-4">
                <div class="container border border-dark p-4 rounded h-100" style="aspect-ratio: 1;">Per Lei</div>
            </div>
            <div class=" col mb-4">
                <div class="container border border-dark p-4 rounded h-100" style="aspect-ratio: 1;">Feste</div>
            </div>
        </div>

        <div id=" bestSellersCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
            <h2>Carosello dei più venduti</h2>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <span>Contenuto Slide 1 Più Venduti</span>
                </div>
                <div class="carousel-item">
                    <span>Contenuto Slide 2 Più Venduti</span>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#bestSellersCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Precedente</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#bestSellersCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Successivo</span>
            </button>
        </div>
    </div>

</main>


<?php
include '../includes/footer.php';
?>