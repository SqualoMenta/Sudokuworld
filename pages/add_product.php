<?php

include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
if (!isUserLoggedIn()) {
    header("Location: login.php");
}
if (!$_SESSION["is_seller"]) {
    echo "Non sei un venditore, non puoi accedere a questa pagina!";
    die();
}
include("../includes/header.php");

if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $imageName = "/uploads/products/" . uploadImage("../uploads/products/", $_FILES["image"])[1];
}

if (isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["price"]) && isset($_POST["discount"])) {
    $_POST["price"] = 100 * $_POST["price"];
    $db->seller->insertProduct($_POST["name"], $_POST["description"], $_POST["price"], $_POST["category"], $imageName, $_SESSION["email"], $_POST["discount"], $_POST["availability"]);
    echo '<div class="alert alert-success mt-4">
                    <p>Prodotto inserito con successo!</p>
                </div>';  
}
$product = new Product(null, '', 100, '', '', $_SESSION["email"], '', 0, 10);
$categories = $db->getAllCategories();

// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     header("Location: seller_dashboard.php");
// }


?>

<main>
    <?= displayEditForm($product, "Inserisci prodotto", $categories) ?>
</main>
<?php
include("../includes/footer.php");
?>