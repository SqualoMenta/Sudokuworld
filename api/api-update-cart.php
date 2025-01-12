<?php
include_once "../includes/bootstrap.php";
include_once "../database/Database.php";
include_once "../includes/functions.php";
require_once("../classes/Product.php");
require_once("../classes/ProductList.php");

$sudoku_solved = $db->sudokuRunner->isTodaySudokuWon($_SESSION["email"]);

if (isUserLoggedIn()) {
    // echo ("hello");
    var_dump($_POST);
    if (isset($_POST["count"]) && isset($_POST["id_product"])) {
        $db->updateQuantityInCart($_SESSION["email"], $_POST["id_product"], $_POST["count"]);
        // echo "ok";
        $cart = new ProductList($db->getCart($_SESSION["email"]));
        $price = number_format($cart->getTotalPrice($db, $sudoku_solved), 2);
        echo($price);
    }
}

?>