<?php
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

define("UPLOAD_DIR", "./upload/");
require_once("../database/Database.php");//TODO: change path
$db = new Database("db", "root", "example", "SUDOKUWORLD", 3306);
?>

<!-- Bootstrap CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Bootstrap JS Bundle with Popper (for tooltips, popovers, etc.) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

