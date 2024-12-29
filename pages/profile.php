<?php

include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
include("../includes/header.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
}
?>

<div>
    <h1>Benvenuto <?= $_SESSION["name"] ?></h1>
</div>



<?php
include("../includes/footer.php");
?>