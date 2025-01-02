<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/Cart.php");

include '../includes/header.php';

if (isset($_POST['searched-product'])) {
    // echo "Risultati per: " . $_POST['searched-product'];
    $ids = $db->searchProductByName($_POST['searched-product']);
    foreach ($ids as $id) {
        $prod = new Product(...$db->getProduct($id['id_product'])[0]);
        echo $prod->getName();
    }
}
if(isset($_POST['category'])){
    $ids = $db->searchProductByName($_POST['searched-product']);
    foreach ($ids as $id) {
        $prod = new Product(...$db->getProduct($id['id_product'])[0]);
        echo $prod->getName();
    }
    echo "Risultati per: " . $_POST['category'];
}



$categories = $db->getAllCategories();
$colors = $db->getAllColors();
$dimensions = $db->getAllDimensions();
// var_dump($categories);
?>

<form action="/pages/search.php" method="post">
    <aside>
        <!-- Category Dropdown -->
        <label for="category">Categoria</label>
        <select id="category" name="category">
            <option value="">Seleziona una categoria</option>
            <?php foreach ($categories as $category) : ?>
                <option><?= $category['tag'] ?></option>
            <?php endforeach; ?>
        </select>

        <!-- Price Range Slider -->
        <label>Prezzo Minimo</label>
        <div class="range-container">
            <input type="range" id="minprice" name="minprice" min="0" max="100" value="50">
        </div>
        <label>Prezzo Massimo</label>
        <div class="range-container">
            <input type="range" id="maxprice" name="maxprice" min="0" max="100" value="50">
        </div>


        <!-- Discount Checkbox -->
        <label>
            <input type="checkbox" id="discount" name="discount">
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
                <option value=""><?= $color['tag'] ?></option>
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
<?php
include '../includes/footer.php';
?>