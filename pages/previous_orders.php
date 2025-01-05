<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");

if (!isUserLoggedIn()) {
    header("Location: login.php");
    exit;
}
$orders = $db->getOrders($_SESSION["email"]);
var_dump($orders);
// for each order, create a label with order date and total price. 
// When the label is clicked, show the order details (products, quantity, total price) through a dropdown menu.
// The dropdown menu should be hidden by default and should be shown when the label is clicked.
// The dropdown menu should be hidden when the label is clicked again.
// The dropdown menu should be hidden when another label is clicked.

include '../includes/header.php';
?>

