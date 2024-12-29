<?php

include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["password"])) {
    if (count($db->getUser($_POST["email"])) > 0) {
        $register_error = "Errore! Email gia' utilizzata!";
    } else {
        unset($register_error);
        $db->registerUser($_POST["name"], $_POST["email"], $_POST["password"]);
        header("Location: login.php");
    }
}

include("../includes/header.php");
?>
<form action="#" method="POST">
    <h2>Registrazione</h2>
    <?php if (isset($register_error)): ?>
        <p><?php echo $register_error ?></p>
    <?php endif; ?>
    <ul>
        <li>
            <label for="name">Nome:</label><input type="text" id="name" name="name" />
        </li>
        <li>
            <label for="email">Email:</label><input type="email" id="email" name="email" />
        </li>
        <li>
            <label for="password">Password:</label><input type="password" id="password" name="password" />
        </li>
        <li>
            <input type="submit" name="submit" value="Invia" />
        </li>
    </ul>
</form>

<?php
include("../includes/footer.php");
?>