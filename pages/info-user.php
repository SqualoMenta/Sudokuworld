<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/CreditCard.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}

if (isset($_POST['add_card'])) {
    $db->addCreditCard($_SESSION["email"], $_POST['cardNumber'], $_POST['cardName'], $_POST['cardSurname'], $_POST['cardExpiration'] . '-01');
    header("Location: info-user.php");
}

if(isset($_POST["remove_card"])){
    $db->removeCreditCard($_SESSION["email"], $_POST["remove_card"]);
    header("Location: info-user.php");

}    
$credit_cards = $db->getCreditCards($_SESSION["email"]);
include '../includes/header.php';
?>

<div class="row">
    <div class="col">
        <h2>Metodo di pagamento</h2>
        <p>Seleziona la carta di credito</p>
        <form method="POST" action="#" onsubmit="return confirm('Sei sicuro di voler rimuovere la carta di credito?')">
            <?php foreach ($credit_cards as $cc) {
                $credit_card = new CreditCard($cc["number"], $cc["name"], $cc["surname"], $cc["expiration"]);
            ?>
                <div class="form-check">
                    <button type="submit" class="btn btn-danger" name="remove_card" value="<?= $credit_card->getNumber()?>" id="credit-card-<?= $credit_card->getNumber() ?>">Rimuovi Carta</button>
                    <label for="credit-card-<?= $credit_card->getNumber() ?>">
                        <?= $credit_card->getNumber()?>
                    </label>
                </div>
            <?php } ?>
            </form>
            <!-- <div id="remove-card-container" style="display: none;" class="mt-3">
            <input type="hidden" name="remove-card" value="true">
                <button type="submitt" id="remove-card-button" class="btn btn-danger">Rimuovi Carta</button>
            </div> -->

            <!-- Button to add a new credit card -->

            <button type="button" id="add-new-card" class="btn btn-link mt-3">Inserisci un'altra carta</button>
            <form method="POST" action="#">
            <input type="hidden" name="add_card" value="new">
            <!-- Form for adding a new credit card -->
            <div id="new-card-form" class="mt-4" style="display: none;">
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
</div>

<script>
    document.querySelector('#add-new-card').addEventListener('click', function() {
        const newCardForm = document.getElementById('new-card-form');
        if(newCardForm.style.display === 'block') {
            newCardForm.style.display = 'none';
            return;
        }else{
            newCardForm.style.display = 'block';
    
            newCardForm.querySelectorAll('input').forEach((input) => {
                input.required = true;
            });
    
            document.querySelectorAll('input[name="credit_card"]').forEach((radio) => {
                radio.checked = false;
            });
            document.getElementById('remove-card-container').style.display = 'none';
        }
    });

    document.querySelectorAll('input[name="credit_card"]').forEach((radio) => {
        radio.addEventListener('change', function () {
            const removeCardContainer = document.getElementById('remove-card-container');
                removeCardContainer.style.display = 'block';
        });
    });
</script>

<?php
include("../includes/footer.php");
?>