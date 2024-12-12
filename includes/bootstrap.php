<?php
session_start();
define("UPLOAD_DIR", "./upload/");
require_once("../classes/Database.php");
$db = new Database("localhost", "root", "", "blogtw", 3306);
?>