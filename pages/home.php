<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/Cart.php");

if(isset($_POST['searched-product'])){
    header("Location: search.php");
}

include '../includes/header.php';

?>
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
<?php
include '../includes/footer.php';
?>