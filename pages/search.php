<?php
include_once("../includes/bootstrap.php");
include_once("../includes/functions.php");
require_once("../classes/Product.php");
require_once("../classes/Cart.php");

include '../includes/header.php';

if (isset($_POST['searched-product'])) {
    // echo "Risultati per: " . $_POST['searched-product'];
    $ids = $db->searchProductByName($_POST['searched-product']);
    foreach($ids as $id){
        $prod = new Product(...$db->getProduct($id['id_product'])[0]);
        echo $prod->getName();
    }
}

