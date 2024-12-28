<?php

include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

if (isset($_POST["name"]) && isset($_POST["mail"]) && isset($_POST["password"])) {

    if (count($db->getUser($_POST["mail"])) > 0) {
        $register_error = "Errore! Email gia' utilizzata!";
    } else {
        unset($register_error);
        $db->registerUser($_POST["name"], $_POST["mail"], $_POST["password"]);
    }
}


?>
<form action="#" method="POST">
    <h2>Registrazione</h2>
    <?php if (isset($register_error)): ?>
        <p><?php echo $register_error ?></p>
    <?php endif; ?>
    <ul>
        <li>
            <label for="username">Username:</label><input type="text" id="username" name="username" />
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