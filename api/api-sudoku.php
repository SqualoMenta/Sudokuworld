<?php
include_once "../includes/bootstrap.php";
include_once "../database/Database.php";
include_once "../includes/functions.php";

if (isUserLoggedIn()) {
    if (isset($_POST["solved"])) {
        if ($_POST["solved"] == '1') {
            $db->sudokuRunner->winSudoku($_SESSION["email"]);
        }
    }
}
