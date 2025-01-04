<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/Cart.php");

include '../includes/header.php';

if (!isset($_POST['searched-product'])) {
    $_POST['searched-product'] = "";
}
$id_products = $db->searchProductByName($_POST['searched-product']);
if (!isset($_POST['discount'])) {
    $_POST['discount'] = false;
}
var_dump($_POST);

if (isset($_POST['category'])) {
    $id_products = $db->filteredSearchProduct(name:$_POST['searched-product'], category:$_POST['category'], is_discount:$_POST['discount'], color:$_POST['color'], dimension:$_POST['size']);
    foreach ($id_products as $id) {
        $prod = new Product(...$db->getProduct($id['id_product'])[0]);
        echo $prod->getName();
    }
    echo "Risultati per: " . $_POST['category'];
}
$categories = $db->getAllCategories();
$colors = $db->getAllColors();
$dimensions = $db->getAllDimensions();
?>
<aside>
    <form action="/pages/search.php" method="post">
        <input type="hidden" name="searched-product" value="<?php if (isset($_POST['searched-product'])) echo $_POST['searched-product']; ?>">

        <!-- Category Dropdown -->
        <label for="category">Categoria</label>
        <select id="category" name="category">
            <option value="">Seleziona una categoria</option>
            <?php foreach ($categories as $category) : ?>
                <option <?php if (isset($_POST['category']) && $category["tag"] === $_POST['category']) echo 'selected'; ?>><?= $category['tag'] ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Price Range Slider -->
        <!-- <label>Prezzo Minimo</label>
        <div class="range-container">
            <input type="range" id="minprice" name="minprice" min="0" max="100" value="0">
        </div>
        <label>Prezzo Massimo</label>
        <div class="range-container">
            <input type="range" id="maxprice" name="maxprice" min="0" max="100" value="100">
        </div> -->


        <!-- Discount Checkbox -->
        <label>
            <input type="checkbox" id="discount" name="discount" value="true">
            In sconto
        </label>

        <!-- Vendor Dropdown -->
        <!-- <label for="vendor">Venditore</label>
        <select id="vendor" name="vendor">
            <option value="">Seleziona un venditore</option>
            <option value="vendor1">Venditore 1</option>
            <option value="vendor2">Venditore 2</option>
            <option value="vendor3">Venditore 3</option>
        </select> -->

        <!-- Color Dropdown -->
        <label for="color">Colore</label>
        <select id="color" name="color">
            <option value="">Seleziona un colore</option>
            <?php foreach ($colors as $color) : ?>
                <option value=""><?= $color['color'] ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Size Dropdown -->
        <label for="size">Dimensione</label>
        <select id="size" name="size">
            <option value="">Seleziona una dimensione</option>
            <?php foreach ($dimensions as $dimension) : ?>
                <option value=""><?= $dimension['tag'] ?></option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Applica filtri</button>
    </form>
</aside>

<?=
displayProductPreviews($id_products, $db);
?>

<?php
include '../includes/footer.php';
?>