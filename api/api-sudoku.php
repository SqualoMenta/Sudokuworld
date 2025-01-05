<?php
include_once "../includes/bootstrap.php";
include_once "../database/Database.php";
include_once "../includes/functions.php";

var_dump($_SESSION["email"]);
if (isUserLoggedIn()) {
    echo ("hello");
    if (isset($_POST["solved"])) {
        var_dump($_POST["solved"]);
        if ($_POST["solved"] == '1') {
            $db->sudokuRunner->winSudoku($_SESSION["email"]);
        }
    }
}
