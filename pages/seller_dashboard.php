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
    echo "Prodotto cancellato con successo!";
}

$products = $db->seller->getProductsSoldBy($_SESSION["email"]);
include("../includes/header.php");
?>

<div>
    <h1>Benvenuto <?= $_SESSION["name"] ?></h1>
</div>

<?php foreach ($products as $product_id): ?>
    <form>
        <label>
            <?php
            $prod = new Product(...$db->getProduct($product_id['id_product'])[0]);
            echo $prod->getName();
            ?>
        </label>
        <input type="hidden" name="id_product" value="<?= $product_id['id_product'] ?>" />
        <input type="submit" value="Modifica" formaction="/pages/edit_product.php" formmethod="GET" />
        <input type="submit" value="Elimina" formaction="#" formmethod="POST" name="delete"/>
    </form>
<?php endforeach; ?>



<?php
include("../includes/footer.php");
?>