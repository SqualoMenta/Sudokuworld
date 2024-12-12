<?php
// index.php
require_once 'includes/header.php';

// Routing logic
if (isset($_GET['page'])) {
    $page = $_GET['page'];
    switch ($page) {
        case 'home':
            include 'pages/home.php';
            break;
        case 'product':
            include 'pages/product.php';
            break;
        case 'cart':
            include 'pages/cart.php';
            break;
        case 'checkout':
            include 'pages/checkout.php';
            break;
        default:
            echo "<h1>Page Not Found</h1>";
            break;
    }
} else {
    include '../pages/home.php';
}

require_once '../includes/footer.php';
