<?php

include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/CreditCard.php");
require_once("../classes/Product.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
}

if (isset($_POST['add_card'])) {
    $db->addCreditCard($_SESSION["email"], $_POST['cardNumber'], $_POST['cardName'], $_POST['cardSurname'], $_POST['cardExpiration'] . '-01');
    unset($_POST['add_card']);
    header("Location: profile.php");
}

if (isset($_POST["remove_card"])) {
    $db->removeCreditCard($_SESSION["email"], $_POST["remove_card"]);
    unset($_POST["remove_card"]);
    header("Location: profile.php");
}
$credit_cards = $db->getCreditCards($_SESSION["email"]);
$orders = $db->getOrders($_SESSION["email"]);
include '../includes/header.php';
?>

<main>
    <link rel="stylesheet" href="/assets/css/profile.css">

    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group" id="list-tab" role="tablist">
                    <a class="list-group-item list-group-item-action active" id="list-info-list" data-bs-toggle="list" href="#list-info" role="tab">
                        Informazioni personali
                    </a>
                    <a class="list-group-item list-group-item-action " id="list-home-list" data-bs-toggle="list" href="#list-home" role="tab">
                        Pagamento
                    </a>
                    <a class="list-group-item list-group-item-action" id="list-orders-list" data-bs-toggle="list" href="#list-orders" role="tab">
                        Ordini
                    </a>
                    <?php if ($_SESSION["is_seller"]) : ?>
                        <a href="seller_dashboard.php" class="list-group-item list-group-item-action list-group-item-primary">
                            Vetrina venditore
                        </a>
                    <?php endif; ?>
                    <a href="logout.php" class="list-group-item list-group-item-action list-group-item-danger">
                        Logout
                    </a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="tab-content" id="nav-tabContent">
                    <div class="tab-pane fade show active" id="list-info" role="tabpanel" aria-labelledby="list-info-list">
                        <div class="container">
                            <h1 class="display-4">Le mie informazioni</h1>
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" value="<?= $_SESSION["email"] ?>" readonly>
                            <label for="name">Nome</label> 
                            <input type="text" class="form-control" id="name" value="<?= $_SESSION["name"] ?>" readonly>
                        </div>
                    </div>
                    <div class="tab-pane fade " id="list-home" role="tabpanel" aria-labelledby="list-home-list">
                        <div class="col">
                        <h1 class="display-4">Metodo di pagamento</h1>
                            <form method="POST" action="#" onsubmit="return confirm('Sei sicuro di voler rimuovere la carta di credito?')">
                                <?php foreach ($credit_cards as $cc) {
                                    $credit_card = new CreditCard($cc["number"], $cc["name"], $cc["surname"], $cc["expiration"]);
                                ?>
                                    <div class="form-check">
                                        <button type="submit" class="btn btn-danger" name="remove_card" value="<?= $credit_card->getNumber() ?>" id="credit-card-<?= $credit_card->getNumber() ?>">Rimuovi Carta</button>
                                        <label for="credit-card-<?= $credit_card->getNumber() ?>">
                                            <?= $credit_card->getNumber() ?>
                                        </label>
                                    </div>
                                <?php } ?>
                            </form>

                            <button type="button" id="add-new-card" class="btn btn-link mt-3">Inserisci un'altra carta di credito</button>
                            <form method="POST" action="#">
                                <input type="hidden" name="add_card" value="new">
                                <div id="new-card-form" class="mt-4 d-none">
                                    <div class="card p-3">
                                        <div class="mb-3">
                                            <label for="cardNumber" class="form-label">Numero Carta</label>
                                            <input type="text" class="form-control border border-2" id="cardNumber" name="cardNumber">
                                        </div>
                                        <div class="mb-3">
                                            <label for="cardName" class="form-label">Nome</label>
                                            <input type="text" class="form-control border border-2" id="cardName" name="cardName">
                                        </div>
                                        <div class="mb-3">
                                            <label for="cardSurname" class="form-label">Cognome</label>
                                            <input type="text" class="form-control border border-2" id="cardSurname" name="cardSurname">
                                        </div>
                                        <div class="mb-3">
                                            <label for="cardExpiration" class="form-label">Data di Scadenza</label>
                                            <input type="month" class="form-control border border-2" id="cardExpiration" name="cardExpiration">
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary">Conferma Carta</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <script>
                            document.querySelector('#add-new-card').addEventListener('click', function() {
                                const newCardForm = document.getElementById('new-card-form');
                                console.log(newCardForm);
                                if (newCardForm.classList.contains("d-none")) {
                                    newCardForm.classList.remove("d-none");

                                    newCardForm.querySelectorAll('input').forEach((input) => {
                                        input.required = true;
                                    });
                                } else {
                                    newCardForm.classList.add("d-none");
                                    return;
                                }


                            });
                        </script>

                    </div>
                    <div class="tab-pane fade" id="list-orders" role="tabpanel" aria-labelledby="list-orders-list">
                        <div class="container">
                            <h1 class="display-4">I miei ordini</h1>
                            <?php foreach ($orders as $order) : ?>
                                <?php
                                $products = $db->getOrderProducts($order["id_order"]);
                                ?>
                                <div class="col-md-12">
                                    <div class="card mb-4">
                                        <div class="card-body">
                                            <h5 class="card-title">Ordine numero: <?= $order["id_order"] ?></h5>
                                            <p class="card-text">Data: <?= $order["day"] ?></p>
                                            <p class="card-text">Prezzo Ordine: <?= $order["price"] ?>$</p>
                                            <div>
                                                <?php displayProductPreviews($products, $db, false, is_prev_order: true); ?>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<?php
include("../includes/footer.php");
?>