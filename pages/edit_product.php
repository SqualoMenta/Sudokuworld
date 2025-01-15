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
if (isset($_FILES["image"]) && $_FILES["image"]["error"] == 0) {
    $imageName = "/uploads/products/" . uploadImage("../uploads/products/", $_FILES["image"])[1];
}

$productList = $db->getProduct($_GET["id_product"]);
if (count($productList) == 0) {
    echo "Prodotto non trovato!";
    die();
}
$product = new Product(...$productList[0]);
if ($product->getSellerEmail() != $_SESSION["email"]) {
    echo "Non sei il venditore di questo prodotto!";
    die();
}
if ($product->isRemoved()) {
    echo "Il prodotto è stato rimosso!";
    die();
}

if (isset($_POST["name"]) && isset($_POST["description"]) && isset($_POST["price"]) && isset($_POST["discount"])) {
    $imageName = $imageName ?? null;
    $_POST["price"] = 100 * $_POST["price"];
    $db->seller->updateProduct($_GET["id_product"], $_POST["name"], $_POST["description"], $_POST["price"], $imageName, $_POST["category"], $_POST["discount"], $_POST["availability"]);
    $db->addNotificationProductUpdated($_GET["id_product"]);
    handleProductAvailabilityUpd($db, $_GET["id_product"]);
}

$categories = $db->getAllCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $queryString = $_SERVER['QUERY_STRING'];
    $url = $_SERVER['PHP_SELF'] . ($queryString ? '?' . $queryString : '');
    header("Location: " . $url);
}

include("../includes/header.php");
?>
<main>
<?= displayEditForm($product, "Modifica prodotto", $categories) ?>
</main>
<?php
include("../includes/footer.php");
?>