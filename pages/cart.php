<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/ProductList.php");
// TODO: fare redirect a se stessi in tutte le pagine dopo una post in modo che non ho la form resubmissione query multiple

if (!isUserLoggedIn()) {
    header("Location: login.php");
}

$sudoku_solved = $db->sudokuRunner->isTodaySudokuWon($_SESSION["email"]);
$cart = new ProductList($db->getCart($_SESSION["email"]));
$products = $cart->getProducts();
include '../includes/header.php';

?>
<div class="container text-center">
    <?php if (empty($products)) : ?>
        <h1>Il carrello è vuoto</h1>
    <?php else: ?>
        <div>
            <h1 id='price'>Prezzo totale: $<?= number_format($cart->getTotalPrice($db, $sudoku_solved), 2) ?></h1>
            <a href="/pages/checkout.php" class="btn btn-info">Vai al checkout</a>
        </div>
    <?php endif; ?>
</div>

<!-- TODO mostrare la quantità -->
<?php foreach ($products as $product): ?>
    <div class="counter">
        <button class="decrease">-</button>
        <span class="count" id=<?= $product["id_product"] ?>><?= $product["quantity"] ?></span>
        <button class="increase">+</button>
    </div>
<?php endforeach; ?>
<?= displayProductPreviews($products, $db, $sudoku_solved) ?>

<script>
    document.querySelectorAll('.counter').forEach(counter => {
        const decreaseButton = counter.querySelector('.decrease');
        const increaseButton = counter.querySelector('.increase');
        const countSpan = counter.querySelector('.count');
        let count = parseInt(countSpan.textContent);

        decreaseButton.addEventListener('click', () => {
            if (count > 1) {
                count--;
                countSpan.textContent = count;
                const data = {
                    count: count,
                    id_product: counter.querySelector('.count').id,
                };
                console.log(data);
                fetch('/api/api-update-cart.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded'
                        },
                        body: new URLSearchParams(data) // Convert the data object to URL-encoded string
                    })
                    .then(response => response.text())
                    .then(result => {
                        const match = result.match(/-?\d+\.\d+$/);

                        if (match) {
                            const lastFloat = parseFloat(match[0]);
                            // console.log("Last float number:", lastFloat); // Output: 144.00
                            document.getElementById('price').textContent = `Prezzo totale: $${lastFloat.toFixed(2)}`;
                        }
                    });

            }
        });

        increaseButton.addEventListener('click', () => {
            count++;
            countSpan.textContent = count;
            const data = {
                count: count,
                id_product: counter.querySelector('.count').id,
            };
            console.log(data);
            fetch('/api/api-update-cart.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: new URLSearchParams(data) // Convert the data object to URL-encoded string
                })
                .then(response => response.text())
                .then(result => {
                    const match = result.match(/-?\d+\.\d+$/);

                    if (match) {
                        const lastFloat = parseFloat(match[0]);
                        // console.log("Last float number:", lastFloat); // Output: 144.00
                        document.getElementById('price').textContent = `Prezzo totale: $${lastFloat.toFixed(2)}`;
                    }
                });


        });
    });
</script>


<?php
include '../includes/footer.php';
?>