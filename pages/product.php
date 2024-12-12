<?php
require_once '../includes/config.php';
if (isset($_GET['id'])) {
    $productId = $_GET['id'];
    // Fetch product details logic here
} else {
    echo "<h1>Product Not Found</h1>";
    exit;
}
?>
<div class="container mt-4">
    <h1>Product Details</h1>
    <p>Details about the product will go here.</p>
</div>
