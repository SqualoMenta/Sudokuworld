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

if (isset($_POST["delete"])) {
    $db->seller->deleteProduct($_POST["id_product"]);
    $users_with_deleted_product_in_cart = $db->getUsersWithProductInCart($_POST["id_product"]);
    $users_with_deleted_product_in_wishlist = $db->getUsersWithProductInWishlist($_POST["id_product"]);
    $deleted_product  = $db->getProduct($_POST["id_product"]);
    var_dump($deleted_product);
    foreach ($users_with_deleted_product_in_cart as $user) {
        $db->removeProductFromCart($user['email'], $_POST["id_product"]);
        $db->addNotification($user["email"], "Prodotto cancellato", "Il seguente prodotto che avevi messo nel carrello e' stato cancellato dal venditore: ". $deleted_product[0]["name"]);
    }
    foreach ($users_with_deleted_product_in_wishlist as $user) {
        $db->removeProductFromWishlist($user['email'], $_POST["id_product"]);
        $db->addNotification($user["email"], "Prodotto cancellato", "Il seguente prodotto che avevi messo nella lista desideri e' stato cancellato dal venditore: ". $deleted_product[0]["name"]);

    }
    echo "Prodotto cancellato con successo!";
}

$id_products = $db->seller->getProductsSoldBy($_SESSION["email"]);
include("../includes/header.php");
?>

<div>
    <h1>Benvenuto <?= $_SESSION["name"] ?></h1>
</div>

<form action="/pages/add_product.php" method="GET">
    <input type="submit" value="Aggiungi Prodotto" class="btn btn-info" />
</form>
<?=
displayProductPreviews($id_products, $db, false, true);
?>

<?php
include("../includes/footer.php");
?>