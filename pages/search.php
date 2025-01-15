<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/ProductList.php");

$max_price = $db->getMaxPrice()[0]["max_price"]/100;
// var_dump($max_price);   
// TODO: aggiungere filtro per prezzo, volendo anche sortare per più venduti
$selected_searched_product = isset($_POST['searched-product']) ? $_POST['searched-product'] : "";
$selected_category = isset($_POST['category']) ? $_POST['category'] : "";
$selected_min_price = isset($_POST['minprice']) ? $_POST['minprice'] : 0;
$selected_max_price = isset($_POST['maxprice']) ? $_POST['maxprice'] : $max_price;
$selected_is_discount = isset($_POST['discount']) ? 1 : 0;



$id_products = $db->filteredSearchProduct(name: $selected_searched_product, minPrice: $selected_min_price * 100, maxPrice: $selected_max_price * 100, category: $selected_category, is_discount: $selected_is_discount);
$sudoku_solved = false;
if (isUserLoggedIn()) {
    $sudoku_solved = $db->sudokuRunner->isTodaySudokuWon($_SESSION["email"]);
}

$categories = $db->getAllCategories();
// if ($_SERVER['REQUEST_METHOD'] === 'POST') {
//     $queryString = $_SERVER['QUERY_STRING'];
//     $url = $_SERVER['PHP_SELF'] . ($queryString ? '?' . $queryString : '');
//     header("Location: " . $url);
// }
include '../includes/header.php';

?>
<main>
<div class="container-fluid mt-4">
    <div class="row">
        <div class="col-md-2 col-sm-12">
            <div class="bg-light border p-3">
                <form action="/pages/search.php" method="post">
                    <input type="hidden" name="searched-product" value="<?= $selected_searched_product ?>">
                    <div class="form-group">
                        <label for="category">Categoria</label>
                        <select id="category" name="category" class="form-control">
                            <option value="">Tutto</option>
                            <?php foreach ($categories as $category) : ?>
                                <option <?php if ($category["category_tag"] === $selected_category) echo 'selected'; ?>>
                                    <?= $category['category_tag'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="minprice">Prezzo Minimo</label>
                        <input type="range" id="minprice" name="minprice" class="form-control-range" min="0" max="<?= $max_price?>" value="<?= $selected_min_price ?>">
                        <span id="minprice-value"></span>
                    </div>

                    <div class="form-group">
                        <label for="maxprice">Prezzo Massimo</label>
                        <input type="range" id="maxprice" name="maxprice" class="form-control-range" min="0" max="<?= $max_price?>"   value="<?= $selected_max_price ?>">
                        <span id="maxprice-value"></span>
                    </div>

                    <div class="form-group form-check">
                        <input type="checkbox" id="discount" name="discount" <?php if ($selected_is_discount) echo "checked" ?> class="form-check-input">
                        <label for="discount" class="form-check-label">In sconto</label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Applica filtri</button>
                </form>
            </div>
        </div>
        <div class="col-md-9 col-sm-12">
            <?=
            displayProductPreviews($id_products, $db, $sudoku_solved);
            ?>
        </div>
    </div>
</div>
                            </main>
<script>
    const minpriceSlider = document.getElementById('minprice');
    const maxpriceSlider = document.getElementById('maxprice');
    const minpriceValue = document.getElementById('minprice-value');
    const maxpriceValue = document.getElementById('maxprice-value');
    minpriceValue.textContent = minpriceSlider.value;
    maxpriceValue.textContent = maxpriceSlider.value;

    minpriceSlider.addEventListener('input', () => {
        minpriceValue.textContent = minpriceSlider.value;
    });

    maxpriceSlider.addEventListener('input', () => {
        maxpriceValue.textContent = maxpriceSlider.value;
    });
</script>
<?php
include '../includes/footer.php';
?>