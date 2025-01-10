<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");


if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}


?>