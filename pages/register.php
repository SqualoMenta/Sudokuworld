<?php

include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

if (isset($_POST["name"]) && isset($_POST["mail"]) && isset($_POST["password"])) {
    // $login_result = $db->checkLogin($_POST["username"], $_POST["password"]);
    if(count($db->getUser($_POST["mail"]))>0){
        $register_error = "Errore! Email gia' utilizzata!";
    } else {
        unset($register_error);
        registerLoggedUser($login_result[0]);
    }
}


?>
<form action="#" method="POST">
    <h2>Login</h2>
    <?php if (isset($login_error)): ?>
        <p><?php echo $login_error ?></p>
    <?php endif; ?>
    <ul>
        <li>
            <label for="username">Username:</label><input type="text" id="username" name="username" />
        </li>
        <li>
            <label for="password">Password:</label><input type="password" id="password" name="password" />
        </li>
        <li>
            <input type="submit" name="submit" value="Invia" />
        </li>
    </ul>
</form>