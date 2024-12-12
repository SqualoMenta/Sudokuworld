<?php
include '../includes/config.php';
include '../classes/Database.php';

$db = new Database($pdo);
$products = $db->fetchAll("SELECT * FROM ITEM");

header('Content-Type: application/json');
echo json_encode($products);
?>
