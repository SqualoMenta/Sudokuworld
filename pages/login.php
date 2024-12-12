<?php

if (isset($_POST["username"]) && isset($_POST["password"])) {
    $login_result = $db->checkLogin($_POST["username"], $_POST["password"]);
    if (count($login_result) == 0) {
        $login_error = "Errore! Controllare username o password!";
    } else {
        unset($login_error);
        registerLoggedUser($login_result[0]);
    }
}

if (isUserLoggedIn()) {
    $templateParams["titolo"] = "Blog TW - Admin";
    $templateParams["nome"] = "login-home.php";
    $templateParams["articoli"] = $dbh->getPostByAuthorId($_SESSION["idautore"]);
    if (isset($_GET["formmsg"])) {
        $templateParams["formmsg"] = $_GET["formmsg"];
    }
} else {
    $templateParams["titolo"] = "Blog TW - Login";
    $templateParams["nome"] = "login-form.php";
}
$templateParams["categorie"] = $dbh->getCategories();
$templateParams["articolicasuali"] = $dbh->getRandomPosts(2);

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