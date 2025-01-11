<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/ProductList.php");

if (isset($_POST['searched-product'])) {
    header("Location: search.php");
}

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

<body>
    <div class="container">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/uploads/products/5090.jpg" class="img-fluid w-100" alt="First slide"
                        style="aspect-ratio: 21 / 9; object-fit: cover; object-position: center center; overflow: hidden;">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Nome del prodotto speciale</h5>
                        <p>...</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/uploads/products/copricerchi.jpg" class="img-fluid w-100" alt="First slide"
                        style="aspect-ratio: 21 / 9; object-fit: cover; object-position: center center; overflow: hidden;">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>Nome del prodotto speciale</h5>
                        <p>...</p>
                    </div>
                </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>

        <div class="row mt-4">
            <div class="col-md-4">
                <div class="category-box">Vai al sudoku del giorno</div>
            </div>
            <div class="col-md-4">
                <div class="category-box">Ultimi prodotti visitati</div>
            </div>
            <div class="col-md-4">
                <div class="category-box">Offerte speciali</div>
            </div>
        </div>

        <div class="row mt-4">
            <div class="col">
                <div class="category-box">Passatempo</div>
            </div>
            <div class="col">
                <div class="category-box">Abbigliamento</div>
            </div>
            <div class="col">
                <div class="category-box">Cucina</div>
            </div>
            <div class="col">
                <div class="category-box">Per Lei</div>
            </div>
            <div class="col">
                <div class="category-box">Feste</div>
            </div>
        </div>

        <div id="bestSellersCarousel" class="carousel slide mt-4" data-bs-ride="carousel">
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

</body>


<?php
include '../includes/footer.php';
?>