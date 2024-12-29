<?php

include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

if (isset($_POST["email"]) && isset($_POST["password"])) {
    $login_result = $db->checkLogin($_POST["email"], $_POST["password"]);
    if (count($login_result) == 0) {
        $login_error = "Errore! Controllare email o password!";
    } else {
        unset($login_error);
        registerLoggedUser($login_result[0]);
    }
}
include("../includes/header.php");
?>
<?php if (isUserLoggedIn()): ?>
    <div>
        <h1>Benvenuto <?= $_SESSION["name"] ?></h1>
        <a href="logout.php">Logout</a>
    </div>
<?php else: ?>
    <form action="#" method="POST">
        <h2>Login</h2>
        <?php if (isset($login_error)): ?>
            <p><?php echo $login_error ?></p>
        <?php endif; ?>
        <ul>
            <li>
                <label for="email">Email:</label><input type="text" id="email" name="email" />
            </li>
            <li>
                <label for="password">Password:</label><input type="password" id="password" name="password" />
            </li>
            <li>
                <input type="submit" name="submit" value="Invia" />
            </li>
        </ul>
    </form>

    <div>
        Non hai un account? <a href="register.php">Registrati</a>
    </div>
<?php endif; ?>

<?php
include("../includes/footer.php");
?>