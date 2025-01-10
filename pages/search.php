<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/ProductList.php");

include '../includes/header.php';

if (!isset($_POST['searched-product'])) {
    $_POST['searched-product'] = "";
}
$id_products = $db->searchProductByName($_POST['searched-product']);
if (!isset($_POST['discount'])) {
    $_POST['discount'] = false;
}

if (isset($_POST['category'])) {
    $id_products = $db->filteredSearchProduct(name:$_POST['searched-product'], category:$_POST['category'], is_discount:$_POST['discount']);
    foreach ($id_products as $id) {
        $prod = new Product(...$db->getProduct($id['id_product'])[0]);
    }
    // echo "Risultati per: " . $_POST['category'];
}
$sudoku_solved = false;
if(isUserLoggedIn()) {
    $sudoku_solved = $db->sudokuRunner->isTodaySudokuWon($_SESSION["email"]);
}
$categories = $db->getAllCategories();
?>
<aside>
    <form action="/pages/search.php" method="post">
        <input type="hidden" name="searched-product" value="<?php if (isset($_POST['searched-product'])) echo $_POST['searched-product']; ?>">

        <!-- Category Dropdown -->
        <label for="category">Categoria</label>
        <select id="category" name="category">
            <option value="">Seleziona una categoria</option>
            <?php foreach ($categories as $category) : ?>
                <option <?php if (isset($_POST['category']) && $category["category_tag"] === $_POST['category']) echo 'selected'; ?>><?= $category['category_tag'] ?></option>
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
    </form>
</aside>

<?=
displayProductPreviews($id_products, $db, $sudoku_solved);
?>

<?php
include '../includes/footer.php';
?>